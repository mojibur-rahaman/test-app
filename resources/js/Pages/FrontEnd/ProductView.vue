<script setup>
import { computed, onMounted, ref } from "vue";
import GuestLayout from "../../Layouts/GuestLayout.vue";
import Productsection from "../../Components/Productsection.vue";
import SliderItem from "../../Components/SliderItem.vue";
import Card from "../../Components/Card.vue";
import Cardproduct from "../../Components/Cardproduct.vue";
// markDown ........................................................>>
import { marked } from "marked";
import DOMPurify from "dompurify";
// Swiper Js Handler ................................................>>
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/navigation";
import { Navigation, Autoplay } from "swiper/modules";
import OrderNowButton from "../../Components/OrderNowButton.vue";

// Swiper Js Handler ..................................................>>
// Swiper handler //
const modules = [Navigation, Autoplay];
const breakpoints = {
    // when window width is >= 320px
    320: {
        slidesPerView: 2,
        spaceBetween: 10,
    },
    // when window width is >= 640px
    640: {
        slidesPerView: 2,
        spaceBetween: 20,
    },
    // when window width is >= 1024px
    1024: {
        slidesPerView: 4,
        spaceBetween: 30,
    },
    // when window width is >= 1440px
    1440: {
        slidesPerView: 5,
        spaceBetween: 40,
    },
};
// Swiper handler //

