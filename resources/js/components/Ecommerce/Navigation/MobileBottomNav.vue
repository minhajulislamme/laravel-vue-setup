<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { Badge } from '@/components/ui/badge';
import {
  Home,
  Search,
  ShoppingCart,
  Heart,
  User,
  Grid3X3,
} from 'lucide-vue-next';

interface Props {
  cartItemCount?: number;
  wishlistCount?: number;
  user?: {
    name: string;
    email: string;
    avatar?: string;
  } | null;
}

withDefaults(defineProps<Props>(), {
  cartItemCount: 0,
  wishlistCount: 0,
  user: null,
});

const page = usePage();

const navItems = [
  {
    name: 'Home',
    href: '/',
    icon: Home,
    badge: null,
  },
  {
    name: 'Categories',
    href: '/categories',
    icon: Grid3X3,
    badge: null,
  },
  {
    name: 'Search',
    href: '/search',
    icon: Search,
    badge: null,
  },
  {
    name: 'Wishlist',
    href: '/wishlist',
    icon: Heart,
    badge: 'wishlistCount',
  },
  {
    name: 'Cart',
    href: '/cart',
    icon: ShoppingCart,
    badge: 'cartItemCount',
  },
];

const isActive = (href: string) => {
  if (href === '/') {
    return page.url === '/';
  }
  return page.url.startsWith(href);
};

const getBadgeCount = (badgeType: string | null, props: any) => {
  if (!badgeType) return 0;
  return props[badgeType] || 0;
};
</script>

<template>
  <nav class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-background border-t border-border">
    <div class="grid grid-cols-5 h-16">
      <Link
        v-for="item in navItems"
        :key="item.name"
        :href="item.href"
        class="flex flex-col items-center justify-center px-1 py-2 text-xs transition-colors relative"
        :class="[
          isActive(item.href)
            ? 'text-primary bg-primary/10'
            : 'text-muted-foreground hover:text-foreground hover:bg-accent/50'
        ]"
      >
        <div class="relative">
          <component :is="item.icon" class="h-5 w-5 mb-1" />
          <Badge
            v-if="item.badge && getBadgeCount(item.badge, $props) > 0"
            class="absolute -right-2 -top-2 h-4 w-4 rounded-full p-0 text-xs flex items-center justify-center"
            variant="destructive"
          >
            {{ getBadgeCount(item.badge, $props) > 99 ? '99+' : getBadgeCount(item.badge, $props) }}
          </Badge>
        </div>
        <span class="font-medium">{{ item.name }}</span>
        
        <!-- Active indicator -->
        <div
          v-if="isActive(item.href)"
          class="absolute top-0 left-1/2 transform -translate-x-1/2 w-8 h-0.5 bg-primary rounded-b-full"
        />
      </Link>
    </div>
  </nav>

  <!-- Bottom padding to prevent content from being hidden behind the nav -->
  <div class="md:hidden h-16" />
</template>

<style scoped>
/* Ensure smooth transitions and proper z-index layering */
nav {
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
}

/* Custom animation for active state */
.grid > a {
  position: relative;
  overflow: hidden;
}

.grid > a::before {
  content: '';
  position: absolute;
  top: 0;
  left: 50%;
  width: 0;
  height: 2px;
  background-color: hsl(var(--primary));
  transition: all 0.3s ease;
  transform: translateX(-50%);
}

.grid > a.text-primary::before {
  width: 100%;
}

/* Ripple effect on tap */
.grid > a {
  -webkit-tap-highlight-color: transparent;
}

.grid > a:active {
  transform: scale(0.95);
  transition: transform 0.1s ease;
}
</style>