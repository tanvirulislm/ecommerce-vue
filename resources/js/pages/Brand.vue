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
    brand: Array,
});

const items = ref(props.brand);

const headers = [
    { text: 'ID', value: 'id', sortable: true },
    { text: 'Brand Image', value: 'brandImg' },
    { text: 'Brand Name', value: 'brandName', sortable: true },
    { text: 'Operation', value: 'operation' },
];
const searchTerm = ref('');
const searchFields = ['name'];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Brand" />
        <div class="px-4 py-6">
            <Heading title="Brand List" />
            <div class="flex justify-between">
                <div class="relative mb-6 max-w-xs">
                    <Search class="absolute left-3 z-10 mt-[22px] h-4 w-4 -translate-y-1/2 text-gray-500" />
                    <Input type="text" class="mt-1 block w-full pl-9" v-model="searchTerm" required placeholder="Search Category..." />
                </div>
                <div class="mb-2 flex justify-end">
                    <Button>Create Brand</Button>
                </div>
            </div>
            <!-- Easy Data Table -->
            <EasyDataTable
                table-class-name="customize-table"
                :headers="headers"
                :items="brand"
                alternating
                buttons-pagination
                :search-value="searchTerm"
                :search-fields="searchFields"
            >
                <template #item-brandImg="{ brandImg }">
                    <img :src="brandImg" alt="Brand" class="ms-2 h-8 w-auto rounded-full" />
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
