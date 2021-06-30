<template>
    <div id="page-user-list">
        <vx-card ref="filterCard" title="Filters" class="user-list-filters mb-8"
                 @refresh="resetFilter"
                 @remove="resetFilter">
            <div class="vx-row">
                <div class="vx-col md:w-1/2 sm:w-1/2 w-full">
                    <label class="text-sm opacity-75">Customer</label>
                    <vs-select autocomplete @change="filter"
                               :dir="$vs.rtl ? 'rtl' : 'ltr'"
                               v-model="customer_id"
                               class="w-full mb-4 md:mb-0">
                        <vs-select-item text="All"/>
                        <vs-select-item :key="index" :value="item.id" :text="item.code"
                                        v-for="(item,index) in customers"/>
                    </vs-select>
                </div>
                <div class="vx-col md:w-1/2 sm:w-1/2 w-full">
                    <label class="text-sm opacity-75">User</label>
                    <vs-select autocomplete
                               :disabled="($auth.user().roles === 2)?false:true"
                               @change="filter"
                               :dir="$vs.rtl ? 'rtl' : 'ltr'"
                               v-model="user_id"
                               class="w-full mb-4 md:mb-0">
                        <vs-select-item text="All"/>
                        <vs-select-item :key="index" :value="item.id" :text="item.name"
                                        v-for="(item,index) in users"/>
                    </vs-select>
                </div>
            </div>
        </vx-card>
        <div class="vx-card p-6">

            <div class="flex-wrap items-center">
                <vs-table :total="total_record" @change-page="handleChangePage"
                          max-items="10" stripe v-model="current_page"
                          :sst="true" :data="orders">
                    <template slot="header">
                        <h3>
                            Total: <strong class="text-danger">{{total_record}}</strong> items
                        </h3>
                    </template>
                    <template slot="thead">
                        <vs-th>
                            ID
                        </vs-th>
                        <vs-th>
                            Code
                        </vs-th>
                        <vs-th sort-key="code">
                            Customer Code
                        </vs-th>
                        <vs-th sort-key="company">
                            Company Name
                        </vs-th>
                        <vs-th sort-key="orderdetails_count">
                            Total Quantity
                        </vs-th>
                        <vs-th sort-key="total_price">
                            Total Price($)
                        </vs-th>

                        <vs-th sort-key="user.name">
                            User Ordered Name
                        </vs-th>
                        <vs-th sort-key="created">
                            Created At
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
                                   @click="view(data[indextr].id)">
                                    {{data[indextr].code}}</p>
                            </vs-td>

                            <vs-td :data="data[indextr].customer.code">
                                <p class="text-primary cursor-pointer"
                                   @click="filterByCustomer(data[indextr].customer.id)">
                                    {{data[indextr].customer.code}}</p>
                            </vs-td>
                            <vs-td :data="data[indextr].customer.company">
                                <p class="text-primary cursor-pointer"
                                   @click="filterByCustomer(data[indextr].customer.id)">
                                    {{data[indextr].customer.company}}</p>
                            </vs-td>

                            <vs-td :data="data[indextr].orderdetails_count">
                                {{data[indextr].orderdetails_count}}
                            </vs-td>
                            <vs-td :data="data[indextr].total_price">
                                {{data[indextr].total_price}}
                            </vs-td>

                            <vs-td :data="data[indextr].user.name">
                                <p class="text-primary cursor-pointer"
                                   @click="$router.push({name:'UserEdit', params:{id:data[indextr].user.id}})">
                                    {{data[indextr].user.name}}</p>
                            </vs-td>

                            <vs-td :data="data[indextr].created">
                                {{data[indextr].created}}
                            </vs-td>

                            <vs-td>
                                <div class="vx-row">
                                    <div class="vx-col w-full">
                                        <vs-button @click="view(data[indextr].id)" class="mb-2 mr-3" color="primary"
                                                   type="gradient">View
                                        </vs-button>
                                    </div>
                                </div>
                                <div class="demo-alignment centerx">
                                </div>
                            </vs-td>
                        </vs-tr>
                    </template>


                </vs-table>
                <vs-pagination
                    :total="total"
                    v-model="current_page"
                    class="p-2"
                    @input="(val) => { handleChangePage(current_page) }"/>
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
            return {
                current_page: 1,
                customer_id: this.$route.query.customer_id || null,
                user_id: this.$route.query.user_id || null,
                search: ''
            }
        },
        computed: {
            orders() {
                return this.$store.state.order.orders;
            },
            customers() {
                return this.$store.state.customer.customers;
            },
            users() {
                return this.$store.state.user.users;
            },
            total() {
                return this.$store.state.order.total;
            },
            total_record() {
                return this.$store.state.order.total_record;
            },
            ...mapState({
                user: state => state.auth.user
            })
        },
        methods: {
            // handleSearch(search) {
            //     this.search = search;
            //     this.current_page = 1;
            //     return this.submitQuery();
            // },
            handleChangePage() {
                return this.submitQuery();
            },
            filter() {
                this.current_page = 1;
                this.submitQuery();
            },
            filterByCustomer(customer_id) {
                this.current_page = 1;
                this.customer_id = customer_id;
                return this.submitQuery();
            },
            resetFilter() {
                this.current_page = 1;
                this.customer_id = null;
                this.user_id = null;
                return this.submitQuery();
            },
            submitQuery() {
                let query = {
                    page: this.current_page,
                    customer_id: this.customer_id,
                    user_id: this.user_id,
                };
                this.$router.push({
                    name: 'OfferView',
                    query
                }).catch(() => {
                });
                this.$store.dispatch('order/FETCH_ORDERS', query).catch(err => {
                    console.error(err)
                })
                this.$refs.filterCard.removeRefreshAnimation()
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
            view(id) {
                this.$router.push({
                    name: 'OfferShow',
                    params: {id: id}
                }).catch(() => {
                });
            },
            remove() {
                this.$store
                    .dispatch("order/DELETE_ORDER", this.id)
                    // go to which page after successfully login
                    .then(this.$vs.notify({
                        title: 'Success',
                        text: 'Order deleted successfully!',
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
            this.$store.dispatch('order/FETCH_ORDERS').catch(err => {
                console.error(err)
            })
            this.$store.dispatch('customer/FETCH_CUSTOMERS').catch(err => {
                console.error(err)
            })
            this.$store.dispatch('user/FETCH_USERS').catch(err => {
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
