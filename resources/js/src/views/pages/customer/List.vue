<template>

    <div id="page-user-list">
        <div class="vx-card p-6">

            <div class="flex-wrap items-center">
                <vs-table search max-items="10" pagination stripe :data="customers">
                    <template slot="header">
                        <vs-button @click="add" color="primary" type="gradient" icon="add">Add new customer
                        </vs-button>
                    </template>
                    <template slot="thead">
                        <vs-th>
                            ID
                        </vs-th>
                        <vs-th sort-key="code">
                            Code
                        </vs-th>
                        <vs-th sort-key="department">
                            Department
                        </vs-th>
                        <vs-th sort-key="email">
                            Email
                        </vs-th>
                        <vs-th sort-key="phone">
                            Phone
                        </vs-th>
                        <vs-th sort-key="company">
                            Company
                        </vs-th>
                        <vs-th sort-key="country">
                            Country
                        </vs-th>
                        <vs-th>
                            Action
                        </vs-th>
                    </template>

                    <template slot-scope="{data}">
                        <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                            <vs-td>
                                {{indextr+1}}
                            </vs-td>


                            <vs-td :data="data[indextr].code">
                                <p class="text-primary cursor-pointer"
                                   @click="filterByCustomer(data[indextr].id)">
                                    {{data[indextr].code}}</p>

                            </vs-td>

                            <vs-td :data="data[indextr].department">
                                {{data[indextr].department}}
                            </vs-td>

                            <vs-td :data="data[indextr].email">
                                {{data[indextr].email}}
                            </vs-td>

                            <vs-td :data="data[indextr].phone">
                                {{data[indextr].phone}}
                            </vs-td>

                            <vs-td :data="data[indextr].company">
                                {{data[indextr].company}}
                            </vs-td>

                            <vs-td :data="data[indextr].country.name">
                                {{data[indextr].country.name}}
                            </vs-td>

                            <vs-td>
                                <div class="vx-row">
                                    <div class="vx-col w-full">
                                        <vs-button @click="edit(data[indextr].id)" class="mb-2 mr-3" color="primary"
                                                   type="gradient">Edit
                                        </vs-button>
                                        <vs-button @click="openConfirm(data[indextr].id)" class="mb-2" color="danger"
                                                   type="gradient">Delete
                                        </vs-button>
                                    </div>
                                </div>
                                <div class="demo-alignment centerx">
                                </div>
                            </vs-td>
                        </vs-tr>
                    </template>


                </vs-table>
            </div>

        </div>
    </div>

</template>

<script>
    import vSelect from 'vue-select'


    // Cell Renderer
    import {mapState} from "vuex";


    export default {
        components: {
            vSelect,
        },
        data() {
            return {}
        },
        computed: {
            customers() {
                return this.$store.state.customer.customers;
            },
            ...mapState({
                user: state => state.auth.user
            })
        },
        methods: {
            filterByCustomer(customer_id) {
                this.$router.push({name: 'OrderList', query: {page: 1, customer_id: customer_id}})
            },
            openConfirm(id) {
                this.id = id
                this.$vs.dialog({
                    type: 'confirm',
                    color: 'danger',
                    title: `Delete`,
                    text: 'Are you sure you want to delete selected items?',
                    accept: this.remove
                })
            },
            add() {
                this.$router.push({name: 'CustomerCreate'})
            },
            edit(id) {
                this.$router.push({name: 'CustomerEdit', params: {id: id}});
            },
            remove() {
                this.$store
                    .dispatch("customer/DELETE_CUSTOMER", this.id)
                    // go to which page after successfully login
                    .then(this.$vs.notify({
                        title: 'Success',
                        text: 'Customer deleted successfully!',
                        color: 'success',
                        iconPack: 'feather',
                        icon: 'icon-check',
                        position: 'top-right',
                    }));
            },
        },
        mounted() {
            if (this.$vs.rtl) {
                const header = this.$refs.agGridTable.$el.querySelector('.ag-header-container')
                header.style.left = `-${String(Number(header.style.transform.slice(11, -3)) + 9)}px`
            }
        },
        created() {
            this.$store.dispatch('customer/FETCH_CUSTOMERS').catch(err => {
                console.error(err)
            })
        }
    }

</script>

<style lang="scss">
    #page-user-list {
        .user-list-filters {
            .vs__actions {
                position: absolute;
                right: 0;
                top: 50%;
                transform: translateY(-58%);
            }
        }
    }

    /*.con-vs-popup .vs-popup {*/
    /*    width: 60% !important;*/
    /*    height: auto !important;*/
    /*}*/
</style>
