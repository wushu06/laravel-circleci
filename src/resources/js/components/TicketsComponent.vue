<template>
    <v-layout row class="pl-10 pr-10 pb-10">
        <v-flex xs12>
            <v-data-table
                v-if="load"
                item-key="name"
                class="elevation-1"
                loading
                loading-text="Loading... Please wait"
            ></v-data-table>
            <v-layout row class="mr-3 mt-3 mb-3 ml-3">
                <v-flex xs6>
                    <div>
                        <v-btn fab class="mb-3 mt-3 mr-2" depressed small @click="addTicket">
                            <v-icon color="grey">fas fa-plus</v-icon>
                        </v-btn>
                        <span>Add Ticket</span>
                    </div>
                </v-flex>
                <v-flex xs6>
                    <div>
                        <v-btn fab class="mb-3 mt-3 mr-2" depressed small v-on:click="showFilter = !showFilter">
                            <i class="fas fa-filter"></i>
                        </v-btn>
                        <span>Filter</span>
                    </div>
                </v-flex>
            </v-layout>
            <Filters v-if="showFilter" @sendFilteredData="filteredData"/>
            <v-card ref="form" class="mb-5 mt-3">
                <v-card-text>
                    <v-text-field
                        ref="first_name"
                        @input="search"
                        v-model="by_name"
                        label="Search ticket by first or last name"
                        required
                    ></v-text-field>
                </v-card-text>
            </v-card>
            <div class="total" v-if="total">
                <span><strong>Total:</strong> {{total}}</span>
            </div>
            <div class="total" v-if="total === 0">
                <h5>No result!</h5>
            </div>
            <v-simple-table v-if="total">
                <template v-slot:default>
                    <thead>
                    <tr>
                        <th class="text-left" @click="sort('id')">
                            Action
                        </th>
                        <th class="text-left" @click="sort('status')">
                            Status
                            <i :class="arrow"></i>
                        </th>
                        <th class="text-left" @click="sort('first_name')">
                            First Name
                            <i :class="arrow"></i>
                        </th>
                        <th class="text-left" @click="sort('first_name')">
                            Last Name
                            <i :class="arrow"></i>
                        </th>
                        <th class="text-left">
                            Address
                        </th>
                        <th class="text-left" >
                            Degree
                        </th>
                        <th class="text-left" >
                            University Year
                        </th>
                        <th class="text-left" >
                            Operating System
                        </th>
                        <th class="text-left" >
                            Issue
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="item in tickets"
                        :key="item.id"
                    >
                        <td>
                            <v-btn fab class="transparent-color" depressed  small @click="deleteTicket(item.id)">
                                <v-icon color="pink">fas fa-trash</v-icon>
                            </v-btn>
                        </td>
                        <td>{{ item.status == 0 ? 'Pending' : 'Resolved' }}</td>
                        <td>{{ item.first_name }}</td>
                        <td>{{ item.last_name }}</td>
                        <td>{{ item.address }}</td>
                        <td>{{ item.degree }}</td>
                        <td>{{ item.uni_year }}</td>
                        <td>{{ item.os }}</td>
                        <td>{{ item.issue }}</td>
                    </tr>
                    </tbody>
                </template>
            </v-simple-table>

            <div class="text-xs-center pagination-wrapper">
                <v-pagination
                    v-if="pageNumber > increment"
                    v-model="page"
                    :length="Math.ceil(pageNumber / increment)"
                    :circle="circle"
                    @input="next"
                    :total-visible="5"
                    color="black"
                    class="my-4"
                ></v-pagination>
                <div class="total" v-if="total">
                    <span><strong>Total:</strong> {{total}}</span>
                </div>
            </div>
            <v-dialog
                v-model="dialog"
                max-width="290">
                <v-card>
                    <v-card-title class="headline">Deleting:</v-card-title>
                    <v-card-text>
                        Are you sure you want to delete this Ticket?
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="green darken-1"
                            text="text"
                            @click="dialog = false"
                        >
                            Cancel
                        </v-btn>
                        <v-btn
                            color="pink"
                            text="text"
                            @click="deleteConfirmed"
                        >
                            Delete
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog
                fullscreen hide-overlay transition="dialog-bottom-transition"
                v-model="dialogAddTicket"
                max-width="900"
            >
                <v-card>
                    <v-toolbar dark color="primary">
                        <v-btn icon dark @click="dialogAddTicket = false">
                            <v-icon color="red">fas fa-times</v-icon>
                        </v-btn>
                        <v-toolbar-title>New Ticket</v-toolbar-title>
                        <v-spacer></v-spacer>
                    </v-toolbar>
                    <v-list>
                        <AddTicket :errors="errors" @clicked="onTicketAdded"/>
                    </v-list>
                </v-card>
            </v-dialog>
            <v-snackbar
                v-model="snackbar"
                bottom="bottom"
                right="right"
                :timeout="timeout">
                {{message}}
                <v-btn
                    color="pink"
                    text
                    @click="snackbar = false"
                >
                    Close
                </v-btn>
            </v-snackbar>
        </v-flex>
    </v-layout>
