<script setup>
import { defineProps } from "vue";
const props = defineProps({
    title: String,
    result: String,
});
</script>
<template>
    <div class="bg-white shadow-md rounded px-2 py-2.5">
        <div class="flex justify-start items-center">
            <div class="w-1/3 p-2 mr-2 rounded-full bg-gray-200">
                <slot />
            </div>
            <div class="w-auto text-center">
                <span class="text-slate-500 text-sm">{{ title }}</span>
                <p class="text-slate-700 text-lg font-bold">{{ result }}</p>
            </div>
        </div>
    </div>
</template>
