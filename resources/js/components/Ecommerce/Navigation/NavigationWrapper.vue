<script setup lang="ts">
import { ref } from 'vue';
import DesktopHeader from './DesktopHeader.vue';
import MobileBottomNav from './MobileBottomNav.vue';
import MobileMenu from './MobileMenu.vue';
import { Sheet, SheetContent, SheetTrigger } from '@/components/ui/sheet';

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

const mobileMenuOpen = ref(false);

const closeMobileMenu = () => {
  mobileMenuOpen.value = false;
};
</script>

<template>
  <div>
    <!-- Desktop Header -->
    <DesktopHeader
      :cart-item-count="cartItemCount"
      :wishlist-count="wishlistCount"
      :user="user"
    />

    <!-- Mobile Bottom Navigation -->
    <MobileBottomNav
      :cart-item-count="cartItemCount"
      :wishlist-count="wishlistCount"
      :user="user"
    />

    <!-- Mobile Menu Sheet (can be triggered from anywhere) -->
    <Sheet v-model:open="mobileMenuOpen">
      <SheetContent side="left" class="w-80 p-0">
        <MobileMenu
          :is-open="mobileMenuOpen"
          :cart-item-count="cartItemCount"
          :wishlist-count="wishlistCount"
          :user="user"
          @close="closeMobileMenu"
        />
      </SheetContent>
    </Sheet>
  </div>
</template>
