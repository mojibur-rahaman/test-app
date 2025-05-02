<script setup>
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import InputBox from "../../Components/InputBox.vue";
import InputCheckBox from "../../Components/InputCheckBox.vue";
import InputSelect from "../../Components/InputSelect.vue";
import TextArea from "../../Components/TextArea.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { marked } from "marked";
import DOMPurify from "dompurify";
import { ref, computed } from "vue";
const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});
const form = useForm({
    backendImages: [],
    productImages: props.product.images.map((image) => ({
        id: `existing-${image.id}`,
        file: `/upload/products/${image.image}`,
        existing: true,
    })),
    previewImages: props.product.images.map((image) => ({
        id: `existing-${image.id}`,
        file: `/upload/products/${image.image}`,
    })),
    deletedImagesIds: [],
    productName: props.product.name,
    englishName: props.product.en_name,
    slug: props.product.slug,
    productPrice: props.product.price,
    productWeight: props.product.weight,
    productWeightDesc: props.product.weightDesc,
    productCategory: props.product.category,
    productMaxQuantity: props.product.maxQuantity,
    metaTitle: props.product.metaTitle,
    metaKeyword: props.product.metaKeyword,
    metaDescription: props.product.metaDescription,
    productSortDesc: props.product.sortDesc,
    productLongDesc: props.product.longDesc,
    productStatus: props.product.status === 1 ? true : 0,
});
const updateProduct = () => {
    form.post(
        route("admin.products.update", { product_id: props.product.id }),
        {
            onSuccess: () => form.reset(),
        }
    );
};

const selectImageHandler = (e) => {
    const selectedFiles = Array.from(e.target.files);
    // Check if the total number of images will exceed 3
    if (form.productImages.length + selectedFiles.length > 3) {
        alert("You can only select up to 3 images.");
        return;
    }
    const imagesWithIds = selectedFiles.map((file, index) => {
        return {
            id: `image-${form.productImages.length + index}`, // Generate a unique ID
            file: file,
        };
    });
    form.backendImages = [...form.backendImages, ...imagesWithIds];
    form.productImages = [...form.productImages, ...imagesWithIds];
    // Generate previews
    preview();
};
const preview = () => {
    form.previewImages = form.productImages.map((image) => {
        if (image.existing) {
            return { id: image.id, file: image.file }; // Use existing image URL
        }
        return { id: image.id, file: URL.createObjectURL(image.file) }; // Use blob for new images
    });
    console.log(form.backendImages);
};
const deleteImage = (id) => {
    form.productImages = form.productImages.filter((image) => image.id !== id);
    form.backendImages = form.backendImages.filter((image) => image.id !== id);
    const exist = id.split("-");
    if (exist[0] === "existing") {
        deleteImageId(exist[1]);
    }
    preview();
};
const deleteImageId = (id) => {
    form.deletedImagesIds.push(id);
};
// MarkDown Code
const markdown = ref("");

const previewMarkDown = computed(() => {
    return DOMPurify.sanitize(marked(markdown.value));
});

