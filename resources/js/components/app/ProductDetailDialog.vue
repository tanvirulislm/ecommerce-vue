<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';

defineProps({
    open: {
        type: Boolean,
        required: true,
    },
    item: {
        type: Object,
        default: () => null,
    },
});

const emit = defineEmits(['update:open']);

const handleClose = () => {
    emit('update:open', false);
};
</script>

<template>
    <Dialog :open="open" @update:open="handleClose">
        <DialogContent v-if="item">
            <DialogHeader>
                <DialogTitle>{{ item.title }}</DialogTitle>
                <DialogDescription>{{ item.short_des }}</DialogDescription>
            </DialogHeader>

            <div class="grid gap-6 overflow-y-auto">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div class="col-span-1">
                        <img
                            :src="item.cover_image ? `/storage/private/${item.cover_image}` : 'https://placehold.co/600x600/png'"
                            alt="Product"
                            class="aspect-square w-full rounded-lg object-cover"
                        />
                    </div>
                    <div class="md:col-span-2">
                        <h3 class="mb-3 text-lg font-semibold">Product Details</h3>

                        <p class="mb-4">{{ item.long_des }}</p>

                        <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm">
                            <p><strong>Category:</strong> {{ item.category?.name || 'N/A' }}</p>
                            <p><strong>Brand:</strong> {{ item.brand?.name || 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div v-if="item.variations?.length > 0" class="mt-6">
                    <h3 class="mb-3 text-lg font-semibold">Available Variations</h3>

                    <div class="max-h-64 space-y-4 overflow-y-auto">
                        <div v-for="variation in item.variations" :key="variation.id" class="flex items-center gap-4 rounded-md border p-4">
                            <div class="flex-shrink-0">
                                <img
                                    v-if="variation.images?.length > 0"
                                    :src="variation.images[0].url ? `/storage/${variation.images[0].url}` : 'https://placehold.co/100x100/png'"
                                    alt="Variation Image"
                                    class="h-16 w-16 rounded-md object-cover"
                                />
                                <div v-else class="flex h-16 w-16 items-center justify-center rounded-md bg-gray-200 text-gray-500">No Image</div>
                            </div>

                            <div>
                                <p><strong>SKU:</strong> {{ variation.sku || 'N/A' }}</p>
                                <p><strong>Price:</strong> ${{ variation.price }}</p>
                                <p><strong>Discount:</strong> ${{ variation.discount_price || '0' }}</p>
                                <p><strong>Stock:</strong> {{ variation.stock }} units</p>
                                <p>
                                    <strong>Attributes:</strong>
                                    <span v-if="variation.options">
                                        {{
                                            Object.entries(variation.options)
                                                .map(([key, val]) => `${key}: ${val}`)
                                                .join(', ')
                                        }}
                                    </span>
                                    <span v-else>N/A</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <DialogFooter class="mt-4 flex justify-end gap-2">
                <Button>Make Order</Button>
                <Button variant="outline" @click="handleClose">Close</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
