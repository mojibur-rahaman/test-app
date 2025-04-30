<script setup>
import { ref, onMounted, computed } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
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
    orderNote: null,
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
    if (product.quantity < 5) {
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
    <GuestLayout>
        <Head title="Checkout" />
        <div class="container mx-auto mb-4 px-2">
            <form @submit.prevent>
                <div class="grid gap-6 md:gap-12 mb-6 md:grid-cols-2">
                    <div class="grid gap-4">
                        <div
                            class="text-lg py-4 md:py-6 mb-0 md:mb-2 md:text-2xl col-span-2 text-center font-semibold text-slate-900 bg-green-200 rounded-xl shadow-md"
                        >
                            Billing & Shipping
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
                            placeholder="আপনার ঠিকানা লিখুন (গ্রাম,উপজেলা,জেলা...) সহ"
                            :message="form.errors.address"
                        />
                    </div>
                    <div class="w-full text-center">
                        <div
                            class="text-lg py-4 md:py-6 mb-4 md:mb-2 md:text-2xl font-semibold text-slate-900 bg-purple-200 rounded-xl shadow-md"
                        >
                            Your Order
                        </div>
                        <Cardproduct
                            :cardProducts="addToCards"
                            @cardProductDeleted="handleCardProductDeleted"
                            @incrementedQuantity="handleIncrementedQuantity"
                            @decrementedQuantity="handleDecrementedQuantity"
                        />
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
                </div>
                <button
                    @click="checkoutSubmit"
                    type="submit"
                    :disabled="form.processing"
                    class="text-white bg-slate-700 hover:bg-slate-900 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-lg w-full md:w-1/2 px-5 py-4 text-center dark:bg-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-800"
                >
                    Place Order
                </button>
            </form>
        </div>
    </GuestLayout>
</template>
