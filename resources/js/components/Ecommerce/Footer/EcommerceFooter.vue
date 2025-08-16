<template>
  <footer class="bg-gray-900 text-white">
    <!-- Main Footer Content -->
    <div class="container mx-auto px-4 py-12 lg:py-16">
      <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
        <!-- Company Info -->
        <div class="space-y-4">
          <div class="flex items-center space-x-2">
            <div class="h-8 w-8 rounded bg-orange-500 flex items-center justify-center">
              <span class="text-white font-bold text-sm">S</span>
            </div>
            <span class="text-xl font-bold">SkyShop</span>
          </div>
          <p class="text-gray-300 text-sm leading-relaxed">
            Your ultimate destination for quality products at amazing prices. We bring you the best shopping experience with fast delivery and excellent customer service.
          </p>
          <div class="flex space-x-4">
            <a
              v-for="social in socialLinks"
              :key="social.name"
              :href="social.href"
              :aria-label="social.name"
              class="text-gray-400 hover:text-white transition-colors duration-200"
              target="_blank"
              rel="noopener noreferrer"
            >
              <component :is="social.icon" class="h-5 w-5" />
            </a>
          </div>
        </div>

        <!-- Quick Links -->
        <div class="space-y-4">
          <h3 class="text-lg font-semibold">Quick Links</h3>
          <ul class="space-y-2">
            <li v-for="link in quickLinks" :key="link.name">
              <a
                :href="link.href"
                class="text-gray-300 hover:text-white transition-colors duration-200 text-sm"
              >
                {{ link.name }}
              </a>
            </li>
          </ul>
        </div>

        <!-- Customer Service -->
        <div class="space-y-4">
          <h3 class="text-lg font-semibold">Customer Service</h3>
          <ul class="space-y-2">
            <li v-for="service in customerService" :key="service.name">
              <a
                :href="service.href"
                class="text-gray-300 hover:text-white transition-colors duration-200 text-sm"
              >
                {{ service.name }}
              </a>
            </li>
          </ul>
        </div>

        <!-- Contact & Newsletter -->
        <div class="space-y-4">
          <h3 class="text-lg font-semibold">Stay Connected</h3>
          <div class="space-y-3">
            <div class="text-sm text-gray-300">
              <p class="flex items-center mb-2">
                <Phone class="h-4 w-4 mr-2" />
                +880 1234-567890
              </p>
              <p class="flex items-center">
                <Mail class="h-4 w-4 mr-2" />
                support@skyshop.com
              </p>
            </div>
            
            <!-- Newsletter -->
            <div>
              <p class="text-gray-300 text-sm mb-3">
                Subscribe for exclusive offers and updates
              </p>
              <form @submit.prevent="handleNewsletterSubmit" class="space-y-3">
                <div class="flex">
                  <input
                    v-model="newsletterEmail"
                    type="email"
                    placeholder="Your email"
                    required
                    class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-l-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm"
                  />
                  <button
                    type="submit"
                    :disabled="isSubmittingNewsletter"
                    class="px-4 py-2 bg-orange-500 hover:bg-orange-600 disabled:opacity-50 disabled:cursor-not-allowed rounded-r-md transition-colors duration-200 text-sm font-medium"
                  >
                    <span v-if="!isSubmittingNewsletter">Subscribe</span>
                    <span v-else class="flex items-center">
                      <Loader2 class="animate-spin h-3 w-3" />
                    </span>
                  </button>
                </div>
                <p v-if="newsletterMessage" :class="['text-xs', newsletterMessage.type === 'success' ? 'text-green-400' : 'text-red-400']">
                  {{ newsletterMessage.text }}
                </p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Payment Methods & Security -->
    <div class="border-t border-gray-800">
      <div class="container mx-auto px-4 py-6">
        <div class="flex flex-col items-center justify-between space-y-4 md:flex-row md:space-y-0">
          <div class="text-center md:text-left">
            <p class="text-sm text-gray-300 mb-2">We Accept</p>
            <div class="flex items-center space-x-3">
              <div
                v-for="payment in paymentMethods"
                :key="payment.name"
                class="bg-white rounded px-3 py-1 flex items-center justify-center"
                :title="payment.name"
              >
                <component :is="payment.icon" class="h-5 w-auto text-gray-700" />
              </div>
            </div>
          </div>
          <div class="text-center md:text-right">
            <div class="flex items-center space-x-2">
              <Shield class="h-5 w-5 text-green-400" />
              <span class="text-sm text-gray-300">100% Secure Payments</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom Footer -->
    <div class="border-t border-gray-800">
      <div class="container mx-auto px-4 py-4">
        <div class="flex flex-col items-center justify-between space-y-2 md:flex-row md:space-y-0">
          <p class="text-sm text-gray-400">
            © {{ currentYear }} SkyShop. All rights reserved.
          </p>
          <div class="flex space-x-6">
            <a
              v-for="legal in legalLinks"
              :key="legal.name"
              :href="legal.href"
              class="text-sm text-gray-400 hover:text-white transition-colors duration-200"
            >
              {{ legal.name }}
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Back to Top Button -->
    <button
      v-show="showBackToTop"
      @click="scrollToTop"
      class="fixed bottom-6 right-6 bg-orange-500 hover:bg-orange-600 text-white p-3 rounded-full shadow-lg transition-all duration-200 transform hover:scale-110 z-50 md:bottom-8 md:right-8"
      aria-label="Back to top"
    >
      <ChevronUp class="h-6 w-6" />
    </button>
  </footer>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { 
  Facebook, 
  Twitter, 
  Instagram, 
  Youtube, 
  Linkedin, 
  Shield, 
  ChevronUp,
  CreditCard,
  Phone,
  Mail,
  Loader2
} from 'lucide-vue-next'

