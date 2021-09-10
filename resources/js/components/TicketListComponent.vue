<template>
    <v-container fluid>
        <v-dialog
            v-model="dialog"
            max-width="600px"
        >
            <v-card>
                <v-card-title>
                    <span class="text-h5"></span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    label="Title"
                                    required
                                    v-model="title"
                                    :error="!!errors.title"
                                    :error-messages="errors.title?errors.title[0]:''"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-textarea
                                    label="Description"
                                    v-model="description"
                                    required
                                    :error="!!errors.description"
                                    :error-messages="errors.description?errors.description[0]:''"
                                ></v-textarea>
                            </v-col>
                            <v-col
                                cols="12"
                            >
                                <v-menu
                                    ref="menu"
                                    v-model="menu"
                                    :close-on-content-click="false"
                                    :return-value.sync="due"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="auto"
                                >
                                    <template v-slot:activator="{on, attrs}">
                                        <v-text-field
                                            v-model="due"
                                            label="Due"
                                            prepend-icon="mdi-calendar"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on"
                                            :error="!!errors.due"
                                            :error-messages="errors.due?errors.due[0]:''"
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker v-model="due" first-day-of-week="1">
                                        <v-spacer></v-spacer>
                                        <v-btn text color="primary" @click="menu = false">
                                            Cancel
                                        </v-btn>
                                        <v-btn text color="primary" @click="$refs.menu.save(due)">
                                            OK
                                        </v-btn>
                                    </v-date-picker>
                                </v-menu>
                            </v-col>
                            <v-col
                                cols="12"
                            >
                                <v-text-field
                                    label="Status"
                                    type="number"
                                    v-model="status"
                                    required
                                    :error="!!errors.status"
                                    :error-messages="errors.status?errors.status[0]:''"
                                >
                                </v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="dialog = false; id=null"
                    >
                        Close
                    </v-btn>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="createOrUpdate()"
                    >
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>

        </v-dialog>
        <v-dialog
            v-model="delete_dialog"
            max-width="290"
        >
            <v-card>
                <v-card-title class="text-h5">
                    Delete ticket
                </v-card-title>

                <v-card-text>
                    Do you want to delete this
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="green darken-1"
                        text
                        @click="delete_dialog = false; delete_id = null;"
                    >
                        Cancel
                    </v-btn>

                    <v-btn
                        color="red darken-1"
                        text
                        @click="deleteTicket"
                    >
                        Delete
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-card class="elevation-5">
            <v-row justify="space-between">
                <v-col>
                    <h1>Tickets</h1>
                </v-col>
                <v-col class="d-flex justify-content-end">
                    <v-btn color="green" @click="createDialog">Create</v-btn>
                </v-col>
            </v-row>
            <v-container>
                <v-data-table
                    fixed-header
                    dense
                    :headers="headers"
                    :items="tickets"
                    :loading="loading"
                    loading-text="Loading please wait..."
                >
                    <template #item.actions="{item}">
                        <v-tooltip>
                            <template #activator="on, attrs">
                                <v-btn v-on="on" v-bind="attrs" icon @click="editDialog(item)">
                                    <v-icon small>mdi-pencil</v-icon>
                                </v-btn>
                            </template>
                            <span>Edit</span>
                        </v-tooltip>
                        <v-tooltip>
                            <template #activator="on, attrs">
                                <v-btn v-on="on" v-bind="attrs" icon @click="deleteDialog(item)">
                                    <v-icon small color="red" class="darken-1">mdi-trash-can</v-icon>
                                </v-btn>
                            </template>
                            <span>Edit</span>
                        </v-tooltip>
                    </template>
                </v-data-table>
            </v-container>
        </v-card>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            headers: [
                {
                    text: "ID",
                    value: "id",
                    sortable: true,
                    divider: true,
                }, {
                    text: "Title",
                    value: "title",
                    sortable: true,
                    divider: true,
                }, {
                    text: "Description",
                    value: "description",
                    sortable: false,
                    divider: true,
                }, {
                    text: "Due",
                    value: "due",
                    sortable: true,
                    divider: true,
                }, {
                    text: "Status",
                    value: "status",
                    sortable: true,
                    divider: true,
                }, {
                    text: "Options",
                    value: "actions",
                },
            ],
            menu: false,
            tickets: [],
            loading: true,
            errors: {},
            dialog: false,
            delete_dialog: false,
            delete_id: null,

            id: null,
            title: null,
            description: null,
            due: null,
            status: null,
        }
    },
    mounted() {
        this.loadTickets()
    },
    methods: {
        loadTickets() {
            this.loading = true;
            axios.get("api/tickets-list").then(response => {
                this.tickets = response.data
            }).catch(e => console.error(e))
                .finally(() => this.loading = false)
        },
        createDialog() {
            this.resetValues();
            this.dialog = true;
        },
        editDialog(ticket) {
            this.dialog = true;
            this.id = ticket.id
            this.title = ticket.title
            this.description = ticket.description
            this.due = ticket.due
            this.status = ticket.status
        },
        createOrUpdate() {
            const path = this.id ? `api/tickets/${this.id}` : "api/tickets";
            axios.post(path, {
                _method: this.id ? "PATCH" : "POST",

                title: this.title,
                description: this.description,
                due: this.due,
                status: this.status,
            }).then(response => {
                if (this.id) {
                    this.tickets = this.tickets.map(t => {
                        if (t.id === this.id) {
                            t.title = this.title;
                            t.description = this.description;
                            t.due = this.due;
                            t.status = this.status;
                        }
                        return t;
                    })
                } else {
                    this.tickets.push({
                        id: response.data,
                        title: this.title,
                        description: this.description,
                        due: this.due,
                        status: this.status,
                    })
                }
                this.resetValues();
            }).catch(error => {
                console.log(error);
                this.errors = error.response.data.errors;
            })

        },
        deleteDialog(ticket) {
            this.delete_dialog = true;
            this.delete_id = ticket.id;
        },
        deleteTicket() {
            axios.delete(`api/tickets/${this.delete_id}`)
                .then(r => {
                    this.tickets = this.tickets.filter(t=>t.id !== this.delete_id)
                    this.resetValues()
                })
        },
        resetValues() {
            this.id = null;
            this.title = null;
            this.description = null;
            this.due = null;
            this.status = null;

            this.dialog = false;
            this.delete_dialog = false;
            this.delete_id = null;
        }
    }
}
</script>
