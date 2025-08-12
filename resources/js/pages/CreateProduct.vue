<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/vue3';
const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Create Product',
        href: '/create-product',
    },
];
const form = useForm({
    title: '',
    short_des: '',
    long_des: '',
    price: '',
    discount: false,
    discount_price: '',
    stock: '',
    remark: '',
    category_id: '',
    brand_id: '',
    image: null,
    images: [],
});
const { categories, brands } = usePage().props;
const submit = () => {
    form.post(route('product'), {
        onSuccess: () => {
            // route to /product
            window.location.href = '/product';
        },
    });
};

function handleImagesUpload(e) {
    form.value.images = Array.from(e.target.files);
}

function handleMainImageUpload(e) {
    form.value.image = e.target.files[0];
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Create Product" />
        <div class="px-4 py-6">
            <form @submit.prevent="submit" class="mx-auto flex max-w-2xl flex-col gap-6 rounded-2xl bg-white p-6 shadow-md">
                <!-- Title -->
                <div class="grid gap-2">
                    <Label for="title">Product Name</Label>
                    <Input id="title" type="text" v-model="form.title" placeholder="Honey Nut" required autofocus />
                    <InputError :message="form.errors.title" />
                </div>

                <!-- Short Description -->
                <div class="grid gap-2">
                    <Label for="short_des">Short Description</Label>
                    <Input id="short_des" type="text" v-model="form.short_des" placeholder="A short and sweet product intro" required />
                    <InputError :message="form.errors.short_des" />
                </div>

                <!-- Long Description -->
                <div class="grid gap-2">
                    <Label for="long_des">Long Description</Label>
                    <Textarea id="long_des" v-model="form.long_des" placeholder="Detailed product information..." rows="4" required />
                    <InputError :message="form.errors.long_des" />
                </div>

                <!-- Price -->
                <div class="grid gap-2">
                    <Label for="price">Price</Label>
                    <Input id="price" type="number" v-model="form.price" placeholder="100" required />
                    <InputError :message="form.errors.price" />
                </div>

                <!-- Discount -->
                <div class="flex items-center gap-3">
                    <Checkbox id="discount" v-model="form.discount" />
                    <Label for="discount" class="cursor-pointer">Has Discount?</Label>
                </div>

                <!-- Discount Price -->
                <div v-if="form.discount" class="grid gap-2">
                    <Label for="discount_price">Discount Price</Label>
                    <Input id="discount_price" type="number" v-model="form.discount_price" placeholder="80" />
                    <InputError :message="form.errors.discount_price" />
                </div>

                <!-- Stock -->
                <div class="grid gap-2">
                    <Label for="stock">Stock Quantity</Label>
                    <Input id="stock" type="number" v-model="form.stock" placeholder="0" />
                    <InputError :message="form.errors.stock" />
                </div>

                <!-- Remark -->
                <div class="grid gap-2">
                    <Label for="remark">Remark</Label>
                    <Select v-model="form.remark">
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="Select a remark" />
                        </SelectTrigger>
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

                <!-- Category -->
                <div class="grid gap-2">
                    <Label for="category_id">Category</Label>
                    <Select v-model="form.category_id">
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="Select a category" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                    <InputError :message="form.errors.category_id" />
                </div>

                <!-- Brand -->
                <div class="grid gap-2">
                    <Label for="brand_id">Brand</Label>
                    <Select v-model="form.brand_id">
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="Select a brand" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem v-for="brand in brands" :key="brand.id" :value="brand.id">
                                {{ brand.name }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                    <InputError :message="form.errors.brand_id" />
                </div>

                <!-- Image -->
                <div class="grid gap-2">
                    <Label for="image">Main Image</Label>
                    <Input id="image" type="file" accept="image/*" @change="handleMainImageUpload" />
                    <InputError :message="form.errors.image" />
                </div>

                <!-- Images -->
                <div class="grid gap-2">
                    <Label for="images">Additional Images</Label>
                    <Input id="images" type="file" multiple accept="image/*" @change="handleImagesUpload" />
                    <InputError :message="form.errors.images" />
                </div>

                <!-- Submit -->
                <Button type="submit" class="w-full"> Save Product </Button>
            </form>
        </div>
    </AppLayout>
</template>
