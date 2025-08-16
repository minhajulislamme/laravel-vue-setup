<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import EcommerceLayout from '@/components/Ecommerce/Layout/EcommerceLayout.vue';

// Example user data - this would typically come from your backend
const user = {
  name: 'John Doe',
  email: 'john@example.com',
  avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face'
};

// Example cart and wishlist counts
const cartItemCount = 3;
const wishlistCount = 12;
</script>

<template>
  <Head title="E-commerce Demo" />

  <EcommerceLayout
    :cart-item-count="cartItemCount"
    :wishlist-count="wishlistCount"
    :user="user"
  >
    <div class="container mx-auto px-4 py-8">
      <div class="max-w-4xl mx-auto">
        <!-- Hero Section -->
        <section class="text-center py-12">
          <h1 class="text-4xl md:text-6xl font-bold mb-6">
            Welcome to <span class="text-primary">ShopVue</span>
          </h1>
          <p class="text-xl text-muted-foreground mb-8 max-w-2xl mx-auto">
            Discover amazing products with our modern e-commerce platform built with Laravel and Vue.js
          </p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button class="bg-primary text-primary-foreground px-8 py-3 rounded-lg font-semibold hover:bg-primary/90 transition-colors">
              Shop Now
            </button>
            <button class="border border-border px-8 py-3 rounded-lg font-semibold hover:bg-accent transition-colors">
              Learn More
            </button>
          </div>
        </section>

        <!-- Features Section -->
        <section class="py-12">
          <h2 class="text-3xl font-bold text-center mb-8">Features</h2>
          <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center p-6 border border-border rounded-lg">
              <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mx-auto mb-4">
                📱
              </div>
              <h3 class="text-xl font-semibold mb-2">Mobile First</h3>
              <p class="text-muted-foreground">
                Responsive design with mobile bottom navigation for the best mobile shopping experience.
              </p>
            </div>
            
            <div class="text-center p-6 border border-border rounded-lg">
              <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mx-auto mb-4">
                🔍
              </div>
              <h3 class="text-xl font-semibold mb-2">Smart Search</h3>
              <p class="text-muted-foreground">
                Powerful search functionality with advanced filtering and category browsing.
              </p>
            </div>
            
            <div class="text-center p-6 border border-border rounded-lg">
              <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mx-auto mb-4">
                🛒
              </div>
              <h3 class="text-xl font-semibold mb-2">Easy Shopping</h3>
              <p class="text-muted-foreground">
                Streamlined shopping cart and wishlist functionality with real-time updates.
              </p>
            </div>
          </div>
        </section>

        <!-- Navigation Demo Section -->
        <section class="py-12 bg-muted/30 rounded-lg px-6">
          <h2 class="text-3xl font-bold text-center mb-8">Navigation Features</h2>
          <div class="space-y-6">
            <div class="grid md:grid-cols-2 gap-6">
              <div class="space-y-4">
                <h3 class="text-xl font-semibold">Desktop Navigation</h3>
                <ul class="space-y-2 text-muted-foreground">
                  <li>• Comprehensive header with search and categories</li>
                  <li>• Dropdown menus for easy category browsing</li>
                  <li>• User account dropdown with profile management</li>
                  <li>• Cart and wishlist with badge counts</li>
                  <li>• Quick access to deals and new arrivals</li>
                </ul>
              </div>
              
              <div class="space-y-4">
                <h3 class="text-xl font-semibold">Mobile Navigation</h3>
                <ul class="space-y-2 text-muted-foreground">
                  <li>• Bottom navigation bar for easy thumb access</li>
                  <li>• Sliding side menu with full navigation</li>
                  <li>• Collapsible category sections</li>
                  <li>• Mobile-optimized search experience</li>
                  <li>• Quick access to cart and wishlist</li>
                </ul>
              </div>
            </div>
            
            <div class="mt-8 p-4 bg-background rounded-lg border border-border">
              <h4 class="font-semibold mb-2">Try it out:</h4>
              <p class="text-sm text-muted-foreground">
                • On desktop: Use the top navigation and hover over "Categories"<br>
                • On mobile: Use the bottom navigation bar and try the menu button in the header<br>
                • Notice the cart ({{ cartItemCount }}) and wishlist ({{ wishlistCount }}) badge counts
              </p>
            </div>
          </div>
        </section>
      </div>
    </div>
  </EcommerceLayout>
</template>
