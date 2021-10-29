<template>
    <v-container class="filter-wrapper" fluid>
        <h5 class="mt-3 mb-3">Statuses:</h5>
        <v-layout row class="">
            <v-flex xs2 v-for="(type, index) in statuses"
                    :key="`filter-${index}`">
                <v-checkbox
                    v-model="selected"
                    :label="type"
                    :value="`status-${index}`"
                ></v-checkbox>
            </v-flex>
        </v-layout>
        <h5 class="mt-3 mb-3">Operating System:</h5>
        <v-layout row class="">
            <v-flex xs2 v-for="(type, index) in os"
                    :key="`filter-${index}`">
                <v-checkbox
                    v-model="selected"
                    :label="type"
                    :value="`os-${type}`"
                ></v-checkbox>
            </v-flex>
        </v-layout>

    </v-container>
</template>
<script>

export default {
    data() {
        return {
            selected: null,
            filters: {},
            statuses: {
                0: 'Pending',
                1: 'Resolved',
            },
            os: [
                'Mac',
                'Windows',
                'Linux',
            ],
            filterBy: {}
        }
    },
    watch: {
        selected: function (newValue, oldValue) {
            if (newValue && newValue.includes("-")) {
                let filter = newValue.split('-')[0];
                let value = newValue.split('-')[1];
                this.setFilterBy(filter, value)
            } else {
                this.setFilterBy()
            }
        },
    },
    methods: {
        setFilterBy(key = null, value = null) {

            if (!this.selected) {
                this.filterBy = {};
            } else {
                this.filterBy[key] = value;
            }
            this.filter()

        },
        filter() {
            this.$emit('sendFilteredData', this.filterBy);
        }
    }
}
</script>
