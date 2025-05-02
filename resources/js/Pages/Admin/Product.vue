<script setup>
import { ref, computed, defineProps } from "vue";
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import PaginateLinks from "../../Components/PaginateLinks.vue";
import { Link, Head } from "@inertiajs/vue3";
const props = defineProps({
    products: {
        type: Object,
        required: true,
    },
});

const originalProducts = ref(props.products.data); // keep untouched data
const allProducts = ref([...originalProducts.value]); // filtered list

const activeProducts = () => {
    allProducts.value = originalProducts.value.filter(
        (product) => product.status === 1
    );
};

const deactiveProducts = () => {
    allProducts.value = originalProducts.value.filter(
        (product) => product.status === 0
    );
};

const abilableProducts = () => {
    allProducts.value = [...originalProducts.value]; // restore all
};
</script>
<template>
    <Head title="শুটকিমার্ট" />
    <AuthenticatedLayout>
        <!-- page title-->
        <div
            class="flex bg-white px-4 py-2 shadow-lg justify-between items-center rounded-lg"
        >
            <h2 class="text-slate-700 text-2xl font-bold">Products</h2>
            <div class="flex justify-end me-4">
                <div class="flex flex-wrap">
                    <div class="flex items-center me-4">
                        <input
                            @click="abilableProducts"
                            checked
                            id="red-radio"
                            type="radio"
                            value=""
                            name="colored-radio"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                        />
                        <label
                            for="red-radio"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                            >All</label
                        >
                    </div>
                    <div class="flex items-center me-4">
                        <input
                            @click="activeProducts"
                            id="green-radio"
                            type="radio"
                            value=""
                            name="colored-radio"
                            class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                        />
                        <label
                            for="green-radio"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                            >Active</label
                        >
                    </div>
                    <div class="flex items-center me-4">
                        <input
                            @click="deactiveProducts"
                            id="purple-radio"
                            type="radio"
                            value=""
                            name="colored-radio"
                            class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                        />
                        <label
                            for="purple-radio"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                            >Deactive</label
                        >
                    </div>
                </div>
            </div>
            <Link
                :href="route('admin.products.create')"
                as="button"
                type="button"
                class="flex bg-blue-400 text-white px-4 py-2 rounded-md"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4.5v15m7.5-7.5h-15"
                    />
                </svg>

                Add Product
            </Link>
        </div>
        <!-- product List show -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            >
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="px-16 py-3">
                            <span class="sr-only">Image</span>
                        </th>
                        <th scope="col" class="px-6 py-3">Product</th>
                        <th scope="col" class="px-6 py-3">Qty</th>
                        <th scope="col" class="px-6 py-3">Price</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="item in allProducts"
                        :key="item.id"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                    >
                        <td class="p-4">
                            <img
                                :src="`/upload/products/${item.images[0].image}`"
                                class="w-16 md:w-32 max-w-full max-h-full rounded-lg"
                                alt="product Image"
                            />
                        </td>
                        <td
                            class="px-6 py-4 font-semibold text-gray-900 dark:text-white"
                        >
                            {{ item.name }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <button
                                    class="inline-flex items-center justify-center p-1 me-3 text-sm font-medium h-6 w-6 text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                    type="button"
                                >
                                    <span class="sr-only">Quantity button</span>
                                    <svg
                                        class="w-3 h-3"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 18 2"
                                    >
                                        <path
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M1 1h16"
                                        />
                                    </svg>
                                </button>
                                <div>
                                    <input
                                        type="number"
                                        id="first_product"
                                        class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="1"
                                        required
                                    />
                                </div>
                                <button
                                    class="inline-flex items-center justify-center h-6 w-6 p-1 ms-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                    type="button"
                                >
                                    <span class="sr-only">Quantity button</span>
                                    <svg
                                        class="w-3 h-3"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 18 18"
                                    >
                                        <path
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 1v16M1 9h16"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td
                            class="px-6 py-4 font-semibold text-gray-900 dark:text-white"
                        >
                            ${{ item.price }}
                        </td>
                        <td class="px-6 flex justify-center items-center py-4">
                            <span
                                class="flex w-3 h-3 me-3 rounded-full"
                                :class="
                                    item.status == '1'
                                        ? 'bg-green-600'
                                        : 'bg-red-600'
                                "
                            ></span>
                            <div
                                class="w-12 h-12 inline-flex items-center justify-center mx-1 text-blue-600 hover:text-white bg-white hover:bg-blue-300 border-gray-300 rounded-full cursor-pointer shadow"
                            >
                                <Link
                                    :href="
                                        route('admin.products.edit', {
                                            product_id: item.id,
                                        })
                                    "
                                    method="get"
                                    as="button"
                                    class="font-medium"
                                    ><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="size-6"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42"
                                        />
                                    </svg>
                                </Link>
                            </div>
                            <div
                                class="w-12 h-12 inline-flex items-center justify-center mx-1 text-red-600 hover:text-white bg-white hover:bg-red-300 border-gray-300 rounded-full cursor-pointer shadow"
                            >
                                <Link href="#" as="button" class="font-medium"
                                    ><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="size-6"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                        />
                                    </svg>
                                </Link>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Pagination links -->
        <div class="my-3 px-4">
            <PaginateLinks :paginator="products" />
        </div>
    </AuthenticatedLayout>
</template>
