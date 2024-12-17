<template>
    <div
      :class="[
        'lg:w-80 transition-all duration-300 ease-in-out',
        isMobileMenuOpen ? 'block' : 'hidden lg:block',
      ]"
    >
      <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6">
          <div class="flex items-center gap-4 mb-6">
            <div
              class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white text-lg font-semibold"
            >
              {{ initials }}
            </div>
            <div>
              <h3 class="font-medium">
                {{ customer.first_name }} {{ customer.last_name }}
              </h3>
              <p class="text-sm text-gray-500">{{ customer.email }}</p>
            </div>
          </div>
  
          <nav class="space-y-1">
            <a
              href="/customer/profile"
              class="flex items-center gap-3 px-4 py-3 text-blue-600 bg-blue-50 rounded-lg font-medium"
            >
              <User class="w-5 h-5" />
              Account Profile
            </a>
  
            <a
              href="/customer/my-orders"
              class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors"
            >
              <ShoppingBag class="w-5 h-5" />
              My Orders
            </a>
  
            <a
              href="#"
              class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors"
            >
              <MapPin class="w-5 h-5" />
              Addresses
            </a>
  
            <a
              href="#"
              class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors"
            >
              <Heart class="w-5 h-5" />
              Wishlists
            </a>
  
            <a
              href="#"
              class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors"
            >
              <Lock class="w-5 h-5" />
              Security
            </a>
          </nav>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
import { computed } from "vue";
import { User, ShoppingBag, MapPin, Heart, Lock } from "lucide-vue-next";

const props = defineProps({
  customer: Object,
  isMobileMenuOpen: Boolean,
});

// Use props.customer directly
const initials = computed(() => {
  const firstInitial = props.customer?.first_name?.charAt(0) || "";
  const lastInitial = props.customer?.last_name?.charAt(0) || "";
  return `${firstInitial}${lastInitial}`.toUpperCase();
});
</script>