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
            <DialogHeader class="">
                <DialogTitle>{{ item.title }}</DialogTitle>
                <DialogDescription>{{ item.long_des }}</DialogDescription>
            </DialogHeader>

            <div class="grid gap-6 overflow-y-auto">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div class="col-span-1">
                        <img :src="item.image" alt="Product" class="aspect-square w-full rounded-lg object-cover" />
                    </div>
                    <div class="md:col-span-2">
                        <h3 class="mb-3 text-lg font-semibold">Product Details</h3>

                        <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm">
                            <p><strong>Price:</strong> ${{ item.price }}</p>
                            <p><strong>Discount:</strong> ${{ item.discount_price }}</p>
                            <p><strong>Stock:</strong> {{ item.stock }} units</p>
                            <p><strong>Category:</strong> {{ item.category.name }}</p>
                            <p><strong>Brand:</strong> {{ item.brand.brandName }}</p>
                        </div>
                    </div>
                </div>

                <div v-if="item.variations?.length > 0">
                    <h3 class="mb-3 text-lg font-semibold">Available Variations</h3>
                    <div class="flex flex-wrap gap-3">
                        <div
                            v-for="variation in item.variations"
                            :key="variation.id"
                            class="flex items-center gap-2 rounded-md border bg-secondary/50 p-2"
                        >
                            <img v-if="variation.image" :src="variation.image" :alt="variation.option" class="h-6 w-6 rounded-full object-cover" />
                            <span class="text-sm font-medium">{{ variation.name }}:</span>
                            <span class="text-sm">{{ variation.option }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <DialogFooter>
                <Button>Make Order</Button>
                <Button @click="handleClose">Close</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
