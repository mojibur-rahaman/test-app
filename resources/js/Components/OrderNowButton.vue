<script setup>
import { Link } from "@inertiajs/vue3";
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
    <div class="w-screen fixed z-20 block md:hidden bottom-0 mx-auto">
        <Link
            @click="
                trackInitiateCheckout(
                    props.cardProducts,
                    props.totalPrice,
                    props.productCount
                )
            "
            as="button"
            href="/checkout"
            class="w-full h-16 text-white bg-yellow-600 hover:bg-yellow-800 font-bold text-xl px-5 py-4 text-center inline-flex items-center justify-center rounded-tl-2xl rounded-tr-2xl border-t-4 border-red-700 shadow-lg"
        >
            <div
                type="button"
                class="relative inline-flex items-center p-1 me-4"
            >
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
                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"
                    />
                </svg>

                <span class="sr-only">Notifications</span>
                <div
                    class="absolute animate-bounce inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 rounded-full -top-1 -end-2"
                >
                    {{ props.productCount }}
                </div>
            </div>
            অর্ডার করুন
        </Link>
    </div>
</template>
