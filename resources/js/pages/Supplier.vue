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
        title: 'Supplier',
        href: '/supplier',
    },
];

// Props for the component
defineProps({
    parties: Array,
});

// Reactive variables for success alert
const showSuccessAlert = ref(false);
const successAlertMessage = ref('');

// For data table
const headers = [
    { text: 'Name', value: 'name', sortable: true },
    { text: 'Phone', value: 'phone', sortable: true },
    { text: 'Email', value: 'email', sortable: true },
    { text: 'City', value: 'city', sortable: true },
    { text: 'Operation', value: 'operation' },
];

// Reactive variables for search functionality
const searchTerm = ref('');
const searchFields = ['name', 'phone', 'email', 'city'];

// Reactive variables for modal and form handling
const isModalOpen = ref(false);

const form = useForm({
    name: '',
    phone: '',
    email: '',
    city: '',
    address: '',
    type: 'supplier',
    created_by: null,
});

watch(isModalOpen, (newVal) => {
    if (!newVal) {
        form.reset('name', 'phone', 'email', 'city', 'address', 'type', 'created_by');
    }
});

const submit = () => {
    form.post(route('create-party'), {
        onSuccess: () => {
            successAlertMessage.value = 'Brand created successfully!';
            showSuccessAlert.value = true;

            form.reset('name', 'phone', 'email', 'city', 'address', 'type', 'created_by');
            isModalOpen.value = false;

            setTimeout(() => {
                showSuccessAlert.value = false;
            }, 3000);
            isModalOpen.value = false;
        },
    });
};

// Reactive variables for delete dialog and success alert
const isDeleteDialogOpen = ref(false);
const partyToDeleteId = ref(null);

function openDeleteDialog(id) {
    partyToDeleteId.value = id;
    isDeleteDialogOpen.value = true;
}

function handleDelete() {
    if (!partyToDeleteId.value) return;

    router.delete(`/delete-party/${partyToDeleteId.value}`, {
        onSuccess: () => {
            successAlertMessage.value = 'The party was deleted successfully.';
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
            partyToDeleteId.value = null;
        },
    });
}

// Edit functionality
const isEditMode = ref(false);
const editingId = ref(null);
function editParty(item) {
    isEditMode.value = true;
    isModalOpen.value = true;
    editingId.value = item.id;

    form.name = item.name;
    form.email = item.email;
    form.phone = item.phone;
    form.city = item.city;
    form.address = item.address;
    form.created_by = item.created_by;
    isModalOpen.value = true;
}
function updateParty() {
    form.post(`/update-party/${editingId.value}`, {
        forceFormData: true,
        onSuccess: () => {
            successAlertMessage.value = 'Party Updated successfully!';
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
        <Head title="Supplier" />

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
            <Heading title="Supplier List" />
            <div class="flex justify-between">
                <div class="relative mb-6 max-w-xs">
                    <Search class="absolute left-3 z-10 mt-[22px] h-4 w-4 -translate-y-1/2 text-gray-500" />
                    <Input type="text" class="mt-1 block w-full pl-9" v-model="searchTerm" required placeholder="Search Supplier..." />
                </div>
                <div class="mb-2 flex justify-end">
                    <Button @click="isModalOpen = true">Create Brand</Button>
                </div>
            </div>
            <!-- Easy Data Table -->
            <EasyDataTable
                table-class-name="customize-table"
                :headers="headers"
                :items="parties"
                alternating
                show-index
                buttons-pagination
                :search-value="searchTerm"
                :search-fields="searchFields"
            >
                <template #item-type="{ type }">
                    <span
                        class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold text-foreground transition-colors focus:ring-2 focus:ring-ring focus:ring-offset-2 focus:outline-none"
                        >{{ type.charAt(0).toUpperCase() + type.slice(1) }}</span
                    >
                </template>

                <template #item-operation="item">
                    <div class="flex items-center gap-2">
                        <Button size="sm" class="mr-2" @click="editParty(item)">
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
                        <DialogTitle>{{ isEditMode ? 'Update Supplier' : 'Create Supplier' }}</DialogTitle>
                    </DialogHeader>
                    <form @submit.prevent="isEditMode ? updateParty() : submit()" class="flex flex-col gap-6">
                        <div class="grid gap-6">
                            <Input type="text" v-model="form.name" placeholder="Supplier Name" />
                            <Input type="email" v-model="form.email" placeholder="Email" />
                            <Input type="text" v-model="form.phone" placeholder="Phone" />
                            <Input type="text" v-model="form.city" placeholder="City" />
                            <Input type="text" v-model="form.address" placeholder="Address" />
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
