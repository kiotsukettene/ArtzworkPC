<template>
    <div class="min-h-screen bg-gray-50">
      <!-- Mobile Sidebar Toggle -->
      <Sidebar></Sidebar>

      <!-- Main Content -->
      <main class="lg:ml-64 min-h-screen">
        <!-- Header -->
        <Header title="Create Products"></Header>

        <!-- Create Product Form -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <form @submit.prevent="submitForm" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form Content -->
            <div class="lg:col-span-2 space-y-6">
              <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-medium mb-4">Product Information</h2>

                <!-- Product Name -->
                <div class="mb-4">
                  <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                  <input
                    v-model="form.name"
                    type="text"
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  >
                </div>

                <!-- Slug and SKU -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                    <input
                      v-model="form.slug"
                      type="text"
                      class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                    <input
                      v-model="form.sku"
                      type="text"
                      class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                  </div>
                </div>

                <!-- Description -->
                <div class="mb-4">
                  <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                  <textarea
                    v-model="form.description"
                    rows="4"
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  ></textarea>
                </div>

             </div>   <!-- Image Upload -->
<div>
  <label class="block text-sm font-medium text-gray-700 mb-1">Images</label>
  <div
    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
    @dragover.prevent
    @drop.prevent="handleDrop"
  >
    <div class="space-y-1 text-center">
      <!-- Image Previews -->
      <div v-if="imagePreviews.length" class="mb-4 flex flex-wrap gap-4 justify-center">
        <div v-for="(preview, index) in imagePreviews" :key="index" class="relative">
          <img :src="preview" alt="Preview" class="h-32 w-auto">
          <button
            @click="removeImage(index)"
            type="button"
            class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1"
          >
            ✕
          </button>
        </div>
      </div>
      <div v-else class="flex text-sm text-gray-600">
        <label
          for="file-upload"
          class="relative cursor-pointer rounded-md font-medium text-blue-600 hover:text-blue-500"
        >
          <span>Upload files</span>
          <input
            id="file-upload"
            type="file"
            multiple
            class="sr-only"
            @change="handleFileUpload"
          >
        </label>
        <p class="pl-1">or drag and drop</p>
      </div>
      <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB each</p>
    </div>
  </div>
</div>

              <!-- Specifications -->
              <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-medium mb-4">Specifications</h2>

                <div class="space-y-4">
                  <div v-for="field in currentSpecificationFields" :key="field.key">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ field.label }}</label>
                    <input
                      v-model="form.specifications[field.key]"
                      type="text"
                      :placeholder="field.placeholder"
                      class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                  </div>
                </div>
              </div>
            </div>

            <!-- Side Panel -->
            <div class="space-y-6">
              <!-- Price Section -->
              <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-medium mb-4">Price</h2>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                  <input
                    v-model="form.price"
                    type="number"
                    placeholder="Enter price"
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  >
                </div>
              </div>

              <!-- Stock Section -->
              <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-medium mb-4">Stock</h2>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                  <input
                    v-model="form.stock"
                    type="number"
                    placeholder="Enter Stock"
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  >
                </div>
              </div>

              <!-- Associations -->
              <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-medium mb-4">Associations</h2>
                <div class="space-y-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select
                      v-model="form.category"
                      @change="handleCategoryChange"
                      class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                      <option value="">Select Category</option>
                      <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                      </option>
                    </select>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                    <select
                      v-model="form.brand"
                      class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                      <option value="">Select</option>
                    </select>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Warranty</label>
                    <select
                      v-model="form.warranty"
                      class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                      <option value="">Select</option>
                    </select>
                  </div>
                </div>
              </div>

              <!-- Form Actions -->
              <div class="flex justify-end space-x-4">
                <Link
                  href="/products"
                  class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-50"
                >
                  Cancel
                </Link>
                <button
                  type="submit"
                  class="px-4 py-2 bg-navy-600 text-white rounded-md hover:bg-navy-700"
                >
                  Create
                </button>
              </div>
            </div>
          </form>
        </div>
      </main>
    </div>
  </template>

  <script setup>
  import { ref, computed } from 'vue'
  import { Link } from '@inertiajs/vue3'
  import {
    HomeIcon,
    TagIcon,
    ShoppingBagIcon,
    UsersIcon,
    ClipboardListIcon,
    MenuIcon,
    XIcon,
  } from 'lucide-vue-next'
