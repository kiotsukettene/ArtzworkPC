<template>
  <div class="min-h-screen bg-gray-50">
    <NavLink />

    <!-- Add the Carousel Here -->
    <div class="relative bg-gray-900">
      <div class="container mx-auto px-4 py-8">
        <!-- Carousel Container -->
        <div class="relative bg-[#1C1C1C] rounded-xl overflow-hidden">
          <!-- Slides -->
          <div class="overflow-hidden relative">
            <div
              class="flex transition-transform duration-500 ease-out"
              :style="{ transform: `translateX(-${currentSlide * 100}%)` }"
            >
              <div
                v-for="(slide, index) in slides"
                :key="index"
                class="w-full flex-shrink-0"
              >
                <div class="flex flex-col md:flex-row items-center justify-between p-8">
                  <div class="text-center md:text-left mb-8 md:mb-0 md:w-1/2">
                    <div
                      class="inline-block bg-red-600 text-white text-sm px-3 py-1 rounded-full mb-4"
                    >
                      15% OFF
                    </div>
                    <h1
                      class="text-2xl md:text-4xl font-bold mb-4 leading-tight text-[#FFD700]"
                    >
                      {{ slide.title }}
                    </h1>
                    <p class="text-gray-300 mb-6">{{ slide.description }}</p>
                    <button
                      class="bg-[#FFD700] text-gray-900 px-8 py-3 rounded-full font-semibold hover:bg-[#F0C800] transition-colors"
                    >
                      BUILD NOW!
                    </button>
                  </div>
                  <div class="md:w-1/2">
                    <img
                      :src="slide.image"
                      :alt="slide.title"
                      class="w-full max-w-lg mx-auto transform hover:scale-105 transition-transform duration-300"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Dots Navigation -->
          <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
            <button
              v-for="(_, index) in slides"
              :key="index"
              @click="currentSlide = index"
              class="w-2 h-2 rounded-full transition-colors"
              :class="
                currentSlide === index ? 'bg-[#FFD700]' : 'bg-white/50 hover:bg-white/75'
              "
            ></button>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
      <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <!-- Search -->
        <div class="w-full md:w-auto mb-4 md:mb-0">
          <div class="relative">
            <input
              type="text"
              v-model="search"
              placeholder="Search for processor..."
              class="w-full md:w-80 pl-10 pr-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500 bg-white shadow-sm"
            />
            <SearchIcon class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" />
          </div>
        </div>

        <!-- Sort -->
        <div class="w-full md:w-auto">
          <select
            v-model="sortBy"
            class="w-full md:w-48 pl-4 pr-8 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500 bg-white shadow-sm appearance-none cursor-pointer"
          >
            <option value="price-asc">Price: Low to High</option>
            <option value="price-desc">Price: High to Low</option>
            <option value="name">Name</option>
          </select>
        </div>
      </div>

      <!-- Processor Grid -->
      <div
        class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 sm:gap-2"
      >
        <div
          v-for="processor in filteredProcessors"
          :key="processor.id"
          class="group relative bg-white rounded-lg p-2 sm:p-3 hover:shadow-lg transition-all duration-300 border border-gray-200 block hover:border-blue-500"
        >
          <!-- Brand Name -->
          <span
            class="text-end text-xs sm:text-sm font-semibold text-black uppercase mb-1 sm:mb-2 block"
          >
            {{ processor.brand }}
          </span>

          <!-- Product Image -->
          <div
            class="flex justify-center items-center mb-2 sm:mb-3 aspect-w-1 aspect-h-1"
          >
            <img
              :src="processor.image"
              :alt="processor.name"
              class="w-full h-28 sm:h-32 md:h-36 lg:h-40 object-contain rounded-lg"
            />
          </div>

          <!-- Product Name -->
          <h3
            class="primary-text text-sm sm:text-base font-medium mb-1 sm:mb-2 truncate whitespace-nowrap overflow-hidden"
          >
            {{ processor.name }}
          </h3>

          <div class="flex items-center justify-between">
            <!-- Product Details -->
            <div>
              <div class="flex items-center mb-1">
                <div class="flex items-center space-x-2 text-xs text-gray-600">
                  <span>{{ processor.cores }} Cores</span>
                  <span>•</span>
                  <span>{{ processor.threads }} Threads</span>
                </div>
              </div>
              <span class="primary-text font-bold text-sm sm:text-base lg:text-lg">
                ₱{{ formatPrice(processor.price) }}
              </span>
            </div>

            <!-- Select Button -->
            <div class="flex space-x-1 sm:space-x-2 mt-1 sm:mt-2">
              <button
                @click="selectProcessor(processor)"
                class="px-3 py-1.5 text-white bg-navy-900 rounded-lg text-sm font-medium hover:bg-navy-800 transition-colors"
              >
                Select
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import { Link } from "@inertiajs/vue3";
import { MenuIcon, XIcon, SearchIcon, ShoppingCartIcon, UserIcon } from "lucide-vue-next";
import NavLink from "../../Components/NavLink.vue";

