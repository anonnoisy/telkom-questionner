<template>
    <app-layout>
        <template #header>
            <inertia-link
                class="text-indigo-400 hover:text-indigo-600"
                :href="route('surveys.index')"
                >Surveys</inertia-link
            >
            <span class="text-indigo-400 font-medium">/</span> Show
        </template>

        <div class="py-6">
            <div class="max-w-7xl w-full mx-auto py-4 sm:px-4 lg:px-8">
                <div class="flex flex-col lg:flex-row w-full lg:space-x-2 space-y-2 lg:space-y-0 mb-2 lg:mb-4">
                    <div class="w-full lg:w-1/4">
                        <div class="widget w-full p-4 rounded-lg bg-white border border-gray-100 dark:bg-gray-900 dark:border-gray-800">
                            <div class="flex flex-row items-center justify-between">
                                <div class="flex flex-col">
                                    <div class="text-xs uppercase font-light text-gray-500">
                                        Respondents
                                    </div>
                                    <div class="text-xl font-bold">
                                        {{ sumRespondents }}
                                    </div>
                                </div>
                                <svg class="stroke-current text-gray-500" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2">
                                    </path>
                                    <circle cx="9" cy="7" r="4">
                                    </circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87">
                                    </path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="w-full lg:w-1/4">
                        <div class="widget w-full p-4 rounded-lg bg-white border border-gray-100 dark:bg-gray-900 dark:border-gray-800">
                            <div class="flex flex-row items-center justify-between">
                                <div class="flex flex-col">
                                    <div class="text-xs uppercase font-light text-gray-500">
                                        On Going
                                    </div>
                                    <div class="text-xl font-bold">
                                        {{ sumOnGoing }}
                                    </div>
                                </div>
                                <svg class="stroke-current text-gray-500" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12">
                                    </polyline>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="w-full lg:w-1/4">
                        <div class="widget w-full p-4 rounded-lg bg-white border border-gray-100 dark:bg-gray-900 dark:border-gray-800">
                            <div class="flex flex-row items-center justify-between">
                                <div class="flex flex-col">
                                    <div class="text-xs uppercase font-light text-gray-500">
                                        Completed
                                    </div>
                                    <div class="text-xl font-bold">
                                        {{ sumCompleted }}
                                    </div>
                                </div>
                                <svg class="stroke-current text-gray-500" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6">
                                    </path>
                                    <polyline points="15 3 21 3 21 9">
                                    </polyline>
                                    <line x1="10" x2="21" y1="14" y2="3">
                                    </line>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="w-full lg:w-1/4">
                        <div class="widget w-full p-4 rounded-lg bg-white border border-gray-100 dark:bg-gray-900 dark:border-gray-800">
                            <div class="flex flex-row items-center justify-between">
                                <div class="flex flex-col">
                                    <div class="text-xs uppercase font-light text-gray-500">
                                        Uncompleted
                                    </div>
                                    <div class="text-xl font-bold">
                                        {{ sumUnCompleted }}
                                    </div>
                                </div>
                                <svg class="stroke-current text-gray-500" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="10">
                                    </circle>
                                    <polyline points="12 6 12 12 16 14">
                                    </polyline>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full">
                    <div class="widget w-full p-4 rounded-lg bg-white border border-gray-100 dark:bg-gray-900 dark:border-gray-800">
                        <!-- This example requires Tailwind CSS v2.0+ -->
                        <div class="flex flex-col">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Unit
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Respondents
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Completed
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Uncompleted
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Percentage
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <tr v-for="(respondent, unit) in this.respondents" :key="respondent.id">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="text-sm font-medium text-gray-900">{{ unit }}</div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ respondent.length }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ sumRespondentResponseByUnit(respondent) }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ sumRespondentResponseUncompleteByUnit }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-bold">{{ calculateRespondentCompletation() }}%</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
    metaInfo: { title: "Show Survey" },
    components: {
        LoadingButton,
        SelectInput,
        TextInput,
        AppLayout
    },
    props: {
        errors: Object,
        survey: Object,
        group: Object,
        respondents: Object,
        responses: Array,
    },
    data() {
        return {
            sumRespondentByUnit: 0,
            sumRespondentResponseCompleteByUnit: 0,
            sumRespondentResponseUncompleteByUnit: 0,
        };
    },
    computed: {
        sumRespondents: function () {
            let sumRespondent = 0;
            var result = Object.keys(this.respondents).map((key) => [
                this.respondents[key]
            ]);

            result.forEach((respondent) => {
                sumRespondent += respondent[0].length
            });

            return sumRespondent;
        },
        sumOnGoing: function () {
            let sumOnGoing = 0;

            this.responses.forEach((response) => {
                if (response.started_at != null && response.completed_at == null) {
                    sumOnGoing += 1;
                }
            });

            return sumOnGoing;
        },
        sumCompleted: function () {
            let completed = 0;

            this.responses.forEach((response) => {
                if (response.completed_at != null) {
                    completed += 1;
                }
            });

            return completed;
        },
        sumUnCompleted: function () {
            return this.sumRespondents - this.sumCompleted;
        },
    },
    methods: {
        sumRespondentResponseByUnit: function (respondents) {
            this.sumRespondentByUnit = respondents.length;
            let sumRespondentResponse = 0;
            respondents.forEach((respondent) => {
                respondent.responses.forEach((response) => {
                    if (response.completed_at != null) {
                        sumRespondentResponse += 1;
                    }
                });
            });

            this.sumRespondentResponseCompleteByUnit = sumRespondentResponse;
            this.sumRespondentResponseUncompleteByUnit = this.sumRespondentByUnit - sumRespondentResponse;
            return sumRespondentResponse;
        },
        calculateRespondentCompletation() {
            let percentage;
            percentage = this.sumRespondentResponseCompleteByUnit / this.sumRespondentByUnit * 100;
            return Math.round(percentage);
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
