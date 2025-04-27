<script setup>
import { defineProps } from "vue";

const props = defineProps({
    cardProducts: {
        type: Object,
        Required: true,
    },
});

const emit = defineEmits([
    "cardProductDeleted",
    "incrementedQuantity",
    "decrementedQuantity",
]);
// deleteCartProduct
const deleteCardProduct = (id) => {
    emit("cardProductDeleted", id);
};
// incrementQuantity
const incrementQuantity = (id, maxQuantity) => {
    emit("incrementedQuantity", id, maxQuantity);
};
const decrementQuantity = (id) => {
    emit("decrementedQuantity", id);
};
</script>
<template>
    <!-----------Product Items ----------------------->
    <div
        v-for="cardProduct in cardProducts"
        :key="cardProduct.index"
        class="w-full border-y-2 py-1 mb-1"
    >
        <div class="flex justify-around items-center">
            <div class="flex flex-col items-center">
                <button
                    @click="
                        incrementQuantity(
                            cardProduct.id,
                            cardProduct.maxQuantity
                        )
                    "
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-5 cursor-pointer"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m4.5 15.75 7.5-7.5 7.5 7.5"
                        />
                    </svg>
                </button>
                <span>{{ cardProduct.quantity }}</span>
                <button
                    @click="
                        decrementQuantity(
                            cardProduct.id,
                            cardProduct.maxQuantity
                        )
                    "
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-5 cursor-pointer"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m19.5 8.25-7.5 7.5-7.5-7.5"
                        />
                    </svg>
                </button>
            </div>
            <div class="ps-2">
                <img
                    class="h-auto w-24 rounded-md shadow-xl dark:shadow-gray-800"
                    :src="`/uploads/products/${cardProduct.images[0].image}`"
                    alt="Product Image"
                />
            </div>
            <div class="max-w-[350px] px-2">
                <span
                    class="text-md font-semibold text-gray-600 float-start line-clamp-2"
                    >{{ cardProduct.name }}
                </span>
                <div class="text-gray-500 text-xs font-semibold">
                    <span class="float-start">
                        ৳{{ cardProduct.price }}/ {{ cardProduct.weight }}
                        {{ cardProduct.weightDesc }}
                    </span>
                    <span class="float-end">
                        ৳{{ cardProduct.price * cardProduct.quantity }}
                    </span>
                </div>
            </div>
            <div
                @click="deleteCardProduct(cardProduct.id)"
                class="rounded-sm items-center cursor-pointer"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-6 hover:text-red-700"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18 18 6M6 6l12 12"
                    />
                </svg>
            </div>
        </div>
    </div>
    <!-----------Product Items ----------------------->
</template>
