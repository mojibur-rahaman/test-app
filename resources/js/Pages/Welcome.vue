<script setup>
import { computed, onMounted, ref, defineProps } from "vue";
import Card from "@/Components/Card.vue";
import Cardproduct from "@/Components/Cardproduct.vue";
import Productnavigation from "@/Components/Productnavigation.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/navigation";
import { Navigation, Autoplay } from "swiper/modules";
import ImageGallery from "@/Components/ImageGallery.vue";
import Productsection from "@/Components/Productsection.vue";
import OrderNowButton from "@/Components/OrderNowButton.vue";
import SliderItem from "@/Components/SliderItem.vue";
const props = defineProps({
    mobileBanners: {
        type: Object,
        required: true,
    },
    desktopBanners: {
        type: Object,
        required: true,
    },
    pk_products: {
        type: Object,
        required: true,
    },
    na_products: {
        type: Object,
        required: true,
    },
    mp_products: {
        type: Object,
        required: true,
    },
    bs_products: {
        type: Object,
        required: true,
    },
    mix_products: {
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
        slidesPerView: 3,
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
// passing product on sliderIems
const pk_products = [...props.pk_products];
const mp_products = [...props.mp_products];
const bs_products = [...props.bs_products];
const na_products = [...props.na_products];
const mix_products = [...props.mix_products];
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
        <meta name="robots" content="index, follow" />
        <link rel="canonical" href="https://shutkimart.com/" />

        <!-- Open Graph (Facebook & others) -->
        <meta
            property="og:title"
            content="ShutkiMart - অর্গানিক শুটকির বিশ্বস্ত ঠিকানা"
        />
        <meta
            property="og:description"
            content="স্বাস্থ্যকর, কেমিকেল মুক্ত ও প্রিমিয়াম মানের শুটকি কিনুন এখনই ShutkiMart থেকে।"
        />
        <meta
            property="og:image"
            content="https://shutkimart.com/images/og-image.png"
        />
        <meta property="og:url" content="https://shutkimart.com" />
        <meta property="og:type" content="website" />

        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta
            name="twitter:title"
            content="ShutkiMart - অর্গানিক শুটকির বিশ্বস্ত ঠিকানা"
        />
        <meta
            name="twitter:description"
            content="স্বাস্থ্যকর, কেমিকেল মুক্ত ও প্রিমিয়াম মানের শুটকি কিনুন এখনই ShutkiMart থেকে।"
        />
        <meta
            name="twitter:image"
            content="https://shutkimart.com/upload/asset/og-image.jpg"
        />
    </Head>
    <GuestLayout>
        <Card
            :cardProducts="addToCards"
            :productCount="cardItems"
            :totalPrice="totalPrice"
            ><Cardproduct
                :cardProducts="addToCards"
                @cardProductDeleted="handleCardProductDeleted"
                @incrementedQuantity="handleIncrementedQuantity"
                @decrementedQuantity="handleDecrementedQuantity"
        /></Card>
        <!-------------- Image Gallery------------------------>
        <ImageGallery :desktopBanners :mobileBanners />
        <!-------------- Image Gallery------------------------>

        <!------------- Products Navigation------------------->
        <Productnavigation />
        <!------------- Products Navigation------------------->

        <!------------- Package Program ---------------------->
        <productsection
            id="package-shutki"
            :title="'শুটকীর প্যাকেজ'"
            :bg="'bg-green-100 dark:bg-green-900'"
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
                    delay: 5000,
                    disableOnInteraction: false,
                }"
                class="mySwiper"
            >
                <swiper-slide
                    v-for="pk_product in pk_products"
                    :key="pk_product.id"
                >
                    <SliderItem
                        :product="pk_product"
                        :cardProduct="addToCards"
                        @addedToCardProduct="handleAddToCardProduct"
                        @incrementedQuantity="handleIncrementedQuantity"
                        @decrementedQuantity="handleDecrementedQuantity"
                    />
                </swiper-slide>
            </swiper>
        </productsection>
        <!------------- Package Program ---------------------->

        <!------------- Popular Products --------------------->
        <productsection
            id="best-selling-shutki"
            :title="'পপুলার শুটকী'"
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
                    v-for="mp_product in mp_products"
                    :key="mp_product.id"
                >
                    <slider-item
                        :product="mp_product"
                        :cardProduct="addToCards"
                        @addedToCardProduct="handleAddToCardProduct"
                        @incrementedQuantity="handleIncrementedQuantity"
                        @decrementedQuantity="handleDecrementedQuantity"
                    />
                </swiper-slide>
            </swiper>
        </productsection>

        <!------------- Popular Products --------------------->

        <!------------- Best Selling Products ---------------->
        <productsection
            id="popular-shutki"
            :title="'বেস্ট সেলিং শুটকী'"
            :bg="'bg-red-100 dark:bg-red-900'"
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
                    delay: 2500,
                    disableOnInteraction: false,
                }"
                class="mySwiper"
            >
                <swiper-slide
                    v-for="bs_product in bs_products"
                    :key="bs_product.id"
                >
                    <slider-item
                        :product="bs_product"
                        :cardProduct="addToCards"
                        @addedToCardProduct="handleAddToCardProduct"
                        @incrementedQuantity="handleIncrementedQuantity"
                        @decrementedQuantity="handleDecrementedQuantity"
                    />
                </swiper-slide>
            </swiper>
        </productsection>
        <!------------- Best Selling Products ---------------->

        <!------------- New Arrivle Products ---------------->
        <productsection
            id="new-arrivle-shutki"
            :title="'নতুন শুটকী'"
            :bg="'bg-green-100 dark:bg-red-900'"
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
                    delay: 2500,
                    disableOnInteraction: false,
                }"
                class="mySwiper"
            >
                <swiper-slide
                    v-for="na_product in na_products"
                    :key="na_product.id"
                >
                    <slider-item
                        :product="na_product"
                        :cardProduct="addToCards"
                        @addedToCardProduct="handleAddToCardProduct"
                        @incrementedQuantity="handleIncrementedQuantity"
                        @decrementedQuantity="handleDecrementedQuantity"
                    />
                </swiper-slide>
            </swiper>
        </productsection>
        <!------------- New Arrivle Products ---------------->

        <!------------- dynamic Package Program ---------------------->
        <productsection
            id="all-shutki"
            :bg="'bg-blue-100'"
            :title="'এক নজরে সকল শুটকি '"
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
                    delay: 2500,
                    disableOnInteraction: false,
                }"
                class="mySwiper"
            >
                <swiper-slide
                    v-for="mix_product in mix_products"
                    :key="mix_product.id"
                >
                    <slider-item
                        :product="mix_product"
                        :cardProduct="addToCards"
                        @addedToCardProduct="handleAddToCardProduct"
                        @incrementedQuantity="handleIncrementedQuantity"
                        @decrementedQuantity="handleDecrementedQuantity"
                    />
                </swiper-slide>
            </swiper>
        </productsection>
        <!------------- dynamic Package Program ---------------------->

        <!------------- Buy Now Button in Footer ---------------------->
        <OrderNowButton
            :cardProducts="addToCards"
            :productCount="cardItems"
            :totalPrice="totalPrice"
        />
    </GuestLayout>
</template>
