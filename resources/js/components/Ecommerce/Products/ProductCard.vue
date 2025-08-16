<template>
    <Link 
        :href="`/products/${product.id}`"
        class="block bg-white rounded-2xl md:rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 group cursor-pointer border border-gray-100 overflow-hidden hover:border-orange-200 relative"
    >
        <!-- Product Image -->
        <div class="relative overflow-hidden rounded-t-2xl md:rounded-t-3xl">
            <div class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center group-hover:from-orange-50 group-hover:to-red-50 transition-all duration-300">
                <!-- Modern placeholder with gradient -->
                <div class="w-full h-full bg-gradient-to-br from-slate-100 via-gray-100 to-slate-200 flex items-center justify-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent -skew-x-12 transform translate-x-full group-hover:translate-x-[-200%] transition-transform duration-1000"></div>
                    <Package class="w-12 h-12 md:w-16 md:h-16 text-gray-300 group-hover:text-orange-300 transition-colors duration-300" />
                </div>
            </div>
            
            <!-- Discount Badge -->
            <div 
                v-if="product.discount" 
                class="absolute top-2 left-2 md:top-4 md:left-4 bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs md:text-sm font-bold px-2 py-1 md:px-3 md:py-1.5 rounded-full shadow-lg animate-pulse"
            >
                -{{ product.discount }}%
            </div>
            
            <!-- Flash Sale Badge -->
            <div 
                v-if="isFlashSale" 
                class="absolute top-2 right-2 md:top-4 md:right-4 bg-gradient-to-r from-orange-400 to-red-500 text-white text-xs md:text-sm font-bold px-2 py-1 md:px-3 md:py-1.5 rounded-full shadow-lg flex items-center gap-1"
            >
                <Flame class="w-3 h-3 md:w-4 md:h-4" />
                <span class="hidden sm:inline">Flash</span>
            </div>
            
            <!-- Quick Actions -->
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                <div class="flex space-x-2 md:space-x-3 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                    <button 
                        @click.stop.prevent="addToWishlist"
                        class="bg-white/90 backdrop-blur-sm p-2 md:p-3 rounded-full shadow-lg hover:bg-white transition-all duration-300 transform hover:scale-110"
                        :class="{ 'text-red-500 bg-red-50': isInWishlist, 'text-gray-600': !isInWishlist }"
                    >
                        <Heart class="w-4 h-4 md:w-5 md:h-5" :class="{ 'fill-current': isInWishlist }" />
                    </button>
                    <button 
                        @click.stop.prevent="quickView"
                        class="bg-white/90 backdrop-blur-sm p-2 md:p-3 rounded-full shadow-lg hover:bg-white transition-all duration-300 text-gray-600 transform hover:scale-110"
                    >
                        <Eye class="w-4 h-4 md:w-5 md:h-5" />
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Product Info -->
        <div class="p-3 md:p-6">
            <!-- Product Name -->
            <h3 class="font-semibold text-gray-800 text-sm md:text-base mb-2 md:mb-3 line-clamp-2 group-hover:text-orange-600 transition-colors duration-300 leading-relaxed">
                {{ product.name }}
            </h3>
            
            <!-- Rating -->
            <div class="flex items-center mb-2 md:mb-3">
                <div class="flex items-center mr-2">
                    <Star 
                        v-for="i in 5" 
                        :key="i"
                        class="w-3 h-3 md:w-4 md:h-4"
                        :class="i <= Math.floor(product.rating) ? 'text-yellow-400 fill-current' : 'text-gray-200'"
                    />
                </div>
                <span class="text-xs md:text-sm text-gray-500">({{ product.rating }})</span>
            </div>
            
            <!-- Price -->
            <div class="flex items-center justify-between mb-3 md:mb-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2">
                    <span class="text-lg md:text-xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
                        ৳{{ formatPrice(product.price) }}
                    </span>
                    <span 
                        v-if="product.originalPrice && product.originalPrice > product.price" 
                        class="text-xs md:text-sm text-gray-400 line-through"
                    >
                        ৳{{ formatPrice(product.originalPrice) }}
                    </span>
                </div>
            </div>
            
            <!-- Flash Sale Progress -->
            <div v-if="isFlashSale" class="mb-3 md:mb-4">
                <div class="flex justify-between text-xs text-gray-600 mb-2">
                    <span>Sold: {{ product.soldCount }}</span>
                    <span>{{ progressPercentage.toFixed(1) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-1.5 md:h-2 overflow-hidden">
                    <div 
                        class="bg-gradient-to-r from-orange-400 to-red-500 h-1.5 md:h-2 rounded-full transition-all duration-1000 ease-out"
                        :style="{ width: progressPercentage + '%' }"
                    ></div>
                </div>
            </div>
            
            <!-- Add to Cart Button -->
            <button 
                @click.stop.prevent="addToCart"
                class="w-full bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white font-semibold py-2 md:py-3 px-3 md:px-4 rounded-xl md:rounded-2xl transition-all duration-300 flex items-center justify-center space-x-1 md:space-x-2 shadow-lg hover:shadow-xl transform hover:scale-[1.02] disabled:opacity-70 disabled:cursor-not-allowed text-sm md:text-base"
                :disabled="isAddingToCart"
            >
                <ShoppingCart class="w-4 h-4 md:w-5 md:h-5" />
                <span class="hidden sm:inline">{{ isAddingToCart ? 'Adding...' : 'Add to Cart' }}</span>
                <span class="sm:hidden">{{ isAddingToCart ? 'Adding...' : 'Add' }}</span>
            </button>
        </div>
    </Link>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import { useToast } from '@/composables/useToast';
import { 
    Heart, 
    Eye, 
    Star, 
    ShoppingCart, 
    Package,
    Flame 
} from 'lucide-vue-next';

interface Product {
    id: number;
    name: string;
    image?: string;
    price: number;
    originalPrice?: number;
    discount?: number;
    rating: number;
    soldCount?: number;
}

interface Props {
    product: Product;
    isFlashSale?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    isFlashSale: false
});

const { success, error } = useToast();

const isInWishlist = ref(false);
const isAddingToCart = ref(false);

const progressPercentage = computed(() => {
    if (!props.isFlashSale || !props.product.soldCount) return 0;
    const maxSold = 500; // Assume max items for flash sale
    return Math.min((props.product.soldCount / maxSold) * 100, 100);
});

const formatPrice = (price: number) => {
    return price.toLocaleString('bn-BD');
};

const addToWishlist = async () => {
    const wasInWishlist = isInWishlist.value;
    isInWishlist.value = !isInWishlist.value;
    
    try {
        // In a real app, you'd make an API call here
        // await axios.post('/api/wishlist', { product_id: props.product.id });
        console.log('Added to wishlist:', props.product.id);
        
        if (isInWishlist.value) {
            success('Added to Wishlist!', `${props.product.name} has been added to your wishlist.`);
        } else {
            success('Removed from Wishlist!', `${props.product.name} has been removed from your wishlist.`);
        }
    } catch (err) {
        console.error('Failed to update wishlist:', err);
        isInWishlist.value = wasInWishlist; // Revert on error
        error('Failed to update wishlist', 'Please try again later.');
    }
};

const addToCart = async () => {
    isAddingToCart.value = true;
    
    try {
        // In a real app, you'd make an API call here
        // await axios.post('/api/cart', { product_id: props.product.id, quantity: 1 });
        console.log('Added to cart:', props.product.id);
        
        success('Added to Cart!', `${props.product.name} has been added to your cart.`);
        
        setTimeout(() => {
            isAddingToCart.value = false;
        }, 1000);
    } catch (err) {
        console.error('Failed to add to cart:', err);
        isAddingToCart.value = false;
        error('Failed to add to cart', 'Please try again later.');
    }
};

const quickView = () => {
    // Open product details in a modal or new tab
    // For now, navigate to product page same as clicking the card
    router.visit(`/products/${props.product.id}`);
};
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
