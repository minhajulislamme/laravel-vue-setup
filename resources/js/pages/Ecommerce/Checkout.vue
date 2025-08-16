<template>
    <Head title="Checkout - SkyShop" />
    
    <EcommerceLayout>
        <div class="container mx-auto px-4 py-6">
            <!-- Breadcrumb -->
            <nav class="flex items-center space-x-2 text-sm text-gray-600 mb-6">
                <a href="/" class="hover:text-orange-600 transition-colors">Home</a>
                <ChevronRight class="w-4 h-4" />
                <a href="/cart" class="hover:text-orange-600 transition-colors">Cart</a>
                <ChevronRight class="w-4 h-4" />
                <span class="text-gray-900 font-medium">Checkout</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Checkout Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Contact Information -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                        <h2 class="text-xl font-semibold mb-4 flex items-center">
                            <User class="w-5 h-5 mr-2 text-orange-600" />
                            Contact Information
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                <input
                                    v-model="form.fullName"
                                    type="text"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                    placeholder="Enter your full name"
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                                <input
                                    v-model="form.phone"
                                    type="tel"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                    placeholder="+880 1XXX-XXXXXX"
                                />
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <input
                                    v-model="form.email"
                                    type="email"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                    placeholder="your@email.com"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Information -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                        <h2 class="text-xl font-semibold mb-4 flex items-center">
                            <MapPin class="w-5 h-5 mr-2 text-orange-600" />
                            Delivery Information
                        </h2>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Division *</label>
                                    <select
                                        v-model="form.division"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                    >
                                        <option value="">Select Division</option>
                                        <option v-for="division in divisions" :key="division" :value="division">
                                            {{ division }}
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">District *</label>
                                    <select
                                        v-model="form.district"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                    >
                                        <option value="">Select District</option>
                                        <option v-for="district in districts" :key="district" :value="district">
                                            {{ district }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Address *</label>
                                <textarea
                                    v-model="form.address"
                                    required
                                    rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                    placeholder="House/Flat number, Road, Area, Landmark"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                        <h2 class="text-xl font-semibold mb-4 flex items-center">
                            <CreditCard class="w-5 h-5 mr-2 text-orange-600" />
                            Payment Method
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div
                                v-for="method in paymentMethods"
                                :key="method.id"
                                @click="form.paymentMethod = method.id"
                                class="border-2 rounded-lg p-4 cursor-pointer transition-all"
                                :class="form.paymentMethod === method.id 
                                    ? 'border-orange-500 bg-orange-50' 
                                    : 'border-gray-200 hover:border-gray-300'"
                            >
                                <div class="flex items-center space-x-3">
                                    <div class="relative">
                                        <input
                                            type="radio"
                                            :value="method.id"
                                            v-model="form.paymentMethod"
                                            class="sr-only"
                                        />
                                        <div class="w-5 h-5 border-2 rounded-full"
                                             :class="form.paymentMethod === method.id 
                                                 ? 'border-orange-500 bg-orange-500' 
                                                 : 'border-gray-300'"
                                        >
                                            <div v-if="form.paymentMethod === method.id" 
                                                 class="w-2 h-2 bg-white rounded-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <component :is="method.icon" class="w-5 h-5 text-gray-600" />
                                            <h3 class="font-semibold">{{ method.name }}</h3>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">{{ method.description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Banking Details -->
                        <div v-if="form.paymentMethod === 'bkash' || form.paymentMethod === 'nagad'" 
                             class="mt-4 p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-semibold mb-2">Payment Instructions</h4>
                            <p class="text-sm text-gray-600 mb-3">
                                Send money to: <span class="font-mono font-bold">01XXXXXXXXX</span>
                            </p>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Transaction ID *</label>
                                <input
                                    v-model="form.transactionId"
                                    type="text"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                    placeholder="Enter transaction ID"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Special Instructions -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                        <h2 class="text-xl font-semibold mb-4 flex items-center">
                            <MessageSquare class="w-5 h-5 mr-2 text-orange-600" />
                            Special Instructions (Optional)
                        </h2>
                        <textarea
                            v-model="form.notes"
                            rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                            placeholder="Any special delivery instructions or notes..."
                        ></textarea>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 sticky top-6">
                        <h2 class="text-xl font-semibold mb-4 flex items-center">
                            <ShoppingBag class="w-5 h-5 mr-2 text-orange-600" />
                            Order Summary
                        </h2>

                        <!-- Cart Items -->
                        <div class="space-y-4 mb-6">
                            <div
                                v-for="item in cartItems"
                                :key="item.id"
                                class="flex items-center space-x-3 pb-4 border-b border-gray-100 last:border-b-0"
                            >
                                <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                                    <Package class="w-8 h-8 text-gray-400" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-medium text-gray-900 line-clamp-1">{{ item.name }}</h3>
                                    <p class="text-sm text-gray-600">Qty: {{ item.quantity }}</p>
                                    <p class="text-sm text-gray-600" v-if="item.variant">{{ item.variant }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">৳{{ formatPrice(item.price * item.quantity) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="space-y-3 border-t border-gray-200 pt-4">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span>৳{{ formatPrice(subtotal) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Delivery Fee</span>
                                <span>{{ deliveryFee === 0 ? 'Free' : '৳' + formatPrice(deliveryFee) }}</span>
                            </div>
                            <div v-if="discount > 0" class="flex justify-between text-green-600">
                                <span>Discount</span>
                                <span>-৳{{ formatPrice(discount) }}</span>
                            </div>
                            <div class="flex justify-between text-xl font-bold text-gray-900 pt-3 border-t border-gray-200">
                                <span>Total</span>
                                <span>৳{{ formatPrice(total) }}</span>
                            </div>
                        </div>

                        <!-- Promo Code -->
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <div class="flex space-x-2">
                                <input
                                    v-model="promoCode"
                                    type="text"
                                    placeholder="Promo code"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                />
                                <button
                                    @click="applyPromoCode"
                                    :disabled="isApplyingPromo"
                                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors disabled:opacity-50"
                                >
                                    {{ isApplyingPromo ? 'Applying...' : 'Apply' }}
                                </button>
                            </div>
                        </div>

                        <!-- Place Order Button -->
                        <button
                            @click="placeOrder"
                            :disabled="isPlacingOrder || !isFormValid"
                            class="w-full mt-6 bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <div v-if="isPlacingOrder" class="flex items-center justify-center space-x-2">
                                <Loader2 class="w-5 h-5 animate-spin" />
                                <span>Placing Order...</span>
                            </div>
                            <div v-else class="flex items-center justify-center space-x-2">
                                <CheckCircle class="w-5 h-5" />
                                <span>Place Order - ৳{{ formatPrice(total) }}</span>
                            </div>
                        </button>

                        <!-- Security Notice -->
                        <div class="mt-4 flex items-center space-x-2 text-sm text-gray-600">
                            <Shield class="w-4 h-4 text-green-600" />
                            <span>Your payment information is secure and encrypted</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </EcommerceLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import { useToast } from '@/composables/useToast'
import EcommerceLayout from '@/layouts/Ecommerce/EcommerceLayout.vue'
import {
    User,
    MapPin,
    CreditCard,
    MessageSquare,
    ShoppingBag,
    Package,
    ChevronRight,
    Shield,
    CheckCircle,
    Loader2,
    Smartphone,
    Banknote,
    Truck
} from 'lucide-vue-next'

const { success, error } = useToast()

// Form data
const form = ref({
    fullName: '',
    phone: '',
    email: '',
    division: '',
    district: '',
    address: '',
    paymentMethod: 'cod',
    transactionId: '',
    notes: ''
})

const promoCode = ref('')
const isApplyingPromo = ref(false)
const isPlacingOrder = ref(false)
const discount = ref(0)

// Mock data
const divisions = ['Dhaka', 'Chittagong', 'Rajshahi', 'Khulna', 'Barisal', 'Sylhet', 'Rangpur', 'Mymensingh']
const districts = ['Dhaka', 'Gazipur', 'Narayanganj', 'Chittagong', 'Cox\'s Bazar', 'Rajshahi', 'Khulna']

const paymentMethods = [
    {
        id: 'cod',
        name: 'Cash on Delivery',
        description: 'Pay when you receive your order',
        icon: Banknote
    },
    {
        id: 'bkash',
        name: 'bKash',
        description: 'Mobile banking payment',
        icon: Smartphone
    },
    {
        id: 'nagad',
        name: 'Nagad',
        description: 'Mobile banking payment',
        icon: Smartphone
    }
]

const cartItems = ref([
    {
        id: 1,
        name: 'স্মার্ট ওয়াচ',
        price: 3500,
        quantity: 1,
        variant: 'Black, Large'
    },
    {
        id: 2,
        name: 'ওয়্যারলেস ইয়ারফোন',
        price: 2500,
        quantity: 2,
        variant: 'White'
    }
])

// Computed values
const subtotal = computed(() => {
    return cartItems.value.reduce((total, item) => total + (item.price * item.quantity), 0)
})

const deliveryFee = computed(() => {
    return subtotal.value >= 1000 ? 0 : 60 // Free delivery over ৳1000
})

const total = computed(() => {
    return subtotal.value + deliveryFee.value - discount.value
})

const isFormValid = computed(() => {
    const requiredFields = [
        form.value.fullName,
        form.value.phone,
        form.value.division,
        form.value.district,
        form.value.address,
        form.value.paymentMethod
    ]
    
    const basicValid = requiredFields.every(field => field.trim() !== '')
    
    // Additional validation for mobile banking
    if ((form.value.paymentMethod === 'bkash' || form.value.paymentMethod === 'nagad') && !form.value.transactionId.trim()) {
        return false
    }
    
    return basicValid
})

// Methods
const formatPrice = (price: number) => {
    return price.toLocaleString('bn-BD')
}

const applyPromoCode = async () => {
    if (!promoCode.value.trim()) return
    
    isApplyingPromo.value = true
    
    try {
        // Simulate API call
        await new Promise(resolve => setTimeout(resolve, 1000))
        
        // Mock promo code validation
        if (promoCode.value.toUpperCase() === 'SAVE10') {
            discount.value = Math.min(subtotal.value * 0.1, 500) // 10% off, max ৳500
            success('Promo Code Applied!', `You saved ৳${formatPrice(discount.value)}`)
        } else {
            error('Invalid Promo Code', 'Please check your promo code and try again.')
        }
    } catch (err) {
        error('Error', 'Failed to apply promo code. Please try again.')
    } finally {
        isApplyingPromo.value = false
    }
}

const placeOrder = async () => {
    if (!isFormValid.value) {
        error('Form Incomplete', 'Please fill in all required fields.')
        return
    }
    
    isPlacingOrder.value = true
    
    try {
        // Simulate API call
        await new Promise(resolve => setTimeout(resolve, 2000))
        
        // Mock successful order placement
        const orderNumber = 'SKY' + Date.now()
        
        success('Order Placed Successfully!', `Your order #${orderNumber} has been placed.`)
        
        // Redirect to order confirmation page
        setTimeout(() => {
            router.visit(`/order-confirmation/${orderNumber}`)
        }, 1500)
        
    } catch (err) {
        error('Order Failed', 'Failed to place your order. Please try again.')
    } finally {
        isPlacingOrder.value = false
    }
}

// Initialize form with saved data if available
onMounted(() => {
    // You can load saved form data from localStorage here
    const savedForm = localStorage.getItem('checkoutForm')
    if (savedForm) {
        try {
            const parsed = JSON.parse(savedForm)
            Object.assign(form.value, parsed)
        } catch (e) {
            // Ignore parsing errors
        }
    }
})
</script>

<style scoped>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Custom scrollbar for better UX */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>
