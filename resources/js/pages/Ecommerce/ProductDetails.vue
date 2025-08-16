<template>
    <Head :title="`${product.name} - SkyShop`" />
    
    <EcommerceLayout>
        <div class="container mx-auto px-4 py-6">
            <!-- Breadcrumb -->
            <nav class="flex items-center space-x-2 text-sm text-gray-600 mb-6">
                <a href="/" class="hover:text-orange-600 transition-colors">Home</a>
                <ChevronRight class="w-4 h-4" />
                <a href="/categories" class="hover:text-orange-600 transition-colors">Categories</a>
                <ChevronRight class="w-4 h-4" />
                <a :href="`/categories/${product.category?.slug}`" class="hover:text-orange-600 transition-colors">{{ product.category?.name }}</a>
                <ChevronRight class="w-4 h-4" />
                <span class="text-gray-900 font-medium">{{ product.name }}</span>
            </nav>

            <!-- Product Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 mb-12">
                <!-- Product Images -->
                <div class="space-y-4">
                    <!-- Main Image Gallery -->
                    <div 
                        class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl overflow-hidden relative group image-gallery cursor-grab active:cursor-grabbing"
                        @touchstart="handleTouchStart"
                        @touchend="handleTouchEnd"
                        @mousedown="handleMouseDown"
                        @mousemove="handleMouseMove"
                        @mouseup="handleMouseUp"
                        @mouseenter="handleMouseEnter"
                        @mouseleave="handleMouseLeave"
                    >
                        <!-- Image Container -->
                        <div class="relative w-full h-full overflow-hidden">
                            <div 
                                class="flex transition-all duration-700 ease-out h-full"
                                :style="{ transform: `translateX(-${currentImageIndex * 100}%)` }"
                            >
                                <div 
                                    v-for="(image, index) in product.images" 
                                    :key="index"
                                    class="w-full h-full flex-shrink-0 bg-gradient-to-br from-slate-100 via-gray-100 to-slate-200 flex items-center justify-center relative"
                                >
                                    <!-- Placeholder for actual images -->
                                    <Package class="w-24 h-24 text-gray-300" />
                                    <!-- You can replace this with actual image when available -->
                                    <!-- <img :src="image" :alt="product.name" class="w-full h-full object-cover" /> -->
                                </div>
                            </div>
                        </div>
                        
                        <!-- Discount Badge -->
                        <div 
                            v-if="product.discount" 
                            class="absolute top-4 left-4 bg-gradient-to-r from-red-500 to-pink-500 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg z-10"
                        >
                            -{{ product.discount }}% OFF
                        </div>
                        
                        <!-- Wishlist Button -->
                        <button 
                            @click="toggleWishlist"
                            class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm p-3 rounded-full shadow-lg hover:bg-white transition-all duration-300 z-10"
                            :class="{ 'text-red-500 bg-red-50': isInWishlist, 'text-gray-600': !isInWishlist }"
                        >
                            <Heart class="w-6 h-6" :class="{ 'fill-current': isInWishlist }" />
                        </button>
                    </div>
                    
                    <!-- Thumbnail Images -->
                    <div 
                        v-if="product.images.length > 1"
                        class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-6 gap-3"
                    >
                        <div 
                            v-for="(image, index) in product.images.slice(0, 6)" 
                            :key="index"
                            @click="selectImage(index)"
                            class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg cursor-pointer hover:ring-2 hover:ring-orange-500 transition-all thumbnail"
                            :class="currentImageIndex === index ? 'ring-2 ring-orange-500' : ''"
                        >
                            <div class="w-full h-full bg-gradient-to-br from-slate-100 via-gray-100 to-slate-200 flex items-center justify-center rounded-lg">
                                <Package class="w-8 h-8 text-gray-300" />
                                <!-- You can replace this with actual thumbnail when available -->
                                <!-- <img :src="image" :alt="product.name" class="w-full h-full object-cover rounded-lg" /> -->
                            </div>
                        </div>
                        
                        <!-- Show More Images Indicator -->
                        <div 
                            v-if="product.images.length > 6"
                            class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg cursor-pointer hover:ring-2 hover:ring-orange-500 transition-all flex items-center justify-center"
                        >
                            <div class="text-center">
                                <MoreHorizontal class="w-6 h-6 text-gray-400 mx-auto mb-1" />
                                <span class="text-xs text-gray-500">+{{ product.images.length - 6 }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="space-y-6">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">{{ product.name }}</h1>
                        
                        <!-- Rating -->
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="flex items-center">
                                <Star 
                                    v-for="i in 5" 
                                    :key="i"
                                    class="w-5 h-5"
                                    :class="i <= Math.floor(product.rating) ? 'text-yellow-400 fill-current' : 'text-gray-200'"
                                />
                                <span class="ml-2 text-gray-600">({{ product.rating }})</span>
                            </div>
                            <span class="text-green-600 text-sm font-medium">{{ product.reviews }} reviews</span>
                            <span class="text-blue-600 text-sm font-medium">{{ product.soldCount }} sold</span>
                        </div>
                        
                        <!-- Price -->
                        <div class="flex items-center space-x-4 mb-6">
                            <span class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
                                ৳{{ formatPrice(product.price) }}
                            </span>
                            <span 
                                v-if="product.originalPrice && product.originalPrice > product.price" 
                                class="text-xl text-gray-400 line-through"
                            >
                                ৳{{ formatPrice(product.originalPrice) }}
                            </span>
                            <span 
                                v-if="product.discount"
                                class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold"
                            >
                                Save ৳{{ formatPrice((product.originalPrice || 0) - product.price) }}
                            </span>
                        </div>
                    </div>

                    <!-- Product Options -->
                    <div class="space-y-4">
                        <!-- Size Selection -->
                        <div v-if="product.sizes && product.sizes.length > 0">
                            <h3 class="text-lg font-semibold mb-3">Size</h3>
                            <div class="flex flex-wrap gap-3">
                                <button
                                    v-for="size in product.sizes"
                                    :key="size"
                                    @click="selectedSize = size"
                                    class="px-4 py-2 border rounded-lg font-medium transition-all"
                                    :class="selectedSize === size 
                                        ? 'border-orange-500 bg-orange-50 text-orange-700' 
                                        : 'border-gray-300 hover:border-gray-400'"
                                >
                                    {{ size }}
                                </button>
                            </div>
                        </div>

                        <!-- Color Selection -->
                        <div v-if="product.colors && product.colors.length > 0">
                            <h3 class="text-lg font-semibold mb-3">Color</h3>
                            <div class="flex flex-wrap gap-3">
                                <button
                                    v-for="color in product.colors"
                                    :key="color.name"
                                    @click="selectedColor = color"
                                    class="flex items-center space-x-2 px-4 py-2 border rounded-lg font-medium transition-all"
                                    :class="selectedColor?.name === color.name 
                                        ? 'border-orange-500 bg-orange-50 text-orange-700' 
                                        : 'border-gray-300 hover:border-gray-400'"
                                >
                                    <div 
                                        class="w-4 h-4 rounded-full border border-gray-300"
                                        :style="{ backgroundColor: color.hex }"
                                    ></div>
                                    <span>{{ color.name }}</span>
                                </button>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div>
                            <h3 class="text-lg font-semibold mb-3">Quantity</h3>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center border border-gray-300 rounded-lg">
                                    <button 
                                        @click="decreaseQuantity"
                                        class="p-3 hover:bg-gray-50 transition-colors"
                                        :disabled="quantity <= 1"
                                    >
                                        <Minus class="w-4 h-4" />
                                    </button>
                                    <span class="px-4 py-3 font-semibold min-w-[60px] text-center">{{ quantity }}</span>
                                    <button 
                                        @click="increaseQuantity"
                                        class="p-3 hover:bg-gray-50 transition-colors"
                                        :disabled="quantity >= product.stock"
                                    >
                                        <Plus class="w-4 h-4" />
                                    </button>
                                </div>
                                <span class="text-gray-600">{{ product.stock }} items available</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button 
                            @click="addToCart"
                            :disabled="isAddingToCart"
                            class="flex-1 bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white font-semibold py-4 px-8 rounded-xl transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl transform hover:scale-[1.02] disabled:opacity-70"
                        >
                            <ShoppingCart class="w-5 h-5" />
                            <span>{{ isAddingToCart ? 'Adding to Cart...' : 'Add to Cart' }}</span>
                        </button>
                        <button 
                            @click="buyNow"
                            class="flex-1 bg-gray-900 hover:bg-gray-800 text-white font-semibold py-4 px-8 rounded-xl transition-all duration-300 flex items-center justify-center space-x-2"
                        >
                            <Zap class="w-5 h-5" />
                            <span>Buy Now</span>
                        </button>
                    </div>

                    <!-- Product Features -->
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                        <div class="flex items-center space-x-3 text-sm text-gray-600">
                            <Truck class="w-5 h-5 text-green-600" />
                            <span>Free shipping on orders over ৳1000</span>
                        </div>
                        <div class="flex items-center space-x-3 text-sm text-gray-600">
                            <RotateCcw class="w-5 h-5 text-blue-600" />
                            <span>30-day return policy</span>
                        </div>
                        <div class="flex items-center space-x-3 text-sm text-gray-600">
                            <Shield class="w-5 h-5 text-purple-600" />
                            <span>2-year warranty</span>
                        </div>
                        <div class="flex items-center space-x-3 text-sm text-gray-600">
                            <CreditCard class="w-5 h-5 text-orange-600" />
                            <span>Secure payment</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details Tabs -->
            <div class="mb-12">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                        <button
                            v-for="tab in tabs"
                            :key="tab.id"
                            @click="activeTab = tab.id"
                            class="py-4 px-1 border-b-2 font-medium text-sm transition-all"
                            :class="activeTab === tab.id 
                                ? 'border-orange-500 text-orange-600' 
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        >
                            {{ tab.name }}
                        </button>
                    </nav>
                </div>
                
                <div class="py-8">
                    <!-- Description Tab -->
                    <div v-if="activeTab === 'description'" class="prose max-w-none">
                        <h3 class="text-xl font-semibold mb-4">Product Description</h3>
                        <p class="text-gray-600 leading-relaxed mb-4">{{ product.description }}</p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600">
                            <li v-for="feature in product.features" :key="feature">{{ feature }}</li>
                        </ul>
                    </div>
                    
                    <!-- Specifications Tab -->
                    <div v-else-if="activeTab === 'specifications'" class="space-y-4">
                        <h3 class="text-xl font-semibold mb-4">Specifications</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div 
                                v-for="spec in product.specifications" 
                                :key="spec.name"
                                class="flex justify-between py-3 border-b border-gray-200"
                            >
                                <span class="font-medium text-gray-900">{{ spec.name }}</span>
                                <span class="text-gray-600">{{ spec.value }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Reviews Tab -->
                    <div v-else-if="activeTab === 'reviews'" class="space-y-6">
                        <h3 class="text-xl font-semibold mb-4">Customer Reviews</h3>
                        <div 
                            v-for="review in product.customerReviews" 
                            :key="review.id"
                            class="border-b border-gray-200 pb-6 last:border-b-0"
                        >
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                        <User class="w-6 h-6 text-gray-600" />
                                    </div>
                                    <div>
                                        <h4 class="font-semibold">{{ review.user }}</h4>
                                        <div class="flex items-center">
                                            <Star 
                                                v-for="i in 5" 
                                                :key="i"
                                                class="w-4 h-4"
                                                :class="i <= review.rating ? 'text-yellow-400 fill-current' : 'text-gray-200'"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">{{ review.date }}</span>
                            </div>
                            <p class="text-gray-600">{{ review.comment }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <!--
            <div>
                <h2 class="text-2xl md:text-3xl font-bold mb-8">Related Products</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    <ProductCard 
                        v-for="relatedProduct in relatedProducts" 
                        :key="relatedProduct.id"
                        :product="relatedProduct"
                    />
                </div>
            </div>
            -->
        </div>
    </EcommerceLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import { useToast } from '@/composables/useToast'
import EcommerceLayout from '@/layouts/Ecommerce/EcommerceLayout.vue'
// import ProductCard from '@/components/Ecommerce/Products/ProductCard.vue'
import {
    Heart,
    Star,
    ShoppingCart,
    Zap,
    Truck,
    RotateCcw,
    Shield,
    CreditCard,
    Package,
    ChevronRight,
    ChevronLeft,
    Minus,
    Plus,
    User,
    ZoomIn,
    MoreHorizontal
} from 'lucide-vue-next'

interface Props {
    productId: string
}

const props = defineProps<Props>()
const { success, error } = useToast()

// Reactive state
const isInWishlist = ref(false)
const isAddingToCart = ref(false)
const quantity = ref(1)
const selectedSize = ref<string | null>(null)
const selectedColor = ref<{ name: string; hex: string } | null>(null)
const activeTab = ref('description')
const currentImageIndex = ref(0)

// Touch support for image slider
const touchStartX = ref(0)
const touchEndX = ref(0)

// Mouse drag support
const isDragging = ref(false)
const dragStartX = ref(0)
const dragEndX = ref(0)
const isUserInteracting = ref(false)

// Autoplay functionality
const isAutoPlaying = ref(true)
const autoplayInterval = ref<number | null>(null)

// Mock product data (replace with API call)
const product = ref({
    id: props.productId,
    name: 'স্মার্ট ওয়াচ',
    description: 'High-quality smart watch with advanced features for health monitoring and connectivity.',
    price: 3500,
    originalPrice: 5000,
    discount: 30,
    rating: 4.5,
    reviews: 128,
    soldCount: 234,
    stock: 15,
    category: { name: 'Electronics', slug: 'electronics' },
    images: [
        '/images/watch-1.jpg',
        '/images/watch-2.jpg', 
        '/images/watch-3.jpg',
        '/images/watch-4.jpg',
        '/images/watch-5.jpg'
    ],
    sizes: ['S', 'M', 'L', 'XL'],
    colors: [
        { name: 'Black', hex: '#000000' },
        { name: 'White', hex: '#FFFFFF' },
        { name: 'Blue', hex: '#3B82F6' }
    ],
    features: [
        'Heart rate monitoring',
        'GPS tracking',
        'Waterproof design',
        '7-day battery life',
        'Multiple sport modes'
    ],
    specifications: [
        { name: 'Display', value: '1.4" AMOLED' },
        { name: 'Battery', value: '7 days' },
        { name: 'Water Resistance', value: '5ATM' },
        { name: 'Connectivity', value: 'Bluetooth 5.0' },
        { name: 'Weight', value: '45g' }
    ],
    customerReviews: [
        {
            id: 1,
            user: 'আহমেদ হাসান',
            rating: 5,
            comment: 'Amazing product! Great quality and fast delivery.',
            date: '2 days ago'
        },
        {
            id: 2,
            user: 'ফাতিমা খান',
            rating: 4,
            comment: 'Good value for money. Battery life is excellent.',
            date: '1 week ago'
        }
    ]
})

const relatedProducts = ref([
    { id: 2, name: 'ওয়্যারলেস ইয়ারফোন', price: 2500, originalPrice: 3500, rating: 4.3, discount: 28 },
    { id: 3, name: 'পাওয়ার ব্যাংক', price: 1500, originalPrice: 2000, rating: 4.7, discount: 25 },
    { id: 4, name: 'স্মার্ট ফোন কেস', price: 800, originalPrice: 1200, rating: 4.4, discount: 33 },
    { id: 5, name: 'ব্লুটুথ স্পিকার', price: 3000, originalPrice: 4000, rating: 4.2, discount: 25 }
])

const tabs = [
    { id: 'description', name: 'Description' },
    { id: 'specifications', name: 'Specifications' },
    { id: 'reviews', name: 'Reviews' }
]

// Methods
const formatPrice = (price: number) => {
    return price.toLocaleString('bn-BD')
}

const toggleWishlist = () => {
    isInWishlist.value = !isInWishlist.value
    if (isInWishlist.value) {
        success('Added to Wishlist!', `${product.value.name} has been added to your wishlist.`)
    } else {
        success('Removed from Wishlist!', `${product.value.name} has been removed from your wishlist.`)
    }
}

const increaseQuantity = () => {
    if (quantity.value < product.value.stock) {
        quantity.value++
    }
}

const decreaseQuantity = () => {
    if (quantity.value > 1) {
        quantity.value--
    }
}

// Image slider methods
const nextImage = () => {
    if (currentImageIndex.value < product.value.images.length - 1) {
        currentImageIndex.value++
    } else {
        currentImageIndex.value = 0 // Loop back to first image
    }
}

const previousImage = () => {
    if (currentImageIndex.value > 0) {
        currentImageIndex.value--
    } else {
        currentImageIndex.value = product.value.images.length - 1 // Loop to last image
    }
}

// Mouse drag event handlers
const handleMouseDown = (e: MouseEvent) => {
    isDragging.value = true
    dragStartX.value = e.clientX
    isUserInteracting.value = true
    stopAutoplay()
}

const handleMouseMove = (e: MouseEvent) => {
    if (!isDragging.value) return
    e.preventDefault()
}

const handleMouseUp = (e: MouseEvent) => {
    if (!isDragging.value) return
    
    isDragging.value = false
    dragEndX.value = e.clientX
    handleDrag()
    // Don't resume autoplay immediately after drag
}

const handleMouseLeave = () => {
    if (isDragging.value) {
        isDragging.value = false
    }
    isUserInteracting.value = false
    // Resume autoplay after leaving the slider area
    resumeAutoplayAfterDelay()
}

const handleMouseEnter = () => {
    isUserInteracting.value = true
    stopAutoplay()
}

const handleDrag = () => {
    const dragThreshold = 50
    const diff = dragStartX.value - dragEndX.value
    
    if (Math.abs(diff) > dragThreshold) {
        if (diff > 0) {
            nextImage() // Drag left, go to next image
        } else {
            previousImage() // Drag right, go to previous image
        }
    }
}

// Touch event handlers for mobile swipe
const handleTouchStart = (e: TouchEvent) => {
    touchStartX.value = e.touches[0].clientX
    isUserInteracting.value = true
    stopAutoplay()
}

const handleTouchEnd = (e: TouchEvent) => {
    touchEndX.value = e.changedTouches[0].clientX
    handleSwipe()
    // Don't resume autoplay immediately after touch
    isUserInteracting.value = false
    resumeAutoplayAfterDelay()
}

const handleSwipe = () => {
    const swipeThreshold = 50
    const diff = touchStartX.value - touchEndX.value
    
    if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
            nextImage() // Swipe left, go to next image
        } else {
            previousImage() // Swipe right, go to previous image
        }
    }
}

// Autoplay control functions
const startAutoplay = () => {
    if (product.value.images.length <= 1 || isUserInteracting.value) return
    
    autoplayInterval.value = setInterval(() => {
        if (!isUserInteracting.value) {
            nextImage()
        }
    }, 4000) // Slower autoplay - change image every 4 seconds
    
    isAutoPlaying.value = true
}

const stopAutoplay = () => {
    if (autoplayInterval.value) {
        clearInterval(autoplayInterval.value)
        autoplayInterval.value = null
    }
    isAutoPlaying.value = false
}

const pauseAutoplay = () => {
    stopAutoplay()
}

const resumeAutoplay = () => {
    if (product.value.images.length > 1 && !isUserInteracting.value) {
        startAutoplay()
    }
}

const resumeAutoplayAfterDelay = () => {
    // Wait longer before resuming autoplay after user interaction
    setTimeout(() => {
        if (!isUserInteracting.value && product.value.images.length > 1) {
            startAutoplay()
        }
    }, 3000) // 3 second delay before resuming
}

// Handle thumbnail selection
const selectImage = (index: number) => {
    currentImageIndex.value = index
    isUserInteracting.value = true
    stopAutoplay()
    // Resume autoplay after longer delay since user deliberately selected an image
    setTimeout(() => {
        isUserInteracting.value = false
        resumeAutoplayAfterDelay()
    }, 5000) // 5 second delay after manual selection
}

// Keyboard navigation (removed since we want only mouse/touch)
// const handleKeydown = (e: KeyboardEvent) => {
//     if (e.key === 'ArrowLeft') {
//         previousImage()
//     } else if (e.key === 'ArrowRight') {
//         nextImage()
//     }
// }

const addToCart = async () => {
    isAddingToCart.value = true
    
    try {
        // Simulate API call
        await new Promise(resolve => setTimeout(resolve, 1000))
        success('Added to Cart!', `${quantity.value} × ${product.value.name} added to your cart.`)
    } catch (err) {
        error('Failed to add to cart', 'Please try again later.')
    } finally {
        isAddingToCart.value = false
    }
}

const buyNow = () => {
    // Add to cart and redirect to checkout
    addToCart().then(() => {
        router.visit('/checkout')
    })
}

// Initialize selections
onMounted(() => {
    if (product.value.sizes && product.value.sizes.length > 0) {
        selectedSize.value = product.value.sizes[0]
    }
    if (product.value.colors && product.value.colors.length > 0) {
        selectedColor.value = product.value.colors[0]
    }
    
    // Start autoplay for image slider
    if (product.value.images.length > 1) {
        startAutoplay()
    }
})

// Cleanup
onUnmounted(() => {
    stopAutoplay()
})
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.prose {
    max-width: none;
}

.prose p {
    margin-bottom: 1rem;
}

.prose ul {
    margin-top: 1rem;
    margin-bottom: 1rem;
}

/* Image slider enhancements */
.image-gallery {
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    transition: transform 0.3s ease;
}

.image-gallery:hover {
    transform: scale(1.01);
}

.image-gallery.cursor-grab {
    cursor: grab;
}

.image-gallery.active\:cursor-grabbing:active {
    cursor: grabbing;
}

.image-gallery:focus {
    outline: none;
}

/* Smooth transitions for all slider elements */
.slider-transition {
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

/* Enhanced thumbnail hover effect */
.thumbnail {
    transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.thumbnail:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.2);
}
</style>
