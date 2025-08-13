<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Product',
        href: '/product',
    },
    {
        title: 'Create Product',
        href: '/create-product',
    },
];

const { categories, brands, allAttributes } = usePage().props;

const form = useForm({
    title: '',
    short_des: '',
    long_des: '',
    category_id: '',
    brand_id: '',
    weight: '',
    remark: '',
    barcode: '',
    meta_title: '',
    meta_description: '',
    status: 'active',
    attributes: [],
    variations: [],
    cover_image: null,
});

// --- Attribute Management ---
function addAttribute() {
    form.attributes.push({ name: '', options: '' });
}

function removeAttribute(index) {
    form.attributes.splice(index, 1);
}

// --- Variation Generation Logic ---
function generateVariations() {
    if (!form.attributes.length) {
        // If no attributes, create one simple variation.
        form.variations = [{ price: '', stock: '', sku: '', options: {}, images: [] }];
        return;
    }

    // Filter out attributes with no options
    const attributesWithOptions = form.attributes.filter((attr) => attr.options.trim() !== '');
    if (!attributesWithOptions.length) {
        form.variations = [{ price: '', stock: '', sku: '', options: {}, images: [] }];
        return;
    }

    // The famous Cartesian Product algorithm to get all combinations
    const arrays = attributesWithOptions.map((attr) => attr.options.split(',').map((s) => s.trim()));
    const cartesian = arrays.reduce((a, b) => a.flatMap((d) => b.map((e) => [d, e].flat())), [[]]);

    // Create the variation objects from the combinations
    form.variations = cartesian.map((combination) => {
        const options = {};
        combination.forEach((optionValue, index) => {
            const attributeName = attributesWithOptions[index].name;
            options[attributeName] = optionValue;
        });
        return {
            price: '',
            stock: '',
            sku: '',
            options: options,
            images: [],
        };
    });
}

function handleVariationImagesUpload(event, variation) {
    // Assign uploaded files directly to the specific variation's 'images' array
    variation.images = Array.from(event.target.files);
}

// Reactive variables for success alert
const showSuccessAlert = ref(false);
const successAlertMessage = ref('');

