<script setup>
import { defineProps } from "vue";
const props = defineProps({
    showAmount: {
        type: Number,
        default: 0,
    },
    amountTitle: String,
});
</script>
<template>
    <div
        class="flex justify-between text-start py-4 border-b-2 text-lg font-semibold text-slate-700"
    >
        <div class="w-3/4">{{ amountTitle }}</div>
        <div class="w-1/4">৳ {{ showAmount }}</div>
    </div>
</template>
