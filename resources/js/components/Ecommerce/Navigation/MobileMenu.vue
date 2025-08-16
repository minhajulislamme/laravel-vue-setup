<script setup lang="ts">
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Separator } from '@/components/ui/separator';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import {
  Collapsible,
  CollapsibleContent,
  CollapsibleTrigger,
} from '@/components/ui/collapsible';
import {
  Search,
  ChevronDown,
  ChevronRight,
  Home,
  Grid3X3,
  Tag,
  Sparkles,
  Building2,
  User,
  Package2,
  Settings,
  LogOut,
  Heart,
  ShoppingCart,
  Phone,
  HelpCircle,
  Truck,
} from 'lucide-vue-next';

interface Props {
  isOpen: boolean;
  cartItemCount?: number;
  wishlistCount?: number;
  user?: {
    name: string;
    email: string;
    avatar?: string;
  } | null;
}

const props = withDefaults(defineProps<Props>(), {
  isOpen: false,
  cartItemCount: 0,
  wishlistCount: 0,
  user: null,
});

const emit = defineEmits<{
  close: [];
}>();

const searchQuery = ref('');
const categoriesOpen = ref(false);

const categories = [
  { name: 'Electronics', href: '/categories/electronics', icon: '📱' },
  { name: 'Clothing', href: '/categories/clothing', icon: '👕' },
  { name: 'Home & Garden', href: '/categories/home-garden', icon: '🏠' },
  { name: 'Sports', href: '/categories/sports', icon: '⚽' },
  { name: 'Books', href: '/categories/books', icon: '📚' },
  { name: 'Beauty', href: '/categories/beauty', icon: '💄' },
  { name: 'Automotive', href: '/categories/automotive', icon: '🚗' },
  { name: 'Toys', href: '/categories/toys', icon: '🧸' },
];

const mainNavItems = [
  { name: 'Home', href: '/', icon: Home },
  { name: 'All Categories', href: '/categories', icon: Grid3X3 },
  { name: 'Deals & Offers', href: '/deals', icon: Tag },
  { name: 'New Arrivals', href: '/new-arrivals', icon: Sparkles },
  { name: 'Brands', href: '/brands', icon: Building2 },
];

const quickLinks = [
  { name: 'Track Your Order', href: '/track-order', icon: Truck },
  { name: 'Help & Support', href: '/help', icon: HelpCircle },
  { name: 'Contact Us', href: '/contact', icon: Phone },
];

const handleSearch = () => {
  if (searchQuery.value.trim()) {
    // Navigate to search results
    window.location.href = `/search?q=${encodeURIComponent(searchQuery.value)}`;
    emit('close');
  }
};

const handleLinkClick = () => {
  emit('close');
};
</script>