// --- Form Submission ---
const submit = () => {
    form.post(route('product.store'), {
        forceFormData: true,
        onSuccess: () => {
            successAlertMessage.value = 'Pruduct created successfully!';
            showSuccessAlert.value = true;

            form.reset();

            setTimeout(() => {
                showSuccessAlert.value = false;
            }, 3000);
        },
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Create Product" />

        <!-- Success Alert -->
        <div v-if="showSuccessAlert" class="fixed top-5 right-5 z-50 w-auto max-w-sm">
            <Alert>
                <!-- <SquareCheckBig class="h-4 w-4" /> -->
                <AlertTitle>Success!</AlertTitle>
                <AlertDescription>
                    {{ successAlertMessage }}
                </AlertDescription>
            </Alert>
        </div>

        <div class="px-4 py-6">
            <form @submit.prevent="submit" class="mx-auto flex max-w-4xl flex-col gap-8 rounded-2xl bg-white p-6 shadow-md">
                <div class="space-y-6">
                    <h2 class="text-xl font-semibold">Product Information</h2>
                    <div class="grid gap-2">
                        <Label for="title">Product Name</Label>
                        <Input id="title" type="text" v-model="form.title" placeholder="e.g., Premium Cotton T-Shirt" required />
                        <InputError :message="form.errors.title" />
                    </div>
                    <div class="grid grid-cols-1 justify-between gap-6 md:grid-cols-4">
                        <div class="grid gap-2">
                            <Label for="category_id">Category</Label>
                            <Select v-model="form.category_id">
                                <SelectTrigger class="w-full"><SelectValue placeholder="Select a category" /></SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.name }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.category_id" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="brand_id">Brand</Label>
                            <Select v-model="form.brand_id">
                                <SelectTrigger class="w-full"><SelectValue placeholder="Select a brand" /></SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="brand in brands" :key="brand.id" :value="brand.id">
                                        {{ brand.name }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.brand_id" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="status">Status</Label>
                            <Select v-model="form.status">
                                <SelectTrigger class="w-full"><SelectValue placeholder="Select status" /></SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="active">Active</SelectItem>
                                    <SelectItem value="draft">Draft</SelectItem>
                                    <SelectItem value="archived">Archived</SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.status" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="remark">Remark</Label>
                            <Select v-model="form.remark">
                                <SelectTrigger class="w-full"><SelectValue placeholder="Select remark" /></SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="Popular">Popular</SelectItem>
                                    <SelectItem value="New">New</SelectItem>
                                    <SelectItem value="Top">Top</SelectItem>
                                    <SelectItem value="Special">Special</SelectItem>
                                    <SelectItem value="Trending">Trending</SelectItem>
                                    <SelectItem value="Regular">Regular</SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.remark" />
                        </div>
                    </div>
                    <div class="grid gap-2">
                        <Label for="short_des">Short Description</Label>
                        <Input
                            id="short_des"
                            placeholder="e.g., A comfortable and stylish t-shirt for everyday wear"
                            type="text"
                            v-model="form.short_des"
                        />
                        <InputError :message="form.errors.short_des" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="long_des">Long Description</Label>
                        <Textarea
                            id="long_des"
                            placeholder="e.g., This premium cotton t-shirt is made from high-quality materials..."
                            v-model="form.long_des"
                            rows="4"
                        />
                        <InputError :message="form.errors.long_des" />
                    </div>
                </div>
                <div class="grid gap-2">
                    <Label for="cover_image">Cover Image</Label>
                    <Input id="cover_image" type="file" accept="image/*" @change="(e) => (form.cover_image = e.target.files[0])" />
                    <InputError :message="form.errors.cover_image" />
                </div>

                <div class="space-y-4 rounded-lg border p-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold">Product Attributes</h2>
                        <Button type="button" @click="addAttribute">Add Attribute</Button>
                    </div>
                    <p class="text-sm text-gray-500">Define attributes like Color or Size. Use commas to separate options (e.g., Red,Green,Blue).</p>

                    <div v-for="(attribute, index) in form.attributes" :key="index" class="flex items-end gap-4">
                        <div class="grid flex-grow gap-2">
                            <Label>Attribute Name</Label>
                            <Input type="text" v-model="attribute.name" placeholder="e.g., Color" />
                        </div>
                        <div class="grid flex-grow gap-2">
                            <Label>Options (comma separated)</Label>
                            <Input type="text" v-model="attribute.options" placeholder="e.g., Red, Blue, Green" />
                        </div>
                        <Button type="button" variant="destructive" @click="removeAttribute(index)">Remove</Button>
                    </div>
                </div>

                <div class="flex justify-center">
                    <Button type="button" @click="generateVariations" class="bg-indigo-600 text-white hover:bg-indigo-700">
                        Generate Product Variations
                    </Button>
                </div>
                <InputError :message="form.errors.variations" class="text-center" />

                <div v-if="form.variations.length > 0" class="space-y-6">
                    <h2 class="text-xl font-semibold">Generated Variations</h2>
                    <div v-for="(variation, index) in form.variations" :key="index" class="space-y-4 rounded-lg border p-4">
                        <h3 class="font-medium text-gray-800">
                            Variation {{ index + 1 }}
                            <span v-if="Object.keys(variation.options).length" class="text-sm text-indigo-600">
                                ({{
                                    Object.entries(variation.options)
                                        .map(([key, val]) => `${key}: ${val}`)
                                        .join(' / ')
                                }})
                            </span>
                        </h3>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                            <div class="grid gap-2">
                                <Label :for="`price_${index}`">Price</Label>
                                <Input :id="`price_${index}`" type="number" v-model="variation.price" placeholder="Price" required />
                                <InputError :message="form.errors[`variations.${index}.price`]" />
                            </div>
                            <div class="grid gap-2">
                                <Label :for="`stock_${index}`">Stock</Label>
                                <Input :id="`stock_${index}`" type="number" v-model="variation.stock" placeholder="Stock" required />
                                <InputError :message="form.errors[`variations.${index}.stock`]" />
                            </div>
                            <div class="grid gap-2">
                                <Label :for="`sku_${index}`">SKU</Label>
                                <Input :id="`sku_${index}`" type="text" v-model="variation.sku" placeholder="SKU (optional)" />
                                <InputError :message="form.errors[`variations.${index}.sku`]" />
                            </div>
                            <div class="grid gap-2">
                                <Label :for="`images_${index}`">Images</Label>
                                <Input
                                    :id="`images_${index}`"
                                    type="file"
                                    multiple
                                    accept="image/*"
                                    @change="handleVariationImagesUpload($event, variation)"
                                />
                                <InputError :message="form.errors[`variations.${index}.images`]" />
                            </div>
                        </div>
                    </div>
                </div>

                <Button type="submit" :disabled="form.processing" class="w-full py-3"> Save Product </Button>
            </form>
        </div>
    </AppLayout>
</template>
