<template>
    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>

        <jet-validation-errors class="mb-4" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            Participant Register
        </div>

        <form @submit.prevent="submit">
            <div>
                <jet-label for="nik" value="NIK" />
                <jet-input id="nik" type="number" class="mt-1 block w-full py-1 pl-1" v-model="form.nik" required autofocus />
            </div>
            <div class="mt-3">
                <jet-label for="phone" value="No Telepon" />
                <jet-input id="phone" type="number" class="mt-1 block w-full py-1 pl-1" v-model="form.phone" required autofocus />
            </div>
            <div class="mt-3">
                <jet-label for="unit" value="Unit" />
                <jet-input id="unit" type="text" class="mt-1 block w-full py-1 pl-1" v-model="form.unit" required autofocus />
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

    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors
        },

        props: {
            survey_name: String,
            group_name: String,
            create_url: String,
        },

        data() {
            return {
                form: this.$inertia.form({
                    nik: null,
                    phone: null,
                    unit: null,
                    survey_name: this.survey_name,
                    groupe_name: this.groupe_name,
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('questioner.register'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    }
</script>
