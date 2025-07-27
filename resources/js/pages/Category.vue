<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Search, SquarePen, Trash } from 'lucide-vue-next';
import { ref } from 'vue';
const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Category',
        href: '/category',
    },
];

defineProps({
    category: Array,
});

const headers = [
    { text: 'Image', value: 'image' },
    { text: 'Name', value: 'name', sortable: true },
    { text: 'Operation', value: 'operation' },
];
const searchTerm = ref('');
const searchFields = ['name'];

const isModalOpen = ref(false);
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Category" />
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
                :items="category"
                show-index
                alternating
                buttons-pagination
                :search-value="searchTerm"
                :search-fields="searchFields"
            >
                <template #item-image="{ image }">
                    <img :src="image" alt="Category" class="ms-2 h-8 w-auto rounded-full" />
                </template>
                <template #item-operation="">
                    <Button size="sm" class="mr-2"><SquarePen class="h-4 w-4" /></Button>
                    <Button size="sm" variant="destructive"><Trash class="h-4 w-4" /></Button>
                </template>
            </EasyDataTable>
            <!-- Dialog -->
            <Dialog :open="isModalOpen" @update:open="isModalOpen = false">
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Create Categogy</DialogTitle>
                    </DialogHeader>

                    <div class="grid gap-6">
                        <Input type="text" placeholder="Category Name" />
                        <Input type="text" placeholder="Category Slug" />
                        <Input type="text" placeholder="Category Description" />
                    </div>
                    <DialogFooter>
                        <Button>Save</Button>
                        <Button @click="isModalOpen = false">Close</Button>
                    </DialogFooter>
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
