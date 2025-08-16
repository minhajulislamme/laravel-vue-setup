<template>
    <Head title="Categories - SkyShop" />
    
    <EcommerceLayout>
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">সব ক্যাটেগরি</h1>

            <!-- Main Categories Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 mb-12">
                <div 
                    v-for="category in mainCategories" 
                    :key="category.id"
                    class="bg-white rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow cursor-pointer group"
                    @click="goToCategory(category.slug)"
                >
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br rounded-full flex items-center justify-center group-hover:scale-110 transition-transform"
                             :style="{ backgroundImage: category.gradient }">
                            <span class="text-2xl">{{ category.icon }}</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">{{ category.name }}</h3>
                        <p class="text-sm text-gray-500">{{ category.count }} পণ্য</p>
                    </div>
                </div>
            </div>

            <!-- Popular Categories Section -->
            <section class="mb-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">জনপ্রিয় ক্যাটেগরি</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div 
                        v-for="category in popularCategories" 
                        :key="category.id"
                        class="relative bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow cursor-pointer group"
                        @click="goToCategory(category.slug)"
                    >
                        <!-- Category Banner -->
                        <div class="h-32 bg-gradient-to-r relative overflow-hidden"
                             :style="{ backgroundImage: category.gradient }">
                            <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center">
                                <span class="text-4xl">{{ category.icon }}</span>
                            </div>
                        </div>
                        
                        <!-- Category Info -->
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 mb-2">{{ category.name }}</h3>
                            <p class="text-sm text-gray-600 mb-3">{{ category.description }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">{{ category.count }} পণ্য</span>
                                <span class="text-orange-600 text-sm font-medium group-hover:text-orange-700">
                                    দেখুন →
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Trending Categories -->
            <section class="mb-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">ট্রেন্ডিং ক্যাটেগরি</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <div 
                        v-for="category in trendingCategories" 
                        :key="category.id"
                        class="relative bg-white rounded-lg p-4 shadow-md hover:shadow-lg transition-shadow cursor-pointer group"
                        @click="goToCategory(category.slug)"
                    >
                        <!-- Trending Badge -->
                        <div class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                            🔥 HOT
                        </div>
                        
                        <div class="text-center">
                            <div class="w-12 h-12 mx-auto mb-3 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-orange-100 transition-colors">
                                <span class="text-lg">{{ category.icon }}</span>
                            </div>
                            <h3 class="font-medium text-gray-800 text-sm mb-1">{{ category.name }}</h3>
                            <p class="text-xs text-gray-500">{{ category.count }} পণ্য</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Browse by Brand -->
            <section>
                <h2 class="text-2xl font-bold text-gray-800 mb-6">ব্র্যান্ড অনুসারে ব্রাউজ করুন</h2>
                <div class="grid grid-cols-3 md:grid-cols-6 lg:grid-cols-8 gap-4">
                    <div 
                        v-for="brand in brands" 
                        :key="brand.id"
                        class="bg-white rounded-lg p-4 shadow-md hover:shadow-lg transition-shadow cursor-pointer group"
                        @click="goToBrand(brand.slug)"
                    >
                        <div class="text-center">
                            <div class="w-12 h-12 mx-auto mb-2 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-orange-100 transition-colors">
                                <span class="text-sm font-bold text-gray-600">{{ brand.initial }}</span>
                            </div>
                            <h3 class="font-medium text-gray-800 text-xs">{{ brand.name }}</h3>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </EcommerceLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import EcommerceLayout from '@/layouts/Ecommerce/EcommerceLayout.vue';

const mainCategories = ref([
    { 
        id: 1, 
        name: 'ইলেকট্রনিক্স', 
        icon: '📱', 
        count: 1240, 
        slug: 'electronics',
        gradient: 'linear-gradient(45deg, #667eea 0%, #764ba2 100%)'
    },
    { 
        id: 2, 
        name: 'ফ্যাশন', 
        icon: '👗', 
        count: 856, 
        slug: 'fashion',
        gradient: 'linear-gradient(45deg, #f093fb 0%, #f5576c 100%)'
    },
    { 
        id: 3, 
        name: 'হোম ও গার্ডেন', 
        icon: '🏠', 
        count: 642, 
        slug: 'home-garden',
        gradient: 'linear-gradient(45deg, #4facfe 0%, #00f2fe 100%)'
    },
    { 
        id: 4, 
        name: 'বিউটি', 
        icon: '💄', 
        count: 423, 
        slug: 'beauty',
        gradient: 'linear-gradient(45deg, #43e97b 0%, #38f9d7 100%)'
    },
    { 
        id: 5, 
        name: 'খেলাধুলা', 
        icon: '⚽', 
        count: 318, 
        slug: 'sports',
        gradient: 'linear-gradient(45deg, #fa709a 0%, #fee140 100%)'
    },
    { 
        id: 6, 
        name: 'বই', 
        icon: '📚', 
        count: 756, 
        slug: 'books',
        gradient: 'linear-gradient(45deg, #a8edea 0%, #fed6e3 100%)'
    },
]);

const popularCategories = ref([
    {
        id: 1,
        name: 'স্মার্টফোন ও ট্যাবলেট',
        description: 'সর্বশেষ স্মার্টফোন এবং ট্যাবলেট কালেকশন',
        icon: '📱',
        count: 567,
        slug: 'smartphones-tablets',
        gradient: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)'
    },
    {
        id: 2,
        name: 'পুরুষ ফ্যাশন',
        description: 'পুরুষদের জন্য ট্রেন্ডি পোশাক ও এক্সেসরিজ',
        icon: '👔',
        count: 423,
        slug: 'mens-fashion',
        gradient: 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)'
    },
    {
        id: 3,
        name: 'কিচেন অ্যাপ্লায়েন্স',
        description: 'রান্নাঘরের জন্য আধুনিক যন্ত্রপাতি',
        icon: '🍳',
        count: 234,
        slug: 'kitchen-appliances',
        gradient: 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)'
    },
]);

const trendingCategories = ref([
    { id: 1, name: 'গেমিং', icon: '🎮', count: 156, slug: 'gaming' },
    { id: 2, name: 'ফিটনেস', icon: '💪', count: 89, slug: 'fitness' },
    { id: 3, name: 'ট্রাভেল', icon: '🧳', count: 234, slug: 'travel' },
    { id: 4, name: 'পেট কেয়ার', icon: '🐕', count: 67, slug: 'pet-care' },
    { id: 5, name: 'অটো পার্টস', icon: '🚗', count: 123, slug: 'auto-parts' },
    { id: 6, name: 'টয়েজ', icon: '🧸', count: 345, slug: 'toys' },
]);

const brands = ref([
    { id: 1, name: 'Samsung', initial: 'S', slug: 'samsung' },
    { id: 2, name: 'Apple', initial: 'A', slug: 'apple' },
    { id: 3, name: 'Nike', initial: 'N', slug: 'nike' },
    { id: 4, name: 'Adidas', initial: 'AD', slug: 'adidas' },
    { id: 5, name: 'Sony', initial: 'SO', slug: 'sony' },
    { id: 6, name: 'LG', initial: 'LG', slug: 'lg' },
    { id: 7, name: 'HP', initial: 'HP', slug: 'hp' },
    { id: 8, name: 'Dell', initial: 'D', slug: 'dell' },
]);

const goToCategory = (slug: string) => {
    router.visit(`/categories/${slug}`);
};

const goToBrand = (slug: string) => {
    router.visit(`/brands/${slug}`);
};
</script>