import Sidebar from '../../../Components/Sidebar.vue';
import Header from '../../../Components/Header.vue';
  // State

  const imagePreview = ref(null)

  // Categories data
  const categories = [
    { id: 'laptop', name: 'Laptop' },
    { id: 'desktop', name: 'Desktop' },
    { id: 'memory', name: 'Memory' },
    { id: 'storage', name: 'Storage' },
    { id: 'monitor', name: 'Monitor' },
  ]

  // Specification fields by category
  const specificationFieldsByCategory = {
    laptop: [
      { key: 'cpu', label: 'CPU', placeholder: 'Intel Core i5-12400, AMD Ryzen 5 5600X' },
      { key: 'ram', label: 'RAM', placeholder: '16GB DDR4 (2x8GB)' },
      { key: 'storage', label: 'Storage', placeholder: '1TB NVMe SSD' },
      { key: 'gpu', label: 'GPU', placeholder: 'NVIDIA RTX 3060, AMD RX 6600' },
      { key: 'operatingSystem', label: 'Operating System', placeholder: 'Windows 11 Pro' },
      { key: 'motherboard', label: 'Motherboard', placeholder: 'MSI B550-A PRO' },
      { key: 'weight', label: 'Weight', placeholder: '2 grams to kg' },
      { key: 'batteryLife', label: 'Battery Life', placeholder: 'Battery capacity mAH' },
      { key: 'display', label: 'Display', placeholder: 'Screen size, resolution, refresh rate (IPS, OLED)' },
    ],
    desktop: [
      { key: 'cpu', label: 'CPU', placeholder: 'Intel Core i5-12400, AMD Ryzen 5 5600X' },
      { key: 'ram', label: 'RAM', placeholder: '16GB DDR4 (2x8GB)' },
      { key: 'storage', label: 'Storage', placeholder: '1TB NVMe SSD' },
      { key: 'gpu', label: 'GPU', placeholder: 'NVIDIA RTX 3060, AMD RX 6600' },
      { key: 'operatingSystem', label: 'Operating System', placeholder: 'Windows 11 Pro' },
      { key: 'motherboard', label: 'Motherboard', placeholder: 'MSI B550-A PRO' },
      { key: 'powerSupply', label: 'Power Supply Unit', placeholder: '650W 80+ Gold PSU' },
      { key: 'coolingSystem', label: 'Cooling System', placeholder: 'Air cooling, 240mm AIO' },
    ],
    memory: [
      { key: 'type', label: 'Type', placeholder: 'DDR4, DDR5' },
      { key: 'capacity', label: 'Capacity', placeholder: '16GB, 32GB' },
      { key: 'speed', label: 'Speed', placeholder: '3200MHz, 3600MHz' },
      { key: 'formFactor', label: 'Form Factor', placeholder: 'DIMM, SO-DIMM' },
      { key: 'rgbLighting', label: 'RGB Lighting', placeholder: 'Yes/No' },
    ],
    storage: [
      { key: 'type', label: 'Type', placeholder: 'SSD, HDD, NVMe' },
      { key: 'capacity', label: 'Capacity', placeholder: '500GB, 1TB, 2TB' },
      { key: 'interface', label: 'Interface', placeholder: 'SATA III, PCIe 4.0' },
      { key: 'formFactor', label: 'Form Factor', placeholder: '2.5", M.2' },
      { key: 'readSpeed', label: 'Read Speed', placeholder: '3500MB/s' },
      { key: 'writeSpeed', label: 'Write Speed', placeholder: '3000MB/s' },
    ],
    monitor: [
      { key: 'size', label: 'Size', placeholder: '24", 27", 32"' },
      { key: 'resolution', label: 'Resolution', placeholder: '1920x1080, 2560x1440, 3840x2160' },
      { key: 'refreshRate', label: 'Refresh Rate', placeholder: '60Hz, 144Hz, 240Hz' },
      { key: 'panelType', label: 'Panel Type', placeholder: 'IPS, VA, TN' },
      { key: 'responseTime', label: 'Response Time', placeholder: '1ms, 4ms' },
      { key: 'hdrSupport', label: 'HDR Support', placeholder: 'HDR400, HDR600, HDR1000' },
    ]
  }

  const form = ref({
    name: '',
    slug: '',
    sku: '',
    description: '',
    images: [],
    price: '',
    stock: '',
    category: '',
    brand: '',
    warranty: '',
    specifications: {}
  })

  // Computed property for current specification fields based on selected category
  const currentSpecificationFields = computed(() => {
    return specificationFieldsByCategory[form.value.category] || []
  })

  // Menu Items


  // Methods
  const imagePreviews = ref([]); // Array to store image previews

// Handle file upload
const handleFileUpload = (event) => {
  const files = Array.from(event.target.files); // Convert FileList to Array
  addFiles(files);
};

// Handle drag-and-drop
const handleDrop = (event) => {
  const files = Array.from(event.dataTransfer.files);
  addFiles(files);
};

// Add files to the form
const addFiles = (files) => {
  files.forEach((file) => {
    if (file.type.startsWith('image/') && file.size <= 10 * 1024 * 1024) { // Validate file type and size
      form.value.images.push(file);
      createImagePreview(file);
    }
  });
};

// Create image previews
const createImagePreview = (file) => {
  const reader = new FileReader();
  reader.onload = (e) => {
    imagePreviews.value.push(e.target.result);
  };
  reader.readAsDataURL(file);
};

// Remove an image
const removeImage = (index) => {
  form.value.images.splice(index, 1); // Remove file from form data
  imagePreviews.value.splice(index, 1); // Remove preview
};

const submitForm = () => {
  // Handle form submission logic
  console.log('Form submitted:', form.value);
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
