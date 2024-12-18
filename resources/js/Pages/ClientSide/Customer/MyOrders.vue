    <template>
        <div class="min-h-screen bg-gray-50">
        <NavLink />
        <Toast />
        <!-- Main Content -->
        <div class="container mx-auto px-4 py-8">
            <div v-if="$page.props.success" class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ $page.props.success }}
            </div>
            <div class="flex flex-col md:flex-row gap-8">
            <!-- Sidebar -->
            <ProfileSidebar :customer="customer" />

           <!-- Orders Content -->
            <div class="flex-1">
            <div class="container mx-auto px-4 py-8 bg-white rounded-lg shadow-sm">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">My Orders</h1>

                <!-- Order Status Tabs -->
                <div class="border-b border-gray-200 mb-6">
                <nav class="flex space-x-8">
                    <button
                    v-for="tab in tabs"
                    :key="tab.name"
                    @click="currentTab = tab.id"
                    :class="[
                        currentTab === tab.id
                        ? 'border-navy-600 text-navy-600'
                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                        'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm',
                    ]"
                    >
                    {{ tab.name }}
                    </button>
                </nav>
                </div>

                <!-- Orders List -->
                <div class="space-y-4">
                    <div
                    v-for="order in filteredOrders"
                    :key="order.id"
                    class="bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-md p-4 flex flex-col sm:flex-row items-start sm:items-center gap-4"
                    >
                    <!-- Order Details -->
                    <div class="flex-1">
                        <h3 class="font-medium text-gray-900 uppercase">
                        {{ order.reference_number }}
                        </h3>
                        <div class="flex items-center text-sm text-gray-500 mt-2">
                        <CalendarIcon class="h-4 w-4 mr-1" />
                        <span>Order Date: {{ getDate(order.order_date) }}</span>
                        </div>
                    </div>

                    <!-- Price and Actions -->
                    <div class="flex flex-col items-end gap-2 min-w-[150px]">
                        <div class="text-right">
                        <div class="font-medium text-gray-900">
                            ${{ order.total_amount }}
                        </div>
                        </div>
                        <div class="flex gap-2">
                        <button
                            v-if="currentTab === 'completed'"
                            class="px-3 py-1 text-sm bg-navy-600 text-white rounded hover:bg-navy-700"
                        >
                            Review
                        </button>
                        <button
                            class="px-3 py-1 text-sm bg-navy-900 text-white rounded hover:bg-navy-800"
                        >
                            View Order Details
                        </button>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- End of Orders List -->
                </div>


            </div>
            </div>
        </div>
        </div>
    </template>

    <script setup>
    import { ref, computed } from "vue";
    import { Link } from "@inertiajs/vue3";
    import {
        CalendarIcon,
    } from "lucide-vue-next";
    import NavLink from "../../../Components/NavLink.vue";
    import ProfileSidebar from "../../../Components/ProfileSidebar.vue";
    import Toast from "../../../Components/Toast.vue";

    const props = defineProps({
        customer: Object,
        orders: Array,
        success: String
    });

    // Tabs
    const tabs = [
        { id: "pending", name: "Pending" },
        { id: "processing", name: "Processing" },
        { id: "shipped", name: "Shipped" },
        { id: "completed", name: "Completed" },
        { id: "canceled", name: "Canceled" },
    ];

const getDate = (date) =>
  new Date(date).toLocaleDateString("en-us", {
    year: "numeric",
    month: "long",
    day: "numeric",
  });

    const currentTab = ref("pending");

    // Sample Orders Data


    // Computed
    const filteredOrders = computed(() => {
        return props.orders.filter((order) => order.status === currentTab.value);
    });

    // Methods
    // const formatPrice = (price) => {
    //     return price.toLocaleString("en-PH", { minimumFractionDigits: 2 });
    // };
    </script>

    <style scoped>
    .bg-navy-600 {
        background-color: #1a237e;
    }

    .bg-navy-700 {
        background-color: #151b60;
    }

    .bg-navy-800 {
        background-color: #0d1147;
    }

    .bg-navy-900 {
        background-color: #070b2e;
    }

    .text-navy-600 {
        color: #1a237e;
    }

    .border-navy-600 {
        border-color: #1a237e;
    }
    </style>
