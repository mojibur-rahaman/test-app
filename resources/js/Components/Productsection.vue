<script setup>
import { defineProps } from "vue";
const props = defineProps({
    title: {
        type: String,
        default: "শুটকীমার্ট",
    },
    bg: {
        type: String,
        default: "bg-gray-100 dark:bg-gray-900",
    },
});
</script>
<template>
    <!------------- Popular Products --------------------->
    <section class="pb-2 lg:pb-6 mb-2 mx-2" :class="bg">
        <div class="w-full">
            <div
                class="inline-flex items-center justify-center w-full py-2 lg:py-4"
            >
                <hr
                    class="w-3/4 lg:w-1/2 h-1 my-8 bg-green-400 border-0 dark:bg-green-700"
                />
                <span
                    class="absolute px-3 font-medium text-xl lg:text-3xl text-gray-900 -translate-x-1/2 left-1/2 dark:text-white"
                    :class="bg"
                    >{{ props.title }}</span
                >
            </div>
            <div class="p-2 lg:p-0">
                <slot />
            </div>
        </div>
    </section>
    <!------------- Popular Products --------------------->
</template>
