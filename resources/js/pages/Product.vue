<script setup lang="ts">
import ProductDetailDialog from '@/components/app/ProductDetailDialog.vue';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
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
                    <Button href="/product/create">Create Product</Button>
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
            <!-- <Dialog :open="isModalOpen" @update:open="isModalOpen = false">
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>{{ selectedItem?.title }}</DialogTitle>
                        <DialogDescription> {{ selectedItem?.long_des }} </DialogDescription>
                    </DialogHeader>

                    <div v-if="selectedItem" class="grid gap-4 py-4">
                        <div class="flex items-center">
                            <img :src="selectedItem.image" alt="Product" class="h-20 w-20 rounded-md object-cover" />
                        </div>
                        <p><strong>Product Price:</strong> $ {{ selectedItem.price }}</p>
                        <p><strong>Discount:</strong> $ {{ selectedItem.discount_price }}</p>
                        <p v-for="(option, index) in selectedItem.variations" :key="index">
                            <strong>{{ option.name }}: {{ option.option }}</strong>
                        </p>
                        <p><strong>Available Stock:</strong> {{ selectedItem.stock }} units</p>
                        <img
                            v-for="(option, index) in selectedItem.variations"
                            :key="index"
                            :src="option.image"
                            alt="Variation Image"
                            class="h-10 w-10 rounded-md object-cover"
                        />
                        <p><strong>Product Category:</strong> {{ selectedItem.category.name }}</p>
                        <p><strong>Brand:</strong> {{ selectedItem.brand.brandName }}</p>
                        <p><strong>Remark:</strong> {{ selectedItem.remark }}</p>
                    </div>

                    <DialogFooter>
                        <Button>Make Order</Button>
                        <Button @click="isModalOpen = false">Close</Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog> -->

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
