<script setup>
import { ref } from "vue";
import { Link, Head } from "@inertiajs/vue3";
import PaginateLinks from "@/Components/PaginateLinks.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
const props = defineProps({
    orders: {
        type: Object,
        required: true,
    },
});
// keep untouched data
const originalOrders = ref(props.orders.data);
// filtered list
const allOrders = ref([...originalOrders.value]);
const abilableOrders = () => {
    allOrders.value = [...originalOrders.value];
};
const pendingOrders = () => {
    allOrders.value = originalOrders.value.filter(
        (order) => order.order_status === "pending"
    );
};
const processingOrders = () => {
    allOrders.value = originalOrders.value.filter(
        (order) => order.order_status === "processing"
    );
};
const shipedOrders = () => {
    allOrders.value = originalOrders.value.filter(
        (order) => order.order_status === "shift"
    );
};
const completedOrders = () => {
    allOrders.value = originalOrders.value.filter(
        (order) => order.order_status === "complete"
    );
};
const canceledOrders = () => {
    allOrders.value = originalOrders.value.filter(
        (order) => order.order_status === "cancel"
    );
};
// Function to format date
const dateFormat = (dateString) => {
    if (!dateString) return "N/A"; // Handle null/undefined dates
    const date = new Date(dateString);
    return new Intl.DateTimeFormat("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
        weekday: "long",
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
        <!-- page titile-->
        <div
            class="flex bg-white px-4 py-2 shadow-lg justify-between items-center rounded-lg"
        >
            <h2 class="text-slate-700 text-2xl font-bold">Orders</h2>
            <div class="flex flex-wrap">
                <div class="flex items-center me-4">
                    <input
                        @click="abilableOrders"
                        checked
                        id="all-radio"
                        type="radio"
                        value=""
                        name="colored-radio"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    />
                    <label
                        for="all-radio"
                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                        >All</label
                    >
                </div>
                <div class="flex items-center me-4">
                    <input
                        @click="pendingOrders"
                        id="yellow-radio"
                        type="radio"
                        value=""
                        name="colored-radio"
                        class="w-4 h-4 text-yellow-600 bg-gray-100 border-gray-300 focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    />
                    <label
                        for="yellow-radio"
                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                        >Pending</label
                    >
                </div>
                <div class="flex items-center me-4">
                    <input
                        @click="processingOrders"
                        id="blue-radio"
                        type="radio"
                        value=""
                        name="colored-radio"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    />
                    <label
                        for="blue-radio"
                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                        >Processing</label
                    >
                </div>
                <div class="flex items-center me-4">
                    <input
                        @click="shipedOrders"
                        id="purple-radio"
                        type="radio"
                        value=""
                        name="colored-radio"
                        class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    />
                    <label
                        for="purple-radio"
                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                        >Shiped</label
                    >
                </div>
                <div class="flex items-center me-4">
                    <input
                        @click="completedOrders"
                        id="green-radio"
                        type="radio"
                        value=""
                        name="colored-radio"
                        class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    />
                    <label
                        for="green-radio"
                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                        >Completed</label
                    >
                </div>
                <div class="flex items-center me-4">
                    <input
                        @click="canceledOrders"
                        id="red-radio"
                        type="radio"
                        value=""
                        name="colored-radio"
                        class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    />
                    <label
                        for="red-radio"
                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                        >Canceled</label
                    >
                </div>
            </div>
            <Link
                :href="route('admin.dashboard')"
                as="button"
                type="button"
                class="bg-red-400 flex text-white px-4 py-1.5 rounded-md"
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
                        d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"
                    />
                </svg>
                Back
            </Link>
        </div>

        <!-- Customers List show -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
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
                        <th scope="col" class="px-6 py-3">Order Date</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="order in allOrders"
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

                        <td class="px-6 flex justify-center items-center py-4">
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
            <PaginateLinks :paginator="orders" />
        </div>
    </AuthenticatedLayout>
</template>
