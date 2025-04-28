<script setup>
import { defineProps } from "vue";
const model = defineModel({
    type: null,
    required: true,
});
const props = defineProps({
    name: {
        type: String,
        default: "",
    },
    type: {
        type: String,
        default: "text",
    },
    placeholder: {
        type: String,
        default: "",
    },
    require: {
        type: Boolean,
        default: false,
    },
    label: String,
    message: String,
});
</script>
<template>
    <div class="col-span-2 md:col-span-1">
        <label
            v-if="label"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >{{ label }}</label
        >
        <input
            v-model="model"
            :type="type"
            :name="name"
            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            :class="message ? 'border-red-300' : 'border-gray-300'"
            :placeholder="placeholder"
        />
        <small class="text-sm font-medium text-red-600" v-if="message">{{
            message
        }}</small>
    </div>
</template>