// Reactive data
const newsletterEmail = ref('')
const isSubmittingNewsletter = ref(false)
const newsletterMessage = ref<{ type: 'success' | 'error'; text: string } | null>(null)
const showBackToTop = ref(false)

// Computed
const currentYear = computed(() => new Date().getFullYear())

// Data
const socialLinks = [
  { name: 'Facebook', href: 'https://facebook.com', icon: Facebook },
  { name: 'Twitter', href: 'https://twitter.com', icon: Twitter },
  { name: 'Instagram', href: 'https://instagram.com', icon: Instagram },
  { name: 'YouTube', href: 'https://youtube.com', icon: Youtube },
  { name: 'LinkedIn', href: 'https://linkedin.com', icon: Linkedin }
]

const quickLinks = [
  { name: 'About Us', href: '/about' },
  { name: 'Contact', href: '/contact' },
  { name: 'Shop', href: '/shop' },
  { name: 'Categories', href: '/categories' },
  { name: 'Brands', href: '/brands' },
  { name: 'Flash Sale', href: '/flash-sale' }
]

const customerService = [
  { name: 'Help Center', href: '/help' },
  { name: 'Shipping Info', href: '/shipping' },
  { name: 'Return & Exchange', href: '/returns' },
  { name: 'Size Guide', href: '/size-guide' },
  { name: 'Track Order', href: '/track-order' },
  { name: 'Customer Support', href: '/support' }
]

const legalLinks = [
  { name: 'Privacy Policy', href: '/privacy' },
  { name: 'Terms of Service', href: '/terms' },
  { name: 'Refund Policy', href: '/refund' }
]

const paymentMethods = [
  { name: 'Visa', icon: CreditCard },
  { name: 'Mastercard', icon: CreditCard },
  { name: 'bKash', icon: CreditCard },
  { name: 'Nagad', icon: CreditCard }
]

// Methods
const handleNewsletterSubmit = async () => {
  if (!newsletterEmail.value) return
  
  isSubmittingNewsletter.value = true
  newsletterMessage.value = null
  
  try {
    // Simulate API call - replace with your actual newsletter subscription endpoint
    await new Promise(resolve => setTimeout(resolve, 1500))
    
    newsletterMessage.value = {
      type: 'success',
      text: 'Successfully subscribed! Check your email for confirmation.'
    }
    
    newsletterEmail.value = ''
  } catch (error) {
    newsletterMessage.value = {
      type: 'error',
      text: 'Something went wrong. Please try again.'
    }
  } finally {
    isSubmittingNewsletter.value = false
    
    // Clear message after 5 seconds
    setTimeout(() => {
      newsletterMessage.value = null
    }, 5000)
  }
}

const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  })
}

const handleScroll = () => {
  showBackToTop.value = window.scrollY > 500
}

// Lifecycle
onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped>
/* Smooth transitions */
* {
  transition-property: color, background-color, border-color, transform;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 200ms;
}

/* Focus styles for accessibility */
input:focus,
button:focus {
  outline: 2px solid #f97316;
  outline-offset: 2px;
}

/* Animation for back to top button */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.fixed {
  animation: fadeInUp 0.3s ease-out;
}
</style>
