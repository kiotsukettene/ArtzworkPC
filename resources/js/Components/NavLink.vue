<template>
  <!-- Header/Navigation -->
  <header class="sticky top-0 z-50 bg-white shadow-sm">
    <nav class="container mx-auto px-4 py-4">
      <div class="flex items-center justify-between">
        <!-- Logo -->
        <Link href="/" class="text-2xl font-bold text-navy-900">ArtzworkPC</Link>

        <!-- Desktop Navigation -->
        <div class="hidden md:hidden lg:flex items-center space-x-8">
          <Link
            v-for="item in navigationItems"
            :key="item.name"
            :href="item.href"
            class="text-gray-700 hover:text-navy-600"
          >
            {{ item.name }}
          </Link>
        </div>

        <!-- Search and Cart -->
        <div class="flex items-center space-x-4">
          <div class="hidden md:block lg:block relative">
            <form @submit.prevent="searchProducts">
              <input
                type="search"
                placeholder="Search for products..."
                class="w-64 pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500"
                v-model="form.search"
              />
              <SearchIcon class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" />
            </form>
          </div>
          <Link
            href="/cart"
            class="relative inline-flex items-center p-2 text-gray-600 hover:text-gray-900"
          >
            <ShoppingCartIcon class="h-6 w-6" />
            <!-- Badge -->
            <div
              v-if="cartCount > 0"
              class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center"
            >
              {{ cartCount }}
            </div>
          </Link>
          <!-- Mobile Menu Toggle -->
          <button
            @click="isMenuOpen = !isMenuOpen"
            class="lg:hidden text-gray-700 hover:text-navy-600"
          >
            <MenuIcon v-if="!isMenuOpen" class="h-6 w-6" />
            <XIcon v-else class="h-6 w-6" />
          </button>
          <Link
            href="/login"
            class="py-2 px-4 border bg-navy-900 text-white border-navy-600 rounded-md"
          >
            Login
          </Link>
        </div>
      </div>

      <!-- Mobile Navigation -->
      <div v-if="isMenuOpen" class="lg:hidden mt-4 border-t pt-4">
        <Link
          v-for="item in navigationItems"
          :key="item.name"
          :href="item.href"
          class="block py-2 px-4 text-gray-700 hover:text-navy-600"
        >
          {{ item.name }}
        </Link>
        <!-- Mobile Search -->
        <div class="mt-4 relative">
          <form @submit.prevent="searchProducts">
            <input
              type="text"
              placeholder="Search for products..."
              class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500"
              v-model="form.search"
            />
            <SearchIcon class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" />
          </form>
        </div>
      </div>
    </nav>
  </header>
</template>

<script setup>
import { ref, computed } from "vue";
import { Link, useForm, router, usePage } from "@inertiajs/vue3";
import { MenuIcon, XIcon, SearchIcon, ShoppingCartIcon } from "lucide-vue-next";

// State
const isMenuOpen = ref(false);

const props = defineProps({
  searchTerm: {
    type: String,
    required: false,
  },
});
const form = useForm({
  search: props.searchTerm,
});

const searchProducts = () => {
  router.get(route("product.list", { search: form.search }));
};

const navigationItems = [
  { name: "Home", href: "/" },
  { name: "Products", href: "/product-list" },
  { name: "PC Builder", href: "/pc-builder" },
  { name: "Laptops", href: "/laptops" },
  { name: "Desktops", href: "/desktops" },
];

// Get cart count directly from session cart items
const cartCount = computed(() => {
  const cart = usePage().props.auth?.cart || {};
  return Object.keys(cart).length;
});
</script>

<style scoped>
/* Optional: Add animation for badge */
.absolute {
  transition: all 0.2s ease-in-out;
}
</style>
