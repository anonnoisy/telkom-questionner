<template>
    <app-layout>
        <template #header>
            <inertia-link
                class="text-indigo-400 hover:text-indigo-600"
                :href="route('groups.index')"
                >Groups</inertia-link
            >
            <span class="text-indigo-400 font-medium">/</span> Create
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded shadow overflow-hidden max-w-7xl">
                    <form @submit.prevent="submit">
                        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                            <text-input
                                v-model="form.name"
                                :error="errors.name"
                                class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Group Name"
                            />
                            <text-input
                                v-model="form.decription"
                                :error="errors.decription"
                                class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Decription"
                            />
                            <file-input
                                v-model="form.members"
                                :error="errors.members"
                                class="pr-6 pb-8 w-full lg:w-1/2"
                                type="file"
                                label="Member"
                            />
                        </div>
                        <div
                            class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center"
                        >
                            <loading-button
                                :loading="sending"
                                class="btn-indigo"
                                type="submit"
                                >Create Group</loading-button
                            >
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import LoadingButton from "@/Shared/LoadingButton";
import SelectInput from "@/Shared/SelectInput";
import TextInput from "@/Shared/TextInput";
import FileInput from "@/Shared/FileInput";

export default {
    metaInfo: { title: "Edit Group" },
    components: {
        LoadingButton,
        SelectInput,
        TextInput,
        FileInput,
        AppLayout
    },
    props: {
        errors: Object,
        respondents: Array
    },
    remember: "form",
    data() {
        return {
            sending: false,
            form: {
                name: null,
                description: null,
                respondents: null,
                members: null
            }
        };
    },
    methods: {
        submit() {
            this.$inertia.post(this.route("groups.store"), this.form, {
                onStart: () => (this.sending = true),
                onFinish: () => (this.sending = false)
            });
        }
    }
};
</script>
