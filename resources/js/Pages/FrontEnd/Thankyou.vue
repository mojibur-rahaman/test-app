<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { defineProps } from "vue";
const props = defineProps({
    order: {
        type: Object,
        required: true,
    },
});
</script>
<template>
    <GuestLayout>
        <Head title="Shutki Mart | Thank You" />
        <div class="relative overflow-hidden bg-gray-100">
            <!-- grapics-->
            <div class="flex justify-between">
                <div
                    class="w-1/5 shadow-lg h-screen bg-red-500 -rotate-45 lg:rotate-45 translate-y-1/3 lg:-translate-y-1/3 -translate-x-1/4"
                ></div>
                <div
                    class="w-1/5 shadow-lg h-screen bg-green-500 rotate-45 translate-y-1/3 translate-x-1/4"
                ></div>
            </div>
            <!-- thank you content -->
            <div class="absolute w-full md:w-1/2 left-0 md:left-1/4 top-0">
                <div class="text-center mt-8 mb-6 md:mb-0">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="size-6 w-28 h-28 text-green-500 mx-auto"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                            clip-rule="evenodd"
                        />
                    </svg>

                    <h2 class="mt-4 text-2xl font-bold text-gray-800">
                        Thank You ({{ props.order.name }}) for Your Purchase!
                    </h2>
                    <p class="mt-2 text-gray-600">
                        Your order was successfully placed. You’ll receive a
                        confirmation sms shortly & your order id is #{{
                            $props.order.id
                        }}
                    </p>
                    <div class="grid md:grid-cols-2 gap-4 mt-6">
                        <div
                            class="bg-white w-3/4 md:w-full mx-auto shadow-lg rounded"
                        >
                            <p class="text-xl font-bold text-center mt-6">
                                Your Order Summary
                            </p>
                            <div class="p-4">
                                <div class="flex justify-between">
                                    <span>Subtotal:</span>
                                    <span class="font-semibold text-gray-700"
                                        >৳ {{ props.order.total - 120 }}</span
                                    >
                                </div>
                                <div class="flex justify-between mt-2">
                                    <span>Shipping:</span>
                                    <span class="font-semibold text-gray-700"
                                        >৳ 120</span
                                    >
                                </div>
                                <div class="flex justify-between mt-2">
                                    <span>Total:</span>
                                    <span class="font-semibold text-gray-800"
                                        >৳ {{ props.order.total }}</span
                                    >
                                </div>
                            </div>
                        </div>
                        <div
                            class="bg-white w-3/4 md:w-full min-h-36 mx-auto shadow-lg rounded"
                        >
                            <p class="text-xl font-bold text-center mt-6">
                                Connect With Us
                            </p>
                            <div
                                class="flex flex-col justify-center p-2 mt-2 md:mt-4 text-white"
                            >
                                <a
                                    href="https://www.facebook.com/shutkimartcxb"
                                    class="text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2 mb-2"
                                >
                                    <svg
                                        class="w-4 h-4 me-2"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 8 19"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    Connect Us With Facebook
                                </a>
                                <button
                                    type="button"
                                    class="text-white bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#4285F4]/55 me-2 mb-2"
                                >
                                    <svg
                                        class="w-4 h-4 me-2"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 18 19"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M8.842 18.083a8.8 8.8 0 0 1-8.65-8.948 8.841 8.841 0 0 1 8.8-8.652h.153a8.464 8.464 0 0 1 5.7 2.257l-2.193 2.038A5.27 5.27 0 0 0 9.09 3.4a5.882 5.882 0 0 0-.2 11.76h.124a5.091 5.091 0 0 0 5.248-4.057L14.3 11H9V8h8.34c.066.543.095 1.09.088 1.636-.086 5.053-3.463 8.449-8.4 8.449l-.186-.002Z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    Connect Us With Youtube
                                </button>
                            </div>
                        </div>
                    </div>
                    <Link
                        :href="route('home')"
                        as="button"
                        class="px-6 py-2 mt-6 font-semibold text-white bg-slate-700 rounded hover:bg-slate-900"
                    >
                        Continue Shopping
                    </Link>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
