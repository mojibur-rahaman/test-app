<script setup>
import { ref } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import OwnerLayout from "@/Layouts/OwnerLayout.vue";
const modelOpen = ref(false);
let removeBannerId;
const inputModelOpen = ref(false);
const props = defineProps({
    mobileBanners: {
        type: Object,
        required: true,
    },
    desktopBanners: {
        type: Object,
        required: true,
    },
});
const previewUrl = ref(null);
const form = useForm({
    image: null,
    placement: "mobile",
});
const handleFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.image = file;
        previewUrl.value = URL.createObjectURL(file);
    }
};
const addBanner = () => {
    form.post(route("owner.asset.index"), {
        forceFormData: true,
        onSuccess: () => {
            inputModelOpen.value = !inputModelOpen.value;
        },
    });
};

const confirmRemoveBanner = (id) => {
    modelOpen.value = true;
    removeBannerId = id;
};
const removeBanner = () => {
    router.delete(route("owner.asset.remove"), {
        data: {
            bannerId: removeBannerId,
        },
    });
    modelOpen.value = false;
};
</script>
<template>
    <OwnerLayout>
        <!-- page titile-->
        <div
            class="flex bg-white px-4 py-2 shadow-lg justify-between items-center rounded-lg"
        >
            <h2 class="text-slate-700 text-2xl font-bold">App Assets</h2>
            <button
                @click="inputModelOpen = !inputModelOpen"
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
                Add Assets
            </button>
        </div>
        <!-- Desktop View -->
        <div class="grid grid-cols-2 mt-4 md:grid-cols-3 gap-4">
            <div
                v-for="desktopBanner in desktopBanners"
                :key="desktopBanner.id"
                class="relative group"
            >
                <img
                    class="h-auto max-w-full rounded-lg"
                    :src="`/upload/asset/${desktopBanner.image}`"
                    alt=""
                />
                <div
                    @click="confirmRemoveBanner(desktopBanner.id)"
                    class="absolute block lg:hidden group-hover:block bg-red-500 text-white rounded bottom-4 right-2 h-6 w-6"
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
                            d="M6 18 18 6M6 6l12 12"
                        />
                    </svg>
                </div>
            </div>
        </div>
        <!-- Mobile View-->
        <div class="grid grid-cols-2 mt-4 md:grid-cols-3 gap-4">
            <div
                v-for="mobileBanner in mobileBanners"
                :key="mobileBanner.id"
                class="relative group"
            >
                <img
                    class="h-auto max-w-full rounded-lg"
                    :src="`/upload/asset/${mobileBanner.image}`"
                    alt=""
                />
                <div
                    @click="confirmRemoveBanner(mobileBanner.id)"
                    class="absolute block lg:hidden group-hover:block bg-red-500 text-white rounded bottom-4 right-2 h-6 w-6"
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
                            d="M6 18 18 6M6 6l12 12"
                        />
                    </svg>
                </div>
            </div>
        </div>

        <!--- Modal popup-->
        <div
            :class="modelOpen ? 'block' : 'hidden'"
            class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full bg-gray-400/50 md:inset-0 h-[calc(100%-1rem)] max-h-full"
        >
            <div class="relative p-4 w-full max-w-md max-h-full mx-auto mt-20">
                <div
                    class="relative bg-white rounded-lg opacity-100 shadow-sm dark:bg-gray-700"
                >
                    <button
                        @click="modelOpen = !modelOpen"
                        class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    >
                        <svg
                            class="w-3 h-3"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 14 14"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                            />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-4 md:p-5 text-center">
                        <svg
                            class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
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
                                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                            />
                        </svg>
                        <h3
                            class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400"
                        >
                            Are you sure you want to delete this app welcome
                            banner?
                        </h3>
                        <button
                            @click="removeBanner"
                            type="button"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center"
                        >
                            Yes, I'm sure
                        </button>
                        <button
                            @click="modelOpen = !modelOpen"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                        >
                            No, cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!--- Modal inputfile-->
        <div
            :class="inputModelOpen ? 'block' : 'hidden'"
            class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full bg-gray-400/50 md:inset-0 h-[calc(100%-1rem)] max-h-full"
        >
            <div class="relative p-4 w-full max-w-md max-h-full mx-auto mt-20">
                <!-- Modal content -->
                <div
                    class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700"
                >
                    <!-- Modal header -->
                    <div
                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200"
                    >
                        <h3
                            class="text-xl font-semibold text-gray-900 dark:text-white"
                        >
                            Add App Welcome Banner
                        </h3>
                        <button
                            @click="inputModelOpen = !inputModelOpen"
                            class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        >
                            <svg
                                class="w-3 h-3"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 14 14"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                                />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <form @submit.prevent="addBanner" class="space-y-4">
                            <div>
                                <div
                                    class="flex items-center justify-center w-full"
                                >
                                    <label
                                        for="dropzone-file"
                                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"
                                    >
                                        <div
                                            class="flex flex-col items-center justify-center pt-5 pb-6"
                                        >
                                            <svg
                                                class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                                                aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 20 16"
                                            >
                                                <path
                                                    stroke="currentColor"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"
                                                />
                                            </svg>
                                            <p
                                                class="mb-2 text-sm text-gray-500 dark:text-gray-400"
                                            >
                                                <span class="font-semibold"
                                                    >Click to upload</span
                                                >
                                                or drag and drop
                                            </p>
                                            <p
                                                class="text-xs text-gray-500 dark:text-gray-400"
                                            >
                                                SVG, PNG, JPG or GIF (MAX.
                                                800x400px)
                                            </p>
                                        </div>
                                        <input
                                            @change="handleFileChange"
                                            id="dropzone-file"
                                            type="file"
                                            class="hidden"
                                        />
                                    </label>
                                </div>
                                <small
                                    class="text-sm font-medium text-red-600"
                                    v-if="form.errors.image"
                                    >{{ form.errors.image }}</small
                                >
                            </div>
                            <!-- Placement Banner -->
                            <div class="flex gap-2">
                                <div
                                    class="flex items-center w-1/2 ps-4 border border-gray-200 rounded-sm dark:border-gray-700"
                                >
                                    <input
                                        v-model="form.placement"
                                        id="bordered-radio-1"
                                        type="radio"
                                        value="mobile"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                    />
                                    <label
                                        for="bordered-radio-1"
                                        class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                    >
                                        Mobile View
                                    </label>
                                </div>
                                <div
                                    class="flex items-center w-1/2 ps-4 border border-gray-200 rounded-sm dark:border-gray-700"
                                >
                                    <input
                                        v-model="form.placement"
                                        id="bordered-radio-2"
                                        type="radio"
                                        value="desktop"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                    />
                                    <label
                                        for="bordered-radio-2"
                                        class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                    >
                                        Desktop View
                                    </label>
                                </div>
                            </div>

                            <!-- Banner Preview -->
                            <div class="relative group w-1/2 mx-auto">
                                <img
                                    :src="previewUrl"
                                    class="h-auto max-w-full rounded-lg cursor-pointer"
                                    alt="App Welcome Banner"
                                />
                                <div
                                    class="absolute block lg:hidden group-hover:block bg-red-500 text-white rounded bottom-0 right-0 h-6 w-6 ..."
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
                                            d="M6 18 18 6M6 6l12 12"
                                        />
                                    </svg>
                                </div>
                            </div>
                            <!-- Banner Preview -->
                            <button
                                type="submit"
                                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                            >
                                Upload Banner
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </OwnerLayout>
</template>
