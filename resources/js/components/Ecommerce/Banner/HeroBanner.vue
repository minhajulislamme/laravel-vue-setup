<template>
  <div class="hero-banner">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 h-[500px]">
        <!-- Main Large Slider -->
        <div class="lg:col-span-3 relative overflow-hidden rounded-lg">
          <div 
            class="main-slider relative h-full cursor-grab active:cursor-grabbing"
            @mousedown="handleMainMouseDown"
            @mousemove="handleMainMouseMove"
            @mouseup="handleMainMouseUp"
            @mouseleave="handleMainMouseUp"
            @touchstart="handleMainTouchStart"
            @touchmove="handleMainTouchMove"
            @touchend="handleMainTouchEnd"
          >
            <div
              v-for="(slide, index) in mainSlides"
              :key="index"
              :class="[
                'slide absolute inset-0 transition-transform duration-500 ease-in-out',
                { 'translate-x-0': currentMainSlide === index },
                { 'translate-x-full': currentMainSlide < index },
                { '-translate-x-full': currentMainSlide > index }
              ]"
            >
              <div
                class="w-full h-full bg-cover bg-center relative"
                :style="{ backgroundImage: `url(${slide.image})` }"
              >
                <div class="absolute inset-0 bg-black bg-opacity-30"></div>
                <div class="absolute inset-0 flex items-center">
                  <div class="text-white p-8 max-w-lg">
                    <h2 class="text-4xl md:text-5xl font-bold mb-4">{{ slide.title }}</h2>
                    <p class="text-lg mb-6">{{ slide.description }}</p>
                    <button class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg transition-colors">
                      {{ slide.buttonText }}
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Side Small Slider -->
        <div class="lg:col-span-1 relative overflow-hidden rounded-lg">
          <div 
            class="side-slider relative h-full cursor-grab active:cursor-grabbing"
            @mousedown="handleSideMouseDown"
            @mousemove="handleSideMouseMove"
            @mouseup="handleSideMouseUp"
            @mouseleave="handleSideMouseUp"
            @touchstart="handleSideTouchStart"
            @touchmove="handleSideTouchMove"
            @touchend="handleSideTouchEnd"
          >
            <div
              v-for="(slide, index) in sideSlides"
              :key="index"
              :class="[
                'slide absolute inset-0 transition-transform duration-500 ease-in-out',
                { 'translate-x-0': currentSideSlide === index },
                { 'translate-x-full': currentSideSlide < index },
                { '-translate-x-full': currentSideSlide > index }
              ]"
            >
              <div
                class="w-full h-full bg-cover bg-center relative"
                :style="{ backgroundImage: `url(${slide.image})` }"
              >
                <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                  <div class="text-white text-center p-4">
                    <h3 class="text-xl font-bold mb-2">{{ slide.title }}</h3>
                    <p class="text-sm opacity-90">{{ slide.description }}</p>
                    <button class="mt-3 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm transition-colors">
                      {{ slide.buttonText }}
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'

// Main slider data
const mainSlides = ref([
  {
    image: 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80',
    title: 'Summer Sale 2024',
    description: 'Up to 70% off on all summer collections. Limited time offer!',
    buttonText: 'Shop Now'
  },
  {
    image: 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2126&q=80',
    title: 'New Arrivals',
    description: 'Discover the latest trends and fashion styles for this season.',
    buttonText: 'Explore'
  },
  {
    image: 'https://images.unsplash.com/photo-1542838132-92c53300491e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2074&q=80',
    title: 'Premium Quality',
    description: 'Experience luxury with our premium collection of products.',
    buttonText: 'View Collection'
  }
])

// Side slider data
const sideSlides = ref([
  {
    image: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=999&q=80',
    title: 'Electronics',
    description: 'Latest gadgets and tech accessories',
    buttonText: 'Shop Electronics'
  },
  {
    image: 'https://images.unsplash.com/photo-1445205170230-053b83016050?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2071&q=80',
    title: 'Fashion',
    description: 'Trendy clothes and accessories',
    buttonText: 'Shop Fashion'
  },
  {
    image: 'https://images.unsplash.com/photo-1586953208448-b95a79798f07?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80',
    title: 'Home & Living',
    description: 'Beautiful home decor items',
    buttonText: 'Shop Home'
  }
])

// Reactive state
const currentMainSlide = ref(0)
const currentSideSlide = ref(0)
let mainSliderInterval: number | null = null

// Side slider touch/mouse interaction state
const sideSliderState = ref({
  isDragging: false,
  startX: 0,
  startY: 0,
  currentX: 0,
  threshold: 50 // minimum distance to trigger slide change
})

// Main slider touch/mouse interaction state
const mainSliderState = ref({
  isDragging: false,
  startX: 0,
  startY: 0,
  currentX: 0,
  threshold: 50 // minimum distance to trigger slide change
})

// Methods
const nextMainSlide = () => {
  currentMainSlide.value = (currentMainSlide.value + 1) % mainSlides.value.length
}

const prevMainSlide = () => {
  currentMainSlide.value = currentMainSlide.value === 0 
    ? mainSlides.value.length - 1 
    : currentMainSlide.value - 1
}

