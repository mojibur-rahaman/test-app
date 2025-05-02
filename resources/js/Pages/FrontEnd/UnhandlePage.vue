<script setup>
import OrderNowButton from "@/Components/OrderNowButton.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
</script>

<template>
    <GuestLayout>
        <Head title="অর্গানিক ও স্বাস্থ্যসম্মত শুটকির অনলাইন বাজার" />
        <!------------- Products Search Details----------------------->
        <!------------- Product Not Found ---------------------------->
        <div
            class="max-w-sm mx-auto px-2 mb-4 text-center bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700"
        >
            <div>
                <img
                    class="rounded-t-lg w-3/4 mx-auto"
                    src="/upload/asset/404-error.gif"
                    alt="Product Not Found Image"
                />
            </div>
            <div class="p-5">
                <div>
                    <h5
                        class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
                    >
                        😕 404 - পৃষ্ঠা খুঁজে পাওয়া যায়নি
                    </h5>
                </div>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                    আপনি যে পাতাটি খুঁজছেন সেটি হয়তো মুছে ফেলা হয়েছে, নাম
                    পরিবর্তন হয়েছে, অথবা এমনকি কখনোই ছিল না! পণ্য কিনতে বাটনটিতে
                    ✔️ ক্লিক করুন
                </p>
                <!-- Continue Shopping Button -->
                <div
                    class="w-full py-2.5 mb-4 bg-red-600 hover:bg-green-600 text-white text-center mx-auto cursor-pointer rounded-md"
                >
                    <Link
                        :href="route('home')"
                        as="button"
                        type="button"
                        class="animate-bounce w-full"
                    >
                        Continue Shopping
                    </Link>
                </div>
            </div>
        </div>
        <!------------- Buy Now Button in Footer ---------------------->
        <OrderNowButton :productCount="cardItems" />
    </GuestLayout>
</template>
