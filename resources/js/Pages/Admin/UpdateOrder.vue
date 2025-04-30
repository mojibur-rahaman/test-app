<script setup>
import InputSelect from "@/Components/InputSelect.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
const props = defineProps({
    order: {
        type: Object,
        required: true,
    },
});
const form = useForm({ orderStatus: props.order.order_status });
const statusColor = (status) => {
    switch (status) {
        case "pending":
            return "bg-yellow-400";
        case "processing": // Fixed typo
            return "bg-blue-400";
        case "shift":
            return "bg-purple-400";
        case "complete":
            return "bg-green-400";
        case "cancel":
            return "bg-red-400";
        default:
            return "bg-gray-400";
    }
};

const updateOrderStatus = () => {
    form.put(
        route("admin.order.update", { order_id: props.order.id }),
        { status: form.orderStatus },
        {
            preserveScroll: true,
            onSuccess: () => console.log("Order status updated!"),
        }
    );
};
</script>

<template>
    <AuthenticatedLayout>
        <div
            class="flex bg-white px-4 py-2 shadow-lg justify-between items-center rounded-lg"
        >
            <h2 class="text-slate-700 text-2xl font-bold">
                Manage Order ({{ order.id }})
            </h2>
            <Link
                :href="route('admin.order.index')"
                as="button"
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
        <!-- Product Details -->
        <div class="flex flex-col lg:flex-row">
            <div
                class="relative overflow-x-auto shadow-md sm:rounded-lg lg:w-3/4 mt-4"
            >
                <table class="w-full text-sm text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-16 py-3">
                                <span class="sr-only">Image</span>
                            </th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Quantity</th>
                            <th scope="col" class="px-6 py-3">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in order.items"
                            :key="item.id"
                            class="bg-white border-b hover:bg-gray-50"
                        >
                            <td class="px-6 py-4">
                                <img
                                    :src="`/upload/products/${item.product.images[0].image}`"
                                    class="w-16 md:w-32 max-w-full max-h-full rounded-lg"
                                    alt="product Image"
                                />
                            </td>
                            <td class="px-6 py-4">{{ item.product.name }}</td>
                            <td class="px-6 py-4">{{ item.qty }}</td>
                            <td class="px-6 py-4">
                                ৳ {{ item.product.price }}
                            </td>
                        </tr>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4">Sub Total</td>
                            <td class="px-6 py-4">{{ order.total - 120 }}</td>
                        </tr>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4 col-span-3">
                                Delivery Charge
                            </td>
                            <td class="px-6 py-4">120</td>
                        </tr>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4 font-bold text-slate-700">
                                Total
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-700">
                                {{ order.total }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="lg:w-1/4 bg-white mt-4 shadow-lg rounded lg:mx-4">
                <span class="flex justify-center items-center my-3">
                    <span
                        :class="[
                            'w-3 h-3 me-3 rounded-full',
                            statusColor(order.order_status),
                        ]"
                    ></span>
                    <span>{{ order.order_status }}</span>
                </span>

                <div class="mt-4 bg-white p-4">
                    <form @submit.prevent="updateOrderStatus">
                        <InputSelect
                            v-model="form.orderStatus"
                            label="Select Order Status"
                        >
                            <option selected>{{ order.order_status }}</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shift">Shift</option>
                            <option value="complete">Complete</option>
                            <option value="cancel">Cancel</option>
                        </InputSelect>
                        <button
                            type="submit"
                            class="text-white mt-3 bg-slate-700 hover:bg-slate-800 focus:ring-4 font-medium rounded-lg w-full px-5 py-2.5 text-sm"
                        >
                            Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
