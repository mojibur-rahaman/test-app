<script setup>
import { computed, onMounted, ref, defineProps } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";
import Cardproduct from "@/Components/Cardproduct.vue";
import SliderItem from "@/Components/SliderItem.vue";
import OrderNowButton from "@/Components/OrderNowButton.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
const props = defineProps({
    products: {
        type: Object,
        required: true,
    },
    query: {
        type: String,
    },
});
const addToCards = ref([]);
const cardItems = computed(() => {
    return addToCards.value.length;
});
onMounted(() => {
    const saveAddToCards = JSON.parse(localStorage.getItem("addToCards"));
    if (saveAddToCards) {
        addToCards.value = saveAddToCards;
    }
});
// Get Total
const totalPrice = computed(() => {
    return addToCards.value.reduce((acc, addToCard) => {
        return acc + addToCard.price * addToCard.quantity;
    }, 0);
});
// handle product card //
const handleAddToCardProduct = (product) => {
    // Find if the product already exists in addToCards
    const existingProduct = addToCards.value.find(
        (addToCard) => addToCard.id === product.id
    );
    if (existingProduct) {
        // If the product exists, increment its quantity
        existingProduct.quantity += 1;
    } else {
        // If the product doesn't exist, add it with quantity 1
        addToCards.value.push({
            ...product,
            quantity: 1,
        });
    }

    // Save to localStorage
    saveProductToLocalStorage();
};
// save product to localstorage
const saveProductToLocalStorage = () => {
    localStorage.setItem("addToCards", JSON.stringify(addToCards.value));
};
// delete product form cardProducts
const handleCardProductDeleted = (id) => {
    addToCards.value = addToCards.value.filter(
        (addToCard) => addToCard.id !== id
    );
    saveProductToLocalStorage();
};
// Increment cart product quantity
const handleIncrementedQuantity = (id) => {
    const product = addToCards.value.find((item) => item.id === id);
    if (product.quantity < product.maxQuantity) {
        product.quantity++;
    }
    saveProductToLocalStorage();
};
// Decrement cart product quantity
const handleDecrementedQuantity = (id) => {
    const product = addToCards.value.find((item) => item.id === id);
    if (product.quantity < 2) {
        handleCardProductDeleted(id);
    } else {
        product.quantity--;
    }
    saveProductToLocalStorage();
};
</script>

<template>
    <Head>
        <title>অর্গানিক ও স্বাস্থ্যসম্মত শুটকির অনলাইন বাজার</title>
        <meta
            name="description"
            content="ShutkiMart থেকে অর্ডার করুন লাক্ষা, লইট্টা, ছুরি, চ্যাপা, ফাইসা, চিংডি সহ কেমিকেল-মুক্ত, স্বাস্থ্যকর ও অর্গানিক দেশি শুটকি। ঘরে বসে পাচ্ছেন ফ্রি হোম ডেলিভারি।"
        />
        <meta
            name="keywords"
            content="ShutkiMart, শুটকি, অর্গানিক শুটকি, লইট্টা শুটকি, লাক্ষা শুটকি, দেশি শুটকি, কেমিকেল মুক্ত শুটকি,শুটকিমার্ট, ফ্রি হোম ডেলিভারি"
        />
    </Head>
    <GuestLayout>
        <Card :productCount="cardItems" :totalPrice="totalPrice"
            ><Cardproduct
                :cardProducts="addToCards"
                @cardProductDeleted="handleCardProductDeleted"
                @incrementedQuantity="handleIncrementedQuantity"
                @decrementedQuantity="handleDecrementedQuantity"
        /></Card>
        <!------------- Products Search Details----------------------->
        <div class="container mx-auto px-2 bg-slate-50 p-4 mb-4 text-center">
            <div class="max-w-sm mx-auto">
                <p class="text-xl text-gray-400">
                    Searching Results for : {{ query }}
                </p>
            </div>
        </div>
        <!------------- Products Navigation Details------------------->
        <div
            v-if="props.products.length > 0"
            class="container mx-auto px-2 grid gap-2 lg:gap-4 grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
        >
            <div class="mx-auto" v-for="product in products" :key="product.id">
                <SliderItem
                    :product="product"
                    :cardProduct="addToCards"
                    @addedToCardProduct="handleAddToCardProduct"
                    @incrementedQuantity="handleIncrementedQuantity"
                    @decrementedQuantity="handleDecrementedQuantity"
                />
            </div>
        </div>
        <!------------- Popular Products ----------------------------->

        <!------------- Product Not Found ---------------------------->
        <div
            v-else
            class="max-w-sm mx-auto px-2 mb-4 text-center bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700"
        >
            <div>
                <img
                    class="rounded-t-lg w-3/4 mx-auto"
                    src="/upload/asset/product_not_found.gif"
                    alt="Product Not Found Image"
                />
            </div>
            <div class="p-5">
                <div>
                    <h5
                        class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
                    >
                        😕পণ্য খুঁজে পাওয়া যায়নি
                    </h5>
                </div>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                    দুঃখিত! আপনি যে পণ্যটি খুঁজছেন সেটি আমাদের স্টকে নেই বা
                    খুঁজে পাওয়া যায়নি। অনুগ্রহ করে পণ্যের নাম (বাংলায়) লিখে আবার
                    চেষ্টা করুন।
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
        <OrderNowButton
            :cardProducts="addToCards"
            :productCount="cardItems"
            :totalPrice="totalPrice"
        />
    </GuestLayout>
</template>
