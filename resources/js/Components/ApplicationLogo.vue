<script setup>
import { Link } from "@inertiajs/vue3";
</script>
<template>
    <Link :href="route('home')" class="flex ms-2 md:me-24 cursor-pointer">
        <img
            src="/upload/asset/shutki_mart_logo.png"
            class="h-16 me-3"
            alt="Shutki Mart Logo"
        />
        <span
            class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white"
            >Shutkimart</span
        >
    </Link>
</template>
