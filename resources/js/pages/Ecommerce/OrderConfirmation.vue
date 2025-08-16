<template>
    <Head title="Order Confirmation - SkyShop" />
    
    <EcommerceLayout>
        <div class="container mx-auto px-4 py-6">
            <div class="max-w-2xl mx-auto">
                <!-- Success Animation -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                        <CheckCircle class="w-12 h-12 text-green-600" />
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Confirmed!</h1>
                    <p class="text-gray-600">Thank you for your order. We'll process it shortly.</p>
                </div>

                <!-- Order Details Card -->
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 mb-6">
                    <div class="border-b border-gray-200 pb-4 mb-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">Order #{{ orderNumber }}</h2>
                                <p class="text-gray-600">Placed on {{ formatDate(orderDate) }}</p>
                            </div>
                            <div class="mt-3 sm:mt-0">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <Clock class="w-4 h-4 mr-1" />
                                    Processing
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Order Items</h3>
                        <div class="space-y-4">
                            <div
                                v-for="item in orderItems"
                                :key="item.id"
                                class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg"
                            >
                                <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                                    <Package class="w-8 h-8 text-gray-400" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-medium text-gray-900">{{ item.name }}</h4>
                                    <p class="text-sm text-gray-600">Qty: {{ item.quantity }}</p>
                                    <p class="text-sm text-gray-600" v-if="item.variant">{{ item.variant }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">৳{{ formatPrice(item.price * item.quantity) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="border-t border-gray-200 pt-4 mb-6">
                        <div class="space-y-2">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span>৳{{ formatPrice(orderSummary.subtotal) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Delivery Fee</span>
                                <span>{{ orderSummary.deliveryFee === 0 ? 'Free' : '৳' + formatPrice(orderSummary.deliveryFee) }}</span>
                            </div>
                            <div v-if="orderSummary.discount > 0" class="flex justify-between text-green-600">
                                <span>Discount</span>
                                <span>-৳{{ formatPrice(orderSummary.discount) }}</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold text-gray-900 pt-2 border-t border-gray-200">
                                <span>Total Paid</span>
                                <span>৳{{ formatPrice(orderSummary.total) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Information -->
                    <div class="border-t border-gray-200 pt-4">
                        <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                            <MapPin class="w-5 h-5 mr-2 text-orange-600" />
                            Delivery Information
                        </h3>
                        <div class="text-gray-600 space-y-1">
                            <p><span class="font-medium">Name:</span> {{ deliveryInfo.name }}</p>
                            <p><span class="font-medium">Phone:</span> {{ deliveryInfo.phone }}</p>
                            <p><span class="font-medium">Address:</span> {{ deliveryInfo.address }}</p>
                            <p><span class="font-medium">Payment:</span> {{ getPaymentMethodName(deliveryInfo.paymentMethod) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Order Tracking -->
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                        <Truck class="w-5 h-5 mr-2 text-orange-600" />
                        Order Tracking
                    </h3>
                    <div class="space-y-4">
                        <div
                            v-for="(status, index) in trackingStatuses"
                            :key="status.id"
                            class="flex items-center space-x-4"
                        >
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center"
                                     :class="status.completed 
                                         ? 'bg-green-600 text-white' 
                                         : status.current 
                                             ? 'bg-orange-600 text-white' 
                                             : 'bg-gray-200 text-gray-400'"
                                >
                                    <component :is="status.icon" class="w-4 h-4" />
                                </div>
                                <div v-if="index < trackingStatuses.length - 1" 
                                     class="w-0.5 h-8 mt-2"
                                     :class="status.completed ? 'bg-green-600' : 'bg-gray-200'"
                                ></div>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium" 
                                    :class="status.completed || status.current ? 'text-gray-900' : 'text-gray-400'"
                                >
                                    {{ status.title }}
                                </h4>
                                <p class="text-sm text-gray-600">{{ status.description }}</p>
                                <p v-if="status.timestamp" class="text-xs text-gray-500 mt-1">
                                    {{ formatDateTime(status.timestamp) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button
                        @click="downloadInvoice"
                        class="flex-1 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-3 px-6 rounded-xl transition-colors flex items-center justify-center space-x-2"
                    >
                        <Download class="w-5 h-5" />
                        <span>Download Invoice</span>
                    </button>
                    <button
                        @click="continueShopping"
                        class="flex-1 bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-[1.02] flex items-center justify-center space-x-2"
                    >
                        <ShoppingBag class="w-5 h-5" />
                        <span>Continue Shopping</span>
                    </button>
                </div>

                <!-- Contact Support -->
                <div class="mt-8 text-center">
                    <p class="text-gray-600 mb-2">Need help with your order?</p>
                    <button
                        @click="contactSupport"
                        class="text-orange-600 hover:text-orange-700 font-medium flex items-center justify-center space-x-1"
                    >
                        <MessageCircle class="w-4 h-4" />
                        <span>Contact Support</span>
                    </button>
                </div>
            </div>
        </div>
    </EcommerceLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import { useToast } from '@/composables/useToast'
import EcommerceLayout from '@/layouts/Ecommerce/EcommerceLayout.vue'
import {
    CheckCircle,
    Clock,
    MapPin,
    Truck,
    Package,
    Download,
    ShoppingBag,
    MessageCircle,
    CheckCircle2,
    Clock4,
    Truck as TruckIcon,
    Home
} from 'lucide-vue-next'

interface Props {
    orderNumber: string
}

const props = defineProps<Props>()
const { success, error } = useToast()

// Mock order data - in real app, this would come from the backend
const orderDate = ref(new Date())
const orderItems = ref([
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

const orderSummary = ref({
    subtotal: 8500,
    deliveryFee: 0,
    discount: 500,
    total: 8000
})

const deliveryInfo = ref({
    name: 'John Doe',
    phone: '+880 1XXX-XXXXXX',
    address: 'House 123, Road 4, Dhanmondi, Dhaka 1205',
    paymentMethod: 'cod'
})

const trackingStatuses = ref([
    {
        id: 1,
        title: 'Order Confirmed',
        description: 'Your order has been placed successfully',
        icon: CheckCircle2,
        completed: true,
        current: false,
        timestamp: new Date()
    },
    {
        id: 2,
        title: 'Processing',
        description: 'We are preparing your order',
        icon: Clock4,
        completed: false,
        current: true,
        timestamp: null
    },
    {
        id: 3,
        title: 'Shipped',
        description: 'Your order is on the way',
        icon: TruckIcon,
        completed: false,
        current: false,
        timestamp: null
    },
    {
        id: 4,
        title: 'Delivered',
        description: 'Order delivered to your address',
        icon: Home,
        completed: false,
        current: false,
        timestamp: null
    }
])

// Methods
const formatPrice = (price: number) => {
    return price.toLocaleString('bn-BD')
}

const formatDate = (date: Date) => {
    return new Intl.DateTimeFormat('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    }).format(date)
}

const formatDateTime = (date: Date) => {
    return new Intl.DateTimeFormat('en-US', {
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    }).format(date)
}

const getPaymentMethodName = (method: string) => {
    const methods: { [key: string]: string } = {
        'cod': 'Cash on Delivery',
        'bkash': 'bKash',
        'nagad': 'Nagad'
    }
    return methods[method] || method
}

const downloadInvoice = () => {
    // In real app, this would generate and download a PDF invoice
    success('Invoice Downloaded', 'Your invoice has been downloaded successfully.')
}

const continueShop
ping = () => {
    router.visit('/')
}

const contactSupport = () => {
    // In real app, this would open support chat or redirect to support page
    success('Support Contact', 'Our support team will contact you shortly.')
}

// Initialize page
onMounted(() => {
    // You can fetch order details from backend here using props.orderNumber
    console.log('Order Number:', props.orderNumber)
})
</script>

<style scoped>
/* Custom animations for success state */
@keyframes checkmark {
    0% {
        stroke-dasharray: 0 100;
    }
    100% {
        stroke-dasharray: 100 0;
    }
}

.checkmark {
    animation: checkmark 0.6s ease-in-out;
}

/* Custom scrollbar */
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
