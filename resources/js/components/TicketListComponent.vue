<template>
    <v-container fluid>
        <v-card class="elevation-5">
            <v-card-text>
                <h1>Tickets</h1>
            </v-card-text>
            <v-container>
                <v-data-table
                    fixed-header
                    dense
                    :headers="headers"
                    :items="tickets"
                    :loading="loading"
                    loading-text="Loading please wait..."
                >
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
                },                {
                    text: "Title",
                    value: "title",
                    sortable: true,
                    divider: true,
                },                {
                    text: "Description",
                    value: "description",
                    sortable: false,
                    divider: true,
                },                {
                    text: "Due",
                    value: "due",
                    sortable: true,
                    divider: true,
                },                {
                    text: "Status",
                    value: "status",
                    sortable: true,
                    divider: true,
                },
            ],
            tickets:[],
            loading:true
        }
    },
    mounted(){
        this.loadTickets()
    },
    methods: {
        loadTickets() {
            this.loading = true;
            axios.get("api/tickets-list").then(response=>{
                this.tickets = response.data
            }).catch(e=>console.error(e))
            .finally(()=>this.loading=false)
        }
    },
}
</script>
