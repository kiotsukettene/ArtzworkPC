<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Mobile Sidebar Toggle -->
    <button
      @click="isSidebarOpen = !isSidebarOpen"
      class="lg:hidden fixed top-4 left-4 z-50 p-2 rounded-md bg-white shadow-md"
    >
      <MenuIcon v-if="!isSidebarOpen" class="h-6 w-6" />
      <XIcon v-else class="h-6 w-6" />
    </button>

    <!-- Sidebar -->
    <aside
      class="fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0"
      :class="{ 'translate-x-0': isSidebarOpen, '-translate-x-full': !isSidebarOpen }"
    >
      <div class="h-full flex flex-col">
        <div class="p-4 border-b">
          <h1 class="text-xl font-bold">ArtzworkPC</h1>
        </div>

        <nav class="flex-1 p-4 space-y-2">
          <Link
            v-for="item in menuItems"
            :key="item.name"
            :href="item.href"
            :class="[
              'flex items-center px-4 py-2 rounded-md',
              item.current
                ? 'bg-gray-100 text-gray-900'
                : 'text-gray-600 hover:bg-gray-100',
            ]"
          >
            <component :is="item.icon" class="h-5 w-5 mr-3" />
            {{ item.name }}
          </Link>
        </nav>

        <div class="p-4 border-t">
          <button
            @click="logout"
            class="flex items-center w-full px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-md"
          >
            <LogOutIcon class="h-5 w-5 mr-3" />
            Logout
          </button>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-64 min-h-screen">
      <!-- Header -->
      <header class="bg-white shadow-sm">
        <div
          class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center"
        >
          <h1 class="text-2xl font-semibold text-gray-900">Edit Category</h1>
          <div class="flex items-center gap-4">
            <div class="relative">
              <input
                type="text"
                placeholder="Search"
                class="w-full sm:w-64 pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
              <SearchIcon class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" />
            </div>
            <img
              src=""
              class="h-10 w-10 rounded-full cursor-pointer"
              @click="isProfileOpen = !isProfileOpen"
            />
          </div>
        </div>
      </header>

      <!-- Create Category Form -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow">
          <div class="p-6">
            <form @submit.prevent="updateForm">
              <!-- Name Input -->
              <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                  Name
                </label>
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <small class="text-red-700">{{ form.errors.name }}</small>
              </div>

              <!-- Slug Input -->
              <div class="mb-6">
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                  Slug
                </label>
                <input
                  id="slug"
                  v-model="form.slug"
                  type="text"
                  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                  disabled
                />
                <small class="text-red-700">{{ form.errors.slug }}</small>
              </div>

              <!-- SKU Input -->
              <div class="mb-6">
                <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">
                  SKU
                </label>
                <input
                  id="sku"
                  v-model="form.sku"
                  type="text"
                  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                  disabled
                />
                <small class="text-red-700">{{ form.errors.sku }}</small>
              </div>

              <!-- Image Upload -->
              <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Image
                </label>
                <div
                  class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg"
                  @dragover.prevent
                  @drop="handleDrop"
                >
                  <div class="space-y-1 text-center">
                    <!-- Preview Section -->
                    <div v-if="imagePreview" class="mb-4">
                      <img
                        :src="imagePreview"
                        alt="Preview"
                        class="mx-auto h-32 w-auto"
                      />
                    </div>

                    <!-- Upload Instructions -->
                    <div v-else class="flex text-sm text-gray-600">
                      <label
                        for="file-upload"
                        class="relative cursor-pointer rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500"
                      >
                        <span>Upload a file</span>
                        <input
                          id="file-upload"
                          type="file"
                          class="sr-only"
                          accept="image/*"
                          @change="handleFileUpload"
                        />
                        <small class="text-red-700">{{ form.errors.image }}</small>
                      </label>
                      <p class="pl-1">or drag and drop</p>
                    </div>

                    <!-- File Format Info -->
                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                  </div>
                </div>
              </div>

              <!-- Form Actions -->
              <div class="flex justify-end space-x-4">
                <Link
                  href="/categories"
                  class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-50"
                >
                  Cancel
                </Link>
                <button
                  type="submit"
                  class="px-4 py-2 bg-navy-600 text-white rounded-md hover:bg-navy-700"
                  :disabled="form.processing"
                >
                  <span v-if="form.processing">Updating...</span>
                  <span v-else>Update</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import { Link } from "@inertiajs/vue3";
import {
  HomeIcon,
  TagIcon,
  ShoppingBagIcon,
  UsersIcon,
  ClipboardListIcon,
  LogOutIcon,
  MenuIcon,
  XIcon,
  SearchIcon,
} from "lucide-vue-next";

// State
const isSidebarOpen = ref(false);
const isProfileOpen = ref(false);
const imagePreview = ref(null);

defineProps({
  category: {
    type: Object,
    required: true,
  },
});

const form = useForm({
  name: category.name || "", // Use optional chaining to avoid errors
  slug: category.slug || "",
  sku: category.sku || "",
  image: category.image
    ? "/storage" + category.image
    : "storage/categoryImages/default.jpg",
});

const updateForm = () => {
  form.put(route("categories.update", category.id), {
    preserveScroll: true,
    onSuccess: () => {
      alert("Category updated successfully!");
    },
  });
};

watch(
  () => form.name,
  (newName) => {
    form.slug = newName.toLowerCase().trim().replace(/\s+/g, "-");
    form.sku = newName
      .toUpperCase()
      .replace(/[AEIOU\s]/g, "")
      .slice(0, 3);
  }
);

const menuItems = [
  { name: "Dashboard", icon: HomeIcon, href: "/dashboard" },
  { name: "Category", icon: TagIcon, href: "categories", current: true },
  { name: "Brands", icon: ShoppingBagIcon, href: "/brands" },
  { name: "Products", icon: ClipboardListIcon, href: "/products" },
  { name: "Transactions", icon: ClipboardListIcon, href: "/transactions" },
  { name: "Order History", icon: ClipboardListIcon, href: "/order-history" },
  { name: "Return / Refund", icon: ClipboardListIcon, href: "/return-refund" },
  { name: "Customers", icon: UsersIcon, href: "/customers" },
  { name: "Employees", icon: UsersIcon, href: "/employees" },
];

// Methods
// Handle File Upload via Input
const handleFileUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    form.image = file; // Append file to the form object
    createImagePreview(file);
  }
};

// Handle File Upload via Drag-and-Drop
const handleDrop = (event) => {
  event.preventDefault(); // Prevent default drag behaviors
  const file = event.dataTransfer.files[0];
  if (file) {
    form.image = file; // Append file to the form object
    createImagePreview(file);
  }
};

// Create Image Preview
const createImagePreview = (file) => {
  const reader = new FileReader();
  reader.onload = (e) => {
    imagePreview.value = e.target.result; // Update preview with base64
  };
  reader.readAsDataURL(file);
};

const logout = () => {
  // Implement logout logic
};
</script>

<style scoped>
.bg-navy-600 {
  background-color: #1a237e;
}

.bg-navy-700 {
  background-color: #151c63;
}

.hover\:bg-navy-700:hover {
  background-color: #151c63;
}
</style>
