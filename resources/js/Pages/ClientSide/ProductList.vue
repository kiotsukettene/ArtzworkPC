<template>
  <div class="min-h-screen main">
    <NavLink :search-term="props.searchTerm" />

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-5xl font-bold text-gray-900 mb-10">Products</h1>
      <div class="flex flex-col md:flex-row gap-8">
        <!-- Filters Sidebar -->
        <div class="w-full md:w-64 shrink-0">
          <div class="bg-white rounded-lg shadow-lg p-6 sticky top-20">
            <h2 class="text-lg font-semibold mb-4">Filters</h2>

            <!-- Price Range -->
            <div class="mb-6">
              <h3 class="text-sm font-medium text-gray-700 mb-3">Price Range</h3>
              <div class="space-y-2">
                <div class="flex items-center justify-between">
                  <span class="text-sm text-gray-600">${{ form.priceRange[0] }}</span>
                  <span class="text-sm text-gray-600">${{ form.priceRange[1] }}</span>
                </div>
                <input
                  type="range"
                  v-model="form.priceRange[0]"
                  min="0"
                  max="10000"
                  class="w-full accent-blue-600"
                />
                <input
                  type="range"
                  v-model="form.priceRange[1]"
                  min="0"
                  max="100000"
                  class="w-full accent-blue-600"
                />
              </div>
            </div>

            <!-- Availability -->
            <div class="mb-6">
              <h3
                @click="toggleDropdown('availability')"
                class="text-sm font-medium text-gray-700 mb-3 cursor-pointer flex items-center"
              >
                Availability
                <span class="ml-2">
                  <ChevronUpIcon v-if="dropdowns.availability" class="h-4 w-4" />
                  <ChevronDownIcon v-else class="h-4 w-4" />
                </span>
              </h3>
              <div v-show="dropdowns.availability" class="space-y-2">
                <label class="flex items-center space-x-3 cursor-pointer">
                  <input
                    type="checkbox"
                    v-model="form.inStock"
                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                  />
                  <span class="text-sm text-gray-600">In Stock</span>
                </label>
              </div>
            </div>

            <!-- Brands -->
            <div class="mb-6">
              <h3
                @click="toggleDropdown('brands')"
                class="text-sm font-medium text-gray-700 mb-3 cursor-pointer flex items-center"
              >
                Brands
                <span class="ml-2">
                  <ChevronUpIcon v-if="dropdowns.brands" class="h-4 w-4" />
                  <ChevronDownIcon v-else class="h-4 w-4" />
                </span>
              </h3>
              <div v-show="dropdowns.brands" class="space-y-2">
                <label
                  v-for="brand in brands"
                  :key="brand.id"
                  class="flex items-center space-x-3 cursor-pointer"
                >
                  <input
                    type="checkbox"
                    v-model="form.brands"
                    :value="brand.id"
                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                  />
                  <span class="text-sm text-gray-600">{{ brand.name }}</span>
                  <span class="text-xs text-gray-400">({{ brand.products_count }})</span>
                </label>
              </div>
            </div>

            <!-- Categories -->
            <div class="mb-6">
              <h3
                @click="toggleDropdown('categories')"
                class="text-sm font-medium text-gray-700 mb-3 cursor-pointer flex items-center"
              >
                Categories
                <span class="ml-2">
                  <ChevronUpIcon v-if="dropdowns.categories" class="h-4 w-4" />
                  <ChevronDownIcon v-else class="h-4 w-4" />
                </span>
              </h3>
              <div v-show="dropdowns.categories" class="space-y-2">
                <label
                  v-for="category in categories"
                  :key="category.id"
                  class="flex items-center space-x-3 cursor-pointer"
                >
                  <input
                    type="checkbox"
                    v-model="form.categories"
                    :value="category.id"
                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                  />
                  <span class="text-sm text-gray-600">{{ category.name }}</span>
                  <span class="text-xs text-gray-400"
                    >({{ category.products_count }})</span
                  >
                </label>
              </div>
            </div>

            <!-- Clear Filters -->
            <button
              @click="clearFilters"
              class="w-full py-2 px-4 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy-500"
            >
              Clear Filters
            </button>
          </div>
        </div>

        <!-- Products Grid -->
        <div class="flex-1">
          <div
            v-if="props.products.data.length > 0"
            class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6"
          >
            <Link
              v-for="product in props.products.data"
              :key="product.id"
              :href="`/products/${product.id}`"
              class="group relative bg-white rounded-lg p-3 sm:p-4 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200 block hover:border-blue-500"
            >
              <!-- Brand Name -->
              <span
                class="text-end text-xs sm:text-sm font-semibold text-black uppercase mb-1 sm:mb-2 block"
              >
                {{ product.brand }}
              </span>

              <!-- Product Image -->
              <div
                class="flex justify-center items-center mb-2 sm:mb-4 aspect-w-1 aspect-h-1"
              >
                <img
                  :src="product.image"
                  :alt="product.name"
                  class="w-full h-32 sm:h-40 md:h-48 object-contain rounded-lg"
                />
              </div>

              <!-- Product Name -->
              <h3
                class="primary-text text-sm sm:text-base font-medium mb-1 sm:mb-2 truncate whitespace-nowrap overflow-hidden"
              >
                {{ product.name }}
              </h3>

              <div class="flex items-center justify-between">
                <!-- Product Details -->
                <div>
                  <div class="flex items-center mb-1">
                    <StarIcon
                      v-for="n in 5"
                      :key="n"
                      class="h-3 w-3 sm:h-4 sm:w-4"
                      :class="
                        n <= product.rating
                          ? 'text-yellow-400 fill-current'
                          : 'text-gray-400'
                      "
                    />
                    <span class="text-gray-400 text-xs sm:text-sm ml-1 sm:ml-2"
                      >({{ product.stock }})</span
                    >
                  </div>
                  <span class="primary-text font-bold text-base sm:text-lg"
                    >${{ product.price }}</span
                  >
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-1 sm:space-x-2 mt-1 sm:mt-2">
                  <button
                    @click.prevent="toggleWishlist(product.id)"
                    class="p-1.5 sm:p-1.5 primary-text main rounded-lg"
                  >
                    <HeartIcon class="h-4 w-4 sm:h-5 sm:w-5" />
                  </button>
                  <button
                    @click.prevent="addToCart(product.id)"
                    class="p-1.5 sm:p-1.5 text-white bg-navy-900 rounded-lg"
                  >
                    <ShoppingCartIcon class="h-4 w-4 sm:h-5 sm:w-5" />
                  </button>
                </div>
              </div>
            </Link>
          </div>

          <!-- No Products Found Message -->
          <div v-else class="min-h-[50vh] flex items-center justify-center">
            <div class="text-center max-w-md mx-auto p-6">
              <h3 class="text-xl font-medium text-gray-900 mb-3">
                No products found for search: "{{ $page.url.split("search=")[1] }}"
              </h3>
              <p class="text-gray-500">
                Try adjusting your search to find what you're looking for.
              </p>
            </div>
          </div>

          <!-- Pagination -->
          <div class="mt-8 flex justify-between items-center gap-2">
            <div class="flex items-left">
              <span class="text-sm text-gray-700"
                >Showing {{ products.from }} to {{ products.to }} of
                {{ products.total }} results</span
              >
            </div>
            <div class="flex gap-2">
              <Link
                v-for="link in props.products.links"
                :key="link.label"
                :href="link.url || '#'"
                class="px-3 py-1 rounded-md flex items-center justify-center text-sm font-medium transition-colors duration-150"
                :class="[
                  link.active
                    ? 'bg-navy-600 text-white'
                    : 'text-gray-700 hover:bg-gray-100',
                  !link.url && 'opacity-50 cursor-not-allowed',
                  link.label.includes('Previous') ? 'mr-2' : '',
                  link.label.includes('Next') ? 'ml-2' : '',
                ]"
              >
                <template v-if="link.label.includes('Previous')">
                  <ChevronLeftIcon class="h-5 w-5" />
                </template>
                <template v-else-if="link.label.includes('Next')">
                  <ChevronRightIcon class="h-5 w-5" />
                </template>
                <template v-else>
                  {{ link.label }}
                </template>
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import {
  HeartIcon,
  ShoppingCartIcon,
  StarIcon,
  ChevronDownIcon,
  ChevronUpIcon,
  ChevronLeftIcon,
  ChevronRightIcon,
} from "lucide-vue-next";
import NavLink from "../../Components/NavLink.vue";
import { usePage } from "@inertiajs/vue3";
import debounce from "lodash/debounce";

