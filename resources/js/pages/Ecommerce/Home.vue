<template>
    <Head title="Home - SkyShop" />
    
    <EcommerceLayout>
        <!-- Hero Banner -->
        <HeroBanner />

        <!-- Featured Categories -->
        <section class="container mx-auto px-4 py-12 md:py-16">
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-4">
                    Popular Categories
                </h2>
                <p class="text-gray-600 text-base md:text-lg">Discover what's trending in our store</p>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 md:gap-6">
                <div 
                    v-for="category in featuredCategories" 
                    :key="category.id"
                    class="bg-white rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-lg hover:shadow-2xl transition-all duration-300 cursor-pointer group border border-gray-100 hover:border-orange-200"
                    @click="goToCategory(category.slug)"
                >
                    <div class="text-center">
                        <div class="w-16 h-16 md:w-20 md:h-20 mx-auto mb-3 md:mb-4 bg-gradient-to-br from-orange-100 to-red-100 rounded-2xl md:rounded-3xl flex items-center justify-center group-hover:from-orange-200 group-hover:to-red-200 transition-all duration-300 group-hover:scale-110">
                            <span class="text-2xl md:text-3xl">{{ category.icon }}</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-1 md:mb-2 group-hover:text-orange-600 transition-colors text-sm md:text-base">{{ category.name }}</h3>
                        <p class="text-xs md:text-sm text-gray-500">{{ category.count }} products</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Flash Sale -->
        <section class="bg-gradient-to-br from-orange-500 via-red-500 to-pink-600 py-16 relative overflow-hidden">
            <!-- Background Elements -->
            <div class="absolute inset-0">
                <div class="absolute top-10 left-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute bottom-10 right-10 w-48 h-48 bg-yellow-300/20 rounded-full blur-3xl"></div>
            </div>
            
            <div class="container mx-auto px-4 relative z-10">
                <div class="text-center text-white mb-12">
                    <span class="inline-block px-6 py-3 bg-white/20 backdrop-blur-sm rounded-full text-lg font-medium mb-4">
                        ⚡ Limited Time Only
                    </span>
                    <h2 class="text-4xl md:text-5xl font-bold mb-4">Flash Sale</h2>
                    <p class="text-xl text-white/90 mb-8">Grab these deals before time runs out!</p>
                    
                    <!-- Modern Countdown Timer -->
                    <div class="flex justify-center items-center space-x-6 mb-8">
                        <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 border border-white/30">
                            <div class="text-3xl font-bold">{{ countdown.hours }}</div>
                            <div class="text-sm opacity-90">Hours</div>
                        </div>
                        <div class="text-2xl animate-pulse">:</div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 border border-white/30">
                            <div class="text-3xl font-bold">{{ countdown.minutes }}</div>
                            <div class="text-sm opacity-90">Minutes</div>
                        </div>
                        <div class="text-2xl animate-pulse">:</div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 border border-white/30">
                            <div class="text-3xl font-bold">{{ countdown.seconds }}</div>
                            <div class="text-sm opacity-90">Seconds</div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-6">
                    <ProductCard 
                        v-for="product in flashSaleProducts" 
                        :key="product.id"
                        :product="product"
                        :is-flash-sale="true"
                    />
                </div>
            </div>
        </section>

        <!-- Featured Products -->
        <section class="container mx-auto px-4 py-12 md:py-16">
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-4">
                    Featured Products
                </h2>
                <p class="text-gray-600 text-base md:text-lg">Our best and most popular items</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 md:gap-6">
                <ProductCard 
                    v-for="product in featuredProducts" 
                    :key="product.id"
                    :product="product"
                />
            </div>

            <div class="text-center mt-8 md:mt-12">
                <Link 
                    href="/products"
                    class="inline-flex items-center px-6 md:px-8 py-3 md:py-4 bg-gradient-to-r from-orange-600 to-red-600 text-white font-semibold rounded-xl md:rounded-2xl hover:from-orange-700 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 text-sm md:text-base"
                >
                    View All Products
                    <ArrowRight class="w-5 h-5 ml-2" />
                </Link>
            </div>
        </section>

        <!-- Why Choose Us -->
        <section class="bg-gradient-to-br from-slate-50 to-gray-100 py-16">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-4">
                        Why Choose Us?
                    </h2>
                    <p class="text-gray-600 text-lg">We're committed to providing the best shopping experience</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center group">
                        <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-3xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <Truck class="w-10 h-10 text-white" />
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Fast Delivery</h3>
                        <p class="text-gray-600 leading-relaxed">Get your orders delivered within 24-48 hours with our express shipping service</p>
                    </div>
                    <div class="text-center group">
                        <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-green-400 to-emerald-500 rounded-3xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <Shield class="w-10 h-10 text-white" />
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Secure Payment</h3>
                        <p class="text-gray-600 leading-relaxed">Shop with confidence using our 100% secure and encrypted payment system</p>
                    </div>
                    <div class="text-center group">
                        <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-orange-400 to-red-500 rounded-3xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <RotateCcw class="w-10 h-10 text-white" />
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Easy Returns</h3>
                        <p class="text-gray-600 leading-relaxed">Not satisfied? Return your purchase within 7 days with our hassle-free policy</p>
                    </div>
                </div>
            </div>
        </section>
    </EcommerceLayout>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import EcommerceLayout from '@/layouts/Ecommerce/EcommerceLayout.vue';
