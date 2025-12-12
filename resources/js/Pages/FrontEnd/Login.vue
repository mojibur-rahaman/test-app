<script setup>
import { ref, computed, onMounted } from "vue";
import { Link, router } from "@inertiajs/vue3";
import { throttle } from "lodash";
import OrderNowButton from "../../Components/OrderNowButton.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
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
// State variables
const open = ref(false);
const mobile = ref("");
const validNumber = ref(false);

// Pattern for matching a valid mobile number
const mobileNumberPattern = /^01(?!0|1|2)\d{9}$/;

// Check if the mobile number matches the pattern
const matchNumber = () => {
    validNumber.value = mobileNumberPattern.test(mobile.value);
};

// Send login request with mobile number
const createAccount = () => {
    if (mobile.value.length === 11) {
        router.post(route("login"), { mobile: mobile.value });
        resetForm();
    }
};

// Throttle createAccount to prevent multiple submissions within 5 seconds
const throttledCreateAccount = throttle(createAccount, 5000);

// Reset form and state
const resetForm = () => {
    mobile.value = "";
    open.value = false;
    validNumber.value = false;
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
        <!-- Logo Section -->
        <div class="w-80 mx-auto">
            <img
                src="/upload/asset/shutki-mart-logo.gif"
                alt="Shutki Mart Logo"
            />
        </div>

        <!-- Continue Shopping Button -->
        <div
            class="w-2/3 lg:w-1/4 py-2.5 mb-4 bg-red-600 hover:bg-green-600 text-white text-center mx-auto cursor-pointer rounded-md"
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

        <!-- Mobile Login Form with Slide Transition -->
        <Transition name="slide-fade">
            <div
                v-if="open"
                class="w-2/3 lg:w-1/4 py-2.5 text-center mx-auto rounded-md"
            >
                <!-- Mobile Number Input -->
                <label
                    for="search"
                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white"
                >
                    Mobile Number (e.g., 018*****084)
                </label>
                <div class="relative">
                    <div
                        class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6 text-gray-500 dark:text-gray-400"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"
                            />
                        </svg>
                    </div>
                    <input
                        v-model="mobile"
                        @keyup="matchNumber"
                        type="search"
                        placeholder="ex (018*****084)"
                        class="block w-full p-4 ps-10 text-sm border border-gray-300 text-gray-900 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    />
                    <!-- Login Button with Throttle -->
                    <Transition name="slide-fade">
                        <button
                            v-if="validNumber"
                            @click="throttledCreateAccount"
                            type="button"
                            class="text-white absolute right-2 top-1.5 bg-green-500 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5"
                        >
                            Login
                        </button>
                    </Transition>
                </div>
                <!-- Invalid Number Message -->
                <small
                    v-if="!validNumber"
                    class="text-sm font-medium text-start text-red-600"
                >
                    Invalid Number
                </small>
            </div>
        </Transition>

        <!-- Toggle Login Form Button -->
        <div
            @click="open = !open"
            class="w-2/3 lg:w-1/4 mb-4 text-center mx-auto cursor-pointer rounded-md"
        >
            <span class="text-gray-700 font-semibold">
                Login to your account with
                <strong class="font-medium text-red-600 underline"
                    >mobile</strong
                >
                number
            </span>
        </div>
        <!------------- Buy Now Button in Footer ---------------------->
        <OrderNowButton
            :cardProducts="addToCards"
            :productCount="cardItems"
            :totalPrice="totalPrice"
        />
    </GuestLayout>
</template>

<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.3s ease-out;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(20px);
    opacity: 0;
}
</style>
