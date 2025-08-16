<template>
    <Head title="Shopping Cart - SkyShop" />
    
    <EcommerceLayout>
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">শপিং কার্ট</h1>

            <div v-if="cartItems.length === 0" class="text-center py-16">
                <ShoppingCart class="w-24 h-24 text-gray-300 mx-auto mb-4" />
                <h2 class="text-2xl font-semibold text-gray-600 mb-2">আপনার কার্ট খালি</h2>
                <p class="text-gray-500 mb-6">কেনাকাটা শুরু করতে পণ্য যোগ করুন</p>
                <Link 
                    href="/products"
                    class="inline-flex items-center px-6 py-3 bg-orange-600 text-white font-medium rounded-lg hover:bg-orange-700 transition-colors"
                >
                    কেনাকাটা শুরু করুন
                    <ArrowRight class="w-5 h-5 ml-2" />
                </Link>
            </div>

            <div v-else class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-8">
                    <div class="bg-white rounded-lg shadow-sm">
                        <div class="p-6 border-b">
                            <h2 class="text-xl font-semibold">কার্টের পণ্যসমূহ ({{ cartItems.length }}টি)</h2>
                        </div>
                        
                        <div class="divide-y">
                            <div 
                                v-for="item in cartItems" 
                                :key="item.id"
                                class="p-6 flex items-center space-x-4"
                            >
                                <!-- Product Image -->
                                <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <Package class="w-8 h-8 text-gray-400" />
                                </div>

                                <!-- Product Details -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-medium text-gray-800 mb-1">{{ item.name }}</h3>
                                    <p class="text-sm text-gray-500 mb-2">{{ item.variant }}</p>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-lg font-bold text-orange-600">৳{{ formatPrice(item.price) }}</span>
                                        <span v-if="item.originalPrice" class="text-sm text-gray-500 line-through">
                                            ৳{{ formatPrice(item.originalPrice) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Quantity Controls -->
                                <div class="flex items-center space-x-2">
                                    <button 
                                        @click="updateQuantity(item.id, item.quantity - 1)"
                                        class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50"
                                        :disabled="item.quantity <= 1"
                                    >
                                        <Minus class="w-4 h-4" />
                                    </button>
                                    <span class="w-12 text-center font-medium">{{ item.quantity }}</span>
                                    <button 
                                        @click="updateQuantity(item.id, item.quantity + 1)"
                                        class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50"
                                    >
                                        <Plus class="w-4 h-4" />
                                    </button>
                                </div>

                                <!-- Total & Remove -->
                                <div class="text-right">
                                    <div class="font-bold text-gray-800 mb-2">
                                        ৳{{ formatPrice(item.price * item.quantity) }}
                                    </div>
                                    <button 
                                        @click="removeFromCart(item.id)"
                                        class="text-red-500 hover:text-red-700 text-sm"
                                    >
                                        <Trash2 class="w-4 h-4" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-4">
                        <h2 class="text-xl font-semibold mb-4">অর্ডার সামারি</h2>
                        
                        <div class="space-y-3 mb-4">
                            <div class="flex justify-between">
                                <span>সাবটোটাল</span>
                                <span>৳{{ formatPrice(subtotal) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>ডেলিভারি চার্জ</span>
                                <span>৳{{ formatPrice(deliveryCharge) }}</span>
                            </div>
                            <div class="flex justify-between text-green-600">
                                <span>ডিসকাউন্ট</span>
                                <span>-৳{{ formatPrice(discount) }}</span>
                            </div>
                            <hr />
                            <div class="flex justify-between text-lg font-bold">
                                <span>মোট</span>
                                <span>৳{{ formatPrice(total) }}</span>
                            </div>
                        </div>

                        <!-- Promo Code -->
                        <div class="mb-4">
                            <div class="flex space-x-2">
                                <input 
                                    type="text" 
                                    v-model="promoCode"
                                    placeholder="প্রোমো কোড"
                                    class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-orange-500"
                                />
                                <button 
                                    @click="applyPromoCode"
                                    class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-700 transition-colors"
                                >
                                    প্রয়োগ
                                </button>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <Link 
                            href="/checkout"
                            class="w-full bg-orange-600 text-white py-3 rounded-lg font-medium text-center block hover:bg-orange-700 transition-colors"
                        >
                            চেকআউট করুন
                        </Link>

                        <!-- Continue Shopping -->
                        <Link 
                            href="/products"
                            class="w-full mt-3 border border-gray-300 text-gray-700 py-3 rounded-lg font-medium text-center block hover:bg-gray-50 transition-colors"
                        >
                            কেনাকাটা চালিয়ে যান
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </EcommerceLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import EcommerceLayout from '@/layouts/Ecommerce/EcommerceLayout.vue';
import { 
    ShoppingCart, 
    Package, 
    Plus, 
    Minus, 
    Trash2, 
    ArrowRight 
} from 'lucide-vue-next';

// Sample cart data
const cartItems = ref([
    {
        id: 1,
        name: 'স্মার্ট ওয়াচ প্রো',
        variant: 'কালো রঙ, 42mm',
        price: 2500,
        originalPrice: 3500,
        quantity: 2
    },
    {
        id: 2,
        name: 'ওয়্যারলেস ইয়ারবাড',
        variant: 'সাদা রঙ',
        price: 1200,
        originalPrice: 1800,
        quantity: 1
    },
    {
        id: 3,
        name: 'পাওয়ার ব্যাংক',
        variant: '20000mAh',
        price: 800,
        originalPrice: null,
        quantity: 1
    }
]);

const promoCode = ref('');
const deliveryCharge = ref(60);
const discount = ref(0);

const subtotal = computed(() => {
    return cartItems.value.reduce((sum, item) => sum + (item.price * item.quantity), 0);
});

const total = computed(() => {
    return subtotal.value + deliveryCharge.value - discount.value;
});

const formatPrice = (price: number) => {
    return price.toLocaleString('bn-BD');
};

const updateQuantity = (itemId: number, newQuantity: number) => {
    if (newQuantity < 1) return;
    
    const item = cartItems.value.find(item => item.id === itemId);
    if (item) {
        item.quantity = newQuantity;
    }
};

const removeFromCart = (itemId: number) => {
    const index = cartItems.value.findIndex(item => item.id === itemId);
    if (index > -1) {
        cartItems.value.splice(index, 1);
    }
};

const applyPromoCode = () => {
    // In a real app, this would validate the promo code
    if (promoCode.value === 'SAVE10') {
        discount.value = Math.floor(subtotal.value * 0.1);
    }
};
</script>