<template>
  <div class="flex flex-col h-full">
    <!-- Header -->
    <div class="p-4 border-b">
      <div v-if="user" class="flex items-center space-x-3 mb-4">
        <Avatar class="h-12 w-12">
          <AvatarImage :src="user.avatar" :alt="user.name" />
          <AvatarFallback class="text-lg">{{ user.name.charAt(0).toUpperCase() }}</AvatarFallback>
        </Avatar>
        <div class="flex-1">
          <h3 class="font-semibold">{{ user.name }}</h3>
          <p class="text-sm text-muted-foreground">{{ user.email }}</p>
        </div>
      </div>

      <!-- Search -->
      <form @submit.prevent="handleSearch" class="relative">
        <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
        <Input
          v-model="searchQuery"
          type="search"
          placeholder="Search products..."
          class="pl-10 w-full"
        />
      </form>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto">
      <!-- Quick Actions -->
      <div class="p-4 space-y-2">
        <div class="grid grid-cols-2 gap-2">
          <Link 
            href="/wishlist" 
            @click="handleLinkClick"
            class="flex items-center justify-center p-3 border rounded-lg hover:bg-accent transition-colors relative"
          >
            <Heart class="h-5 w-5 mr-2" />
            <span class="text-sm">Wishlist</span>
            <Badge
              v-if="wishlistCount > 0"
              class="absolute -right-1 -top-1 h-5 w-5 rounded-full p-0 text-xs"
              variant="destructive"
            >
              {{ wishlistCount }}
            </Badge>
          </Link>
          
          <Link 
            href="/cart" 
            @click="handleLinkClick"
            class="flex items-center justify-center p-3 border rounded-lg hover:bg-accent transition-colors relative"
          >
            <ShoppingCart class="h-5 w-5 mr-2" />
            <span class="text-sm">Cart</span>
            <Badge
              v-if="cartItemCount > 0"
              class="absolute -right-1 -top-1 h-5 w-5 rounded-full p-0 text-xs"
              variant="destructive"
            >
              {{ cartItemCount }}
            </Badge>
          </Link>
        </div>
      </div>

      <!-- Main Navigation -->
      <div class="px-4">
        <h3 class="font-semibold text-sm text-muted-foreground uppercase tracking-wider mb-3">
          Shop
        </h3>
        <nav class="space-y-1">
          <Link
            v-for="item in mainNavItems"
            :key="item.name"
            :href="item.href"
            @click="handleLinkClick"
            class="flex items-center px-3 py-2 text-sm rounded-md hover:bg-accent transition-colors"
          >
            <component :is="item.icon" class="h-5 w-5 mr-3 text-muted-foreground" />
            {{ item.name }}
          </Link>
        </nav>
      </div>

      <Separator class="my-4" />

      <!-- Categories -->
      <div class="px-4">
        <Collapsible v-model:open="categoriesOpen">
          <CollapsibleTrigger class="flex items-center justify-between w-full px-3 py-2 text-sm font-semibold hover:bg-accent rounded-md transition-colors">
            <div class="flex items-center">
              <Grid3X3 class="h-5 w-5 mr-3 text-muted-foreground" />
              Categories
            </div>
            <ChevronDown 
              class="h-4 w-4 transition-transform"
              :class="{ 'transform rotate-180': categoriesOpen }"
            />
          </CollapsibleTrigger>
          <CollapsibleContent class="mt-2">
            <div class="space-y-1 ml-6">
              <Link
                v-for="category in categories"
                :key="category.name"
                :href="category.href"
                @click="handleLinkClick"
                class="flex items-center px-3 py-2 text-sm rounded-md hover:bg-accent transition-colors"
              >
                <span class="mr-3 text-lg">{{ category.icon }}</span>
                {{ category.name }}
              </Link>
            </div>
          </CollapsibleContent>
        </Collapsible>
      </div>

      <Separator class="my-4" />

      <!-- Quick Links -->
      <div class="px-4">
        <h3 class="font-semibold text-sm text-muted-foreground uppercase tracking-wider mb-3">
          Support
        </h3>
        <nav class="space-y-1">
          <Link
            v-for="link in quickLinks"
            :key="link.name"
            :href="link.href"
            @click="handleLinkClick"
            class="flex items-center px-3 py-2 text-sm rounded-md hover:bg-accent transition-colors"
          >
            <component :is="link.icon" class="h-5 w-5 mr-3 text-muted-foreground" />
            {{ link.name }}
          </Link>
        </nav>
      </div>
    </div>

    <!-- Footer -->
    <div class="p-4 border-t bg-muted/30">
      <!-- User Actions -->
      <div v-if="user" class="space-y-2">
        <Link 
          href="/profile" 
          @click="handleLinkClick"
          class="flex items-center px-3 py-2 text-sm rounded-md hover:bg-accent transition-colors w-full"
        >
          <User class="h-4 w-4 mr-3" />
          My Profile
        </Link>
        <Link 
          href="/orders" 
          @click="handleLinkClick"
          class="flex items-center px-3 py-2 text-sm rounded-md hover:bg-accent transition-colors w-full"
        >
          <Package2 class="h-4 w-4 mr-3" />
          My Orders
        </Link>
        <Link 
          href="/settings" 
          @click="handleLinkClick"
          class="flex items-center px-3 py-2 text-sm rounded-md hover:bg-accent transition-colors w-full"
        >
          <Settings class="h-4 w-4 mr-3" />
          Settings
        </Link>
        <Separator class="my-2" />
        <Link 
          href="/logout" 
          method="post"
          @click="handleLinkClick"
          class="flex items-center px-3 py-2 text-sm rounded-md hover:bg-destructive hover:text-destructive-foreground transition-colors w-full text-destructive"
        >
          <LogOut class="h-4 w-4 mr-3" />
          Sign Out
        </Link>
      </div>

      <!-- Guest Actions -->
      <div v-else class="space-y-2">
        <Link href="/login" @click="handleLinkClick">
          <Button variant="outline" class="w-full">
            Sign In
          </Button>
        </Link>
        <Link href="/register" @click="handleLinkClick">
          <Button class="w-full">
            Create Account
          </Button>
        </Link>
      </div>

      <!-- App Info -->
      <div class="mt-4 pt-4 border-t text-center">
        <p class="text-xs text-muted-foreground">
          ShopVue v1.0.0
        </p>
        <p class="text-xs text-muted-foreground mt-1">
          © 2025 ShopVue. All rights reserved.
        </p>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Custom scrollbar for mobile menu */
.overflow-y-auto::-webkit-scrollbar {
  width: 4px;
}

.overflow-y-auto::-webkit-scrollbar-track {
  background: transparent;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
  background: hsl(var(--muted-foreground) / 0.3);
  border-radius: 2px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
  background: hsl(var(--muted-foreground) / 0.5);
}
</style>
