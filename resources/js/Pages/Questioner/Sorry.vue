<template>
    <div class="min-h-screen bg-gray-300">
        <div class="container mx-auto p-10 max-w-screen-lg">
            <div class="bg-white rounded shadow p-8">
                <div>
                    <h3 class="text-xl font-bold">{{ this.survey_name }} - {{ this.group_name }}</h3>
                    <div class="p-4">
                        <div class="w-2/3">
                            <h3 class="text-sm font-medium">You have finished the questionner.</h3>
                            <h3 class="text-md font-medium">See you!</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            survey_name: String,
            group_name: String
        },
    }
</script>
