<template>
    <v-container class="pa-0">
        <v-form
            ref="form"
            v-model="valid"
            lazy-validation
        >
            <v-container>
                <v-layout row wrap>
                    <v-flex
                        xs12
                        md12>
                        <v-text-field
                            v-model="first_name"
                            :rules="nameRules"
                            label="First Name">
                        </v-text-field>
                        <v-text-field
                            v-model="last_name"
                            :rules="nameRules"
                            label="Last Name">
                        </v-text-field>
                        <vue-google-autocomplete
                            ref="google_address"
                            id="map"
                            classname="form-control"
                            placeholder="Look up your address"
                            label="Address look up"
                            v-on:placechanged="getAddressData"
                            country="gb"
                            autocomplete="chrome-off"
                            :rules="fieldRequired"
                        >
                        </vue-google-autocomplete>
                        <v-text-field
                            v-model="address"
                            :rules="fieldRequired"
                            label="Or manually type your Address"
                        >
                        </v-text-field>
                        <v-select
                            v-model="uni_year"
                            :items="years"
                            label="University Year"
                            :rules="fieldRequired"
                        ></v-select>

                        <v-text-field
                            v-model="degree"
                            label="Degree"
                            :rules="fieldRequired"
                        >
                        </v-text-field>
                        <v-select
                            v-model="os"
                            :items="osList"
                            label="Operating System"
                            :rules="fieldRequired"
                        ></v-select>

                        <v-textarea
                            v-model="issue"
                            label="Issue"
                            :rules="fieldRequired"
                        >
                        </v-textarea>

                    </v-flex>
                    <v-flex
                        xs12
                        md12>
                    <v-btn color="primary" @click="submit">Add</v-btn>
                    </v-flex>

                    <div v-if="errors" class="text-danger pt-5">
                        <div v-for="(v, k) in errors" :key="k">
                            <p v-for="error in v" :key="error" class="text-sm">
                                {{ error }}
                            </p>
                        </div>
                    </div>
                </v-layout>
            </v-container>
        </v-form>
    </v-container>
</template>

import VueGoogleAutocomplete from 'vue-google-autocomplete'

<script>
    import VueGoogleAutocomplete from 'vue-google-autocomplete'

    export default {
        components: { VueGoogleAutocomplete },
        props: [
            'errors'
        ],
        data: () => ({
            valid: true,
            nameRules: [
                v => !!v || 'Name is required',
                v => (v && v.length <= 20) || 'Name must be less than 20 characters',
            ],
            fieldRequired: [
                v => !!v || 'required'
            ],
            first_name: '',
            last_name: '',
            address: '',
            uni_year: '',
            degree: '',
            os: '',
            osList: ['Mac', 'Windows', 'Linux'],
            issue: '',
            years: [],
        }),
        methods: {
            submit() {
                if(!this.validate()){
                    return;
                }
                let data = {
                    first_name:  this.first_name,
                    last_name:  this.last_name,
                    address:  this.address,
                    uni_year:  this.uni_year.toString(),
                    degree:  this.degree,
                    os:  this.os,
                    issue:  this.issue,
                };
                this.$emit('clicked', data);
            },
            getAddressData: function (addressData, placeResultData, id) {
                this.address = placeResultData.formatted_address;
            },
            validate () {
                return this.$refs.form.validate()
            }
        },
        mounted() {
            const year = new Date().getFullYear()
            this.years = Array.from({length: year - 1960}, (value, index) => 1961 + index)
        }
    }
</script>
