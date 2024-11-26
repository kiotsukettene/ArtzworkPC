<template>
    <Head title=" | Create Product"></Head>
  <div class="min-h-screen bg-gray-50">
    <!-- Mobile Sidebar Toggle -->
    <Sidebar></Sidebar>

    <!-- Main Content -->
    <main class="lg:ml-64 min-h-screen">
      <!-- Header -->
      <Header title="Create Product" :showSearch="false"></Header>

      <!-- Create Product Form -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form @submit.prevent="submitForm" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Main Form Content -->
          <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
              <h2 class="text-lg font-medium mb-4">Product Information</h2>

              <!-- Product Name -->
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1"
                  >Product Name</label
                >
                <input
                  v-model="form.name"
                  type="text"
                  class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>

              <!-- Slug and SKU -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                  <input
                    v-model="form.slug"
                    type="text"
                    disabled
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                  <input
                    v-model="form.sku"
                    disabled
                    type="text"
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  />
                </div>
              </div>

              <!-- Description -->
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1"
                  >Description</label
                >
                <textarea
                  v-model="form.description"
                  rows="4"
                  class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                ></textarea>
              </div>
              <!-- Image Upload -->
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
                      <div v-for="(preview, index) in imagePreviews" :key="index" class="relative group">
                        <img :src="preview" alt="Preview" class="h-32 w-auto rounded-md shadow-md" />
                        <button
                          @click="removeImage(index)"
                          type="button"
                          class="absolute top-1 right-1 text-red-600 w-6 h-6 rounded-full flex items-center justify-center shadow-lg"
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
                          accept="image/*"
                          class="sr-only"
                          @change="handleFileUpload"
                        />
                      </label>
                      <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB each</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Specifications -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-medium mb-4">Specifications</h2>

                <div class="space-y-4">
                    <div v-for="spec in currentSpecifications" :key="spec.id">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ spec.name }}</label>
                    <input
                        v-model="form.specifications[spec.id]"
                        type="text"
                        :placeholder="`Enter ${spec.name}`"
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
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
                />
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
                />
              </div>
            </div>

            <!-- Associations -->
            <div class="bg-white rounded-lg shadow p-6">
              <h2 class="text-lg font-medium mb-4">Associations</h2>
              <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select
                        v-model="form.category_id"
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
                        v-model="form.brand_id"
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">Select Brand</option>
                        <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                        {{ brand.name }}
                        </option>
                    </select>
                    </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1"
                    >Warranty</label
                  >
                  <input
                    v-model="form.warranty"
                    type="name"
                    placeholder="e.g 12 months"
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  >
                  </input>
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
                :disabled="form.processing"
                class="px-4 py-2 bg-navy-600 text-white rounded-md hover:bg-navy-700 disabled:opacity-50"
                >
                <span v-if="form.processing">Creating...</span>
                <span v-else>Create</span>
                </button>
            </div>
          </div>
        </form>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import { Link, useForm, } from "@inertiajs/vue3";
import Sidebar from "../../../Components/Sidebar.vue";
import Header from "../../../Components/Header.vue";
// State

const props = defineProps({
  categories: Array,
  brands: Array,
});

const form = useForm({
  name: "",
  slug: "",
  sku: "",
  description: "",
  images: [],
  price: "",
  stock: "",
  category_id: "",
  brand_id: "",
  warranty: "",
  specifications: [],
});

const currentSpecifications = ref([]);

// Watch for changes to the selected category
watch(
  () => form.category_id, // Watch the correct property
  (newCategoryId) => {
    const selectedCategory = props.categories.find((category) => category.id === newCategoryId);
    currentSpecifications.value = selectedCategory ? selectedCategory.specifications : [];
  }
);

watch(
  () => form.name,
  (newName) => {
    form.slug = newName.toLowerCase().trim().replace(/\s+/g, "-");
  }
);

const handleCategoryChange = () => {
  form.specifications = {};
};


// Methods
const imagePreviews = ref([]); // Array to store image previews

// Handle file upload
// Handle file upload
const handleFileUpload = (event) => {
  const files = Array.from(event.target.files); // Convert FileList to Array
  addFiles(files);
};

// Handle drag-and-drop
const handleDrop = (event) => {
  event.preventDefault(); // Prevent default behavior
  const files = Array.from(event.dataTransfer.files);
  addFiles(files);
};

// Add files to the form
const addFiles = (files) => {
  files.forEach((file) => {
    if (!file.type.startsWith("image/")) {
      alert("Only image files are allowed.");
      return;
    }

    if (file.size > 10 * 1024 * 1024) {
      alert("File size must not exceed 10MB.");
      return;
    }

    form.images.push(file); // Add the file to form.images
    createImagePreview(file); // Create a preview for the image
  });
};

// Create image previews
const createImagePreview = (file) => {
  const reader = new FileReader();
  reader.onload = (e) => {
    imagePreviews.value.push(e.target.result); // Store the base64 preview
  };
  reader.readAsDataURL(file);
};

// Remove an image
const removeImage = (index) => {
  form.images.splice(index, 1); // Remove file from form data
  imagePreviews.value.splice(index, 1); // Remove preview
};

const submitForm = () => {
  form.post(route("products.store"), {
    onSuccess: () => {
      // Optional: Redirect to the product index or reset the form
      form.reset();
    },
    onError: (errors) => {
      // Handle validation errors if necessary
      console.error(errors);
    },
  });
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
