<template>
  <!-- Header/Navigation -->
  <header class="sticky top-0 z-50 bg-white shadow-sm">
    <nav class="container mx-auto px-4 py-4">
      <div class="flex items-center justify-between">
        <!-- Logo -->
        <Link href="/" class="text-2xl font-bold text-navy-900">ArtzworkPC</Link>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center space-x-8">
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
          <div class="hidden sm:block relative">
            <input
              type="text"
              placeholder="Search for products..."
              class="w-64 pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500"
            />
            <SearchIcon class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" />
          </div>
          <button class="text-gray-700 hover:text-navy-600">
            <ShoppingCartIcon class="h-6 w-6" />
          </button>
          <button
            @click="isMenuOpen = !isMenuOpen"
            class="md:hidden text-gray-700 hover:text-navy-600"
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
    </nav>
  </header>
</template>

<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import { MenuIcon, XIcon, SearchIcon, ShoppingCartIcon } from "lucide-vue-next";

// State
const isMenuOpen = ref(false);

const navigationItems = [
  { name: "Home", href: "/" },
  { name: "Products", href: "/products" },
  { name: "PC Builder", href: "/pc-builder" },
  { name: "Laptops", href: "/laptops" },
  { name: "Desktops", href: "/desktops" },
];
</script>
