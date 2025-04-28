<script setup>
import { defineProps } from "vue";
const model = defineModel({
    type: null,
    required: true,
});
const props = defineProps({
    title: String,
});
</script>
<template>
    <div class="flex items-start mb-6">
        <div class="flex items-center h-5">
            <input
                id="remember"
                v-model="model"
                type="checkbox"
                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800"
            />
        </div>
        <label
            for="remember"
            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
            >{{ title }}
        </label>
    </div>
</template>
