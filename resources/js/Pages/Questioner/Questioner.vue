<template>
    <div class="min-h-screen bg-gray-300">
        <div class="container mx-auto p-10 max-w-screen-lg">
            <div class="bg-white rounded shadow p-8">
                <div>
                    <h3 class="text-xl font-bold">{{ this.survey_name }} - {{ this.group_name }}</h3>
                    <p class="text-sm font-regular">{{ this.current_step + 1 }}/{{ this.survey.questions.length }}</p>
                    <div class="p-4">
                        <form @submit.prevent="submit">
                            <div v-for="(question, question_index) in this.survey.questions" :key="question.id">
                                <div v-if="current_step == question_index" class="w-full rounded mt-5 flex p-3 justify-between items-center flex-wrap">
                                    <div class="w-2/3">
                                        <h3 class="text-sm font-medium">{{ question.question }}</h3>

                                        <div v-if="question.question_types[0].type == 'C'">
                                            <div class="mt-3 pb-5">
                                                <div v-for="choice in question.question_choices" :key="choice.id">
                                                    <div class="bg-white rounded-md -space-y-px" >
                                                        <div class="relative border rounded-tl-md rounded-tr-md p-4 flex">
                                                            <div class="flex items-center h-5">
                                                                <input id="settings-option-0" x-ref="radio" :value="choice.choice" v-model="answer" name="privacy_setting" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 cursor-pointer border-gray-300" checked>
                                                            </div>
                                                            <label for="settings-option-0" class="ml-3 flex flex-col cursor-pointer">
                                                                <span class="block text-sm">
                                                                {{ choice.choice }}
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else>
                                            <p class="text-sm mt-3 mb-2">Text Answer</p>
                                            <textarea class="resize border rounded-md w-full" rows="3" v-model="answer"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex p-2 mt-4">
                                <button class="text-base hover:scale-110 focus:outline-none flex justify-center px-4 py-2 rounded font-bold cursor-pointer 
                                    hover:bg-gray-200  
                                    bg-gray-100 
                                    text-gray-700 
                                    border duration-200 ease-in-out 
                                    border-gray-600 transition"
                                    type="button"
                                    v-if="current_step > 0"
                                    @click="previousStep()">Previous
                                </button>
                                <div class="flex-auto flex flex-row-reverse">
                                    <button class="text-base  ml-2  hover:scale-110 focus:outline-none flex justify-center px-4 py-2 rounded font-bold cursor-pointer 
                                        hover:bg-purple-900  
                                        bg-purple-700
                                        text-purple-100 
                                        border duration-200 ease-in-out 
                                        border-purple-600 transition"
                                        type="button"
                                        v-if="current_step < this.survey.questions.length - 1"
                                        @click="nextStep()">Next
                                    </button>
                                    <loading-button
                                        v-if="current_step == this.survey.questions.length - 1"
                                        :loading="sending"
                                        class="btn-indigo"
                                        type="submit">Submit Quistionner
                                    </loading-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetCheckbox from '@/Jetstream/Checkbox'
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'
    import LoadingButton from "@/Shared/LoadingButton";

    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            LoadingButton
        },

        props: {
            survey_name: String,
            group_name: String,
            respondent: Object,
            survey: Object,
        },

        data() {
            return {
                sending: false,
                answer: null,
                current_step: 0,
                form: {
                    survey_name: this.survey_name,
                    group_name: this.group_name,
                    survey_id: this.survey.id,
                    respondent_id: this.respondent.id,
                    response_id: this.survey.responses[0].id,
                    questions: []
                }
            }
        },

        methods: {
            addAnswer() {
                if (this.form.questions[this.current_step] == undefined) {
                    this.form.questions.push({
                        question_id: this.survey.questions[this.current_step].id,
                        answer: this.answer
                    });
                }
                this.answer = null;
            },
            nextStep() {
                this.addAnswer();
                ++this.current_step;
            },
            previousStep() {
                --this.current_step;
                this.answer = this.form.questions[this.current_step].answer;
            },
            submit() {
                this.addAnswer();
                this.$inertia.post(this.route("questioner.finish"), this.form, {
                    onStart: () => (this.sending = true),
                    onFinish: () => (this.sending = false)
                });
            }
        }
    }
</script>
