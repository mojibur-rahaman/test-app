<script setup>
const model = defineModel({
    type: null,
    required: true,
});
const props = defineProps({
    rows: {
        type: String,
        default: 2,
    },
    placeholder: {
        type: String,
        default: "",
    },
    label: String,
    message: String,
});
</script>
<template>
    <div class="col-span-2 mb-4">
        <label
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
        >
            {{ label }}
        </label>
        <textarea
            v-model="model"
            :rows="rows"
            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            :class="message ? 'border-red-300' : 'border-gray-300'"
            :placeholder="placeholder"
        ></textarea>
        <small class="text-sm font-medium text-red-600" v-if="message">{{
            message
        }}</small>
    </div>
</template>