</template>

<script>


import axios from "axios";
import AddTicket from "./AddTicket";
import Filters from "./Filters";

export default {
    props: [],
    data: () => ({
        by_name: null,
        first_name: null,
        showFilter: false,
        filters: {},
        id: null,
        ticket: null,
        tickets: {},
        timeout: 6000,
        snackbar: false,
        message: '',
        total: 0,
        dialog: false,
        dialogEdit: false,
        dialogAddTicket: false,
        page: 1,
        currentUser: 0,
        pageNumber: 0,
        circle: false,
        currentPage: 0,
        increment: 10,
        multiple: false,
        option: null,
        dir: 'asc',
        load: true,
        arrow: "fas fa-arrow-down",
        errors: null
    }),
    components: {
        AddTicket, Filters
    },
    watch: {},
    computed: {},

    methods: {
        filteredData(filters = this.filters){
            this.filters = filters;
            axios.post( `/api/tickets/filters?page=${this.page}`, filters)
                .then((res) => {
                    this.setData(res)
                })
                .catch(error => {
                    console.log(error);
                })
        },
        next(page) {
            this.page = page;
            if (this.by_name && this.by_name !== '') {
                this.search();
            } else {
                this.getData();

            }
        },
        search() {
            if (this.by_name === '') {
                this.getData();
                return;
            }
            this.getData(`/api/tickets/search/${this.by_name}`);
        },
        sort(option) {
            if (option === '') {
                return;
            }
            if (option === this.option) {
                this.dir = this.dir === 'desc' ? 'asc' : 'desc'
            } else {
                this.option = option;
                this.dir = 'desc';
            }
            if(this.dir === 'desc'){
                this.arrow = "fas fa-arrow-up"
            }else{
                this.arrow = "fas fa-arrow-down"
            }
            this.getData(`/api/tickets/sort/filter?sort=${this.option}`, '&');
        },
        deleteConfirmed() {
            this.dialog = false;
            if (!this.id) {
                return;
            }
            let self = this;
            axios.delete(
                `/api/tickets/${this.id}`,
            )
                .then(res => {
                    self.setData(res);
                    self.snackbar = true;
                    self.message = 'Ticket has been deleted!';
                })
                .catch(error => {
                    console.log(error);
                })
        },
        addTicket(){
            this.dialogAddTicket = true
        },
        onTicketAdded(data){
            let self = this;
            axios.post(
                '/api/tickets',
                data
            )
                .then(res => {
                    self.setData(res);
                    self.dialogAddTicket = false;
                    self.snackbar = true;
                    self.message = `${data.first_name}  has been added!`;
                })
                .catch(error => {
                    if (error.response) {
                        this.errors = error.response.data.errors;
                    }
                });

        },
        deleteTicket(id) {
            this.dialog = true;
            this.id = id
        },
        setData(res) {
            this.pageNumber = res.data.total;
            this.total = res.data.total;
            this.tickets = res.data.data;
            this.load = false;
        },
        getData(url = '/api/tickets', concat = '?') {
            let self = this;
            let page = `${concat}page=${this.page}&dir=${this.dir}`;
            axios.get(`${url}${page}`)
                .then((res) => {
                    self.setData(res)
                })
                .catch(error => {
                    console.log(error);
                })
        }
    },
    beforeMount() {
    },
    mounted() {
        this.getData();
    }
}
</script>

