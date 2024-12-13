<template>
  <div class="min-h-screen main">
    <!-- Header/Navigation -->
    <NavLink></NavLink>

    <!-- Registration Form -->
    <div
      class="flex min-h-[calc(95vh-80px)] items-center justify-center py-12 px-4 sm:px-6 lg:px-8"
    >
      <div class="w-full max-w-md">
        <div class="bg-white shadow-lg rounded-lg px-8 py-10">
          <div class="mb-8">
            <h2 class="text-3xl font-bold text-center text-gray-900">Create Account</h2>
            <p class="mt-2 text-center text-gray-600">
              Please fill in the details to create your account.
            </p>
          </div>
          <form @submit.prevent="submitForm" class="space-y-6">
            <div>
              <label for="firstname" class="block text-sm font-medium text-gray-700"
                >First Name</label
              >
              <div class="mt-1">
                <input
                  id="firstname"
                  v-model="form.firstname"
                  type="text"
                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-navy-500 focus:border-navy-500"
                />
              </div>
              <small class="text-red-700">{{ form.errors.firstname }}</small>
            </div>
            <div>
              <label for="lastname" class="block text-sm font-medium text-gray-700"
                >Last Name</label
              >
              <div class="mt-1">
                <input
                  id="lastname"
                  v-model="form.lastname"
                  type="text"
                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-navy-500 focus:border-navy-500"
                />
              </div>
              <small class="text-red-700">{{ form.errors.lastname }}</small>
            </div>

            <div>
              <label for="email" class="block text-sm font-medium text-gray-700"
                >Email</label
              >
              <div class="mt-1">
                <input
                  id="email"
                  v-model="form.email"
                  type="email"
                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-navy-500 focus:border-navy-500"
                />
              </div>
              <small class="text-red-700">{{ form.errors.email }}</small>
            </div>

            <div>
              <label for="password" class="block text-sm font-medium text-gray-700"
                >Password</label
              >
              <div class="mt-1 relative">
                <input
                  id="password"
                  v-model="form.password"
                  :type="showPassword ? 'text' : 'password'"
                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-navy-500 focus:border-navy-500"
                />
                <button
                  type="button"
                  @click="showPassword = !showPassword"
                  class="absolute inset-y-0 right-0 pr-3 flex items-center"
                >
                  <EyeIcon v-if="showPassword" class="h-5 w-5 text-gray-400" />
                  <EyeOffIcon v-else class="h-5 w-5 text-gray-400" />
                </button>
              </div>
              <small class="text-red-700">{{ form.errors.password }}</small>
            </div>

            <div>
              <label
                for="password_confirmation"
                class="block text-sm font-medium text-gray-700"
              >
                Confirm Password
              </label>
              <div class="mt-1">
                <input
                  id="password_confirmation"
                  v-model="form.password_confirmation"
                  type="password"
                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-navy-500 focus:border-navy-500"
                />
              </div>
              <small class="text-red-700">{{ form.errors.password_confirmation }}</small>
            </div>

            <button
              type="submit"
              class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-navy-900 hover:bg-navy-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy-500"
            >
              Register
            </button>
          </form>

          <p class="mt-6 text-center text-sm text-gray-600">
            Already have an account?
            <Link href="/login" class="font-medium text-navy-600 hover:text-navy-500">
              Sign in
            </Link>
          </p>
        </div>
      </div>
    </div>
    <!-- Footer -->
    <footer class="footer-color">
      <div class="mx-auto max-w-7xl px-4 py-4">
        <p class="text-center text-sm text-gray-500">Artzwork PC © 2024</p>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import { EyeIcon, EyeOffIcon } from "lucide-vue-next";
import NavLink from "../../Components/NavLink.vue";

// State
const showPassword = ref(false);

const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "", // Required for password confirmation
});

// Form submission
const submitForm = () => {
  form.post("/register", {
    onSuccess: () => form.reset("password", "password_confirmation"),
  });
};
</script>
