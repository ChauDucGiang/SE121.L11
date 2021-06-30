<template>

    <div id="page-user-list">
        <div class="vx-row">
            <div class="vx-col lg:w-1/5 w-full">
                <vx-card title="Offer Info" class="mb-base w-full" :actionable="true">

                    <!-- Avatar -->
                    <div class="vx-row">
                        <!-- Information - Col 1 -->
                        <div class="vx-col flex-1">
                            <table>
                                <tr>
                                    <td class="font-semibold">Code:</td>
                                    <td>{{ order.code }}</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold">Created At:</td>
                                    <td>{{ order.created }}</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold">Total Price:</td>
                                    <td>$ {{ order.total_price }}</td>
                                </tr>
                            </table>
                        </div>
                        <!-- /Information - Col 1 -->
                        <!-- /Information - Col 2 -->
                    </div>

                </vx-card>

            </div>
            <div class="vx-col lg:w-2/5 w-full">
                <vx-card title="Customer Info" class="mb-base w-full" :actionable="true">

                    <!-- Avatar -->
                    <div class="vx-row">
                        <!-- Information - Col 1 -->
                        <div class="vx-col flex-1" id="account-info-col-1">
                            <table>
                                <tr>
                                    <td class="font-semibold">Code:</td>
                                    <td>{{ order.customer.code }}</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold">Company:</td>
                                    <td>{{ order.customer.company }}</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold">Department:</td>
                                    <td>{{ order.customer_department }}</td>
                                </tr>
                            </table>
                        </div>
                        <!-- /Information - Col 1 -->

                        <!-- Information - Col 2 -->
                        <div class="vx-col flex-1" id="account-info-col-2">
                            <table>
                                <tr>
                                    <td class="font-semibold">Phone:</td>
                                    <td>{{ order.customer.phone }}</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold">Email:</td>
                                    <td>{{ order.customer.email }}</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold">Country:</td>
                                    <td>{{ order.customer.country.name }}</td>
                                </tr>
                            </table>
                        </div>
                        <!-- /Information - Col 2 -->
                    </div>

                </vx-card>

            </div>
            <div class="vx-col lg:w-2/5 w-full">
                <vx-card title="User Offered Info" class="mb-base w-full" :actionable="true">

                    <!-- Avatar -->
                    <div class="vx-row">
                        <!-- Information - Col 1 -->
                        <div class="vx-col flex-1" id="user-info-col-1">
                            <table>
                                <tr>
                                    <td class="font-semibold">Name:</td>
                                    <td>{{ order.user.name }}</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold">Email:</td>
                                    <td>{{ order.user.email }}</td>
                                </tr>
                            </table>
                        </div>
                        <!-- /Information - Col 1 -->

                        <!-- Information - Col 2 -->
                        <div class="vx-col flex-1" id="user-info-col-2">
                            <table>
                                <tr>
                                    <td class="font-semibold">Phone:</td>
                                    <td>{{ order.user.phone }}</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold">Role:</td>
                                    <td>{{ order.user.RoleName}}</td>
                                </tr>
                            </table>
                        </div>
                        <!-- /Information - Col 2 -->
                    </div>

                </vx-card>

            </div>
        </div>

        <div class="vx-card p-6">

            <div class="flex-wrap items-center">
                <vs-table :total="order.orderdetails.length" max-items="10" stripe :data="order.orderdetails">
                    <template slot="header">
                        <h3>
                            Total: <strong class="text-danger">{{order.orderdetails.length}}</strong> items
                        </h3>
                    </template>
                    <template slot="thead">
                        <vs-th>
                            ID
                        </vs-th>
                        <vs-th sort-key="code">
                            Code
                        </vs-th>
                        <vs-th>
                            Image
                        </vs-th>
                        <vs-th sort-key="name">
                            Name
                        </vs-th>
                        <vs-th sort-key="price">
                            Price ($)
                        </vs-th>
                        <vs-th sort-key="new_price">
                            New Price ($)
                        </vs-th>
                        <vs-th sort-key="color">
                            Color
                        </vs-th>
                        <vs-th sort-key="category">
                            Category
                        </vs-th>
                        <vs-th sort-key="materials">
                            Materials
                        </vs-th>
                        <vs-th sort-key="weaving">
                            Weaving
                        </vs-th>
                        <vs-th sort-key="info">
                            Info
                        </vs-th>
                    </template>


                    <template slot-scope="{data}">
                        <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                            <vs-td>
                                {{indextr+1}}
                            </vs-td>
                            <vs-td :data="data[indextr].product.code">
                                <router-link :to="{name: 'ProductDetail', params:{id:data[indextr].product.id}}">{{
                                    data[indextr].product.code }}
                                </router-link>
                            </vs-td>
                            <vs-td :data="data[indextr].product.name">
                                <div class="con-userx flex items-center justify-start">
                                    <div class="md:flex-shrink-0">
                                        <img class="rounded-lg md:w-56" :src="data[indextr].product.images[0]['url']"
                                             width="98"
                                             height="65" :alt="data[indextr].product.name">
                                    </div>
                                </div>
                            </vs-td>
                            <vs-td :data="data[indextr].product.name">

                                <router-link :to="{name: 'ProductDetail', params:{id:data[indextr].product.id}}">{{
                                    data[indextr].product.name }}
                                </router-link>
                            </vs-td>

                            <vs-td :data="data[indextr].product.price">
                                {{data[indextr].product.price}}
                            </vs-td>

                            <vs-td :data="data[indextr].new_price">
                                {{data[indextr].new_price}}
                            </vs-td>

                            <vs-td :data="data[indextr].product.color">
                                {{data[indextr].product.color}}
                            </vs-td>

                            <vs-td :data="data[indextr].product.category.name">
                                {{data[indextr].product.category.name}}
                            </vs-td>

                            <vs-td :data="data[indextr].product.materials">
                                {{data[indextr].product.materials}}
                            </vs-td>
                            <vs-td :data="data[indextr].product.weaving">
                                {{data[indextr].product.weaving}}
                            </vs-td>

                            <vs-td :data="data[indextr].product.info">
                                {{data[indextr].product.info}}
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
            return {
                current_page: 1,
                customer_id: (this.$route.query.customer_id) ? (this.$route.query.customer_id) : null,
                search: ''
            }
        },
        computed: {
            order() {
                return this.$store.state.order.order;
            },
            ...mapState({
                user: state => state.auth.user
            })
        },
        methods: {
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
        },
        mounted() {
            if (this.$vs.rtl) {
                const header = this.$refs.agGridTable.$el.querySelector('.ag-header-container')
                header.style.left = `-${String(Number(header.style.transform.slice(11, -3)) + 9)}px`
            }
        },
        created() {
            this.$store.dispatch('order/FETCH_ORDER', this.$route.params.id).catch(err => {
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
