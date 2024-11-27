<template>
  <div class="min-h-screen bg-white">
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

          <!-- Search, Cart, Account -->
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
            <button class="text-gray-700 hover:text-navy-600">
              <UserIcon class="h-6 w-6" />
            </button>
            <!-- Mobile Menu Button -->
            <button
              @click="isMenuOpen = !isMenuOpen"
              class="md:hidden text-gray-700 hover:text-navy-600"
            >
              <MenuIcon v-if="!isMenuOpen" class="h-6 w-6" />
              <XIcon v-else class="h-6 w-6" />
            </button>
          </div>
        </div>

        <!-- Mobile Navigation -->
        <div v-if="isMenuOpen" class="md:hidden mt-4 pb-4 border-t">
          <Link
            v-for="item in navigationItems"
            :key="item.name"
            :href="item.href"
            class="block py-2 text-gray-700 hover:text-navy-600"
          >
            {{ item.name }}
          </Link>
          <!-- Mobile Search -->
          <div class="mt-4 relative">
            <input
              type="text"
              placeholder="Search for products..."
              class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500"
            />
            <SearchIcon class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" />
          </div>
        </div>
      </nav>
    </header>

    <!-- Hero Section -->
    <section class="white">
      <div class="container rounded-lg bg-gray-200 mt-3 mx-auto px-4 py-8">
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
            <div class="p-3 bg-gray-100 rounded-lg">
              <TruckIcon class="h-6 w-6 text-navy-600" />
            </div>
            <div>
              <h3 class="font-semibold">Free Delivery</h3>
              <p class="text-sm text-gray-600">100% Free for all orders</p>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <div class="p-3 bg-gray-100 rounded-lg">
              <HeadphonesIcon class="h-6 w-6 text-navy-600" />
            </div>
            <div>
              <h3 class="font-semibold">Great Support 24/7</h3>
              <p class="text-sm text-gray-600">We care your experiences</p>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <div class="p-3 bg-gray-100 rounded-lg">
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
    <section class="py-12 bg-gray-100">
      <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
          <div>
            <div class="flex items-center space-x-2 mb-2">
              <div class="w-4 h-8 bg-navy-600 rounded"></div>
              <span class="text-sm font-medium">This Month</span>
            </div>
            <h2 class="text-2xl font-bold">Latest Products</h2>
          </div>
          <!-- <Link
            href="/products"
            class="px-4 py-2 bg-navy-900 text-white rounded-md hover:text-navy-700 flex items-center"
          >
            View All
            <ArrowRightIcon class="h-4 w-4 ml-1" />
          </Link> -->
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <div
            v-for="product in latestProducts"
            :key="product.id"
            class="bg-white rounded-lg shadow-lg overflow-hidden"
          >
            <img
              :src="product.image"
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
    </section>

    <!-- Categories Section -->
    <section class="py-12 bg-navy-900 text-white">
      <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold mb-8">Categories</h2>
        <div class="relative">
          <div class="flex overflow-x-auto space-x-6 pb-4 -mx-4 px-4">
            <div v-for="category in categories" :key="category.id" class="flex-none w-64">
              <div class="bg-navy-800 rounded-lg overflow-hidden">
                <img
                  :src="category.image"
                  :alt="category.name"
                  class="w-full h-48 object-cover"
                />
                <div class="p-4">
                  <h3 class="font-medium">{{ category.name }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Explore Products Section -->
    <section class="py-12 bg-white">
      <div class="container mx-auto px-4">
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

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <div
            v-for="product in exploreProducts"
            :key="product.id"
            class="bg-navy-900 rounded-lg p-4"
          >
            <img
              :src="product.image"
              :alt="product.name"
              class="w-full h-48 object-cover rounded-lg mb-4"
            />
            <h3 class="text-white font-medium mb-2">{{ product.name }}</h3>
            <div class="flex items-center justify-between">
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
                  <span class="text-gray-400 text-sm ml-2">({{ product.reviews }})</span>
                </div>
                <span class="text-white font-bold">${{ product.price }}</span>
              </div>
              <div class="flex space-x-2">
                <button class="p-2 text-white hover:text-navy-300">
                  <HeartIcon class="h-5 w-5" />
                </button>
                <button class="p-2 text-white hover:text-navy-300">
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
    <footer class="bg-navy-900 text-white pt-12 pb-6">
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
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
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
} from "lucide-vue-next";

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
  {
    id: 1,
    name: "Mini Robin Black",
    price: "32.30",
    rating: "4.1",
    image: "",
  },
  {
    id: 2,
    name: "Coolman Cyborg Pink",
    price: "32.30",
    rating: "4.1",
    image: "",
  },
  {
    id: 3,
    name: "Ming Mini Blk",
    price: "32.30",
    rating: "4.1",
    image: "",
  },
  {
    id: 4,
    name: "Coolmax Cyborg White",
    price: "32.30",
    rating: "4.1",
    image: "",
  },
];

// Categories Data
const categories = [
  {
    id: 1,
    name: "Mousepad Extended",
    image: "",
  },
  {
    id: 2,
    name: "CCTV Dome Hikvision HD",
    image: "",
  },
  {
    id: 3,
    name: "PSU - AVR",
    image: "",
  },
  {
    id: 4,
    name: "Mouse",
    image: "",
  },
];

// Explore Products Data
const exploreProducts = [
  {
    id: 1,
    name: "PROCESSOR RYZEN 7 5700",
    price: "400",
    rating: 5,
    reviews: "325",
    image: "",
  },
  {
    id: 2,
    name: "PROCESSOR RYZEN 7 5700X",
    price: "400",
    rating: 3,
    reviews: "325",
    image: "",
  },
  {
    id: 3,
    name: "PROCESSOR I5 6TH",
    price: "400",
    rating: 4,
    reviews: "325",
    image: "",
  },
  {
    id: 4,
    name: "PROCESSOR CORE I3- 6TH GEN",
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