const insertText = (text) => {
    form.productLongDesc += text;
    markdown.value = form.productLongDesc;
};
const addText = () => {
    markdown.value = form.productLongDesc;
};
</script>
<template>
    <AuthenticatedLayout>
        <!-- page titile-->
        <div
            class="flex bg-white px-4 py-2 shadow-lg justify-between items-center rounded-lg"
        >
            <h2 class="text-slate-700 text-2xl font-bold">Add Products</h2>
            <Link
                :href="route('admin.products.index')"
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
        <!-- product form -->
        <div class="mt-4 bg-white rounded-lg shadow-lg p-4">
            <form @submit.prevent="updateProduct">
                <!-- Image -->
                <div class="grid md:grid-cols-2 gap-4">
                    <div
                        class="flex items-center justify-center w-full md:w-1/2 mx-auto"
                    >
                        <label
                            for="dropzone-file"
                            class="flex flex-col items-center justify-center w-full h-28 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"
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
                                    SVG, PNG, JPG or GIF (MAX. 800x400px)
                                </p>
                            </div>
                            <input
                                id="dropzone-file"
                                @input="selectImageHandler"
                                type="file"
                                class="hidden"
                                multiple
                            />
                            <small
                                class="text-sm font-medium text-red-600"
                                v-if="form.errors.productImages"
                                >{{ form.errors.productImages }}</small
                            >
                        </label>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div
                            v-for="image in form.previewImages"
                            :key="image.id"
                            class="relative group"
                        >
                            <img
                                :src="image.file"
                                class="h-auto max-w-full rounded-lg cursor-pointer"
                                alt="Product Image"
                            />
                            <div
                                @click="deleteImage(image.id)"
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
                    </div>
                </div>
                <!-- Image -->

                <!-- Products Details -->
                <div class="grid gap-6 mb-6 md:grid-cols-2 pt-4">
                    <InputBox
                        v-model="form.productName"
                        label="Product Name"
                        type="text"
                        placeholder="Product Name"
                        :message="form.errors.productName"
                    />
                    <InputBox
                        v-model="form.englishName"
                        label="Product English Name"
                        type="text"
                        placeholder="Product English Name"
                        :message="form.errors.productName"
                    />
                    <InputBox
                        v-model="form.slug"
                        label="English Slug Name"
                        type="text"
                        placeholder="Enter English Slug Name"
                        :message="form.errors.slug"
                    />
                    <InputBox
                        v-model="form.productPrice"
                        label="Price"
                        type="text"
                        placeholder="Product Price"
                        :message="form.errors.productPrice"
                    />
                    <InputBox
                        v-model="form.productWeight"
                        label="Weight"
                        type="text"
                        placeholder="Product Weight..."
                        :message="form.errors.productWeight"
                    />

                    <InputSelect
                        v-model="form.productWeightDesc"
                        label="Select Weight Desc..."
                    >
                        <option selected>Weight Description</option>
                        <option value="kg">Kg</option>
                        <option value="gm">Gm</option>
                        <option value="pcs">Pcs</option>
                        <option value="ltr">Ltr</option>
                        <option value="Item">item</option>
                    </InputSelect>

                    <InputSelect
                        v-model="form.productCategory"
                        label="Select Category"
                    >
                        <option value="NA" selected>Choose a category</option>
                        <option value="NA">New Arrival</option>
                        <option value="MP">Most Popular</option>
                        <option value="PK">Package</option>
                    </InputSelect>

                    <InputSelect
                        v-model="form.productMaxQuantity"
                        label="Max Purcess Quantity"
                    >
                        <option selected>Max Purcess Quantity</option>
                        <option value="1">One</option>
                        <option value="3">Three</option>
                        <option value="5">Five</option>
                        <option value="7">Seven</option>
                        <option value="10">Ten</option>
                    </InputSelect>
                    <InputBox
                        v-model="form.metaTitle"
                        label="Meta Title"
                        type="text"
                        placeholder="meta titile"
                        :message="form.errors.metaTitle"
                    />
                    <InputBox
                        v-model="form.metaKeyword"
                        label="Meta Keyword"
                        type="text"
                        placeholder="meta keyword"
                        :message="form.errors.metaKeyword"
                    />
                </div>
                <TextArea
                    v-model="form.metaDescription"
                    :rows="'2'"
                    label="Meta Description"
                    placeholder="Product sort description..."
                    :message="form.errors.metaDescription"
                />
                <TextArea
                    v-model="form.productSortDesc"
                    :rows="'4'"
                    label="Sort Description"
                    placeholder="Product sort description..."
                    :message="form.errors.productSortDesc"
                />
                <!-- MarkDown-->
                <div
                    class="markdown-editor p-4 mb-4 bg-white shadow-md rounded-lg"
                >
                    <div class="toolbar flex flex-wrap gap-2 mb-4">
                        <span class="btn" @click="insertText('**bold**')">
                            b
                        </span>
                        <span class="btn" @click="insertText('_italic_')">
                            i
                        </span>
                        <span class="btn" @click="insertText('# h1')">h1</span>
                        <span class="btn" @click="insertText('\n')">br</span>
                        <span
                            class="btn"
                            @click="insertText('~~strikethrough~~')"
                        >
                            St
                        </span>
                        <span
                            class="btn"
                            @click="insertText('<u>underline</u>')"
                        >
                            un
                        </span>
                        <span
                            class="btn"
                            @click="
                                insertText('[Link text](https://example.com)')
                            "
                        >
                            l
                        </span>
                        <span
                            class="btn"
                            @click="insertText('\n1. Item 1\n2. Item 2\n')"
                        >
                            ol
                        </span>
                        <span
                            class="btn"
                            @click="insertText('\n- Item 1\n- Item 2\n')"
                        >
                            ul
                        </span>
                        <span
                            class="btn"
                            @click="
                                insertText(
                                    '\n| Header | Header |\n|--------|--------|\n| Data   | Data   |\n'
                                )
                            "
                        >
                            tb
                        </span>
                        <span
                            class="btn"
                            @click="insertText('![Alt text](image-url)')"
                        >
                            im
                        </span>
                    </div>
                    <!-- Textarea-->
                    <TextArea
                        v-model="form.productLongDesc"
                        :rows="'6'"
                        label="Long Description"
                        placeholder="Product long description..."
                        :message="form.errors.productLongDesc"
                        @keyup="addText"
                    />
                    <div
                        class="preview border p-4 mt-4 bg-gray-100 rounded-md"
                        v-html="previewMarkDown"
                    ></div>
                </div>
                <!--MarkDown-->

                <InputCheckBox
                    v-model="form.productStatus"
                    title="Active Product"
                />
                <button
                    type="submit"
                    class="text-white bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-800"
                >
                    Submit
                </button>
                <!-- Products Details -->
            </form>
        </div>
    </AuthenticatedLayout>
</template>
