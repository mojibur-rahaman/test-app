<script setup>
import PaginateLinks from "@/Components/PaginateLinks.vue";
import OwnerLayout from "@/Layouts/OwnerLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
const props = defineProps({
    users: {
        type: Object,
        required: true,
    },
});
// Function to format date
const dateFormat = (dateString) => {
    if (!dateString) return "N/A"; // Handle null/undefined dates
    const date = new Date(dateString);
    return new Intl.DateTimeFormat("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
    }).format(date);
};

// User Role
const userRole = (role) => {
    switch (role) {
        case 0:
            return "Customer";
        case 1:
            return "Admin";
        case 2:
            return "Owner";
        default:
            return "Undifine User";
    }
};
</script>
<template>
    <Head title="শুটকিমার্ট" />
    <OwnerLayout>
        <!-- page titile-->
        <div
            class="flex bg-white px-4 py-2 shadow-lg justify-between items-center rounded-lg"
        >
            <h2 class="text-slate-700 text-2xl font-bold">Users</h2>
            <Link
                :href="route('owner.user.create')"
                as="button"
                type="button"
                class="bg-blue-400 flex text-white px-4 py-1.5 rounded-md"
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

                Add User
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
                        <th scope="col" class="px-16 py-3">
                            <span class="sr-only">Profile</span>
                        </th>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Mobile</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Since</th>
                        <th scope="col" class="px-6 py-3">Role</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="user in users.data"
                        :key="user.id"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                    >
                        <td class="p-4">
                            <img
                                class="w-8 h-8 mx-auto rounded-full"
                                src="/upload/asset/defult-image.jpg"
                                alt="user photo"
                            />
                        </td>
                        <td class="px-6 py-4">
                            {{ user.name ?? "user Name" }}
                        </td>
                        <td class="px-6 py-4">
                            {{ user.mobile }}
                        </td>
                        <td class="px-6 py-4">
                            {{ user.email ?? "example.com" }}
                        </td>
                        <td class="px-6 py-4">
                            {{ dateFormat(user.created_at) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ userRole(user.role) }}
                        </td>
                        <td class="px-6 flex justify-center items-center py-4">
                            <div
                                class="w-12 h-12 inline-flex items-center justify-center mx-1 text-blue-600 hover:text-white bg-white hover:bg-blue-300 border-gray-300 rounded-full cursor-pointer shadow"
                            >
                                <Link
                                    :href="
                                        route('owner.user.edit', {
                                            user_id: user.id,
                                        })
                                    "
                                    method="get"
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
            <PaginateLinks :paginator="users" />
        </div>
    </OwnerLayout>
</template>
