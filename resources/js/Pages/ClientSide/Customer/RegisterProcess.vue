<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <NavLink />

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
      <div class="max-w-3xl mx-auto">
        <!-- Progress Steps -->
        <div class="mb-8">
          <div class="flex items-center justify-between relative">
            <div class="absolute left-0 right-0 top-1/2 h-0.5 bg-gray-200 -z-10"></div>
            <div
              class="absolute left-0 right-0 top-1/2 h-0.5 bg-green-500 -z-10 transition-all duration-300"
              :style="{ width: `${(currentStep - 1) * 50}%` }"
            ></div>
            <div v-for="step in steps" :key="step.id" class="flex flex-col items-center">
              <div
                class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium transition-colors"
                :class="[
                  step.id <= currentStep
                    ? 'bg-green-500 text-white'
                    : 'bg-gray-200 text-gray-600',
                ]"
              >
                {{ step.id }}
              </div>
              <span class="mt-2 text-sm text-gray-600">{{ step.name }}</span>
            </div>
          </div>
        </div>

        <!-- Form Content -->
        <div class="bg-white rounded-lg shadow-sm p-6 md:p-8">
          <!-- Step 1: User Account -->
          <form v-if="currentStep === 1" @submit.prevent="nextStep" class="space-y-6">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">User Account</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  First Name
                </label>
                <input
                  v-model="formData.firstName"
                  type="text"
                  required
                  class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500"
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Last Name
                </label>
                <input
                  v-model="formData.lastName"
                  type="text"
                  required
                  class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500"
                />
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Email Address
              </label>
              <input
                v-model="formData.email"
                type="email"
                required
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500"
              />
            </div>

            <div class="flex justify-between pt-4">
              <button
                type="button"
                class="px-6 py-2 border rounded-lg text-gray-600 hover:bg-gray-50"
                @click="$router.back()"
              >
                Back
              </button>
              <button
                type="submit"
                class="px-6 py-2 bg-navy-600 text-white rounded-lg hover:bg-navy-700"
              >
                Continue
              </button>
            </div>
          </form>

          <!-- Step 2: Personal Information -->
          <form v-if="currentStep === 2" @submit.prevent="nextStep" class="space-y-6">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">
              Personal Information
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Username
                </label>
                <input
                  v-model="formData.username"
                  type="text"
                  required
                  class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500"
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Gender
                </label>
                <select
                  v-model="formData.gender"
                  required
                  class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500"
                >
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                  <option value="other">Other</option>
                </select>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Birthday
                </label>
                <input
                  v-model="formData.birthday"
                  type="date"
                  required
                  class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500"
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Phone Number
                </label>
                <input
                  v-model="formData.phone"
                  type="tel"
                  required
                  class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500"
                />
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Profile Picture
              </label>
              <div
                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg"
              >
                <div class="space-y-1 text-center">
                  <UploadIcon class="mx-auto h-12 w-12 text-gray-400" />
                  <div class="flex text-sm text-gray-600">
                    <label
                      for="file-upload"
                      class="relative cursor-pointer rounded-md font-medium text-navy-600 hover:text-navy-500"
                    >
                      <span>Upload a file</span>
                      <input
                        id="file-upload"
                        name="file-upload"
                        type="file"
                        class="sr-only"
                        @change="handleFileUpload"
                      />
                    </label>
                    <p class="pl-1">or drag and drop</p>
                  </div>
                  <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                </div>
              </div>
            </div>

            <div class="flex justify-between pt-4">
              <button
                type="button"
                class="px-6 py-2 border rounded-lg text-gray-600 hover:bg-gray-50"
                @click="currentStep--"
              >
                Back
              </button>
              <button
                type="submit"
                class="px-6 py-2 bg-navy-600 text-white rounded-lg hover:bg-navy-700"
              >
                Continue
              </button>
            </div>
          </form>

          <!-- Step 3: Checkout Information -->
          <form v-if="currentStep === 3" @submit.prevent="submitForm" class="space-y-6">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">
              Checkout Information
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Province
                </label>
                <select
                  v-model="formData.province"
                  required
                  class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500"
                >
                  <option value="metro-manila">Metro Manila</option>
                  <!-- Add more provinces -->
                </select>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"> City </label>
                <select
                  v-model="formData.city"
                  required
                  class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500"
                >
                  <option value="caloocan">Caloocan City</option>
                  <!-- Add more cities -->
                </select>
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Zip Code
              </label>
              <input
                v-model="formData.zipCode"
                type="text"
                required
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Complete Address
              </label>
              <textarea
                v-model="formData.address"
                rows="4"
                required
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-500"
              ></textarea>
            </div>

            <div class="flex justify-between pt-4">
              <button
                type="button"
                class="px-6 py-2 border rounded-lg text-gray-600 hover:bg-gray-50"
                @click="currentStep--"
              >
                Back
              </button>
              <button
                type="submit"
                class="px-6 py-2 bg-navy-600 text-white rounded-lg hover:bg-navy-700"
              >
                Complete
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from "vue";
import { Link } from "@inertiajs/vue3";
import { ShoppingCartIcon, UserIcon, UploadIcon } from "lucide-vue-next";
import NavLink from "@/Components/NavLink.vue";

// Steps configuration
const steps = [
  { id: 1, name: "User Account" },
  { id: 2, name: "Personal Information" },
  { id: 3, name: "Checkout Information" },
];

// Form state
const currentStep = ref(1);
const formData = reactive({
  firstName: "",
  lastName: "",
  email: "",
  username: "",
  gender: "",
  birthday: "",
  phone: "",
  profilePicture: null,
  province: "",
  city: "",
  zipCode: "",
  address: "",
});

// Methods
const handleFileUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    formData.profilePicture = file;
  }
};

const nextStep = () => {
  currentStep.value++;
};

const submitForm = () => {
  // Implement form submission logic
  console.log("Form submitted:", formData);
};
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

/* Hide number input spinners */
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>
