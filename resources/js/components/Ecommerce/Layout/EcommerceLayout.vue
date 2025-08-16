<script setup lang="ts">
import { NavigationWrapper } from '@/components/Ecommerce/Navigation';

interface Props {
  cartItemCount?: number;
  wishlistCount?: number;
  user?: {
    name: string;
    email: string;
    avatar?: string;
  } | null;
}

const props = withDefaults(defineProps<Props>(), {
  cartItemCount: 0,
  wishlistCount: 0,
  user: null,
});
</script>

<template>
  <div class="min-h-screen bg-background">
    <!-- Navigation -->
    <NavigationWrapper
      :cart-item-count="cartItemCount"
      :wishlist-count="wishlistCount"
      :user="user"
    />

    <!-- Main Content -->
    <main class="pb-16 md:pb-0">
      <slot />
    </main>
  </div>
</template>

<style scoped>
/* Ensure proper spacing for mobile bottom nav */
@media (max-width: 768px) {
  main {
    padding-bottom: 4rem; /* 64px for bottom nav */
  }
}
</style>
