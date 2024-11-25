<template>
  <Head title=" | Category" />
  <div class="min-h-screen bg-gray-50">
    <!-- Mobile Sidebar Toggle -->
    <Sidebar></Sidebar>

    <!-- Main Content -->
    <main class="lg:ml-64 min-h-screen">
      <!-- Header -->
      <Header title="Category"></Header>

      <!-- Category Content -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
          <div class="relative">
            <button
              @click="isFilterOpen = !isFilterOpen"
              class="flex items-center px-4 py-2 border rounded-md bg-white hover:bg-gray-50"
            >
              Filter by
              <ChevronDownIcon class="ml-2 h-5 w-5" />
            </button>
            <!-- Filter Dropdown -->
            <div
              v-if="isFilterOpen"
              class="absolute mt-2 w-48 bg-white rounded-md shadow-lg z-10"
            >
              <!-- Add filter options here -->
            </div>
          </div>
          <button class="px-4 py-2 bg-navy-600 text-white rounded-md hover:bg-navy-700">
            <Link :href="route('categories.create')"> New Category </Link>
          </button>
        </div>

        <!-- Category Table -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th
                  v-for="header in ['NAME', 'IMG', 'SKU', 'SLUG', 'CREATED_AT', '']"
                  :key="header"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  {{ header }}
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="(category, index) in categories.data" :key="category.id">
                <td class="px-6 py-4 whitespace-nowrap">{{ category.name }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <img
                    :src="
                      category.image
                        ? '/storage/' + category.image
                        : 'storage/categoryImages/default.jpg'
                    "
                    class="h-16 w-24 object-cover rounded-md shadow-sm"
                  />
                </td>
                <td class="px-6 py-4 whitespace-nowrap">{{ category.sku }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ category.slug }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  {{ getDate(category.created_at) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right relative">
                  <!-- MoreVerticalIcon Button -->
                  <button
                    @click="toggleActionMenu(index)"
                    class="text-gray-400 hover:text-gray-500"
                  >
                    <MoreVerticalIcon class="h-5 w-5" />
                  </button>
                  <!-- Action Menu -->
                  <div
                    v-if="activeActionMenu === index"
                    :class="[
                      'absolute z-10 w-40 bg-white shadow-lg rounded-md',
                      index === categories.data.length - 1 ? 'bottom-0' : 'mt-2',
                    ]"
                    :style="{
                      right: '0',
                      transform:
                        index === categories.data.length - 1
                          ? 'translateY(-100%)'
                          : 'none',
                    }"
                  >
                    <Link>
                      <button
                        @click="
                          () => {
                            console.log('Viewing', category);
                          }
                        "
                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                      >
                        View
                      </button>
                    </Link>
                    <Link :href="route('categories.edit', category.id)">
                      <button
                        class="block w-full text-left px-4 py-2 text-sm text-green-500 hover:bg-green-100"
                      >
                        Edit
                      </button>
                    </Link>

                    <button
                      @click="() => openDeleteModal(category)"
                      class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100"
                    >
                      Delete
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination Links-->
        <div class="flex items-center justify-between mt-6">
          <div class="flex items-center">
            <span class="text-sm text-gray-700"
              >Showing {{ categories.from }} to {{ categories.to }} of
              {{ categories.total }} results</span
            >
          </div>
          <div class="flex gap-2">
            <Link
              v-for="link in categories.links"
              :key="link.label"
              v-html="makeLabel(link.label)"
              :href="link.url"
              :class="[
                'px-3 py-1 rounded-md',
                {
                  'text-slate-300': !link.url,
                  'text-white bg-navy-600 font-medium hover:bg-navy-700': link.active,
                  ' bg-stone-100': !link.active,
                },
              ]"
            />
          </div>
        </div>
      </div>
    </main>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto">
      <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="relative bg-white rounded-lg max-w-md w-full p-6">
          <div class="flex flex-col items-center">
            <div
              class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100"
            >
              <TrashIcon class="h-6 w-6 text-red-600" />
            </div>
            <h3 class="mt-4 text-lg font-semibold">Delete Item</h3>
            <p class="mt-2 text-sm text-gray-500">Are you sure you want to do this?</p>
            <div class="mt-6 flex gap-4">
              <button
                @click="showDeleteModal = false"
                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200"
              >
                Cancel
              </button>
              <button
                @click="confirmDelete"
                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
              >
                Confirm
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import { MoreVerticalIcon, ChevronDownIcon, TrashIcon } from "lucide-vue-next";
import Sidebar from "../../../Components/Sidebar.vue";
import Header from "../../../Components/Header.vue";
import { route } from "../../../../../vendor/tightenco/ziggy/src/js";

const props = defineProps({
  categories: Object,
});

const isFilterOpen = ref(false);
const showDeleteModal = ref(false); // Tracks if the delete modal is visible
const categoryToDelete = ref(null);
const activeActionMenu = ref(null); // Tracks the row index for which the modal is active

const toggleActionMenu = (index) => {
  // Toggle the active modal for the given row index
  activeActionMenu.value = activeActionMenu.value === index ? null : index;
};

const closeActionMenu = () => {
  // Close all action menus
  activeActionMenu.value = null;
};

const openDeleteModal = (item) => {
  categoryToDelete.value = item;
  activeActionMenu.value = null;
  showDeleteModal.value = true;
};

const confirmDelete = () => {
  router.delete(route("categories.destroy", categoryToDelete.value.id), {
    onSuccess: () => {
      showDeleteModal.value = false; // Close the modal after success
      activeActionMenu.value = null;
    },
  });
};
const logout = () => {
  // Implement logout logic
};

const getDate = (date) =>
  new Date(date).toLocaleDateString("en-us", {
    year: "numeric",
    month: "long",
    day: "numeric",
  });

const makeLabel = (label) => {
  if (label.includes("Previous")) {
    return "<";
  } else if (label.includes("Next")) {
    return ">";
  } else {
    return label;
  }
};
</script>
<style scoped>
.bg-navy-600 {
  background-color: #001044;
}

.bg-navy-700 {
  background-color: #151c63;
}

.hover\:bg-navy-700:hover {
  background-color: #151c63;
}
</style>
