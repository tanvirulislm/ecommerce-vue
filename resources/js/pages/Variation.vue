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

defineProps({
    variations: Array,
});

// const items = ref(props.brand);

const headers = [
    { text: 'Variation Name', value: 'name', sortable: true },
    { text: 'Variation Options', value: 'variation_options' },
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
                :items="variations"
                show-index
                alternating
                buttons-pagination
                :search-value="searchTerm"
                :search-fields="searchFields"
            >
                <template #item-variation_options="{ variation_options }">
                    <div class="flex flex-wrap gap-1">
                        <span
                            v-for="(option, index) in variation_options"
                            :key="index"
                            class="inline-block rounded bg-gray-200 px-2 py-1 text-xs font-semibold text-gray-800"
                        >
                            {{ option.name }}
                        </span>
                    </div>
                </template>
                <template #item-operation="">
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