// Navigation
const navigation = [
  { name: "Home", href: "/" },
  { name: "Products", href: "/products" },
  { name: "PC Builder", href: "/pc-builder" },
  { name: "Laptops", href: "/laptops" },
  { name: "Desktops", href: "/desktops" },
];

// Mobile menu state
const isMobileMenuOpen = ref(false);

// Search and sort
const search = ref("");
const sortBy = ref("price-asc");

// Processors data
const processors = [
  {
    id: 1,
    name: "Ryzen 7 5800X",
    price: 14995.0,
    cores: 8,
    threads: 16,
    baseClock: "3.8 GHz",
    boostClock: "4.7 GHz",
    image: "/placeholder.svg?height=200&width=200&text=AMD",
  },
  {
    id: 2,
    name: "Intel Core i5-11th Gen",
    price: 14995.0,
    cores: 6,
    threads: 12,
    baseClock: "3.3 GHz",
    boostClock: "4.6 GHz",
    image: "/placeholder.svg?height=200&width=200&text=Intel",
  },
  {
    id: 3,
    name: "Intel Core i7-11th Gen",
    price: 16995.0,
    cores: 8,
    threads: 16,
    baseClock: "3.6 GHz",
    boostClock: "5.0 GHz",
    image: "/placeholder.svg?height=200&width=200&text=Intel",
  },
  {
    id: 4,
    name: "Ryzen 5 5600X",
    price: 14995.0,
    cores: 6,
    threads: 12,
    baseClock: "3.7 GHz",
    boostClock: "4.6 GHz",
    image: "/placeholder.svg?height=200&width=200&text=AMD",
  },
  {
    id: 5,
    name: "Ryzen 9 5900X",
    price: 16995.0,
    cores: 12,
    threads: 24,
    baseClock: "3.7 GHz",
    boostClock: "4.8 GHz",
    image: "/placeholder.svg?height=200&width=200&text=AMD",
  },
  {
    id: 6,
    name: "Ryzen 7 7700X",
    price: 14995.0,
    cores: 8,
    threads: 16,
    baseClock: "4.5 GHz",
    boostClock: "5.4 GHz",
    image: "/placeholder.svg?height=200&width=200&text=AMD",
  },
  {
    id: 7,
    name: "Ryzen 7 5700X",
    price: 14995.0,
    cores: 8,
    threads: 16,
    baseClock: "3.4 GHz",
    boostClock: "4.6 GHz",
    image: "/placeholder.svg?height=200&width=200&text=AMD",
  },
  {
    id: 8,
    name: "Ryzen 9 5950X",
    price: 16995.0,
    cores: 16,
    threads: 32,
    baseClock: "3.4 GHz",
    boostClock: "4.9 GHz",
    image: "/placeholder.svg?height=200&width=200&text=AMD",
  },
];

// Computed
const filteredProcessors = computed(() => {
  let result = [...processors];

  // Apply search filter
  if (search.value) {
    const searchLower = search.value.toLowerCase();
    result = result.filter((processor) =>
      processor.name.toLowerCase().includes(searchLower)
    );
  }

  // Apply sorting
  result.sort((a, b) => {
    switch (sortBy.value) {
      case "price-asc":
        return a.price - b.price;
      case "price-desc":
        return b.price - a.price;
      case "name":
        return a.name.localeCompare(b.name);
      default:
        return 0;
    }
  });

  return result;
});

// Methods
const formatPrice = (price) => {
  return price.toLocaleString("en-PH");
};

const selectProcessor = (processor) => {
  // Implement processor selection logic
  console.log("Selected processor:", processor);
};

// Add carousel data and functions
const slides = [
  {
    title: "10.10 BIG SALE GET 15% OFF",
    description: "Build your dream gaming PC with our exclusive deals and discounts!",
    image: "ClientSide/assets/ads1.png",
  },
  {
    title: "MEGA PC DEALS",
    description: "Premium components at unbeatable prices",
    image: "ClientSide/assets/ads2.png",
  },
  {
    title: "LIMITED TIME OFFER",
    description: "Don't miss out on our biggest sale of the year",
    image: "ClientSide/assets/ads3.png",
  },
];

const currentSlide = ref(0);
let autoplayInterval;

const nextSlide = () => {
  currentSlide.value = (currentSlide.value + 1) % slides.length;
};

const startAutoplay = () => {
  autoplayInterval = setInterval(() => {
    nextSlide();
  }, 5000);
};

const stopAutoplay = () => {
  if (autoplayInterval) {
    clearInterval(autoplayInterval);
  }
};

onMounted(() => {
  startAutoplay();
});

onBeforeUnmount(() => {
  stopAutoplay();
});
</script>

<style scoped>
.bg-navy-600 {
  background-color: #1a237e;
}

.bg-navy-700 {
  background-color: #151b60;
}

.text-navy-600 {
  color: #1a237e;
}

.hover\:bg-navy-700:hover {
  background-color: #151b60;
}

.hover\:text-navy-600:hover {
  color: #1a237e;
}

.focus\:ring-navy-500:focus {
  --tw-ring-color: #1e2b8f;
}

/* Carousel transitions */
.transition-transform {
  transition-property: transform;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
