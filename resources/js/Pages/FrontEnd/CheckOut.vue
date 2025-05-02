<script setup>
import { ref, onMounted, computed } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import InputBox from "@/Components/InputBox.vue";
import TextArea from "@/Components/TextArea.vue";
import Cardproduct from "@/Components/Cardproduct.vue";
import Amountshow from "@/Components/Amountshow.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";

// Form Input filds..............
const form = useForm({
    name: null,
    mobile: null,
    address: null,
    total: 0,
    products: [],
});
// Cart Product
const addToCards = ref([]);
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
// Shipping Cost
const shippingCost = ref(120);
// Total payable amount for checkout order
const totalAmount = computed(() => {
    return totalPrice.value + shippingCost.value;
});
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
// Checkout this order

const checkoutSubmit = () => {
    form.products = addToCards.value;
    form.total = totalAmount.value;
    form.post(route("user.checkout"), {
        onFinish: () => localStorage.removeItem("addToCards"),
    });
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
        <div class="container mx-auto mb-4 px-2">
            <form @submit.prevent>
                <div class="grid gap-6 md:gap-12 mb-0 md:mb-6 md:grid-cols-2">
                    <div class="grid gap-4 order-last md:order-first">
                        <div
                            class="text-lg py-4 md:py-6 mb-0 md:mb-2 md:text-2xl col-span-2 text-center font-semibold text-slate-900 bg-green-200 rounded-xl shadow-md"
                        >
                            ডেলিভারির তথ্য দিন
                        </div>
                        <InputBox
                            v-model="form.name"
                            type="text"
                            label="আপনার নাম *"
                            placeholder="আপনার নাম লিখুন..."
                            :message="form.errors.name"
                        />
                        <InputBox
                            v-model="form.mobile"
                            type="text"
                            label="মোবাইল নাম্বার *"
                            placeholder="আপনার ফোন নাম্বার লিখুন..."
                            :message="form.errors.mobile"
                        />
                        <TextArea
                            v-model="form.address"
                            rows="8"
                            label="আপনার ঠিকানা *"
                            placeholder="আপনার ঠিকানা লিখুন (গ্রাম,উপজেলা,জেলা,পোষ্ট কোড)"
                            :message="form.errors.address"
                        />
                    </div>
                    <div class="w-full text-center">
                        <div
                            class="text-lg py-4 md:py-6 mb-4 md:mb-2 md:text-2xl font-semibold text-slate-900 bg-purple-200 rounded-xl shadow-md"
                        >
                            আপনার অর্ডার সম্পর্কে
                        </div>
                        <Cardproduct
                            :cardProducts="addToCards"
                            @cardProductDeleted="handleCardProductDeleted"
                            @incrementedQuantity="handleIncrementedQuantity"
                            @decrementedQuantity="handleDecrementedQuantity"
                        />
                        <div v-if="addToCards.length > 0">
                            <Amountshow
                                :showAmount="totalPrice"
                                amountTitle="Sub Total"
                            />
                            <Amountshow
                                :showAmount="shippingCost"
                                amountTitle="Shipping"
                            />
                            <Amountshow
                                :showAmount="totalAmount"
                                amountTitle="Total Amount"
                            />
                        </div>
                        <div v-else>
                            <img
                                class="w-1/2 mx-auto"
                                src="/upload/asset/product_not_found.gif"
                                alt="Product Not Found Image"
                            />
                            <div
                                class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                                role="alert"
                            >
                                <svg
                                    class="shrink-0 inline w-4 h-4 me-3"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"
                                    />
                                </svg>
                                <span class="sr-only">Info</span>
                                <div>
                                    আপনার কার্টে কোনো পণ্য নেই! অর্ডার করতে হলে
                                    অন্তত একটি
                                    <Link
                                        :href="route('home')"
                                        class="underline font-medium text-green-600 hover:text-green-900"
                                        >পণ্য যুক্ত করতে এখানে ক্লিক করুন</Link
                                    >
                                    ।
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button
                    @click="checkoutSubmit"
                    type="submit"
                    :disabled="form.processing"
                    class="text-white bg-slate-700 hover:bg-slate-900 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-lg w-full md:w-1/2 px-5 py-4 text-center dark:bg-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-800"
                >
                    অর্ডার কনফার্ম করুন
                </button>
            </form>
        </div>
    </GuestLayout>
</template>
