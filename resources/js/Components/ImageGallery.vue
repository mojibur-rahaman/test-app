<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
const props = defineProps({
    mobileBanners: {
        require: true,
        type: Object,
    },
    desktopBanners: {
        require: true,
        type: Object,
    },
});
const activeIndex = ref(0);
const images = ref([]);
const imagesMd = [...props.mobileBanners];
const imagesLg = [...props.desktopBanners];
// Function to set images based on screen size
const updateImages = () => {
    images.value = window.matchMedia("(max-width: 667px)").matches
        ? [...imagesMd]
        : [...imagesLg];
};
// Initialize images and watch for screen size changes
onMounted(() => {
    updateImages();
    window.addEventListener("resize", updateImages);
});

// Cleanup event listener on unmount
onBeforeUnmount(() => {
    window.removeEventListener("resize", updateImages);
});

// Go to the next slide
const nextSlide = () => {
    activeIndex.value = (activeIndex.value + 1) % images.value.length;
};

// Go to the previous slide
const prevSlide = () => {
    activeIndex.value =
        (activeIndex.value - 1 + images.value.length) % images.value.length;
};

// Autoplay feature
let autoplayInterval;
onMounted(() => {
    autoplayInterval = setInterval(nextSlide, 10000);
});

onBeforeUnmount(() => {
    clearInterval(autoplayInterval);
});
</script>

<template>
    <div id="gallery" class="relative w-full px-2">
        <!-- Carousel wrapper -->
        <div class="overflow-hidden rounded-lg">
            <transition name="fade" mode="out-in" v-if="images.length > 0">
                <img
                    :key="activeIndex"
                    :src="`/upload/asset/${images[activeIndex].image}`"
                    class="block max-w-full duration-300 h-auto"
                    alt="Slider image"
                />
            </transition>
        </div>

        <!-- Previous button -->
        <button
            @click="prevSlide"
            type="button"
            class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
        >
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none"
            >
                <svg
                    class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 6 10"
                >
                    <path
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 1 1 5l4 4"
                    />
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>

        <!-- Next button -->
        <button
            @click="nextSlide"
            type="button"
            class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
        >
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none"
            >
                <svg
                    class="w-4 h-4 text-white dark:text-gray-800"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 6 10"
                >
                    <path
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m1 9 4-4-4-4"
                    />
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}
.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>
