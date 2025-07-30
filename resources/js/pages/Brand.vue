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
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { Search, SquarePen, Trash } from 'lucide-vue-next';
import { ref, watch } from 'vue';

// Breadcrumb items for navigation
const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Brand',
        href: '/brand',
    },
];

// Props for the component
defineProps({
    brand: Array,
});

// Reactive variables for success alert
const showSuccessAlert = ref(false);
const successAlertMessage = ref('');

// For data table
const headers = [
    { text: 'Brand Image', value: 'image' },
    { text: 'Brand Name', value: 'name', sortable: true },
    { text: 'Operation', value: 'operation' },
];
// Reactive variables for search functionality
const searchTerm = ref('');
const searchFields = ['name'];

// Reactive variables for modal and form handling
const isModalOpen = ref(false);

const form = useForm({
    name: '',
    image: null,
});

watch(isModalOpen, (newVal) => {
    if (!newVal) {
        form.reset('name', 'image');
    }
});

const submit = () => {
    form.post(route('create-brand'), {
        onSuccess: () => {
            successAlertMessage.value = 'Brand created successfully!';
            showSuccessAlert.value = true;

            form.reset('name', 'image');
            isModalOpen.value = false;

            setTimeout(() => {
                showSuccessAlert.value = false;
            }, 3000);
            isModalOpen.value = false;
        },
    });
};

const handleFile = (e: Event) => {
    const file = (e.target as HTMLInputElement).files?.[0];
    form.image = file;
};

// Reactive variables for delete dialog and success alert
const isDeleteDialogOpen = ref(false);
const brandToDeleteId = ref(null);

function openDeleteDialog(id) {
    brandToDeleteId.value = id;
    isDeleteDialogOpen.value = true;
}

function handleDelete() {
    if (!brandToDeleteId.value) return;

    router.delete(`/delete-brand/${brandToDeleteId.value}`, {
        onSuccess: () => {
            successAlertMessage.value = 'The brand was deleted successfully.';
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
            brandToDeleteId.value = null;
        },
    });
}

// Edit functionality
const isEditMode = ref(false);
const editingId = ref(null);
function editBrand(item) {
    isEditMode.value = true;
    isModalOpen.value = true;
    editingId.value = item.id;

    form.name = item.name;
    form.image = null;
}
function updateBrand() {
    form.post(`/update-brand/${editingId.value}`, {
        forceFormData: true,
        onSuccess: () => {
            successAlertMessage.value = 'Brand Updated successfully!';
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
        <Head title="Brand" />

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

        <div class="px-4 py-6">
            <Heading title="Brand List" />
            <div class="flex justify-between">
                <div class="relative mb-6 max-w-xs">
                    <Search class="absolute left-3 z-10 mt-[22px] h-4 w-4 -translate-y-1/2 text-gray-500" />
                    <Input type="text" class="mt-1 block w-full pl-9" v-model="searchTerm" required placeholder="Search Brand..." />
                </div>
                <div class="mb-2 flex justify-end">
                    <Button @click="isModalOpen = true">Create Brand</Button>
                </div>
            </div>
            <!-- Easy Data Table -->
            <EasyDataTable
                table-class-name="customize-table"
                :headers="headers"
                :items="brand"
                alternating
                show-index
                buttons-pagination
                :search-value="searchTerm"
                :search-fields="searchFields"
            >
                <template #item-image="{ image, name }">
                    <img :src="image || 'https://placehold.co/150x150.png'" :alt="name" class="ms-2 h-8 w-auto rounded-full" />
                </template>
                <template #item-operation="item">
                    <div class="flex items-center gap-2">
                        <Button size="sm" class="mr-2" @click="editBrand(item)">
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
                            This will permanently delete the brand and all of its data. This action cannot be undone.
                        </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel @click="isDeleteDialogOpen = false">Cancel</AlertDialogCancel>

                        <AlertDialogAction @click="handleDelete">Continue</AlertDialogAction>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>

            <!-- Create and Update Brand Modal -->
            <Dialog :open="isModalOpen" @update:open="isModalOpen = false">
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>{{ isEditMode ? 'Update Brand' : 'Create Brand' }}</DialogTitle>
                    </DialogHeader>
                    <form @submit.prevent="isEditMode ? updateBrand() : submit()" class="flex flex-col gap-6">
                        <div class="grid gap-6">
                            <Input type="text" v-model="form.name" placeholder="Brand Name" />
                            <Input type="file" @change="handleFile" placeholder="Brand Logo" />
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
<style scoped>
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
