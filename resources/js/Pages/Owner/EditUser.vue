<script setup>
import InputBox from "@/Components/InputBox.vue";
import InputSelect from "@/Components/InputSelect.vue";
import OwnerLayout from "@/Layouts/OwnerLayout.vue";
import { Link, useForm, Head } from "@inertiajs/vue3";
const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});
const form = useForm({
    name: props.user.name,
    email: props.user.email,
    role: props.user.role,
});
const updateUserRole = () => {
    form.post(route("owner.user.edit", { user_id: props.user.id }), {
        onSuccess: () => form.reset(),
    });
};
</script>
<template>
    <Head title="শুটকিমার্ট" />
    <OwnerLayout>
        <!-- page titile-->
        <div
            class="flex bg-white px-4 py-2 shadow-lg justify-between items-center rounded-lg"
        >
            <h2 class="text-slate-700 text-2xl font-bold">Update User</h2>
            <Link
                :href="route('owner.user.index')"
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
            <form @submit.prevent="updateUserRole">
                <!-- Products Details -->
                <div class="grid gap-6 mb-6 md:grid-cols-2 pt-4">
                    <InputBox
                        v-model="form.name"
                        label="User Name"
                        type="text"
                        placeholder="Jhon Doe"
                        :message="form.errors.name"
                    />
                    <InputBox
                        v-model="form.email"
                        label="Enter Email"
                        type="email"
                        placeholder="Enter Your Email"
                        :message="form.errors.email"
                    />
                    <InputSelect v-model="form.role" label="Select User Role">
                        <option selected>Default User Role Is Customer</option>
                        <option value="0">Customer</option>
                        <option value="1">Admin</option>
                        <option value="2">Owner</option>
                    </InputSelect>
                </div>

                <button
                    type="submit"
                    class="text-white bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-800"
                >
                    Submit
                </button>
                <!-- Products Details -->
            </form>
        </div>
    </OwnerLayout>
</template>
