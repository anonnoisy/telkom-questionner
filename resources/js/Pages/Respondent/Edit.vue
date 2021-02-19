<template>
    <app-layout>
        <template #header>
            <h1 class="mb-8 font-bold text-3xl">
                <inertia-link
                    class="text-indigo-400 hover:text-indigo-600"
                    :href="route('respondents.index')"
                    >Respondents</inertia-link
                >
                <span class="text-indigo-400 font-medium">/</span>
                {{ form.name }}
            </h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <trashed-message
                    v-if="respondent.deleted_at"
                    class="mb-6"
                    @restore="restore"
                >
                    This respondent has been deleted.
                </trashed-message>
                <div class="bg-white rounded shadow overflow-hidden max-w-7xl">
                    <form @submit.prevent="submit">
                        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                            <text-input
                                v-model="form.name"
                                :error="errors.name"
                                class="pr-6 pb-8 w-full lg:w-1/2"
                                label="First name"
                            />
                            <select-input
                                v-model="form.group_id"
                                :error="errors.group_id"
                                class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Group"
                            >
                                <option :value="null" />
                                <option
                                    v-for="group in groups"
                                    :key="group.id"
                                    :value="group.id"
                                    >{{ group.name }}</option
                                >
                            </select-input>
                            <text-input
                                v-model="form.nik"
                                :error="errors.nik"
                                class="pr-6 pb-8 w-full lg:w-1/2"
                                label="NIK"
                            />
                            <text-input
                                v-model="form.objid_posisi"
                                :error="errors.objid_posisi"
                                class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Objid Posisi"
                            />
                            <text-input
                                v-model="form.jabatan"
                                :error="errors.jabatan"
                                class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Jabatan"
                            />
                            <text-input
                                v-model="form.band"
                                :error="errors.band"
                                class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Band"
                            />
                            <text-input
                                v-model="form.loaksi_kerja"
                                :error="errors.loaksi_kerja"
                                class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Lokasi Kerja"
                            />
                            <text-input
                                v-model="form.sub_unit"
                                :error="errors.sub_unit"
                                class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Sub Unit"
                            />
                            <text-input
                                v-model="form.unit"
                                :error="errors.unit"
                                class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Unit"
                            />
                        </div>
                        <div
                            class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center"
                        >
                            <button
                                v-if="!respondent.deleted_at"
                                class="text-red-600 hover:underline"
                                tabindex="-1"
                                type="button"
                                @click="destroy"
                            >
                                Delete Respondent
                            </button>
                            <loading-button
                                :loading="sending"
                                class="btn-indigo ml-auto"
                                type="submit"
                                >Update Respondent</loading-button
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
        TrashedMessage,
        AppLayout
    },
    props: {
        errors: Object,
        groups: Array,
        respondent: Object
    },
    remember: "form",
    data() {
        return {
            sending: false,
            form: {
                name: this.respondent.name,
                group_id: this.respondent.groups[0].id,
                nik: this.respondent.nik,
                objid_posisi: this.respondent.objid_posisi,
                jabatan: this.respondent.jabatan,
                band: this.respondent.band,
                loaksi_kerja: this.respondent.loaksi_kerja,
                sub_unit: this.respondent.sub_unit,
                unit: this.respondent.unit
            }
        };
    },
    methods: {
        submit() {
            this.$inertia.put(
                this.route("respondents.update", this.respondent.id),
                this.form,
                {
                    onStart: () => (this.sending = true),
                    onFinish: () => (this.sending = false)
                }
            );
        },
        destroy() {
            if (confirm("Are you sure you want to delete this respondent?")) {
                this.$inertia.delete(
                    this.route("respondents.destroy", this.respondent.id)
                );
            }
        },
        restore() {
            if (confirm("Are you sure you want to restore this respondent?")) {
                this.$inertia.put(
                    this.route("respondents.restore", this.respondent.id)
                );
            }
        }
    }
};
</script>
