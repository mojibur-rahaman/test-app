<script setup>
import PaginateLinks from "@/Components/PaginateLinks.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
const props = defineProps({
    results: {
        type: Object,
        required: true,
    },
    query: {
        type: String,
    },
    type: {
        type: String,
    },
});
// Function to format date
const dateFormat = (dateString) => {
    if (!dateString) return "N/A";
    const date = new Date(dateString);
    return new Intl.DateTimeFormat("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
    }).format(date);
};
// Status Indicators Color
const statusColor = (status) => {
    switch (status) {
        case "pending":
            return "bg-yellow-400"; // Yellow for pending
        case "processing":
            return "bg-blue-400"; // Blue for processing
        case "shift":
            return "bg-purple-400"; // Purple for shipped
        case "complete":
            return "bg-green-400"; // Green for complete
        case "cancel":
            return "bg-red-400"; // Red for canceled
        default:
            return "bg-gray-400"; // Gray for unknown status
    }
};
</script>
<template>
    <Head title="শুটকিমার্ট" />
    <AuthenticatedLayout>
        <!------------- Products Search Details----------------------->
        <div class="container mx-auto px-2 bg-slate-50 p-4 mb-4 text-center">
            <div class="max-w-sm mx-auto">
                <p class="text-xl text-gray-400">
                    Searching Results for : {{ query }} in {{ type }}
                </p>
            </div>
        </div>
        <!------------- Listing Searching Result Details------------------->
        <div
            v-if="results.data.length > 0"
            class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4"
        >
            <!-- Orders -->
            <div v-if="type === 'orders'">
                <div
                    class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4"
                >
                    <table
                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                        >
                            <tr>
                                <th scope="col" class="px-6 py-3">Id</th>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">Mobile</th>
                                <th scope="col" class="px-6 py-3">Address</th>
                                <th scope="col" class="px-6 py-3">
                                    Order Date
                                </th>
                                <th scope="col" class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="order in results.data"
                                :key="order.id"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                            >
                                <td class="px-6 py-4">#{{ order.id }}</td>
                                <td class="px-6 py-4">
                                    {{ order.name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ order.mobile }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ order.address }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ dateFormat(order.created_at) }}
                                </td>

                                <td
                                    class="px-6 flex justify-center items-center py-4"
                                >
                                    <span
                                        :class="[
                                            'w-3 h-3 me-3 rounded-full',
                                            statusColor(order.order_status),
                                        ]"
                                    ></span>
                                    <div
                                        class="w-12 h-12 inline-flex items-center justify-center mx-1 text-blue-600 hover:text-white bg-white hover:bg-blue-300 border-gray-300 rounded-full cursor-pointer shadow"
                                    >
                                        <Link
                                            :href="
                                                route('admin.order.edit', {
                                                    order_id: order.id,
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
                                        <Link
                                            href="#"
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
            </div>
            <!-- Products -->
            <div v-if="type === 'products'">
                <div
                    class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4"
                >
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
                                v-for="item in results.data"
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
                                            <span class="sr-only"
                                                >Quantity button</span
                                            >
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
                                            <span class="sr-only"
                                                >Quantity button</span
                                            >
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
                                <td
                                    class="px-6 flex justify-center items-center py-4"
                                >
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
                                        <Link
                                            href="#"
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
            </div>
            <!-- Users -->
            <div v-if="type === 'users'">
                <div
                    class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4"
                >
                    <table
                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                        >
                            <tr>
                                <th scope="col" class="px-16 py-3">
                                    <span class="sr-only">Profile</span>
                                </th>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">Mobile</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                                <th scope="col" class="px-6 py-3">Since</th>
                                <th scope="col" class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="customer in results.data"
                                :key="customer.id"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                            >
                                <td class="p-4">
                                    <img
                                        class="w-8 h-8 mx-auto rounded-full"
                                        src="/public/upload/asset/defult-image.jpg"
                                        alt="user photo"
                                    />
                                </td>
                                <td class="px-6 py-4">
                                    {{ customer.name ?? "Customer Name" }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ customer.mobile }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ customer.email ?? "example.com" }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ dateFormat(customer.created_at) }}
                                </td>
                                <td
                                    class="px-6 flex justify-center items-center py-4"
                                >
                                    <div
                                        class="w-12 h-12 inline-flex items-center justify-center mx-1 text-blue-600 hover:text-white bg-white hover:bg-blue-300 border-gray-300 rounded-full cursor-pointer shadow"
                                    >
                                        <Link
                                            :href="
                                                route('admin.customer.index')
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
                                        <Link
                                            href="#"
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
            </div>
            <!-- Pagination links -->
            <div class="my-3 px-4">
                <PaginateLinks :paginator="results" />
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
        </div>
    </AuthenticatedLayout>
</template>
