<template>
  <Head title="Profile" />
  <NavLink />
  <div class="container mx-auto px-4 sm:px-6 py-6">
    <!-- Mobile Menu Button -->
    <div class="lg:hidden mb-4">
      <button
        @click="toggleMobileMenu"
        class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors"
      >
        <Menu v-if="!isMobileMenuOpen" class="w-6 h-6" />
        <X v-else class="w-6 h-6" />
      </button>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
      <!-- Sidebar -->
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
                href="#"
                class="flex items-center gap-3 px-4 py-3 text-blue-600 bg-blue-50 rounded-lg font-medium"
              >
                <User class="w-5 h-5" />
                Account Profile
              </a>

              <a
                href="#"
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

      <!-- Main Content -->
      <div class="flex-1">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Profile Information</h2>
            <Link
              :href="route('customer.profile')"
              class="text-green-600 hover:text-green-700 transition-colors"
            >
              <Pencil class="w-5 h-5" />
            </Link>
          </div>

          <!-- Form -->
          <form @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">First Name</label>
              <input
                type="text"
                v-model="customer.first_name"
                class="w-full p-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                disabled
              />
            </div>

            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Last Name</label>
              <input
                type="text"
                v-model="customer.last_name"
                class="w-full p-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                disabled
              />
            </div>

            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Username</label>
              <input
                type="text"
                v-model="customer.username"
                class="w-full p-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                disabled
              />
            </div>

            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Birthday</label>
              <input
                type="date"
                v-model="customer.birthday"
                class="w-full p-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                disabled
              />
            </div>

            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Email Address</label>
              <input
                type="email"
                v-model="customer.email"
                class="w-full p-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                disabled
              />
            </div>

            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Phone Number</label>
              <input
                type="text"
                v-model="customer.phone"
                class="w-full p-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                disabled
              />
            </div>

            <div class="md:col-span-2 space-y-2">
              <label class="block text-sm font-medium text-gray-700"
                >Default Address</label
              >
              <textarea
                rows="3"
                class="w-full p-2.5 border border-gray-200 rounded-lg focus:ring-2 text-black focus:ring-blue-500 focus:border-blue-500"
                disabled
                >{{ defaultAddress?.province || "" }} {{ defaultAddress?.city || "" }} {{
                  defaultAddress?.zip_code || ""
                }} {{ defaultAddress?.complete_address || "" }}
              </textarea>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { computed, ref } from "vue";
import { Head } from "@inertiajs/vue3";
import {
  User,
  ShoppingBag,
  MapPin,
  Heart,
  Lock,
  Check,
  Menu,
  X,
  Pencil,
} from "lucide-vue-next";
import NavLink from "@/Components/NavLink.vue";
const props = defineProps({
  customer: Object,
  addresses: Array,
  defaultAddress: Object,
});

const isMobileMenuOpen = ref(false);

const initials = computed(() => {
  const firstInitial = props.customer.first_name
    ? props.customer.first_name.charAt(0)
    : "";
  const lastInitial = props.customer.last_name ? props.customer.last_name.charAt(0) : "";
  return `${firstInitial}${lastInitial}`.toUpperCase();
});

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};
</script>
