<script setup lang="ts">
import { ref, nextTick } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import {
  NavigationMenu,
  NavigationMenuContent,
  NavigationMenuItem,
  NavigationMenuLink,
  NavigationMenuList,
  NavigationMenuTrigger,
} from '@/components/ui/navigation-menu';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Sheet, SheetContent, SheetTrigger } from '@/components/ui/sheet';
import {
  Search,
  ShoppingCart,
  User,
  Heart,
  Menu,
  Package2,
  Bell,
  Settings
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

const searchQuery = ref('');
const isSearchOpen = ref(false);
const searchInput = ref<HTMLInputElement>();
const categories = [
  { name: 'Electronics', href: '/categories/electronics' },
  { name: 'Clothing', href: '/categories/clothing' },
  { name: 'Home & Garden', href: '/categories/home-garden' },
  { name: 'Sports', href: '/categories/sports' },
  { name: 'Books', href: '/categories/books' },
];

const handleSearch = () => {
  // Implement search functionality
  console.log('Searching for:', searchQuery.value);
};

const toggleSearch = async () => {
  isSearchOpen.value = !isSearchOpen.value;
  if (isSearchOpen.value) {
    await nextTick();
    searchInput.value?.focus();
  }
};
</script>

<template>
  <header class="sticky top-0 z-50 w-full border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
    <!-- Top Bar -->
    <div class="hidden lg:block border-b bg-muted/30">
      <div class="container mx-auto px-4">
        <div class="flex h-10 items-center justify-between text-sm">
          <div class="flex items-center space-x-4">
            <span class="text-muted-foreground">Free shipping on orders over $50</span>
          </div>
          <div class="flex items-center space-x-4">
            <Link href="/help" class="text-muted-foreground hover:text-foreground transition-colors">
              Help
            </Link>
            <Link href="/contact" class="text-muted-foreground hover:text-foreground transition-colors">
              Contact
            </Link>
            <Link href="/track-order" class="text-muted-foreground hover:text-foreground transition-colors">
              Track Order
            </Link>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Header -->
    <div class="container mx-auto px-4">
      <div class="flex h-16 items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center">
          <Link href="/" class="flex items-center space-x-2">
            <Package2 class="h-8 w-8 text-primary" />
            <span class="text-xl font-bold">ShopVue</span>
          </Link>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden lg:flex items-center justify-center flex-1 space-x-8">
          <NavigationMenu>
            <NavigationMenuList>
              <NavigationMenuItem>
                <NavigationMenuLink as-child>
                  <Link href="/" class="group inline-flex h-9 w-max items-center justify-center rounded-md bg-background px-4 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground focus:outline-none disabled:pointer-events-none disabled:opacity-50">
                    Home
                  </Link>
                </NavigationMenuLink>
              </NavigationMenuItem>

              <NavigationMenuItem>
                <NavigationMenuLink as-child>
                  <Link href="/shop" class="group inline-flex h-9 w-max items-center justify-center rounded-md bg-background px-4 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground focus:outline-none disabled:pointer-events-none disabled:opacity-50">
                    Shop
                  </Link>
                </NavigationMenuLink>
              </NavigationMenuItem>

              <NavigationMenuItem>
                <NavigationMenuTrigger>Categories</NavigationMenuTrigger>
                <NavigationMenuContent>
                  <ul class="grid w-[400px] gap-3 p-4 md:w-[500px] md:grid-cols-2 lg:w-[600px]">
                    <li v-for="category in categories" :key="category.name" class="row-span-3">
                      <NavigationMenuLink as-child>
                        <Link
                          :href="category.href"
                          class="flex h-full w-full select-none flex-col justify-end rounded-md bg-gradient-to-b from-muted/50 to-muted p-6 no-underline outline-none focus:shadow-md hover:bg-accent hover:text-accent-foreground"
                        >
                          <div class="mb-2 mt-4 text-lg font-medium">
                            {{ category.name }}
                          </div>
                          <p class="text-sm leading-tight text-muted-foreground">
                            Explore our {{ category.name.toLowerCase() }} collection
                          </p>
                        </Link>
                      </NavigationMenuLink>
                    </li>
                  </ul>
                </NavigationMenuContent>
              </NavigationMenuItem>

              <NavigationMenuItem>
                <NavigationMenuLink as-child>
                  <Link href="/deals" class="group inline-flex h-9 w-max items-center justify-center rounded-md bg-background px-4 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground focus:outline-none disabled:pointer-events-none disabled:opacity-50">
                    Deals
                  </Link>
                </NavigationMenuLink>
              </NavigationMenuItem>

              <NavigationMenuItem>
                <NavigationMenuLink as-child>
                  <Link href="/new-arrivals" class="group inline-flex h-9 w-max items-center justify-center rounded-md bg-background px-4 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground focus:outline-none disabled:pointer-events-none disabled:opacity-50">
                    New Arrivals
                  </Link>
                </NavigationMenuLink>
              </NavigationMenuItem>

              <NavigationMenuItem>
                <NavigationMenuLink as-child>
                  <Link href="/brands" class="group inline-flex h-9 w-max items-center justify-center rounded-md bg-background px-4 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground focus:outline-none disabled:pointer-events-none disabled:opacity-50">
                    Brands
                  </Link>
                </NavigationMenuLink>
              </NavigationMenuItem>
            </NavigationMenuList>
          </NavigationMenu>
        </div>

        <!-- Search Bar -->
        <div class="hidden md:block w-80">
          <form @submit.prevent="handleSearch" class="relative">
            <Search class="absolute left-3 top-2.5 h-4 w-4 text-muted-foreground" />
            <Input
              v-model="searchQuery"
              type="search"
              placeholder="Search products..."
              class="pl-10 pr-4 py-2 w-full h-10 text-sm rounded-lg border border-input bg-background"
            />
          </form>
        </div>

        <!-- Right Side Actions -->
        <div class="flex items-center space-x-4">
          <!-- Search Icon (Mobile Only) -->
          <Button 
            variant="ghost" 
            size="icon" 
            class="md:hidden"
            @click="toggleSearch"
            :class="{ 'text-primary': isSearchOpen }"
          >
            <Search class="h-5 w-5" />
          </Button>

          <!-- Wishlist -->
          <Link href="/wishlist">
            <Button variant="ghost" size="icon" class="relative">
              <Heart class="h-5 w-5" />
              <Badge
                v-if="wishlistCount > 0"
                class="absolute -right-2 -top-2 h-5 w-5 rounded-full p-0 text-xs"
              >
                {{ wishlistCount }}
              </Badge>
            </Button>
          </Link>

          <!-- Shopping Cart -->
          <Link href="/cart">
            <Button variant="ghost" size="icon" class="relative">
              <ShoppingCart class="h-5 w-5" />
              <Badge
                v-if="cartItemCount > 0"
                class="absolute -right-2 -top-2 h-5 w-5 rounded-full p-0 text-xs"
              >
                {{ cartItemCount }}
              </Badge>
            </Button>
          </Link>

          <!-- User Menu -->
          <DropdownMenu v-if="user">
            <DropdownMenuTrigger as-child>
              <Button variant="ghost" class="relative h-8 w-8 rounded-full">
                <Avatar class="h-8 w-8">
                  <AvatarImage :src="user.avatar" :alt="user.name" />
                  <AvatarFallback>{{ user.name.charAt(0).toUpperCase() }}</AvatarFallback>
                </Avatar>
              </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent class="w-56" align="end" :side-offset="5">
              <DropdownMenuLabel class="font-normal">
                <div class="flex flex-col space-y-1">
                  <p class="text-sm font-medium leading-none">{{ user.name }}</p>
                  <p class="text-xs leading-none text-muted-foreground">
                    {{ user.email }}
                  </p>
                </div>
              </DropdownMenuLabel>
              <DropdownMenuSeparator />
              <DropdownMenuItem as-child>
                <Link href="/profile" class="flex items-center">
                  <User class="mr-2 h-4 w-4" />
                  <span>Profile</span>
                </Link>
              </DropdownMenuItem>
              <DropdownMenuItem as-child>
                <Link href="/orders" class="flex items-center">
                  <Package2 class="mr-2 h-4 w-4" />
                  <span>Orders</span>
                </Link>
              </DropdownMenuItem>
              <DropdownMenuItem as-child>
                <Link href="/settings" class="flex items-center">
                  <Settings class="mr-2 h-4 w-4" />
                  <span>Settings</span>
                </Link>
              </DropdownMenuItem>
              <DropdownMenuSeparator />
              <DropdownMenuItem as-child>
                <Link href="/logout" method="post" class="flex items-center">
                  <span>Log out</span>
                </Link>
              </DropdownMenuItem>
            </DropdownMenuContent>
          </DropdownMenu>

          <!-- Login/Register (Guest) -->
          <div v-else class="hidden md:flex items-center space-x-2">
            <Link href="/login">
              <Button variant="ghost" size="sm">
                Sign In
              </Button>
            </Link>
            <Link href="/register">
              <Button size="sm">
                Sign Up
              </Button>
            </Link>
          </div>

          <!-- Mobile Menu Trigger -->
          <Sheet>
            <SheetTrigger as-child>
              <Button variant="ghost" size="icon" class="md:hidden">
                <Menu class="h-5 w-5" />
              </Button>
            </SheetTrigger>
            <SheetContent side="right" class="w-80 p-0">
              <div class="flex flex-col h-full">
                <!-- Header -->
                <div class="p-4 border-b bg-background">
                  <h2 class="text-lg font-semibold">Menu</h2>
                </div>

                <!-- Navigation Content -->
                <div class="flex-1 overflow-y-auto p-4">
                  <div class="space-y-6">
                    <!-- Categories -->
                    <div>
                      <h3 class="text-base font-semibold mb-3 text-foreground">Categories</h3>
                      <div class="space-y-2">
                        <Link
                          v-for="category in categories"
                          :key="category.name"
                          :href="category.href"
                          class="block py-2.5 px-3 text-sm text-muted-foreground hover:text-foreground hover:bg-accent rounded-md transition-colors"
                        >
                          {{ category.name }}
                        </Link>
                      </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                      <h3 class="text-base font-semibold mb-3 text-foreground">Quick Links</h3>
                      <div class="space-y-2">
                        <Link href="/deals" class="block py-2.5 px-3 text-sm text-muted-foreground hover:text-foreground hover:bg-accent rounded-md transition-colors">
                          Deals
                        </Link>
                        <Link href="/new-arrivals" class="block py-2.5 px-3 text-sm text-muted-foreground hover:text-foreground hover:bg-accent rounded-md transition-colors">
                          New Arrivals
                        </Link>
                        <Link href="/brands" class="block py-2.5 px-3 text-sm text-muted-foreground hover:text-foreground hover:bg-accent rounded-md transition-colors">
                          Brands
                        </Link>
                      </div>
                    </div>

                    <!-- User Menu for Authenticated Users -->
                    <div v-if="user">
                      <h3 class="text-base font-semibold mb-3 text-foreground">Account</h3>
                      <div class="space-y-2">
                        <div class="flex items-center space-x-3 p-3 bg-accent/50 rounded-lg mb-3">
                          <Avatar class="h-10 w-10">
                            <AvatarImage :src="user.avatar" :alt="user.name" />
                            <AvatarFallback>{{ user.name.charAt(0).toUpperCase() }}</AvatarFallback>
                          </Avatar>
                          <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-foreground truncate">{{ user.name }}</p>
                            <p class="text-xs text-muted-foreground truncate">{{ user.email }}</p>
                          </div>
                        </div>
                        <Link href="/profile" class="block py-2.5 px-3 text-sm text-muted-foreground hover:text-foreground hover:bg-accent rounded-md transition-colors">
                          Profile
                        </Link>
                        <Link href="/orders" class="block py-2.5 px-3 text-sm text-muted-foreground hover:text-foreground hover:bg-accent rounded-md transition-colors">
                          Orders
                        </Link>
                        <Link href="/settings" class="block py-2.5 px-3 text-sm text-muted-foreground hover:text-foreground hover:bg-accent rounded-md transition-colors">
                          Settings
                        </Link>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Footer with Auth Buttons for Guests -->
                <div v-if="!user" class="p-4 border-t bg-background/95">
                  <div class="space-y-3">
                    <Link href="/login" class="block">
                      <Button variant="outline" class="w-full h-11 text-sm font-medium">
                        Sign In
                      </Button>
                    </Link>
                    <Link href="/register" class="block">
                      <Button class="w-full h-11 text-sm font-medium bg-primary hover:bg-primary/90 text-primary-foreground">
                        Sign Up
                      </Button>
                    </Link>
                  </div>
                </div>

                <!-- Footer with Logout for Authenticated Users -->
                <div v-else class="p-4 border-t bg-background/95">
                  <Link href="/logout" method="post" class="block">
                    <Button variant="outline" class="w-full h-11 text-sm font-medium text-destructive border-destructive hover:bg-destructive hover:text-destructive-foreground">
                      Log Out
                    </Button>
                  </Link>
                </div>
              </div>
            </SheetContent>
          </Sheet>
        </div>
      </div>
    </div>

    <!-- Mobile Search Section -->
    <div v-show="isSearchOpen" class="md:hidden border-t bg-background">
      <div class="container mx-auto px-4 py-3">
        <form @submit.prevent="handleSearch" class="relative">
          <Search class="absolute left-3 top-3 h-4 w-4 text-muted-foreground" />
          <Input
            ref="searchInput"
            v-model="searchQuery"
            type="search"
            placeholder="Search products..."
            class="pl-10 pr-4 py-3 w-full h-12 text-sm rounded-lg border border-input bg-background focus:ring-2 focus:ring-primary/20 focus:border-primary"
          />
        </form>
      </div>
    </div>
  </header>
</template>