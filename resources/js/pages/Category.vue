<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { Search, SquarePen, Trash } from 'lucide-vue-next';
import { ref, watch } from 'vue';

// Breadcrumb items for navigation
const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Category',
        href: '/category',
    },
];

// Props for the component
defineProps({
    categories: Array,
});

// Reactive variables for success alert
const showSuccessAlert = ref(false);
const successAlertMessage = ref('');

// For data table
const headers = [
    { text: 'Image', value: 'image' },
    { text: 'Name', value: 'name', sortable: true },
    { text: 'Operation', value: 'operation' },
];

// Reactive variables for search functionality
const searchTerm = ref('');
const searchFields = ['name'];

// Reactive variables for modal and form handling
const isModalOpen = ref(false);
const selectedParentId = ref(null);

const form = useForm({
    name: '',
    image: null,
    parent_id: null,
});

const submit = () => {
    form.post(route('create-category'), {
        onSuccess: () => {
            successAlertMessage.value = 'Category created successfully!';
            showSuccessAlert.value = true;

            setTimeout(() => {
                showSuccessAlert.value = false;
            }, 3000);
        },
        onFinish: () => {
            form.reset();
            isModalOpen.value = false;
        },
    });
};

const handleFile = (e: Event) => {
    const file = (e.target as HTMLInputElement).files?.[0];
    form.image = file;
};

watch(selectedParentId, (val) => {
    form.parent_id = val;
});

// Reactive variables for delete dialog and success alert
const isDeleteDialogOpen = ref(false);
const categoryToDeleteId = ref(null);

function openDeleteDialog(id) {
    categoryToDeleteId.value = id;
    isDeleteDialogOpen.value = true;
}

function handleDelete() {
    if (!categoryToDeleteId.value) return;

    router.delete(`/delete-category/${categoryToDeleteId.value}`, {
        onSuccess: () => {
            successAlertMessage.value = 'The category was deleted successfully.';
            showSuccessAlert.value = true;

            setTimeout(() => {
                showSuccessAlert.value = false;
            }, 3000);
        },
        onError: (errors) => {
            alert('An error occurred.');
            console.error(errors);
        },
        onFinish: () => {
            isDeleteDialogOpen.value = false;
            categoryToDeleteId.value = null;
        },
    });
}

// Edit functionality
const isEditMode = ref(false);
const editingId = ref(null);
function editCategory(item) {
    isEditMode.value = true;
    isModalOpen.value = true;
    editingId.value = item.id;

    form.name = item.name;
    form.image = null;
    selectedParentId.value = item.parent_id;
}
function updateCategory() {
    form.parent_id = selectedParentId.value;

    form.post(`/update-category/${editingId.value}`, {
        forceFormData: true,
        onSuccess: () => {
            successAlertMessage.value = 'Category Updated successfully!';
            showSuccessAlert.value = true;

            setTimeout(() => {
                showSuccessAlert.value = false;
            }, 3000);
            isModalOpen.value = false;
            isEditMode.value = false;
            form.reset();
        },
    });
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Category" />

        <!-- Success Alert -->
        <div v-if="showSuccessAlert" class="fixed top-5 right-5 z-50 w-auto max-w-sm">
            <Alert>
                <SquareCheckBig class="h-4 w-4" />
                <AlertTitle>Success!</AlertTitle>
                <AlertDescription>
                    {{ successAlertMessage }}
                </AlertDescription>
            </Alert>
        </div>

        <!-- Main Content -->
        <div class="px-4 py-6">
            <Heading title="Category List" />
            <div class="flex justify-between">
                <div class="relative mb-6 max-w-xs">
                    <Search class="absolute left-3 z-10 mt-[23px] h-4 w-4 -translate-y-1/2 text-gray-500" />
                    <Input type="text" class="mt-1 block w-full pl-9" v-model="searchTerm" required placeholder="Search Category..." />
                </div>
                <div class="mb-2 flex justify-end">
                    <Button @click="isModalOpen = true">Create Category</Button>
                </div>
            </div>

            <!-- Easy Data Table -->
            <EasyDataTable
                table-class-name="customize-table"
                :headers="headers"
                :items="categories"
                show-index
                alternating
                buttons-pagination
                :search-value="searchTerm"
                :search-fields="searchFields"
            >
                <template #item-image="{ image, name }">
                    <img :src="image || 'https://placehold.co/150x150.png'" :alt="name" class="ms-2 h-8 w-auto rounded-full" />
                </template>
                <template #item-operation="item">
                    <div class="flex items-center gap-2">
                        <Button size="sm" class="mr-2" @click="editCategory(item)">
                            <SquarePen class="h-4 w-4" />
                        </Button>
                        <Button size="sm" @click="openDeleteDialog(item.id)" variant="destructive"><Trash class="h-4 w-4" /></Button>
                    </div>
                </template>
            </EasyDataTable>

            <!-- Alert Dialog -->
            <AlertDialog :open="isDeleteDialogOpen" @update:open="isDeleteDialogOpen = $event">
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                        <AlertDialogDescription>
                            This will permanently delete the category and all of its data. This action cannot be undone.
                        </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel @click="isDeleteDialogOpen = false">Cancel</AlertDialogCancel>

                        <AlertDialogAction @click="handleDelete">Continue</AlertDialogAction>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>

            <!-- Create Category Modal -->
            <Dialog :open="isModalOpen" @update:open="isModalOpen = false">
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>{{ isEditMode ? 'Update Category' : 'Create Category' }}</DialogTitle>
                    </DialogHeader>
                    <form @submit.prevent="isEditMode ? updateCategory() : submit()" class="flex flex-col gap-6">
                        <div class="grid gap-6">
                            <Input type="text" v-model="form.name" placeholder="Category Name" />
                            <Input type="file" @change="handleFile" placeholder="Category Image" />

                            <Select v-model="selectedParentId">
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Select Parent Category" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem :value="null">No Parent (Root Category)</SelectItem>
                                    <SelectItem v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.name }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                        <DialogFooter>
                            <Button type="submit">{{ isEditMode ? 'Update' : 'Save' }}</Button>
                        </DialogFooter>
                    </form>
                </DialogContent>
            </Dialog>
        </div>
    </AppLayout>
</template>

<style>
.customize-table {
    --easy-table-header-font-size: 15px;
    --easy-table-body-row-font-size: 14px;
}

::v-deep(.buttons-pagination .item.button.active) {
    background-color: #2e2e2e !important;
    border-color: #2e2e2e !important;
    color: #ffffff !important;
}
::v-deep(.select-items .selected) {
    background-color: #2e2e2e !important;
    border-color: #2e2e2e !important;
    color: #ffffff !important;
}
</style>
