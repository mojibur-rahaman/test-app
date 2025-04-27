<script setup>
import { Link, router, usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import { debounce } from "lodash";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import PageFooter from "@/Components/PageFooter.vue";
const page = usePage();
const navOpen = ref(false);
const search = ref("");
watch(
    search,
    debounce(
        (q) =>
            router.get(
                route("user.search"),
                { query: q },
                { preserveState: true }
            ),
        500
    )
);
</script>
<template>
    <!--------- Header-------------->
    <header>
        <nav
            class="fixed top-0 z-[100] w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700"
        >
            <div
                class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto"
            >
                <!-------Home Page Link and Logo --------->
                <ApplicationLogo />
                <!-------Home Page Link and Logo --------->

                <!---- Product Searching -------->
                <div class="flex">
                    <button
                        @click="navOpen = !navOpen"
                        class="md:hidden text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 me-1"
                    >
                        <svg
                            class="w-5 h-5"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 20 20"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                            />
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                    <div
                        :class="{
                            'block md:block': true,
                            'hidden md:block': !navOpen,
                        }"
                        class="relative hidden md:block"
                    >
                        <div
                            class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none"
                        >
                            <svg
                                class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                                />
                            </svg>
                            <span class="sr-only">Search icon</span>
                        </div>
                        <input
                            v-model="search"
                            type="text"
                            class="block w-full p-2 ps-10 text-sm text-gray-900 border-2 border-green-600 focus:outline-none rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Search..."
                        />
                    </div>
                    <button
                        @click="navOpen = !navOpen"
                        class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 me-4"
                    >
                        <span class="sr-only">Open main menu</span>
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
                                d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25"
                            />
                        </svg>
                    </button>
                </div>
                <!---- Product Searching -------->

                <!----- Importent Link----------->
                <div
                    :class="{
                        hidden: !navOpen,
                    }"
                    class="items-center px-4 md:px-0 justify-between w-full md:flex md:w-auto md:order-1"
                >
                    <div
                        :class="{
                            'md:hidden': !navOpen,
                        }"
                        class="relative mt-3 md:hidden"
                    >
                        <div
                            class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none"
                        >
                            <svg
                                class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                                />
                            </svg>
                        </div>
                        <input
                            v-model="search"
                            type="text"
                            class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search..."
                        />
                    </div>

                    <ul
                        class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700"
                    >
                        <li>
                            <a
                                href="#"
                                class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500"
                                aria-current="page"
                                >Home</a
                            >
                        </li>
                        <li>
                            <a
                                href="#"
                                class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                                >About</a
                            >
                        </li>
                        <li>
                            <Link
                                v-if="page.props.auth.user"
                                as="button"
                                href="/logout"
                                class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                            >
                                Log Out</Link
                            >
                            <Link
                                v-else
                                as="button"
                                href="/login"
                                class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                                >Log In</Link
                            >
                        </li>
                    </ul>
                    <button
                        @click="navOpen = !navOpen"
                        class="w-[33%] h-6 absolute -bottom-6 block md:hidden left-[33%] mx-auto bg-red-400 rounded-br-full rounded-bl-full"
                    >
                        <svg
                            class="w-4 h-4 text-white rotate-90 mx-auto"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 6 10"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 1 1 5l4 4"
                            />
                        </svg>
                    </button>
                </div>
                <!----- Importent Link----------->
            </div>
        </nav>
    </header>
    <!--------- Header--------------->

    <!-------- Main Content --------->
    <main class="pt-20">
        <slot />
    </main>
    <!-------- Main Content --------->

    <!-------- Footer --------------->
    <PageFooter />
    <!-------- Footer --------------->
</template>
