<template>
  <header class="bg-white shadow-sm">
    <div
      class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center"
    >
      <!-- Dynamic Title -->
      <h1 class="text-2xl font-semibold text-gray-900">{{ title }}</h1>

      <div class="flex items-center gap-4">
        <!-- Search Input (Optional) -->
        <div v-if="showSearch" class="relative">
          <input
            type="text"
            placeholder="Search"
            class="w-full sm:w-64 pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            v-model="searchQuery"
          />
          <SearchIcon class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" />
        </div>

        <!-- Additional Actions Slot -->
        <slot name="actions"></slot>

        <!-- Profile Section -->
        <div class="relative">
          <img
            :src="profileImage"
            alt="User Profile"
            class="h-10 w-10 rounded-full cursor-pointer"
            @click="toggleProfile"
          />
          <div
            v-if="isProfileOpen"
            class="absolute right-0 mt-2 w-45 bg-white border rounded-lg shadow-lg z-50"
          >
            <slot name="profile-menu">
              <Link
                href="/logout"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
              >
                Logout
              </Link>
            </slot>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref } from "vue";
import { SearchIcon } from "lucide-vue-next";

// Props for dynamic content
defineProps({
  title: {
    type: String,
    required: true,
    default: "Dashboard",
  },
  showSearch: {
    type: Boolean,
    default: true,
  },
  profileImage: {
    type: String,
    required: false,
    default: "", // Provide a default profile image if necessary
  },
});

// State for search query and profile menu
const searchQuery = ref("");
const isProfileOpen = ref(false);

// Methods
const toggleProfile = () => {
  isProfileOpen.value = !isProfileOpen.value;
};
</script>
