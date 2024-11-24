<template>
  <div
    :class="[
      'fixed z-50 p-4 rounded-lg shadow-lg max-w-md transition-all duration-300 ease-in-out',
      positionClasses,
      typeClasses[type],
    ]"
    :style="{ top: `${index * 5 + 1}rem` }"
  >
    <div class="flex items-center">
      <component :is="icon" class="w-5 h-5 mr-3" />
      <div class="flex-grow">
        <h3 class="font-semibold text-sm">{{ title }}</h3>
        <p class="text-sm">{{ message }}</p>
      </div>
      <button @click="close" class="ml-4 text-current hover:text-gray-700">
        <XIcon class="w-5 h-5" />
      </button>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";
import {
  XIcon,
  CheckCircleIcon,
  AlertCircleIcon,
  InfoIcon,
  AlertTriangleIcon,
  StarIcon, // Assuming you have an appropriate icon for the new success
} from "lucide-vue-next";

const props = defineProps({
  type: {
    type: String,
    default: "info",
    validator: (value) =>
      [
        "success",
        "new-success",
        "info",
        "warn",
        "error",
        "secondary",
        "contrast",
      ].includes(value),
  },
  title: {
    type: String,
    required: true,
  },
  message: {
    type: String,
    required: true,
  },
  position: {
    type: String,
    default: "top-right",
    validator: (value) =>
      ["top-right", "top-left", "bottom-right", "bottom-left"].includes(value),
  },
  index: {
    type: Number,
    default: 0,
  },
});

const emit = defineEmits(["close"]);

const close = () => {
  emit("close");
};

const typeClasses = {
  success: "bg-green-100 text-green-800",
  "new-success": "bg-teal-100 text-teal-800", // New category with teal colors
  info: "bg-blue-100 text-blue-800",
  warn: "bg-yellow-100 text-yellow-800",
  error: "bg-red-100 text-red-800",
  secondary: "bg-gray-100 text-gray-800",
  contrast: "bg-black text-white",
};

const icon = computed(() => {
  switch (props.type) {
    case "success":
      return CheckCircleIcon;
    case "new-success":
      return StarIcon; // Use StarIcon or another relevant icon for the new category
    case "info":
      return InfoIcon;
    case "warn":
      return AlertTriangleIcon;
    case "error":
      return AlertCircleIcon;
    default:
      return InfoIcon;
  }
});

const positionClasses = computed(() => {
  switch (props.position) {
    case "top-right":
      return "top-4 right-4";
    case "top-left":
      return "top-4 left-4";
    case "bottom-right":
      return "bottom-4 right-4";
    case "bottom-left":
      return "bottom-4 left-4";
    default:
      return "top-4 right-4";
  }
});
</script>
