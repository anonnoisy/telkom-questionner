<template>
    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>

        <jet-validation-errors class="mb-4" />

        <div class="mb-4 font-medium text-sm">
            Participant Register
        </div>

        <form @submit.prevent="submit">
            <div>
                <jet-label for="nik" value="NIK" />
                <jet-input id="nik" type="number" class="mt-1 block w-full py-1 pl-1" v-model="form.nik" required autofocus />
            </div>
            <div class="mt-3">
                <select-input
                    v-model="form.unit_id"
                    :error="errors.unit_id"
                    label="Unit"
                >
                    <option :value="null">Select Unit</option>
                    <option
                        v-for="unit in units"
                        :key="unit.id"
                        :value="unit.id"
                        >{{ unit.name }}</option
                    >
                </select-input>
            </div>

            <div class="flex items-center justify-end mt-4">
                <inertia-link :href="this.create_url" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Back to login
                </inertia-link>

                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register & Start Quistioner
                </jet-button>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetCheckbox from '@/Jetstream/Checkbox'
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'
    import SelectInput from "@/Shared/SelectInput"

    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            SelectInput,
            JetValidationErrors
        },

        props: {
            errors: Object,
            survey_name: String,
            group_name: String,
            units: Array,
            create_url: String,
        },

        data() {
            return {
                form: this.$inertia.form({
                    nik: null,
                    unit_id: null,
                    survey_name: this.survey_name,
                    group_name: this.group_name,
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('questioner.register-start'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    }
</script>
