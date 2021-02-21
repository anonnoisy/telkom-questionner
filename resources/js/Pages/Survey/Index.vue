<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Surveys
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-6 flex justify-between items-center">
                    <search-filter
                        v-model="form.search"
                        class="w-full max-w-md mr-4"
                        @reset="reset"
                    >
                    </search-filter>
                    <inertia-link
                        class="btn-indigo"
                        :href="route('surveys.create')"
                    >
                        <span>Create</span>
                        <span class="hidden md:inline">Survey</span>
                    </inertia-link>
                </div>
                <div class="bg-white rounded shadow overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <tr class="text-left font-bold">
                            <th class="px-6 pt-6 pb-4">Name</th>
                            <th class="px-6 pt-6 pb-4">Type</th>
                            <th class="px-6 pt-6 pb-4">
                                Opening & Closing Time
                            </th>
                        </tr>
                        <tr
                            v-for="survey in surveys.data"
                            :key="survey.id"
                            class="hover:bg-gray-100 focus-within:bg-gray-100"
                        >
                            <td class="border-t">
                                <inertia-link
                                    class="px-6 py-4 flex items-center focus:text-indigo-500"
                                    :href="route('surveys.show', survey.id)"
                                >
                                    {{ survey.name }}
                                    <icon
                                        v-if="survey.deleted_at"
                                        name="trash"
                                        class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2"
                                    />
                                </inertia-link>
                            </td>
                            <td class="border-t">
                                <inertia-link
                                    class="px-6 py-4 flex items-center"
                                    :href="route('surveys.show', survey.id)"
                                    tabindex="-1"
                                >
                                    {{
                                        survey.is_private ? "Private" : "Public"
                                    }}
                                </inertia-link>
                            </td>
                            <td class="border-t">
                                <inertia-link
                                    class="px-6 py-4 flex items-center"
                                    :href="route('surveys.show', survey.id)"
                                    tabindex="-1"
                                >
                                    {{ survey.opening_time == null ? "Always Open" : survey.opening_time }}
                                </inertia-link>
                            </td>
                            <td class="border-t w-px">
                                <inertia-link
                                    class="px-4 flex items-center"
                                    :href="route('surveys.show', survey.id)"
                                    tabindex="-1"
                                >
                                    <icon
                                        name="cheveron-right"
                                        class="block w-6 h-6 fill-gray-400"
                                    />
                                </inertia-link>
                            </td>
                        </tr>
                        <tr v-if="surveys.data.length === 0">
                            <td class="border-t px-6 py-4" colspan="4">
                                No surveys found.
                            </td>
                        </tr>
                    </table>
                </div>
                <pagination :links="surveys.links" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import Icon from "@/Shared/Icon";
import AppLayout from "@/Layouts/AppLayout";
import mapValues from "lodash/mapValues";
import Pagination from "@/Shared/Pagination";
import pickBy from "lodash/pickBy";
import SearchFilter from "@/Shared/SearchFilter";
import throttle from "lodash/throttle";

export default {
    metaInfo: { title: "Surveys" },
    components: {
        Icon,
        Pagination,
        SearchFilter,
        AppLayout
    },
    props: {
        surveys: Object,
        filters: Object
    },
    data() {
        return {
            form: {
                search: this.filters.search
            }
        };
    },
    watch: {
        form: {
            handler: throttle(function() {
                let query = pickBy(this.form);
                this.$inertia.replace(
                    this.route(
                        "surveys",
                        Object.keys(query).length
                            ? query
                            : { remember: "forget" }
                    )
                );
            }, 150),
            deep: true
        }
    },
    methods: {
        reset() {
            this.form = mapValues(this.form, () => null);
        }
    }
};
</script>
