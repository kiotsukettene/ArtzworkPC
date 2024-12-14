<template>
    <div class="min-h-screen bg-gray-50">
      <NavLink />
  
      <!-- Main Content -->
      <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Compare Products</h1>
  
        <!-- Filter Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              Category
            </label>
            <select 
              v-model="selectedCategory"
              class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500"
            >
              <option value="">Select a category</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">
                {{ category.name }}
              </option>
            </select>
          </div>
  
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              Brand
            </label>
            <select 
              v-model="selectedBrand"
              class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500"
            >
              <option value="">Select brand</option>
              <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                {{ brand.name }}
              </option>
            </select>
          </div>
        </div>
  
        <!-- Product Selection -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
          <!-- Product 1 -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              Product 1
            </label>
            <select 
              v-model="selectedProduct1"
              class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500 mb-4"
            >
              <option value="">Select a product</option>
              <option v-for="product in products" :key="product.id" :value="product">
                {{ product.name }}
              </option>
            </select>
  
            <div v-if="selectedProduct1" class="bg-white rounded-lg shadow-sm overflow-hidden">
              <div class="relative">
                <img 
                  :src="selectedProduct1.image" 
                  :alt="selectedProduct1.name"
                  class="w-full h-64 object-contain p-4"
                />
                <button 
                  @click="selectedProduct1 = null"
                  class="absolute top-2 right-2 p-1 bg-gray-100 rounded-full hover:bg-gray-200"
                >
                  <XIcon class="h-4 w-4 text-gray-600" />
                </button>
              </div>
              <div class="p-4 border-t">
                <h3 class="font-medium text-gray-900">{{ selectedProduct1.name }}</h3>
                <p class="text-lg font-bold text-navy-600 mt-1">₱{{ formatPrice(selectedProduct1.price) }}</p>
                <button 
                  @click="addToCart(selectedProduct1)"
                  class="w-full mt-4 bg-navy-900 text-white py-2 rounded-lg hover:bg-navy-800"
                >
                  Add to Cart
                </button>
              </div>
            </div>
          </div>
  
          <!-- Product 2 -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              Product 2
            </label>
            <select 
              v-model="selectedProduct2"
              class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500 mb-4"
            >
              <option value="">Select a product</option>
              <option v-for="product in products" :key="product.id" :value="product">
                {{ product.name }}
              </option>
            </select>
  
            <div v-if="selectedProduct2" class="bg-white rounded-lg shadow-sm overflow-hidden">
              <div class="relative">
                <img 
                  :src="selectedProduct2.image" 
                  :alt="selectedProduct2.name"
                  class="w-full h-64 object-contain p-4"
                />
                <button 
                  @click="selectedProduct2 = null"
                  class="absolute top-2 right-2 p-1 bg-gray-100 rounded-full hover:bg-gray-200"
                >
                  <XIcon class="h-4 w-4 text-gray-600" />
                </button>
              </div>
              <div class="p-4 border-t">
                <h3 class="font-medium text-gray-900">{{ selectedProduct2.name }}</h3>
                <p class="text-lg font-bold text-navy-600 mt-1">₱{{ formatPrice(selectedProduct2.price) }}</p>
                <button 
                  @click="addToCart(selectedProduct2)"
                  class="w-full mt-4 bg-navy-900 text-white py-2 rounded-lg hover:bg-navy-800"
                >
                  Add to Cart
                </button>
              </div>
            </div>
          </div>
        </div>
  
        <!-- Specifications Comparison -->
        <div v-if="selectedProduct1 && selectedProduct2" class="bg-white rounded-lg shadow-sm overflow-hidden">
          <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Specifications</h2>
            
            <div class="space-y-4">
              <div v-for="(spec, key) in specifications" :key="key" class="grid grid-cols-3 gap-4 py-3 border-b">
                <div class="font-medium text-gray-700">{{ spec.label }}</div>
                <div class="text-gray-900">{{ selectedProduct1.specifications[key] }}</div>
                <div class="text-gray-900">{{ selectedProduct2.specifications[key] }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed, watch } from 'vue'
  import { Link, usePage } from '@inertiajs/vue3'
  import {
    ShoppingCartIcon,
    UserIcon,
    XIcon
  } from 'lucide-vue-next'
import NavLink from '../../Components/NavLink.vue';
  
  // Navigation

  const props = defineProps({
    categories: {
      type: Object,
      required: true,
    },
    brands: {
        type: Object,
        required: true,
    },
    products: {
        type: Object,
        required: true,
    },
  });

  const selectedCategory = ref('')
  const selectedBrand = ref('')
  const selectedProduct1 = ref(null)
  const selectedProduct2 = ref(null)
  
  // Computed
  const filteredProducts = computed(() => {
    return props.products.filter(product => {
      if (selectedCategory.value && product.categoryId !== parseInt(selectedCategory.value)) return false
      if (selectedBrand.value && product.brandId !== parseInt(selectedBrand.value)) return false
      return true
    })
  })
  
  // Methods
  const formatPrice = (price) => {
    return price.toLocaleString('en-PH', { minimumFractionDigits: 2 })
  }
  
  const addToCart = (product) => {
    // Implement add to cart logic
    console.log('Adding to cart:', product)
  }
  </script>
  
  <style scoped>
  .bg-navy-800 {
    background-color: #0d1147;
  }
  
  .bg-navy-900 {
    background-color: #070b2e;
  }
  
  .text-navy-600 {
    color: #1a237e;
  }
  
  .hover\:bg-navy-800:hover {
    background-color: #0d1147;
  }
  
  .focus\:ring-navy-500:focus {
    --tw-ring-color: #1e2b8f;
  }
  </style>