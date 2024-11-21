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
          <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
          <div class="flex items-center gap-4">
            <div class="relative">
              <input
                type="text"
                placeholder="Search"
                class="w-full sm:w-64 pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
              <SearchIcon class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" />
            </div>
            <div class="relative">
              <img
                src=""
                class="h-10 w-10 rounded-full cursor-pointer"
                @click="isProfileOpen = !isProfileOpen"
              />
            </div>
          </div>
        </div>
      </header>

      <!-- Dashboard Content -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <div
            v-for="metric in metrics"
            :key="metric.title"
            class="bg-white p-6 rounded-lg shadow-sm"
          >
            <div class="flex items-center">
              <component :is="metric.icon" class="h-8 w-8 text-gray-400" />
              <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">{{ metric.title }}</h3>
                <div class="flex items-baseline">
                  <p class="text-2xl font-semibold">{{ metric.value }}</p>
                  <p
                    :class="[
                      'ml-2 text-sm',
                      metric.trend > 0 ? 'text-green-600' : 'text-red-600',
                    ]"
                  >
                    {{ Math.abs(metric.trend) }}% {{ metric.period }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Chart and Most Sold Items -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
          <!-- Overview Chart -->
          <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-lg font-medium mb-4">Overview</h3>
            <div class="h-64">
              <!-- Chart would go here - implement with your preferred charting library -->
            </div>
          </div>

          <!-- Most Sold Items -->
          <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-lg font-medium mb-4">Most Sold Items</h3>
            <div class="space-y-4">
              <div
                v-for="item in mostSoldItems"
                :key="item.name"
                class="flex items-center"
              >
                <span class="w-24 text-sm">{{ item.name }}</span>
                <div class="flex-1 mx-4">
                  <div class="h-2 bg-gray-200 rounded-full">
                    <div
                      class="h-2 bg-blue-600 rounded-full"
                      :style="{ width: `${item.percentage}%` }"
                    ></div>
                  </div>
                </div>
                <span class="text-sm font-medium">{{ item.percentage }}%</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Latest Orders -->
        <div class="bg-white rounded-lg shadow-sm">
          <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-medium">Latest Orders</h3>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th
                    v-for="header in tableHeaders"
                    :key="header"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    {{ header }}
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="order in latestOrders" :key="order.id">
                  <td class="px-6 py-4 whitespace-nowrap">{{ order.product }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">#{{ order.id }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">{{ order.date }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">{{ order.customer }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span
                      :class="[
                        'px-2 py-1 text-xs rounded-full',
                        order.status === 'Delivered'
                          ? 'bg-green-100 text-green-800'
                          : order.status === 'Pending'
                          ? 'bg-yellow-100 text-yellow-800'
                          : 'bg-red-100 text-red-800',
                      ]"
                    >
                      {{ order.status }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">${{ order.amount }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <button class="text-gray-400 hover:text-gray-500">
                      <MoreVerticalIcon class="h-5 w-5" />
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref } from "vue";
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
  MoreVerticalIcon,
  DollarSignIcon,
  PackageIcon,
  TrendingUpIcon,
} from "lucide-vue-next";

const isSidebarOpen = ref(false);
const isProfileOpen = ref(false);

const currentPage = ref(1);
const menuItems = [
  { name: "Dashboard", icon: HomeIcon, href: "/dashboard", current: true },
  { name: "Category", icon: TagIcon, href: "/categories" },
  { name: "Brands", icon: ShoppingBagIcon, href: "/brands" },
  { name: "Products", icon: PackageIcon, href: "/products" },
  { name: "Transactions", icon: ClipboardListIcon, href: "/transactions" },
  { name: "Order History", icon: ClipboardListIcon, href: "/order-history" },
  { name: "Return / Refund", icon: ClipboardListIcon, href: "/return-refund" },
  { name: "Customers", icon: UsersIcon, href: "/customers" },
  { name: "Employees", icon: UsersIcon, href: "/employees" },
];

const setActivePage = (page) => {
  activePage.value = page;
};

const metrics = [
  {
    title: "Revenue",
    value: "$166,580",
    trend: 5,
    period: "in the last 1 month",
    icon: DollarSignIcon,
  },
  {
    title: "Product Sold",
    value: "5,679",
    trend: 2,
    period: "in the last 1 month",
    icon: PackageIcon,
  },
  {
    title: "Daily Revenue",
    value: "51,801",
    trend: -3,
    period: "in the last 1 week",
    icon: TrendingUpIcon,
  },
];

const mostSoldItems = [
  { name: "Asus Laptop", percentage: 70 },
  { name: "Asus Laptop", percentage: 40 },
  { name: "Asus Laptop", percentage: 60 },
  { name: "Asus Laptop", percentage: 80 },
  { name: "Asus Laptop", percentage: 20 },
  { name: "Asus Laptop", percentage: 30 },
  { name: "Asus Laptop", percentage: 10 },
  { name: "Asus Laptop", percentage: 100 },
];

const tableHeaders = [
  "Products",
  "Order ID",
  "Date",
  "Customer name",
  "Status",
  "Amount",
  "Action",
];

const latestOrders = [
  {
    id: "11232",
    product: "Iphone 13 Pro",
    date: "Jun 29,2022",
    customer: "Afaq Karim",
    status: "Delivered",
    amount: "400.00",
  },
  {
    id: "11232",
    product: "Macbook Pro",
    date: "Jun 29,2022",
    customer: "Afaq Karim",
    status: "Pending",
    amount: "288.00",
  },
  {
    id: "11232",
    product: "Apple Watch",
    date: "Jun 29,2022",
    customer: "Afaq Karim",
    status: "Canceled",
    amount: "500.00",
  },
  {
    id: "11232",
    product: "Microsoft Book",
    date: "Jun 29,2022",
    customer: "Afaq Karim",
    status: "Delivered",
    amount: "100.00",
  },
  {
    id: "11232",
    product: "Apple Pen",
    date: "Jun 29,2022",
    customer: "Afaq Karim",
    status: "Delivered",
    amount: "60.00",
  },
  {
    id: "11232",
    product: "Airpods",
    date: "Jun 29,2022",
    customer: "Afaq Karim",
    status: "Delivered",
    amount: "80.00",
  },
];

const logout = () => {
  // Implement logout logic
  console.log("Logging out...");
};
</script>
