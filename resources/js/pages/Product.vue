<script setup lang="ts">
import ProductDetailDialog from '@/components/app/ProductDetailDialog.vue';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Eye, Search, SquarePen, Trash } from 'lucide-vue-next';
import { ref } from 'vue';
const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Product',
        href: '/product',
    },
];

defineProps({
    product: Array,
});

const headers = [
    { text: 'Product Name', value: 'title', sortable: true },
    { text: 'Image', value: 'image' },
    { text: 'Price', value: 'price', sortable: true },
    { text: 'Stock', value: 'stock', sortable: true },
    { text: 'Remark', value: 'remark', sortable: true },
    { text: 'Category', value: 'category.name', sortable: true },
    { text: 'Brand', value: 'brand.name', sortable: true },
    { text: 'Operation', value: 'operation' },
];

const searchTerm = ref('');
const searchFields = ['title', 'category.name', 'brand.name', 'remark'];

const showRow = (item: any) => {
    selectedItem.value = item;
    isModalOpen.value = true;
};

const isModalOpen = ref(false);
const selectedItem = ref<any | null>(null);
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Product" />
        <div class="px-4 py-6">
            <Heading title="Product List" />

            <div class="flex justify-between">
                <div class="relative mb-6 max-w-xs">
                    <Search class="absolute left-3 z-10 mt-[22px] h-4 w-4 -translate-y-1/2 text-gray-500" />
                    <Input type="text" class="mt-1 block w-full pl-9" v-model="searchTerm" required placeholder="Search Product..." />
                </div>
                <div class="mb-2 flex justify-end">
                    <Button as-child><Link href="/create-product">Create Product</Link></Button>
                </div>
            </div>

            <!-- Easy Data Table -->
            <EasyDataTable
                table-class-name="customize-table"
                alternating
                buttons-pagination
                show-index
                :headers="headers"
                :items="product"
                :search-value="searchTerm"
                :search-fields="searchFields"
            >
                <template #item-image="{ image }">
                    <img :src="image" alt="Product" class="ms-2 h-8 w-auto rounded-full" />
                </template>
                <template #item-operation="item">
                    <div class="flex items-center gap-2">
                        <Button size="sm" @click="showRow(item)" class="mr-2"><Eye class="h-4 w-4" /></Button>
                        <Button size="sm" class="mr-2"><SquarePen class="h-4 w-4" /></Button>
                        <Button size="sm" variant="destructive"><Trash class="h-4 w-4" /></Button>
                    </div>
                </template>
            </EasyDataTable>
            <template>
                <ProductDetailDialog v-model:open="isModalOpen" :item="selectedItem" />
            </template>
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
