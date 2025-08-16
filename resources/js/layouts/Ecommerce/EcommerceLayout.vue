<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 flex flex-col">
        <!-- Desktop Header -->
        <DesktopHeader ref="desktopHeader" />
        
        <!-- Main Content -->
        <main class="pb-20 md:pb-0 flex-1">
            <slot />
        </main>
        
        <!-- Footer -->
        <EcommerceFooter />
        
        <!-- Mobile Bottom Navigation -->
        <MobileBottomNav @openMobileMenu="handleOpenMobileMenu" />
        
        <!-- Toast Container -->
        <ToastContainer />
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import DesktopHeader from '@/components/Ecommerce/Navigation/DesktopHeader.vue';
import MobileBottomNav from '@/components/Ecommerce/Navigation/MobileBottomNav.vue';
import EcommerceFooter from '@/components/Ecommerce/Footer/EcommerceFooter.vue';
import ToastContainer from '@/components/Common/ToastContainer.vue';

const desktopHeader = ref<InstanceType<typeof DesktopHeader> | null>(null);

const handleOpenMobileMenu = () => {
    if (desktopHeader.value) {
        desktopHeader.value.toggleMobileMenu();
    }
};
</script>
