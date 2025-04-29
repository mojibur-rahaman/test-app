<script setup>
import { Link } from "@inertiajs/vue3";
import { computed, defineProps } from "vue";
const props = defineProps({
    product: {
        type: Object,
        Required: true,
    },
    cardProduct: {
        type: Array,
        default: [],
    },
});
const emit = defineEmits([
    "addedToCardProduct",
    "incrementedQuantity",
    "decrementedQuantity",
]);
const addToCardProduct = (product) => {
    emit("addedToCardProduct", product);
};
// Check if product is in the cardProduct array
const isProductInCart = computed(() => {
    return props.cardProduct.some((item) => item.id === props.product.id);
});

// Get current product quantity
const productQuantityInCart = computed(() => {
    const productInCart = props.cardProduct.find(
        (item) => item.id === props.product.id
    );
    return productInCart ? productInCart.quantity : 0;
});
// incrementQuantity
const incrementQuantity = (id) => {
    emit("incrementedQuantity", id);
};
const decrementQuantity = (id) => {
    emit("decrementedQuantity", id);
};
</script>
<template>
    <div
        class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
    >
        <!----Product Image-->
        <Link :href="route('product.view', { product_id: props.product.id })">
            <img
                class="h-auto max-sm:h-[156px] p-2 md:p-4 pb-4 rounded-lg mx-auto"
                :src="`/upload/products/${props.product.images[0].image}`"
                alt="product image"
            />
        </Link>
        <!---- Product Image-->

        <div class="px-2 pb-5">
            <a href="#">
                <h5
                    class="h-[40px] md:h-[54px] text-sm md:text-xl font-semibold text-center tracking-tight text-gray-900 dark:text-white line-clamp-2"
                >
                    {{ props.product.name }}
                </h5>
            </a>
            <div class="flex items-center mt-2.5 mb-5 justify-center">
                <span
                    class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white"
                    >৳ {{ props.product.price }}</span
                >
                <span
                    class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 ms-3"
                    >{{ props.product.weight }}
                    {{ props.product.weightDesc }}</span
                >
            </div>
            <!----------Initial add to card button-->
            <div
                v-if="!isProductInCart"
                class="w-full text-center"
                @click="addToCardProduct(props.product)"
            >
                <button
                    class="w-full flex justify-center font-medium text-sm lg:text-lg lg:px-5 py-2 text-center text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 rounded-sm"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-6 me-4"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z"
                        />
                    </svg>
                    পন্য যোগ করুন
                </button>
            </div>
            <!----------Initial add to card button-->

            <!-- show when product added on card-->
            <div
                v-else
                class="w-full flex text-white justify-between bg-red-500 items-center"
            >
                <button
                    @click="decrementQuantity(product.id)"
                    class="w-12 py-2 border-r bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium text-sm lg:text-lg text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-6 mx-auto"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 12h14"
                        />
                    </svg>
                </button>

                <span
                    @click="incrementQuantity(product.id)"
                    class="font-medium w-3/4 mx-auto text-center text-sm lg:text-lg cursor-pointer"
                >
                    {{ productQuantityInCart }} টি ব্যাগে</span
                >

                <button
                    @click="incrementQuantity(product.id)"
                    class="w-12 py-2 border-l bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium text-sm lg:text-lg text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-6 mx-auto"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 4.5v15m7.5-7.5h-15"
                        />
                    </svg>
                </button>
            </div>
            <!-- show when product added on card-->
        </div>
    </div>
</template>
