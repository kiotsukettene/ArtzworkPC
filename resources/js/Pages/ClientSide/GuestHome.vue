<template>
  <div class="min-h-screen bg-white">
    <!-- Header/Navigation -->
    <NavLink />
    <!-- Hero Section -->
    <section class="py-16 main">
      <div class="container rounded-lg main mt-1 mx-auto px-4 py-8">
        <div class="grid md:grid-cols-2 gap-8 items-center">
          <!-- Text Section -->
          <div>
            <h1 class="text-4xl md:text-5xl font-bold text-navy-900 mb-4 leading-tight">
              Best Furniture Collection for your interior.
            </h1>
            <p class="text-gray-600 mb-6 leading-relaxed">
              Save up to 50% on select Xbox games.<br />
              Get 3 months of PC Game Pass for $2 USD.
            </p>
          </div>

          <!-- Images Section -->
          <div class="grid md:grid-cols-2 gap-3">
            <!-- Xbox Console -->
            <div
              class="bg-white rounded-lg p-4 shadow-lg flex justify-center items-center"
            >
              <img
                src="../ClientSide/assets/Image.png"
                alt="Xbox Console"
                class="w-full max-w-[250px] object-contain"
              />
            </div>

            <!-- Right Content Section -->
            <div class="space-y-2">
              <!-- Summer Sales -->
              <div class="bg-white rounded-lg p-4 shadow-lg relative">
                <div
                  class="absolute top-2 left-2 bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded"
                >
                  SUMMER SALES
                </div>
                <img
                  src="../ClientSide/assets/Widget.png"
                  alt="Iphone 15 Series"
                  class="w-full object-cover rounded-lg"
                />
                <h3 class="font-semibold mt-2">Iphone 15 Series</h3>
                <div class="text-lg font-bold text-green-600">29% OFF</div>
              </div>

              <!-- Play Station 5 -->
              <div class="bg-white rounded-lg p-4 shadow-lg">
                <img
                  src="../ClientSide/assets/ps53.png"
                  alt="Play Station 5"
                  class="w-full max-w-[150px] mx-auto mb-2"
                />
                <h3 class="font-semibold mb-2 text-center">Play Station 5</h3>
                <p class="text-sm text-gray-600 text-center">Digital Edition + 2TB</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="py-12 bg-white">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
          <div class="flex items-center space-x-4">
            <div class="p-3 bg-gray-100 rounded-lg">
              <PackageIcon class="h-6 w-6 text-navy-600" />
            </div>
            <div>
              <h3 class="font-semibold">Discount</h3>
              <p class="text-sm text-gray-600">Every month new sales</p>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <div class="p-3 main rounded-lg">
              <TruckIcon class="h-6 w-6 text-navy-600" />
            </div>
            <div>
              <h3 class="font-semibold">Free Delivery</h3>
              <p class="text-sm text-gray-600">100% Free for all orders</p>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <div class="p-3 main rounded-lg">
              <HeadphonesIcon class="h-6 w-6 text-navy-600" />
            </div>
            <div>
              <h3 class="font-semibold">Great Support 24/7</h3>
              <p class="text-sm text-gray-600">We care your experiences</p>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <div class="p-3 main rounded-lg">
              <ShieldIcon class="h-6 w-6 text-navy-600" />
            </div>
            <div>
              <h3 class="font-semibold">Secure Payment</h3>
              <p class="text-sm text-gray-600">100% Secure Payment Method</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Latest Products Section -->
    <section class="py-12 main">
      <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="flex justify-between items-center mb-8">
          <div>
            <div class="flex items-center space-x-2 mb-2">
              <div class="w-4 h-8 bg-navy-600 rounded"></div>
              <span class="text-sm font-medium">This Month</span>
            </div>
            <h2 class="text-2xl font-bold">Latest Products</h2>
          </div>
        </div>

        <div class="relative overflow-hidden">
          <!-- Carousel Wrapper -->
          <div
            class="flex transition-transform duration-300"
            :style="{ transform: `translateX(-${currentSlide * (100 / visibleCards)}%)` }"
            ref="productCarousel"
          >
            <div
              v-for="product in latestProducts"
              :key="product.id"
              class="flex-none px-2"
              :class="{
                'w-1/2': visibleCards === 2,
                'w-1/3': visibleCards === 3,
                'w-1/5': visibleCards === 5,
              }"
            >
              <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img
                  src="../ClientSide/assets/ryzen.webp"
                  :alt="product.name"
                  class="w-full h-48 object-cover"
                />
                <div class="p-4">
                  <h3 class="font-medium mb-2">{{ product.name }}</h3>
                  <div class="flex items-center justify-between">
                    <div class="flex items-center">
                      <span class="text-lg font-bold">${{ product.price }}</span>
                      <div class="flex items-center ml-2">
                        <StarIcon class="h-4 w-4 text-yellow-400 fill-current" />
                        <span class="text-sm ml-1">{{ product.rating }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Navigation Buttons -->
          <button
            @click="prevSlide"
            class="absolute left-0 top-1/2 -translate-y-1/2 bg-navy-600 p-2 rounded-full hover:bg-navy-700 transition sm:p-1 lg:p-2"
          >
            <ChevronLeft class="h-6 w-6 text-white" />
          </button>
          <button
            @click="nextSlide"
            class="absolute right-0 top-1/2 -translate-y-1/2 bg-navy-600 p-2 rounded-full hover:bg-navy-700 transition sm:p-1 lg:p-2"
          >
            <ChevronRight class="h-6 w-6 text-white" />
          </button>
        </div>
      </div>
    </section>

    <!-- Categories Section -->
    <section class="py-12 bg-navy-900 text-white">
      <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold mb-8">Categories</h2>
        <div class="relative overflow-hidden">
          <!-- Carousel Wrapper -->
          <div
            class="flex transition-transform duration-300"
            :style="{
              transform: `translateX(-${
                currentCategorySlide * (100 / visibleCategoryCards)
              }%)`,
            }"
            ref="categoryCarousel"
          >
            <div
              v-for="category in categories"
              :key="category.id"
              class="flex-none px-2"
              :class="{
                'w-1/2': visibleCategoryCards === 2,
                'w-1/3': visibleCategoryCards === 3,
                'w-1/5': visibleCategoryCards === 5,
              }"
            >
              <div class="bg-navy-800 rounded-lg overflow-hidden">
                <img
                  src="../ClientSide/assets/laptop.webp"
                  :alt="category.name"
                  class="w-full h-48 object-cover"
                />
                <div class="p-4">
                  <h3 class="font-medium">{{ category.name }}</h3>
                </div>
              </div>
            </div>
          </div>

          <!-- Navigation Buttons -->
          <button
            @click="prevCategorySlide"
            class="absolute left-0 top-1/2 -translate-y-1/2 bg-navy-800 p-2 rounded-full hover:bg-navy-700 transition sm:p-1 lg:p-2"
          >
            <ChevronLeft class="h-6 w-6 text-white" />
          </button>
          <button
            @click="nextCategorySlide"
            class="absolute right-0 top-1/2 -translate-y-1/2 bg-navy-800 p-2 rounded-full hover:bg-navy-700 transition sm:p-1 lg:p-2"
          >
            <ChevronRight class="h-6 w-6 text-white" />
          </button>
        </div>
      </div>
    </section>

    <!-- Explore Products Section -->
    <section class="py-12 main">
      <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="flex items-center space-x-2 mb-2">
          <div class="w-4 h-8 bg-navy-600 rounded"></div>
          <span class="text-sm font-medium">Our Products</span>
        </div>
        <div class="flex justify-between items-center mb-8">
          <h2 class="text-2xl font-bold">Explore Our Products</h2>
          <Link
            href="/products"
            class="px-4 py-2 bg-navy-900 text-white rounded-lg hover:bg-navy-800"
          >
            Browse All Products
          </Link>
        </div>

        <!-- Responsive Products Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
          <div
            v-for="product in exploreProducts"
            :key="product.id"
            class="bg-white rounded-lg p-4 shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-200"
          >
            <!-- Brand Name -->
            <span class="text-end text-sm font-semibold text-black uppercase mb-2 block">
              {{ product.brand }}
            </span>
            <!-- Product Image -->
            <div class="flex justify-center items-center mb-4 aspect-w-1 aspect-h-1">
              <img
                src="../ClientSide/assets/product.webp"
                :alt="product.name"
                class="w-full object-contain rounded-lg"
              />
            </div>
            <!-- Product Name -->
            <h3 class="primary-text font-medium mb-2">{{ product.name }}</h3>
            <div class="flex items-center justify-between">
              <!-- Product Details -->
              <div>
                <div class="flex items-center mb-1">
                  <StarIcon
                    v-for="n in 5"
                    :key="n"
                    class="h-4 w-4"
                    :class="
                      n <= product.rating
                        ? 'text-yellow-400 fill-current'
                        : 'text-gray-400'
                    "
                  />
                  <span class="text-gray-400 text-sm ml-2">
                    ({{ product.reviews }})
                  </span>
                </div>
                <span class="primary-text font-bold text-lg">${{ product.price }}</span>
              </div>
              <!-- Action Buttons -->
              <div class="flex space-x-2">
                <button class="p-2 primary-text main rounded-lg">
                  <HeartIcon class="h-5 w-5" />
                </button>
                <button class="p-2 text-white bg-navy-900 rounded-lg">
                  <ShoppingCartIcon class="h-5 w-5" />
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Reviews Section -->
    <section class="py-12 bg-navy-900 text-white">
      <div class="container mx-auto px-4">
        <div class="flex items-center space-x-2 mb-2">
          <div class="w-4 h-8 bg-white rounded"></div>
          <span class="text-sm font-medium">Reviews</span>
        </div>
        <h2 class="text-2xl font-bold mb-8">What our customers say about</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            v-for="review in reviews"
            :key="review.id"
            class="bg-navy-800 rounded-lg p-6"
          >
            <div class="flex items-center mb-4">
              <img
                :src="review.avatar"
                :alt="review.name"
                class="w-12 h-12 rounded-full"
              />
              <div class="ml-4">
                <h3 class="font-medium">{{ review.name }}</h3>
                <p class="text-sm text-gray-400">{{ review.title }}</p>
              </div>
            </div>
            <p class="text-gray-300">{{ review.content }}</p>
            <p class="mt-4 text-sm text-gray-400">{{ review.date }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="footer-color text-white pt-12 pb-6">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
          <div>
            <h3 class="text-lg font-bold mb-4">ArtzworkPC</h3>
            <p class="text-gray-400 mb-2">Customer Support:</p>
            <p class="text-gray-400">(629) 555-0129</p>
            <p class="text-gray-400 mb-4">Phone & Support: 9am-6pm Caloocan City</p>
            <p class="text-gray-400">ArtzworkPC@gmail.com</p>
          </div>

          <div>
            <h3 class="text-lg font-bold mb-4">TOP CATEGORY</h3>
            <ul class="space-y-2">
              <li>
                <Link href="#" class="text-gray-400 hover:text-white"
                  >Computer & Laptop</Link
                >
              </li>
              <li>
                <Link href="#" class="text-gray-400 hover:text-white">SmartPhone</Link>
              </li>
              <li>
                <Link href="#" class="text-gray-400 hover:text-white">Headphone</Link>
              </li>
              <li><Link href="#" class="text-gray-400 hover:text-white">Mouse</Link></li>
            </ul>
          </div>

          <div>
            <h3 class="text-lg font-bold mb-4">QUICK LINKS</h3>
            <ul class="space-y-2">
              <li>
                <Link href="#" class="text-gray-400 hover:text-white"
                  >Artzwork PC Shopee</Link
                >
              </li>
              <li>
                <Link href="#" class="text-gray-400 hover:text-white"
                  >Artzwork PC Lazada</Link
                >
              </li>
              <li>
                <Link href="#" class="text-gray-400 hover:text-white"
                  >Privacy Policy</Link
                >
              </li>
              <li><Link href="#" class="text-gray-400 hover:text-white">FAQ</Link></li>
              <li>
                <Link href="#" class="text-gray-400 hover:text-white">Contact</Link>
              </li>
              <li>
                <Link href="#" class="text-gray-400 hover:text-white">About Us</Link>
              </li>
            </ul>
          </div>

          <div>
            <h3 class="text-lg font-bold mb-4">POPULAR TAG</h3>
            <div class="flex flex-wrap gap-2">
              <Link
                href="#"
                class="px-3 py-1 bg-navy-800 rounded-full text-sm text-gray-400 hover:text-white"
                >Game</Link
              >
              <Link
                href="#"
                class="px-3 py-1 bg-navy-800 rounded-full text-sm text-gray-400 hover:text-white"
                >iPhone</Link
              >
              <Link
                href="#"
                class="px-3 py-1 bg-navy-800 rounded-full text-sm text-gray-400 hover:text-white"
                >Keyboard</Link
              >
              <Link
                href="#"
                class="px-3 py-1 bg-navy-800 rounded-full text-sm text-gray-400 hover:text-white"
                >Asus Laptop</Link
              >
              <Link
                href="#"
                class="px-3 py-1 bg-navy-800 rounded-full text-sm text-gray-400 hover:text-white"
                >Macbook</Link
              >
              <Link
                href="#"
                class="px-3 py-1 bg-navy-800 rounded-full text-sm text-gray-400 hover:text-white"
                >SSD</Link
              >
              <Link
                href="#"
                class="px-3 py-1 bg-navy-800 rounded-full text-sm text-gray-400 hover:text-white"
                >Graphics Card</Link
              >
              <Link
                href="#"
                class="px-3 py-1 bg-navy-800 rounded-full text-sm text-gray-400 hover:text-white"
                >Power Bank</Link
              >
              <Link
                href="#"
                class="px-3 py-1 bg-navy-800 rounded-full text-sm text-gray-400 hover:text-white"
                >Smart TV</Link
              >
              <Link
                href="#"
                class="px-3 py-1 bg-navy-800 rounded-full text-sm text-gray-400 hover:text-white"
                >Speaker</Link
              >
              <Link
                href="#"
                class="px-3 py-1 bg-navy-800 rounded-full text-sm text-gray-400 hover:text-white"
                >Case</Link
              >
              <Link
                href="#"
                class="px-3 py-1 bg-navy-800 rounded-full text-sm text-gray-400 hover:text-white"
                >Microwave</Link
              >
              <Link
                href="#"
                class="px-3 py-1 bg-navy-800 rounded-full text-sm text-gray-400 hover:text-white"
                >Mouse</Link
              >
            </div>
          </div>
        </div>

        <div class="border-t border-navy-800 pt-6">
          <p class="text-center text-gray-400">Artzwork PC © 2024</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import { Link, router } from "@inertiajs/vue3";
import {
  MenuIcon,
  XIcon,
  SearchIcon,
  ShoppingCartIcon,
  UserIcon,
  StarIcon,
  HeartIcon,
  PackageIcon,
  TruckIcon,
  HeadphonesIcon,
  ShieldIcon,
  ArrowRightIcon,
  ChevronLeft,
  ChevronRight,
} from "lucide-vue-next";
import NavLink from "../../Components/NavLink.vue";

// State
const isMenuOpen = ref(false);

// Navigation Items
const navigationItems = [
  { name: "Home", href: "/" },
  { name: "Products", href: "/products" },
  { name: "PC Builder", href: "/pc-builder" },
  { name: "Laptops", href: "/laptops" },
  { name: "Desktops", href: "/desktops" },
];

// Latest Products Data
const latestProducts = [
  { id: 1, name: "Product 1", price: "32.30", rating: "4.1" },
  { id: 2, name: "Product 2", price: "32.30", rating: "4.1" },
  { id: 3, name: "Product 3", price: "32.30", rating: "4.1" },
  { id: 4, name: "Product 4", price: "32.30", rating: "4.1" },
  { id: 5, name: "Product 5", price: "32.30", rating: "4.1" },
  { id: 6, name: "Product 6", price: "32.30", rating: "4.1" },
  { id: 7, name: "Product 7", price: "32.30", rating: "4.1" },
  { id: 8, name: "Product 8", price: "32.30", rating: "4.1" },
];
const currentSlide = ref(0);
const visibleCards = ref(5);

// State for Categories Section
const currentCategorySlide = ref(0);
const visibleCategoryCards = ref(5);

// Update visible cards based on screen size
const updateVisibleCards = () => {
  if (window.innerWidth < 640) {
    visibleCards.value = 2;
    visibleCategoryCards.value = 2;
  } else if (window.innerWidth < 1024) {
    visibleCards.value = 3;
    visibleCategoryCards.value = 3;
  } else {
    visibleCards.value = 5;
    visibleCategoryCards.value = 5;
  }
};

// Scroll functionality for Latest Products Section
const prevSlide = () => {
  currentSlide.value = Math.max(currentSlide.value - 1, 0);
};
const nextSlide = () => {
  currentSlide.value = Math.min(
    currentSlide.value + 1,
    latestProducts.length - visibleCards.value
  );
};

// Scroll functionality for Categories Section
const prevCategorySlide = () => {
  currentCategorySlide.value = Math.max(currentCategorySlide.value - 1, 0);
};
const nextCategorySlide = () => {
  currentCategorySlide.value = Math.min(
    currentCategorySlide.value + 1,
    categories.length - visibleCategoryCards.value
  );
};

// Add event listener for window resize
onMounted(() => {
  updateVisibleCards();
  window.addEventListener("resize", updateVisibleCards);
});

onBeforeUnmount(() => {
  window.removeEventListener("resize", updateVisibleCards);
});
// Sample categories (replace with your dynamic data)
const categories = [
  { id: 1, name: "Laptops" },
  { id: 2, name: "Desktops" },
  { id: 3, name: "Accessories" },
  { id: 4, name: "Gaming" },
  { id: 5, name: "Monitors" },
  { id: 6, name: "Monitors" },
  { id: 6, name: "Monitors" },
  { id: 6, name: "Monitors" },
  { id: 6, name: "Monitors" },
  { id: 6, name: "Monitors" },
];

// // State for category carousel
// const currentCategorySlide = ref(0);
// const visibleCategoryCards = 5; // Number of visible cards

// // Compute the maximum slide index for categories
// const maxCategorySlide = computed(() =>
//   Math.max(0, categories.length - visibleCategoryCards)
// );

// // Slide left
// const prevCategorySlide = () => {
//   currentCategorySlide.value = Math.max(currentCategorySlide.value - 1, 0);
// };

// // Slide right
// const nextCategorySlide = () => {
//   currentCategorySlide.value = Math.min(
//     currentCategorySlide.value + 1,
//     maxCategorySlide.value
//   );
// };

// References for carousels

// Explore Products Data
const exploreProducts = [
  {
    id: 1,
    name: "PROCESSOR RYZEN 7 5700",
    brand: "AMD",
    price: "400",
    rating: 5,
    reviews: "325",
    image: "",
  },
  {
    id: 2,
    name: "PROCESSOR RYZEN 7 5700X",
    brand: "AMD",
    price: "400",
    rating: 3,
    reviews: "325",
    image: "",
  },
  {
    id: 3,
    name: "PROCESSOR I5 6TH",
    brand: "AMD",
    price: "400",
    rating: 4,
    reviews: "325",
    image: "",
  },
  {
    id: 4,
    name: "PROCESSOR CORE I3- 6TH GEN",
    brand: "AMD",
    price: "400",
    rating: 2,
    reviews: "325",
    image: "",
  },
  {
    id: 4,
    name: "PROCESSOR CORE I3- 6TH GEN",
    brand: "AMD",
    price: "400",
    rating: 2,
    reviews: "325",
    image: "",
  },
  {
    id: 4,
    name: "PROCESSOR CORE I3- 6TH GEN",
    brand: "AMD",
    price: "400",
    rating: 2,
    reviews: "325",
    image: "",
  },
  {
    id: 4,
    name: "PROCESSOR CORE I3- 6TH GEN",
    brand: "AMD",
    price: "400",
    rating: 2,
    reviews: "325",
    image: "",
  },
  {
    id: 4,
    name: "PROCESSOR CORE I3- 6TH GEN",
    brand: "AMD",
    price: "400",
    rating: 2,
    reviews: "325",
    image: "",
  },
];

// Reviews Data
const reviews = [
  {
    id: 1,
    name: "Martin Goutry",
    title: "Back-end developer at MyOnline",
    content:
      "Dico is finally addressing a long-time problem we had when building UIs. It's ease of use and workflow seems really intuitive. Promising!",
    date: "Dico user, 2023.03.02",
    avatar: "",
  },
  {
    id: 2,
    name: "Theo Champion",
    title: "Back-end developer at MyOnline",
    content:
      "Dico is finally addressing a long-time problem we had when building UIs. It's ease of use and workflow seems really intuitive. Promising!",
    date: "Dico user, 2023.03.02",
    avatar: "",
  },
  {
    id: 3,
    name: "Agnes Remi",
    title: "Back-end developer at MyOnline",
    content:
      "Dico is finally addressing a long-time problem we had when building UIs. It's ease of use and workflow seems really intuitive. Promising!",
    date: "Dico user, 2023.03.02",
    avatar: "",
  },
];
</script>

<style scoped></style>