import HeroBanner from '@/components/Ecommerce/Banner/HeroBanner.vue';
import ProductCard from '@/components/Ecommerce/Products/ProductCard.vue';
import { 
    ArrowRight, 
    Truck, 
    Shield, 
    RotateCcw 
} from 'lucide-vue-next';

// Sample data (in real app, this would come from props/API)
const featuredCategories = ref([
    { id: 1, name: 'ইলেকট্রনিক্স', icon: '📱', count: 1240, slug: 'electronics' },
    { id: 2, name: 'ফ্যাশন', icon: '👗', count: 856, slug: 'fashion' },
    { id: 3, name: 'হোম ও গার্ডেন', icon: '🏠', count: 642, slug: 'home-garden' },
    { id: 4, name: 'বিউটি', icon: '💄', count: 423, slug: 'beauty' },
    { id: 5, name: 'খেলাধুলা', icon: '⚽', count: 318, slug: 'sports' },
    { id: 6, name: 'বই', icon: '📚', count: 756, slug: 'books' },
]);

const flashSaleProducts = ref([
    {
        id: 1,
        name: 'স্মার্ট ওয়াচ',
        image: '/images/watch.jpg',
        price: 2500,
        originalPrice: 3500,
        discount: 29,
        rating: 4.5,
        soldCount: 145
    },
    {
        id: 2,
        name: 'ওয়্যারলেস ইয়ারবাড',
        image: '/images/earbuds.jpg',
        price: 1200,
        originalPrice: 1800,
        discount: 33,
        rating: 4.3,
        soldCount: 234
    },
    {
        id: 3,
        name: 'পাওয়ার ব্যাংক',
        image: '/images/powerbank.jpg',
        price: 800,
        originalPrice: 1200,
        discount: 33,
        rating: 4.7,
        soldCount: 89
    },
    {
        id: 4,
        name: 'ব্লুটুথ স্পিকার',
        image: '/images/speaker.jpg',
        price: 1500,
        originalPrice: 2200,
        discount: 32,
        rating: 4.4,
        soldCount: 167
    },
    {
        id: 5,
        name: 'ফোন কেস',
        image: '/images/phonecase.jpg',
        price: 300,
        originalPrice: 500,
        discount: 40,
        rating: 4.2,
        soldCount: 312
    },
]);

const featuredProducts = ref([
    {
        id: 6,
        name: 'ল্যাপটপ',
        image: '/images/laptop.jpg',
        price: 45000,
        originalPrice: 50000,
        discount: 10,
        rating: 4.6,
        soldCount: 45
    },
    {
        id: 7,
        name: 'স্মার্টফোন',
        image: '/images/smartphone.jpg',
        price: 15000,
        originalPrice: 18000,
        discount: 17,
        rating: 4.4,
        soldCount: 78
    },
    {
        id: 8,
        name: 'ট্যাবলেট',
        image: '/images/tablet.jpg',
        price: 12000,
        originalPrice: 15000,
        discount: 20,
        rating: 4.3,
        soldCount: 56
    },
    {
        id: 9,
        name: 'হেডফোন',
        image: '/images/headphones.jpg',
        price: 2800,
        originalPrice: 3500,
        discount: 20,
        rating: 4.5,
        soldCount: 123
    },
    {
        id: 10,
        name: 'ক্যামেরা',
        image: '/images/camera.jpg',
        price: 25000,
        originalPrice: 30000,
        discount: 17,
        rating: 4.7,
        soldCount: 34
    },
]);

// Countdown timer
const countdown = ref({
    hours: 0,
    minutes: 0,
    seconds: 0
});

let countdownInterval: number | null = null;

const updateCountdown = () => {
    // Set target time (e.g., next midnight)
    const now = new Date();
    const tomorrow = new Date(now);
    tomorrow.setDate(tomorrow.getDate() + 1);
    tomorrow.setHours(0, 0, 0, 0);
    
    const diff = tomorrow.getTime() - now.getTime();
    
    countdown.value.hours = Math.floor(diff / (1000 * 60 * 60));
    countdown.value.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    countdown.value.seconds = Math.floor((diff % (1000 * 60)) / 1000);
};

const goToCategory = (slug: string) => {
    router.visit(`/categories/${slug}`);
};

onMounted(() => {
    updateCountdown();
    countdownInterval = setInterval(updateCountdown, 1000);
});

onUnmounted(() => {
    if (countdownInterval) {
        clearInterval(countdownInterval);
    }
});
</script>