// Main slider mouse events
const handleMainMouseDown = (e: MouseEvent) => {
  mainSliderState.value.isDragging = true
  mainSliderState.value.startX = e.clientX
  mainSliderState.value.startY = e.clientY
  stopAutoSlide() // Stop auto-advance when user interacts
}

const handleMainMouseMove = (e: MouseEvent) => {
  if (!mainSliderState.value.isDragging) return
  e.preventDefault()
  mainSliderState.value.currentX = e.clientX
}

const handleMainMouseUp = () => {
  if (!mainSliderState.value.isDragging) return
  
  const deltaX = mainSliderState.value.currentX - mainSliderState.value.startX
  
  if (Math.abs(deltaX) > mainSliderState.value.threshold) {
    if (deltaX > 0) {
      prevMainSlide()
    } else {
      nextMainSlide()
    }
  }
  
  mainSliderState.value.isDragging = false
  startAutoSlide() // Restart auto-advance after interaction
}

// Main slider touch events
const handleMainTouchStart = (e: TouchEvent) => {
  const touch = e.touches[0]
  mainSliderState.value.isDragging = true
  mainSliderState.value.startX = touch.clientX
  mainSliderState.value.startY = touch.clientY
  stopAutoSlide() // Stop auto-advance when user interacts
}

const handleMainTouchMove = (e: TouchEvent) => {
  if (!mainSliderState.value.isDragging) return
  const touch = e.touches[0]
  mainSliderState.value.currentX = touch.clientX
}

const handleMainTouchEnd = () => {
  if (!mainSliderState.value.isDragging) return
  
  const deltaX = mainSliderState.value.currentX - mainSliderState.value.startX
  
  if (Math.abs(deltaX) > mainSliderState.value.threshold) {
    if (deltaX > 0) {
      prevMainSlide()
    } else {
      nextMainSlide()
    }
  }
  
  mainSliderState.value.isDragging = false
  startAutoSlide() // Restart auto-advance after interaction
}

const nextSideSlide = () => {
  currentSideSlide.value = (currentSideSlide.value + 1) % sideSlides.value.length
}

const prevSideSlide = () => {
  currentSideSlide.value = currentSideSlide.value === 0 
    ? sideSlides.value.length - 1 
    : currentSideSlide.value - 1
}

// Side slider mouse events
const handleSideMouseDown = (e: MouseEvent) => {
  sideSliderState.value.isDragging = true
  sideSliderState.value.startX = e.clientX
  sideSliderState.value.startY = e.clientY
}

const handleSideMouseMove = (e: MouseEvent) => {
  if (!sideSliderState.value.isDragging) return
  e.preventDefault()
  sideSliderState.value.currentX = e.clientX
}

const handleSideMouseUp = () => {
  if (!sideSliderState.value.isDragging) return
  
  const deltaX = sideSliderState.value.currentX - sideSliderState.value.startX
  
  if (Math.abs(deltaX) > sideSliderState.value.threshold) {
    if (deltaX > 0) {
      prevSideSlide()
    } else {
      nextSideSlide()
    }
  }
  
  sideSliderState.value.isDragging = false
}

// Side slider touch events
const handleSideTouchStart = (e: TouchEvent) => {
  const touch = e.touches[0]
  sideSliderState.value.isDragging = true
  sideSliderState.value.startX = touch.clientX
  sideSliderState.value.startY = touch.clientY
}

const handleSideTouchMove = (e: TouchEvent) => {
  if (!sideSliderState.value.isDragging) return
  const touch = e.touches[0]
  sideSliderState.value.currentX = touch.clientX
}

const handleSideTouchEnd = () => {
  if (!sideSliderState.value.isDragging) return
  
  const deltaX = sideSliderState.value.currentX - sideSliderState.value.startX
  
  if (Math.abs(deltaX) > sideSliderState.value.threshold) {
    if (deltaX > 0) {
      prevSideSlide()
    } else {
      nextSideSlide()
    }
  }
  
  sideSliderState.value.isDragging = false
}

const startAutoSlide = () => {
  mainSliderInterval = setInterval(() => {
    nextMainSlide()
  }, 5000) // Change slide every 5 seconds
}

const stopAutoSlide = () => {
  if (mainSliderInterval) {
    clearInterval(mainSliderInterval)
    mainSliderInterval = null
  }
}

// Lifecycle
onMounted(() => {
  startAutoSlide()
})

onUnmounted(() => {
  stopAutoSlide()
})
</script>

<style scoped>
.hero-banner {
  padding: 2rem 0;
}

.slide {
  will-change: transform;
}

/* Main slider touch/mouse interaction */
.main-slider {
  user-select: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  touch-action: pan-y;
}

.main-slider:active {
  cursor: grabbing;
}

/* Side slider touch/mouse interaction */
.side-slider {
  user-select: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  touch-action: pan-y;
}

.side-slider:active {
  cursor: grabbing;
}

/* Responsive adjustments */
@media (max-width: 1024px) {
  .hero-banner .grid {
    grid-template-columns: 1fr;
    height: auto;
  }
  
  .hero-banner .grid > div:first-child {
    height: 400px;
  }
  
  .hero-banner .grid > div:last-child {
    height: 200px;
    margin-top: 1rem;
  }
}
</style>