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
        <DialogContent v-if="item" class="max-h-[90vh] w-full max-w-4xl overflow-y-auto p-4 sm:p-6">
            <!-- Header -->
            <DialogHeader>
                <DialogTitle class="text-xl font-semibold">
                    {{ item.title }}
                </DialogTitle>
                <DialogDescription> All available variations & attributes </DialogDescription>
            </DialogHeader>

            <!-- Variations List -->
            <div v-if="item.variations?.length > 0" class="mt-4 space-y-4">
                <div
                    v-for="variation in item.variations"
                    :key="variation.id"
                    class="flex flex-col gap-4 rounded-lg border p-4 shadow-sm transition hover:shadow-md"
                >
                    <!-- Variation Top Row -->
                    <div class="flex flex-wrap items-center gap-4">
                        <!-- Variation Image -->
                        <div class="flex-shrink-0">
                            <img
                                v-if="variation.images?.length > 0"
                                :src="variation.images?.length > 0 ? `/storage/${variation.images[0].url}` : 'https://placehold.co/100x100/png'"
                                alt="Variation Image"
                                class="h-20 w-20 rounded-md object-cover"
                            />
                            <div v-else class="flex h-20 w-20 items-center justify-center rounded-md bg-gray-200 text-gray-500">No Image</div>
                        </div>

                        <!-- Variation Basic Info -->
                        <div class="flex-1">
                            <p class="font-medium">
                                SKU: <span class="text-gray-700">{{ variation.sku || 'N/A' }}</span>
                            </p>
                            <p class="text-sm">
                                Price: <span class="font-semibold text-green-600">${{ variation.price }}</span>
                            </p>
                            <p class="text-sm">Discount: ${{ variation.discount_price || '0' }}</p>
                            <p class="text-sm">Stock: {{ variation.stock }} units</p>
                        </div>
                    </div>

                    <!-- Attributes -->
                    <div class="border-t pt-2 text-sm">
                        <p class="font-semibold">Attributes:</p>
                        <div v-if="variation.options" class="mt-1 flex flex-wrap gap-2">
                            <span
                                v-for="[key, val] in Object.entries(variation.options)"
                                :key="key"
                                class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium"
                            >
                                {{ key }}: {{ val }}
                            </span>
                        </div>
                        <p v-else class="text-gray-500">N/A</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <DialogFooter class="mt-6 flex justify-end gap-2">
                <Button>Make Order</Button>
                <Button variant="outline" @click="handleClose">Close</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
