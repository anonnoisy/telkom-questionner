<template>
    <app-layout>
        <template #header>
            <inertia-link
                class="text-indigo-400 hover:text-indigo-600"
                :href="route('respondents.index')"
                >Respondents</inertia-link
            >
            <span class="text-indigo-400 font-medium">/</span> Create
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded shadow overflow-hidden max-w-7xl">
                    <form @submit.prevent="submit">
                        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                            <text-input
                                v-model="form.first_name"
                                :error="errors.first_name"
                                class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Name"
                            />
                            <select-input
                                v-model="form.group_id"
                                :error="errors.group_id"
                                class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Group"
                            >
                                <option :value="null"/>
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
                            class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center"
                        >
                            <loading-button
                                :loading="sending"
                                class="btn-indigo"
                                type="submit"
                                >Create Respondent</loading-button
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

export default {
    metaInfo: { title: "Create Respondent" },
    components: {
        LoadingButton,
        SelectInput,
        TextInput,
        AppLayout
    },
    props: {
        errors: Object,
        groups: Array
    },
    remember: "form",
    data() {
        return {
            sending: false,
            form: {
                name: null,
                organization_id: null,
                email: null,
                phone: null,
                address: null,
                city: null,
                band: null,
                loaksi_kerja: null
            }
        };
    },
    methods: {
        submit() {
            this.$inertia.post(this.route("respondents.store"), this.form, {
                onStart: () => (this.sending = true),
                onFinish: () => (this.sending = false)
            });
        }
    }
};
</script>
