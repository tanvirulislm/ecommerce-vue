<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Search, SquarePen, Trash } from 'lucide-vue-next';
import { ref } from 'vue';
const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Brand',
        href: '/brand',
    },
];

const props = defineProps({
    product: Array,
});

const items = ref(props.product);

const headers = [
    { text: 'ID', value: 'id', sortable: true },
    { text: 'Product Name', value: 'title', sortable: true },
    { text: 'Image', value: 'image' },
    { text: 'Price', value: 'price', sortable: true },
    { text: 'Stock', value: 'stock', sortable: true },
    { text: 'Star', value: 'star', sortable: true },
    { text: 'Remark', value: 'remark', sortable: true },
    { text: 'Category', value: 'category.name', sortable: true },
    { text: 'Brand', value: 'brand.brandName', sortable: true },
    { text: 'Operation', value: 'operation' },
];
const searchTerm = ref('');
const searchFields = ['name'];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Product" />
        <div class="px-4 py-6">
            <Heading title="Product List" />
            <div class="flex justify-between">
                <div class="relative mb-6 max-w-xs">
                    <Search class="absolute left-3 z-10 mt-[22px] h-4 w-4 -translate-y-1/2 text-gray-500" />
                    <Input type="text" class="mt-1 block w-full pl-9" v-model="searchTerm" required placeholder="Search Category..." />
                </div>
                <div class="mb-2 flex justify-end">
                    <Button>Create Product</Button>
                </div>
            </div>
            <!-- Easy Data Table -->
            <EasyDataTable
                table-class-name="customize-table"
                :headers="headers"
                :items="product"
                alternating
                buttons-pagination
                :search-value="searchTerm"
                :search-fields="searchFields"
            >
                <template #item-image="{ image }">
                    <img :src="image" alt="Product" class="ms-2 h-8 w-auto rounded-full" />
                </template>
                <template #item-operation="{ id }">
                    <Button size="sm" class="mr-2"><SquarePen class="h-4 w-4" /></Button>
                    <Button size="sm" variant="destructive"><Trash class="h-4 w-4" /></Button>
                </template>
            </EasyDataTable>
        </div>
    </AppLayout>
</template>

<style scoped>
.customize-table {
    --easy-table-header-font-size: 15px;
    --easy-table-body-row-font-size: 14px;
}
</style>
