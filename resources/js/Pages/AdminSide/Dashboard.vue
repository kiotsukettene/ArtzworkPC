<template>
  <Head title=" | Dashboard"></Head>
  <div class="min-h-screen bg-gray-50">
    <!-- Mobile Sidebar Toggle -->
    <Sidebar></Sidebar>

    <!-- Main Content -->
    <main class="lg:ml-64 min-h-screen">
      <!-- Header -->
      <Header></Header>

      <!-- Dashboard Content -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Message -->
        <div class="mb-6">
          <h2 class="text-3xl font-bold text-gray-800">Welcome back, {{ userName }}!</h2>
        </div>
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
import { ref, computed } from "vue";
import { Link, Head, usePage } from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import {
  SearchIcon,
  MoreVerticalIcon,
  DollarSignIcon,
  PackageIcon,
  TrendingUpIcon,
} from "lucide-vue-next";
import Sidebar from "@/Components/Sidebar.vue";
const page = usePage();
const userName = computed(() => page.props.auth?.user?.first_name || "User");

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
</script>
