<script setup>
import { debounce } from "lodash";
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
const search = ref("");
const tableName = ref("products");
watch(
    search,
    debounce(
        (q) =>
            router.get(
                "/admin/search",
                { query: q, t: tableName.value },
                { preserveState: true }
            ),
        500
    )
);

const selectInputOpen = ref(false);
const manageTable = (table) => {
    tableName.value = table;
    selectInputOpen.value = false;
};
</script>
<template>
    <form class="max-w-lg mx-auto">
        <div class="flex">
            <button
                @click="selectInputOpen = !selectInputOpen"
                class="shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
                type="button"
            >
                {{ tableName }}
                <svg
                    class="w-2.5 h-2.5 ms-2.5"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 10 6"
                >
                    <path
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m1 1 4 4 4-4"
                    />
                </svg>
            </button>

            <div
                :class="selectInputOpen ? 'block' : 'hidden'"
                class="z-10 absolute mt-12 bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700"
            >
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                    <li>
                        <button
                            @click="manageTable('products')"
                            type="button"
                            class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                        >
                            Products
                        </button>
                    </li>
                    <li>
                        <button
                            @click="manageTable('orders')"
                            type="button"
                            class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                        >
                            Orders
                        </button>
                    </li>
                    <li>
                        <button
                            @click="manageTable('users')"
                            type="button"
                            class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                        >
                            Users
                        </button>
                    </li>
                </ul>
            </div>

            <div class="relative w-full">
                <input
                    v-model="search"
                    type="search"
                    class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                    placeholder="Search Products, Orders, Customers ..."
                    required
                />
            </div>
        </div>
    </form>
</template>