const props = defineProps({
  products: Object,
  categories: Array,
  brands: Array,
  searchTerm: String,
  filters: Object,
});
const page = usePage();
// State

// Filter state
const form = useForm({
  priceRange: props.filters?.priceRange || [0, 100000],
  inStock: props.filters?.inStock || false,
  brands: props.filters?.brands || [],
  categories: props.filters?.categories || [],
  search: props.searchTerm || "",
});

// Debounced filter function
const debouncedFilter = debounce(() => {
  if (!form.processing) {
    form.get(route("product.list"), {
      preserveState: true,
      preserveScroll: true,
    });
  }
}, 1000); // Increased to 1 second

// Watch specific form properties instead of the entire form
watch(
  [() => form.priceRange, () => form.inStock, () => form.brands, () => form.categories],
  () => {
    debouncedFilter();
  },
  { deep: true }
);

// Dropdown state
const dropdowns = ref({
  availability: true,
  brands: true,
  categories: true,
});

// Methods
const clearFilters = () => {
  form.priceRange = [0, 100000];
  form.inStock = false;
  form.brands = [];
  form.categories = [];
  form.get(route("product.list"), {
    preserveState: true,
    preserveScroll: true,
  });
};

const toggleDropdown = (dropdown) => {
  dropdowns.value[dropdown] = !dropdowns.value[dropdown];
};
</script>

<style scoped>
@keyframes border-flow {
  0% {
    clip-path: inset(0 0 95% 0);
  }
  25% {
    clip-path: inset(0 0 0 95%);
  }
  50% {
    clip-path: inset(95% 0 0 0);
  }
  75% {
    clip-path: inset(0 95% 0 0);
  }
  100% {
    clip-path: inset(0 0 95% 0);
  }
}

.animate-border-flow {
  content: "";
  position: absolute;
  inset: 0;
  border: 2px solid;
  border-image: linear-gradient(
      45deg,
      theme("colors.blue.600"),
      theme("colors.blue.400"),
      theme("colors.blue.600")
    )
    1;
  animation: border-flow 2s linear infinite;
}
</style>
