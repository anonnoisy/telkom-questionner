<template>
    <app-layout>
        <template #header>
            <inertia-link
                class="text-indigo-400 hover:text-indigo-600"
                :href="route('surveys.index')"
                >Surveys</inertia-link
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
                                label="Survey Name"
                            />
                            <select-input
                                v-model="form.is_private"
                                :error="errors.is_private"
                                class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Type"
                            >
                                <option :value="false">Public</option>
                                <option :value="true">Private</option>
                            </select-input>
                            <div
                                v-if="form.is_private == true"
                                class="pr-6 pb-8 w-full lg:w-1/2"
                            >
                                <select-input
                                    v-model="form.group_id"
                                    :error="errors.group_id"
                                    label="Group"
                                >
                                    <option :value="null">Select group</option>
                                    <option
                                        v-for="group in groups"
                                        :key="group.id"
                                        :value="group.id"
                                        >{{ group.name }}</option
                                    >
                                </select-input>
                            </div>
                        </div>

                        <div class="hidden sm:block" aria-hidden="true">
                            <div class="py-5">
                                <div class="border-t border-gray-200"></div>
                            </div>
                        </div>

                        <div class="pl-8 pr-8 pb-8 -mr-4">
                            <h2
                                class="font-semibold text-xl text-gray-800 leading-tight mb-4"
                            >
                                Survey Questions
                            </h2>
                            <div class="flex flex-col">
                                <div
                                    class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8"
                                >
                                    <div
                                        class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
                                    >
                                        <div
                                            class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"
                                        >
                                            <table
                                                class="min-w-full divide-y divide-gray-200"
                                            >
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th
                                                            scope="col"
                                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                                        >
                                                            Setup Questioner
                                                        </th>
                                                        <th
                                                            scope="col"
                                                            class="relative px-6 py-3"
                                                        ></th>
                                                    </tr>
                                                </thead>
                                                <tbody
                                                    class="bg-white divide-y divide-gray-200"
                                                >
                                                    <tr
                                                        v-for="(question,
                                                        questionIndex) in form.questions"
                                                        :key="question.id"
                                                        class="flex"
                                                    >
                                                        <td
                                                            class="px-6 py-4 flex-1"
                                                        >
                                                            <div
                                                                class="text-sm text-gray-500"
                                                            >
                                                                <text-input
                                                                    v-model="
                                                                        question.question
                                                                    "
                                                                    class="w-full pb-2"
                                                                />
                                                            </div>
                                                            <div
                                                                class="flex items-center"
                                                            >
                                                                <select-input
                                                                    v-model="
                                                                        question.type
                                                                    "
                                                                >
                                                                    <option
                                                                        :value="
                                                                            'C'
                                                                        "
                                                                        >Choice
                                                                        answers</option
                                                                    >
                                                                    <option
                                                                        :value="
                                                                            'T'
                                                                        "
                                                                        >Text
                                                                        answer</option
                                                                    >
                                                                </select-input>
                                                            </div>
                                                            <div
                                                                v-if="
                                                                    question.type ==
                                                                        'C'
                                                                "
                                                                class="w-full max-w-screen-xl mx-auto"
                                                            >
                                                                <div
                                                                    class="flex justify-start pb-2 pt-4"
                                                                >
                                                                    <div
                                                                        class="w-full max-w-lg"
                                                                    >
                                                                        <div
                                                                            class="block text-gray-700 text-sm font-semibold"
                                                                        >
                                                                            Choice
                                                                            answers
                                                                        </div>
                                                                        <div
                                                                            v-for="(choice,
                                                                            choiceIndex) in question.choices"
                                                                            :key="
                                                                                choice.id
                                                                            "
                                                                            class="text-sm"
                                                                        >
                                                                            <div
                                                                                class="flex justify-start text-gray-700 py-2 my-2"
                                                                            >
                                                                                <div
                                                                                    class="w-10 mr-3"
                                                                                >
                                                                                    <text-input
                                                                                        v-model="
                                                                                            choice.alpha_choice
                                                                                        "
                                                                                        class="w-full pb-2"
                                                                                    />
                                                                                </div>
                                                                                <div
                                                                                    class="flex-grow"
                                                                                >
                                                                                    <text-input
                                                                                        v-model="
                                                                                            choice.choice
                                                                                        "
                                                                                        class="w-full"
                                                                                    />
                                                                                </div>
                                                                                <div
                                                                                    v-if="
                                                                                        question
                                                                                            .choices
                                                                                            .length >
                                                                                            1
                                                                                    "
                                                                                    class="text-sm font-normal text-gray-500 tracking-wide"
                                                                                >
                                                                                    <button
                                                                                        type="button"
                                                                                        class="inline-flex justify-center ml-2 py-3 px-3 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:bg-red-500"
                                                                                        @click="
                                                                                            removeChoice(
                                                                                                questionIndex,
                                                                                                choiceIndex
                                                                                            )
                                                                                        "
                                                                                    >
                                                                                        <font-awesome-icon
                                                                                            icon="trash"
                                                                                        />
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <button
                                                                            type="button"
                                                                            class="inline-flex justify-center py-2 px-3 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:bg-indigo-500"
                                                                            @click="
                                                                                addChoice(
                                                                                    questionIndex
                                                                                )
                                                                            "
                                                                        >
                                                                            <font-awesome-icon
                                                                                icon="plus"
                                                                            />
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td
                                                            v-if="
                                                                questionIndex >
                                                                    0
                                                            "
                                                            class="flex-none px-2 py-4 text-center text-sm font-medium"
                                                        >
                                                            <button
                                                                type="button"
                                                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:bg-red-500"
                                                                @click="
                                                                    removeQuestion(
                                                                        questionIndex
                                                                    )
                                                                "
                                                            >
                                                                Remove Question
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button
                                class="btn-indigo mt-2"
                                type="button"
                                @click="addQuestion()"
                            >
                                Add Question
                            </button>
                        </div>

                        <div
                            class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center"
                        >
                            <loading-button
                                :loading="sending"
                                class="btn-indigo"
                                type="submit"
                                >Create Survey</loading-button
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
    metaInfo: { title: "Create Survey" },
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
            questionId: 1,
            form: {
                name: null,
                is_private: false,
                questions: [
                    {
                        id: 1,
                        question: null,
                        type: null,
                        error: null,
                        choices: [
                            {
                                id: 1,
                                alpha_choice: null,
                                choice: null
                            }
                        ]
                    }
                ]
            }
        };
    },
    methods: {
        addQuestion() {
            this.form.questions.push({
                id: ++this.questionId,
                question: null,
                type: "T",
                choices: [
                    {
                        id: 1,
                        alpha_choice: null,
                        choice: null
                    }
                ]
            });
        },
        removeQuestion(questionIndex) {
            this.form.questions.splice(questionIndex, 1);
            --this.questionId;
        },
        addChoice(questionIndex) {
            let choicesLastIndex = this.form.questions[questionIndex].choices
                .length;
            this.form.questions[questionIndex].choices.push({
                id: ++choicesLastIndex,
                aplpha_choice: null,
                choice: null
            });
        },
        removeChoice(questionIndex, choiceIndex) {
            this.form.questions[questionIndex].choices.splice(choiceIndex, 1);
        },
        submit() {
            this.$inertia.post(this.route("surveys.store"), this.form, {
                onStart: () => (this.sending = true),
                onFinish: () => (this.sending = false)
            });
        }
    }
};
</script>
