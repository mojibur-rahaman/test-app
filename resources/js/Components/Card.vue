<script setup>
import { ref, defineProps } from "vue";
import { Link } from "@inertiajs/vue3";

const cardOpen = ref(false);
const props = defineProps({
    cardProducts: {
        type: Object,
        Required: true,
    },
    productCount: {
        type: Number,
        default: 0,
    },
    totalPrice: {
        type: Number,
        Required: true,
    },
});
// Checkout Event Tracking Using GTM
const trackInitiateCheckout = (cardProducts, totalPrice, productCount) => {
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
        event: "initiate_checkout",
        // For GA4
        ecommerce: {
            currency: "BDT",
            value: totalPrice,
            items: cardProducts.map((product) => ({
                item_id: product.id,
                item_name: product.name,
                price: product.price,
                quantity: product.quantity,
                item_category: product.category || "Shutki",
            })),
        },
        // For Facebook Pixel
        fb_event_data: {
            content_type: "product",
            content_ids: cardProducts.map((p) => p.id),
            contents: cardProducts.map((p) => ({
                id: p.id,
                quantity: p.quantity,
                item_price: p.price,
            })),
            value: totalPrice,
            currency: "BDT",
            num_items: productCount,
        },
    });
};
</script>
<template>
    <!-- drawer init and toggle -->
    <div
        @click="cardOpen = !cardOpen"
        class="fixed w-20 h-24 lg:w-24 lg:h-32 z-40 top-[45%] right-0 overflow-hidden text-center bg-green-600 hover:bg-green-700 text-white shadow-lg rounded-s-lg cursor-pointer"
    >
        <div class="flex flex-col h-3/4 justify-center items-center">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="size-8"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"
                />
            </svg>
            <span>{{ productCount }} items</span>
        </div>
        <div class="bg-white/80 h-1/4 text-gray-900 font-medium">
            <span>৳ {{ totalPrice }}</span>
        </div>
    </div>
    <!-- drawer component -->
    <div
        id="product-card-drawer"
        :class="{
            'translate-x-full': !cardOpen,
        }"
        class="fixed top-0 right-0 z-50 h-screen p-4 overflow-y-auto transition-transform bg-white w-full lg:w-1/4 dark:bg-gray-800"
    >
        <!---Card Header --------------------->
        <div
            class="absolute top-20 w-[90%] border-b-4 border-green-400 pb-2 flex justify-between items-center"
        >
            <div class="inline-flex items-center text-slate-700">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-10 text-green-700 mr-2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"
                    />
                </svg>
                <span class="text-md lg:text-xl font-semibold"
                    >{{ productCount }} pcs</span
                >
            </div>

            <button
                @click="cardOpen = !cardOpen"
                class="text-red-400 bg-transparent bg-gray-300 border hover:bg-red-200 hover:text-red-900 rounded-lg text-md lg:text-xl px-4 py-2 inline-flex items-center justify-center dark:hover:bg-red-600 dark:hover:text-white shadow-md"
            >
                close
                <span class="sr-only">Close menu</span>
            </button>
        </div>
        <!---Card Header --------------------->

        <!----------Back Button -------------->
        <div
            @click="cardOpen = !cardOpen"
            class="hidden md:block cursor-pointer"
        >
            <div
                class="absolute flex items-center text-white w-4 h-16 left-0 top-[45%] bg-gray-500 rounded-l-lg"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m8.25 4.5 7.5 7.5-7.5 7.5"
                    />
                </svg>
            </div>
        </div>

        <!----------Back Button -------------->

        <!------ listing card product -------->
        <div class="w-full mt-32">
            <slot />
        </div>
        <!------ listing card product -------->

        <!------- Card Footer ---------------->
        <div
            class="absolute bottom-12 w-[90%] flex justify-around items-center text-md lg:text-xl text-center animate-bounce"
        >
            <Link
                @click="
                    trackInitiateCheckout(
                        props.cardProducts,
                        props.totalPrice,
                        props.productCount
                    )
                "
                :href="route('user.checkout')"
                method="get"
                class="w-2/3 bg-green-400 text-white py-2 cursor-pointer"
            >
                চেক আউট করুন
            </Link>
            <div class="w-1/3 bg-green-600 text-white py-2">
                ৳ {{ totalPrice }}
            </div>
        </div>
        <!------- Card Footer ---------------->
    </div>
</template>
