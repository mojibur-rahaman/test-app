<!-- eslint-disable vue/no-v-text-v-html-on-component -->
<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    paginator: {
        type: Object,
        required: true,
    },
});

// Function to format pagination labels
const makeLabel = (label) => {
    if (label.includes("Previous")) {
        return "<<";
    } else if (label.includes("Next")) {
        return ">>";
    }
    return label;
};
</script>

<template>
    <div class="flex justify-between items-start">
        <!-- Pagination Links -->
        <div class="flex items-center rounded-md overflow-hidden shadow-lg">
            <div v-for="link in paginator.links" :key="link.url || link.label">
                <component
                    :is="link.url ? Link : 'span'"
                    :href="link.url || '#'"
                    v-text="makeLabel(link.label)"
                    class="border-x border-slate-50 w-12 h-12 grid place-items-center bg-white"
                    :class="{
                        'hover:bg-slate-300': link.url,
                        'text-zinc-400': !link.url,
                        'font-bold text-blue-500': link.active,
                    }"
                />
            </div>
        </div>

        <!-- Pagination Info -->
        <p class="text-slate-600 text-sm">
            Showing {{ paginator.from }} to {{ paginator.to }} of
            {{ paginator.total }} results
        </p>
    </div>
</template>
