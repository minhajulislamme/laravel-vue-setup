<template>
    <Head title="Products - SkyShop" />
    
    <EcommerceLayout>
        <div class="container mx-auto px-4 py-8">
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">সব পণ্য</h1>
                    <p class="text-gray-600">{{ totalProducts }} টি পণ্য পাওয়া গেছে</p>
                </div>
                
                <!-- Sort & Filter -->
                <div class="flex items-center space-x-4 mt-4 md:mt-0">
                    <select 
                        v-model="sortBy" 
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-orange-500"
                        @change="applyFilters"
                    >
                        <option value="newest">নতুন</option>
                        <option value="price_low">দাম কম থেকে বেশি</option>
                        <option value="price_high">দাম বেশি থেকে কম</option>
                        <option value="popular">জনপ্রিয়</option>
                        <option value="rating">রেটিং</option>
                    </select>
                    
                    <button 
                        @click="toggleFilters"
                        class="flex items-center space-x-2 border border-gray-300 rounded-lg px-3 py-2 text-sm hover:bg-gray-50"
                    >
                        <Filter class="w-4 h-4" />
                        <span>ফিল্টার</span>
                    </button>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Filters -->
                <div 
                    class="w-full lg:w-64 space-y-6"
                    :class="{ 'hidden lg:block': !showFilters }"
                >
                    <!-- Categories -->
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <h3 class="font-semibold text-gray-800 mb-4">ক্যাটেগরি</h3>
                        <div class="space-y-2">
                            <label 
                                v-for="category in categories" 
                                :key="category.id"
                                class="flex items-center space-x-2 cursor-pointer"
                            >
                                <input 
                                    type="checkbox" 
                                    :value="category.id" 
                                    v-model="selectedCategories"
                                    @change="applyFilters"
                                    class="rounded text-orange-600 focus:ring-orange-500"
                                />
                                <span class="text-sm text-gray-700">{{ category.name }}</span>
                                <span class="text-xs text-gray-500">({{ category.count }})</span>
                            </label>
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <h3 class="font-semibold text-gray-800 mb-4">দামের পরিসর</h3>
                        <div class="space-y-3">
                            <div class="flex items-center space-x-2">
                                <input 
                                    type="number" 
                                    placeholder="সর্বনিম্ন" 
                                    v-model="priceRange.min"
                                    class="w-full border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:border-orange-500"
                                />
                                <span class="text-gray-500">-</span>
                                <input 
                                    type="number" 
                                    placeholder="সর্বোচ্চ" 
                                    v-model="priceRange.max"
                                    class="w-full border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:border-orange-500"
                                />
                            </div>
                            <button 
                                @click="applyFilters"
                                class="w-full bg-orange-600 text-white py-2 rounded text-sm hover:bg-orange-700 transition-colors"
                            >
                                প্রয়োগ করুন
                            </button>
                        </div>
                    </div>

                    <!-- Ratings -->
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <h3 class="font-semibold text-gray-800 mb-4">রেটিং</h3>
                        <div class="space-y-2">
                            <label 
                                v-for="rating in [5, 4, 3, 2, 1]" 
                                :key="rating"
                                class="flex items-center space-x-2 cursor-pointer"
                            >
                                <input 
                                    type="radio" 
                                    :value="rating" 
                                    v-model="selectedRating"
                                    @change="applyFilters"
                                    name="rating"
                                    class="text-orange-600 focus:ring-orange-500"
                                />
                                <div class="flex items-center">
                                    <Star 
                                        v-for="i in 5" 
                                        :key="i"
                                        class="w-4 h-4"
                                        :class="i <= rating ? 'text-yellow-400 fill-current' : 'text-gray-300'"
                                    />
                                    <span class="text-sm text-gray-700 ml-1">ও তার উপরে</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="flex-1">
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                        <ProductCard 
                            v-for="product in products" 
                            :key="product.id"
                            :product="product"
                        />
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8 flex justify-center">
                        <div class="flex items-center space-x-2">
                            <button 
                                v-for="page in totalPages" 
                                :key="page"
                                @click="goToPage(page)"
                                class="px-3 py-2 rounded border text-sm"
                                :class="currentPage === page 
                                    ? 'bg-orange-600 text-white border-orange-600' 
                                    : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'"
                            >
                                {{ page }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </EcommerceLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import EcommerceLayout from '@/layouts/Ecommerce/EcommerceLayout.vue';
import ProductCard from '@/components/Ecommerce/Products/ProductCard.vue';
import { Filter, Star } from 'lucide-vue-next';

// Reactive data
const showFilters = ref(false);
const sortBy = ref('newest');
const selectedCategories = ref<number[]>([]);
const selectedRating = ref<number | null>(null);
const priceRange = ref({ min: null, max: null });
const currentPage = ref(1);

// Sample data
const categories = ref([
    { id: 1, name: 'ইলেকট্রনিক্স', count: 1240 },
    { id: 2, name: 'ফ্যাশন', count: 856 },
    { id: 3, name: 'হোম ও গার্ডেন', count: 642 },
    { id: 4, name: 'বিউটি', count: 423 },
    { id: 5, name: 'খেলাধুলা', count: 318 },
    { id: 6, name: 'বই', count: 756 },
]);

const products = ref([
    {
        id: 1,
        name: 'স্মার্ট ওয়াচ প্রো',
        price: 2500,
        originalPrice: 3500,
        discount: 29,
        rating: 4.5,
        soldCount: 145
    },
    {
        id: 2,
        name: 'ওয়্যারলেস ইয়ারবাড',
        price: 1200,
        originalPrice: 1800,
        discount: 33,
        rating: 4.3,
        soldCount: 234
    },
    {
        id: 3,
        name: 'পাওয়ার ব্যাংক 20000mAh',
        price: 800,
        originalPrice: 1200,
        discount: 33,
        rating: 4.7,
        soldCount: 89
    },
    {
        id: 4,
        name: 'ব্লুটুথ স্পিকার',
        price: 1500,
        originalPrice: 2200,
        discount: 32,
        rating: 4.4,
        soldCount: 167
    },
    {
        id: 5,
        name: 'প্রিমিয়াম ফোন কেস',
        price: 300,
        originalPrice: 500,
        discount: 40,
        rating: 4.2,
        soldCount: 312
    },
    {
        id: 6,
        name: 'গেমিং ল্যাপটপ',
        price: 45000,
        originalPrice: 50000,
        discount: 10,
        rating: 4.6,
        soldCount: 45
    },
    {
        id: 7,
        name: 'স্মার্টফোন প্রো ম্যাক্স',
        price: 15000,
        originalPrice: 18000,
        discount: 17,
        rating: 4.4,
        soldCount: 78
    },
    {
        id: 8,
        name: 'ট্যাবলেট 10 ইঞ্চি',
        price: 12000,
        originalPrice: 15000,
        discount: 20,
        rating: 4.3,
        soldCount: 56
    },
]);

const totalProducts = computed(() => products.value.length);
const totalPages = computed(() => Math.ceil(totalProducts.value / 12));

const toggleFilters = () => {
    showFilters.value = !showFilters.value;
};

const applyFilters = () => {
    // In a real app, this would make an API call with the current filters
    console.log('Applying filters:', {
        sortBy: sortBy.value,
        categories: selectedCategories.value,
        rating: selectedRating.value,
        priceRange: priceRange.value
    });
};

const goToPage = (page: number) => {
    currentPage.value = page;
    // In a real app, this would load new products
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

onMounted(() => {
    // Load initial products
});
</script>