// Product Handling ...................................................>>
const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    relatedProducts: {
        type: Object,
        required: true,
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
const isProductInCart = computed(() => {
    return addToCards.value.some((item) => item.id === props.product.id);
});
// Get current product quantity
const productQuantityInCart = computed(() => {
    const productInCart = addToCards.value.find(
        (item) => item.id === props.product.id
    );
    return productInCart ? productInCart.quantity : 0;
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
// Handling Product Images And It's Functionality......................>>
const zoomScale = 1.5;
const zoomImage = ref(null);
const position = ref({ x: 50, y: 50 });
const handleMouseMove = (event) => {
    updatePosition(event.clientX, event.clientY);
};
const handleTouchMove = (event) => {
    const touch = event.touches[0];
    if (touch) {
        updatePosition(touch.clientX, touch.clientY);
    }
};
const updatePosition = (clientX, clientY) => {
    const rect = zoomImage.value.getBoundingClientRect();
    const offsetX = clientX - rect.left;
    const offsetY = clientY - rect.top;

    const xPercent = (offsetX / rect.width) * 100;
    const yPercent = (offsetY / rect.height) * 100;

    position.value = { x: xPercent, y: yPercent };
};
const resetZoom = () => {
    position.value = { x: 50, y: 50 }; // Center image when the touch/mouse leaves
};
const imageStyle = computed(() => ({
    transform: `scale(${zoomScale})`,
    transformOrigin: `${position.value.x}% ${position.value.y}%`,
}));
const images = ref(props.product.images || []);
const showcaseIndex = ref(0);
function swapImage(index) {
    if (index !== showcaseIndex.value) {
        showcaseIndex.value = index;
    }
}
// MarkDown .....................................>>
const previewMarkDown = computed(() => {
    return DOMPurify.sanitize(marked(props.product.longDesc));
});

const previewMarkDownSortDsc = computed(() => {
    return DOMPurify.sanitize(marked(props.product.sortDesc));
});
// Handle product description
const activeTab = ref(0);
</script>
<template>
    <GuestLayout>
        <Card :productCount="cardItems" :totalPrice="totalPrice"
            ><cardproduct
                :cardProducts="addToCards"
                @cardProductDeleted="handleCardProductDeleted"
                @incrementedQuantity="handleIncrementedQuantity"
                @decrementedQuantity="handleDecrementedQuantity"
        /></Card>
        <div class="grid gap-6 md:grid-cols-2 mx-2 lg:mx-32">
            <!-- Image View-->
            <div class="grid w-full mx-auto gap-4">
                <!-- Showcase Image with Zoom Effect -->
                <div
                    class="overflow-hidden rounded-lg duration-500 relative border-2 border-blue-500"
                    @mousemove="handleMouseMove"
                    @mouseleave="resetZoom"
                    @touchmove="handleTouchMove"
                    @touchend="resetZoom"
                >
                    <img
                        ref="zoomImage"
                        :style="imageStyle"
                        class="h-auto max-w-full rounded-lg cursor-zoom-in transition-transform duration-500"
                        :src="`/upload/products/${images[showcaseIndex].image}`"
                        alt="Main Showcase Image"
                    />
                </div>
                <!-- Thumbnails with Click-to-Swap functionality -->
                <div class="grid grid-cols-3 gap-4">
                    <div v-for="(image, index) in images" :key="index">
                        <img
                            class="h-auto max-w-full rounded-lg cursor-pointer"
                            @click="swapImage(index)"
                            :src="`/upload/products/${image.image}`"
                            alt="Product Image"
                            :class="{
                                'border-2 border-blue-500':
                                    index === showcaseIndex,
                            }"
                        />
                    </div>
                </div>
            </div>
            <!-- Details View -->
            <div class="lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                <h2 class="text-sm title-font text-gray-500 tracking-widest">
                    শুটকির নাম
                </h2>
                <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">
                    {{ props.product.name }}
                </h1>
                <div class="flex mb-4">
                    <span class="flex items-center">
                        <svg
                            fill="currentColor"
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            class="w-4 h-4 text-slate-500"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"
                            ></path>
                        </svg>
                        <svg
                            fill="currentColor"
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            class="w-4 h-4 text-indigo-500"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"
                            ></path>
                        </svg>
                        <svg
                            fill="currentColor"
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            class="w-4 h-4 text-indigo-500"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"
                            ></path>
                        </svg>
                        <svg
                            fill="currentColor"
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            class="w-4 h-4 text-indigo-500"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"
                            ></path>
                        </svg>
                        <svg
                            fill="none"
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            class="w-4 h-4 text-indigo-500"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"
                            ></path>
                        </svg>
                        <span class="text-gray-600 ml-3">4 Reviews</span>
                    </span>
                    <span
                        class="flex ml-3 pl-3 py-2 border-l-2 border-gray-200 space-x-2s"
                    >
                        <a class="text-gray-500">
                            <svg
                                fill="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                class="w-5 h-5"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"
                                ></path>
                            </svg>
                        </a>
                        <a class="text-gray-500">
                            <svg
                                fill="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                class="w-5 h-5"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"
                                ></path>
                            </svg>
                        </a>
                        <a class="text-gray-500">
                            <svg
                                fill="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                class="w-5 h-5"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"
                                ></path>
                            </svg>
                        </a>
                    </span>
                </div>
                <p
                    v-html="previewMarkDownSortDsc"
                    class="leading-relaxed preview"
                ></p>
                <div
                    class="flex mt-6 items-center pb-5 border-b-2 border-gray-100 mb-5"
                >
                    <div class="flex items-center">
                        <span
                            class="text-3xl font-bold text-gray-900 dark:text-white"
                            >৳ {{ props.product.price }}
                        </span>
                        <span
                            class="bg-blue-100 text-blue-800 text-md font-semibold px-2.5 py-1.5 rounded dark:bg-blue-200 dark:text-blue-800 ms-3"
                            >{{ props.product.weight }}
                            {{ props.product.weightDesc }}</span
                        >
                    </div>
                </div>
                <div>
                    <!----------Initial add to card button-->
                    <div
                        v-if="!isProductInCart"
                        class="w-full text-center"
                        @click="handleAddToCardProduct(props.product)"
                    >
                        <button
                            class="w-full flex justify-center text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium text-sm lg:text-lg px-5 py-4 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
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
                            @click="handleDecrementedQuantity(product.id)"
                            class="w-12 py-4 border-r bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium text-sm lg:text-lg text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
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
                            @click="handleIncrementedQuantity(product.id)"
                            class="font-medium w-3/4 mx-auto text-center text-sm lg:text-lg cursor-pointer"
                        >
                            {{ productQuantityInCart }} টি ব্যাগে</span
                        >

                        <button
                            @click="handleIncrementedQuantity(product.id)"
                            class="w-12 py-4 border-l bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium text-sm lg:text-lg text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
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
        </div>
        <!-- Product Description -->

        <div
            class="mb-4 mx-2 lg:mx-32 border-b border-gray-200 dark:border-gray-700"
        >
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                <li class="me-2">
                    <button
                        @click="activeTab = 0"
                        :class="activeTab === 0 ? 'border-green-500' : ''"
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-green-500 dark:hover:text-gray-300"
                    >
                        Description
                    </button>
                </li>
                <li class="me-2">
                    <button
                        @click="activeTab = 1"
                        :class="activeTab === 1 ? 'border-green-500' : ''"
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-green-500 dark:hover:text-gray-300"
                    >
                        Dashboard
                    </button>
                </li>
                <li class="me-2">
                    <button
                        @click="activeTab = 2"
                        :class="activeTab === 2 ? 'border-green-500' : ''"
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-green-500 dark:hover:text-gray-300"
                    >
                        Settings
                    </button>
                </li>
            </ul>
        </div>
        <div class="mx-2 lg:mx-32 mb-4">
            <div
                v-html="previewMarkDown"
                :class="activeTab === 0 ? 'block' : 'hidden'"
                class="preview border p-4 mt-4 bg-gray-100 rounded-md"
            ></div>
            <div
                :class="activeTab === 1 ? 'block' : 'hidden'"
                class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
            >
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    This is some placeholder content the
                    <strong class="font-medium text-gray-800 dark:text-white"
                        >Dashboard tab's associated content</strong
                    >. Clicking another tab will toggle the visibility of this
                    one for the next. The tab JavaScript swaps classes to
                    control the content visibility and styling.
                </p>
            </div>
            <div
                :class="activeTab === 2 ? 'block' : 'hidden'"
                class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
            >
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    This is some placeholder content the
                    <strong class="font-medium text-gray-800 dark:text-white"
                        >Settings tab's associated content</strong
                    >. Clicking another tab will toggle the visibility of this
                    one for the next. The tab JavaScript swaps classes to
                    control the content visibility and styling.
                </p>
            </div>
        </div>
        <!------------- Related Products --------------------->
        <Productsection
            id="popular-shutki"
            :title="'রিলেটেড শুটকী'"
            :bg="'bg-purple-100 dark:bg-purple-900'"
        >
            <swiper
                :slidesPerView="4"
                :spaceBetween="30"
                :centeredSlides="true"
                :loop="true"
                :navigation="true"
                :modules="modules"
                :breakpoints="breakpoints"
                :autoplay="{
                    delay: 3500,
                    disableOnInteraction: true,
                }"
                class="mySwiper"
            >
                <swiper-slide
                    v-for="product in relatedProducts"
                    :key="product.id"
                >
                    <SliderItem
                        :product="product"
                        :cardProduct="addToCards"
                        @addedToCardProduct="handleAddToCardProduct"
                        @incrementedQuantity="handleIncrementedQuantity"
                        @decrementedQuantity="handleDecrementedQuantity"
                    />
                </swiper-slide>
            </swiper>
        </Productsection>
        <!------------- Related Products --------------------->

        <!------------- Buy Now Button in Footer ---------------------->
        <OrderNowButton :productCount="cardItems" />
    </GuestLayout>
</template>
