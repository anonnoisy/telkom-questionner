<template>
    <app-layout>
        <template #header>
            <h1 class="mb-8 font-bold text-3xl">
                <inertia-link
                    class="text-indigo-400 hover:text-indigo-600"
                    :href="route('groups.index')"
                    >Groups</inertia-link
                >
                <span class="text-indigo-400 font-medium">/</span>
                {{ form.name }}
            </h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <trashed-message
                    v-if="group.deleted_at"
                    class="mb-6"
                    @restore="restore"
                >
                    This group has been deleted.
                </trashed-message>
                <div class="bg-white rounded shadow overflow-hidden max-w-7xl">
                    <form @submit.prevent="submit">
                        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                            <text-input
                                v-model="form.name"
                                :error="errors.name"
                                class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Name"
                            />
                            <text-input
                                v-model="form.decription"
                                :error="errors.decription"
                                class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Decription"
                            />
                            <file-input
                                v-model="form.membersFile"
                                :error="errors.membersFile"
                                class="pr-6 pb-8 w-full lg:w-1/2"
                                type="file"
                                label="Member"
                            />
                        </div>
                        <div
                            class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center"
                        >
                            <button
                                v-if="!group.deleted_at"
                                class="text-red-600 hover:underline"
                                tabindex="-1"
                                type="button"
                                @click="destroy"
                            >
                                Delete group
                            </button>
                            <loading-button
                                :loading="sending"
                                class="btn-indigo ml-auto"
                                type="submit"
                                >Update group</loading-button
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
import TrashedMessage from "@/Shared/TrashedMessage";
import FileInput from "@/Shared/FileInput";

export default {
    metaInfo() {
        return {
            title: `${this.form.name}`
        };
    },
    components: {
        LoadingButton,
        SelectInput,
        TextInput,
        FileInput,
        TrashedMessage,
        AppLayout
    },
    props: {
        errors: Object,
        group: Object
    },
    remember: "form",
    data() {
        return {
            sending: false,
            form: {
                name: this.group.name,
                description: this.group.description,
                membersFile: null,
                members: this.group.respondents
            }
        };
    },
    methods: {
        submit() {
            this.$inertia.put(
                this.route("groups.update", this.group.id),
                this.form,
                {
                    onStart: () => (this.sending = true),
                    onFinish: () => (this.sending = false)
                }
            );
        },
        destroy() {
            if (confirm("Are you sure you want to delete this group?")) {
                this.$inertia.delete(
                    this.route("groups.destroy", this.group.id)
                );
            }
        }
    }
};
</script>
