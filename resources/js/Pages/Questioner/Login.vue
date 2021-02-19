<template>
    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>

        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <jet-label for="nik" value="NIK" />
                <jet-input
                    id="nik"
                    type="number"
                    class="mt-1 block w-full py-1 pl-1"
                    v-model="form.nik"
                    required
                    autofocus
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <inertia-link
                    :href="this.create_url"
                    class="underline text-sm text-gray-600 hover:text-gray-900"
                >
                    Participant Register
                </inertia-link>

                <jet-button
                    class="ml-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Start Questioner
                </jet-button>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
import JetAuthenticationCard from "@/Jetstream/AuthenticationCard";
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo";
import JetButton from "@/Jetstream/Button";
import JetInput from "@/Jetstream/Input";
import JetCheckbox from "@/Jetstream/Checkbox";
import JetLabel from "@/Jetstream/Label";
import JetValidationErrors from "@/Jetstream/ValidationErrors";

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
        create_url: String
    },

    data() {
        return {
            registerUrl: this.create_url,
            form: this.$inertia.form({
                nik: null,
                survey_name: this.survey_name,
                group_name: this.group_name
            })
        };
    },

    methods: {
        submit() {
            this.form.post(this.route("questioner.start"), {
                onStart: () => (this.sending = true),
                onFinish: () => (this.sending = false)
            });
        }
    }
};
</script>
