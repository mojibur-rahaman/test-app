<script setup>
import { defineProps } from "vue";
const model = defineModel({
    type: null,
    required: true,
});
const props = defineProps({ label: String });
</script>
<template>
    <div class="col-span-2 md:col-span-1">
        <label
            for="countries"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >{{ label }}</label
        >
        <select
            v-model="model"
            id="countries"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        >
            <slot />
        </select>
    </div>
</template>
