<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Search, SquarePen, Trash } from 'lucide-vue-next';
import { ref, watch } from 'vue';
const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Category',
        href: '/category',
    },
];

defineProps({
    categories: Array,
});

const headers = [
    { text: 'Image', value: 'image' },
    { text: 'Name', value: 'name', sortable: true },
    { text: 'Operation', value: 'operation' },
];
const searchTerm = ref('');
const searchFields = ['name'];

const isModalOpen = ref(false);
const selectedParentId = ref(null);

const form = useForm({
    name: '',
    image: null,
    parent_id: null,
});
const submit = () => {
    form.post(route('create-category'), {
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
                :items="categories"
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
                    <form @submit.prevent="submit" class="flex flex-col gap-6">
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
                            <Button type="submit">Save</Button>
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
