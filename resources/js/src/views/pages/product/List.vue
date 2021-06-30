<template>

    <div id="page-user-list">
        <vx-card ref="filterCard" title="Filters" class="user-list-filters mb-8" actionButtons
                 @refresh="resetColFilters"
                 @remove="resetColFilters">
            <div class="vx-row">
                <div class="vx-col md:w-1/3 sm:w-1/2 w-full">
                    <label class="text-sm opacity-75">Category</label>
                    <vs-select @change="categoryChange" autocomplete clearable="false" :dir="$vs.rtl ? 'rtl' : 'ltr'"
                               class="w-full mb-4 md:mb-0"
                               v-model="category_id">
                        <vs-select-item value="0" text="All"/>
                        <vs-select-item :key="index" :value="category.id" :text="category.name"
                                        v-for="(category,index) in categoryOptions"/>
                    </vs-select>
                </div>
                <div class="vx-col md:w-1/3 sm:w-1/2 w-full">
                    <label class="text-sm opacity-75">SubCategory</label>
                    <vs-select :disabled="category_id==0" @change="subcategoryChange" autocomplete clearable="false"
                               :dir="$vs.rtl ? 'rtl' : 'ltr'"
                               class="w-full mb-4 md:mb-0" v-model="subcategory_id">
                        <vs-select-item value="0" text="All" selected/>
                        <vs-select-item :key="index" :value="subcategory.id" :text="subcategory.name"
                                        v-for="(subcategory,index) in subcategoryOptions"/>
                    </vs-select>
                </div>
                <div class="vx-col md:w-1/3 sm:w-1/2 w-full">
                    <label class="text-sm opacity-75">Color</label>
                    <vs-select @change="colorChange" autocomplete clearable="false" :dir="$vs.rtl ? 'rtl' : 'ltr'"
                               class="w-full mb-4 md:mb-0"
                               v-model="color"
                    >
                        <vs-select-item text="All"/>
                        <vs-select-item :key="index" :value="item.color" :text="item.color"
                                        v-for="(item,index) in colorOptions"/>
                    </vs-select>
                </div>
            </div>
        </vx-card>
        <div class="vx-card p-6">

            <div class="flex-wrap items-center">
                <vs-table @search="handleSearch" search max-items="10" stripe :sst="true" :data="products">
                    <template slot="header">
                        <vs-button @click="add" color="primary" type="gradient" icon="add">Add new product
                        </vs-button>
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
                            Extra Info
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
                                <router-link :to="{name: 'ProductShow', params:{id:data[indextr].id}}">{{
                                    data[indextr].code }}
                                </router-link>
                            </vs-td>

                            <vs-td :data="data[indextr].code">
                                <router-link :to="{name: 'ProductShow', params:{id:data[indextr].id}}">
                                    <img class="rounded-lg md:w-56" :src="data[indextr].images[0]['url']" width="98"
                                         height="65" :alt="data[indextr].name">
                                </router-link>
                            </vs-td>
                            <vs-td :data="data[indextr].name">
                                <router-link :to="{name: 'ProductShow', params:{id:data[indextr].id}}">{{
                                    data[indextr].name }}
                                </router-link>
                            </vs-td>

                            <vs-td :data="data[indextr].price">
                                {{data[indextr].price}}
                            </vs-td>

                            <vs-td :data="data[indextr].color">
                                {{data[indextr].color}}
                            </vs-td>

                            <vs-td :data="data[indextr].category.name">
                                {{data[indextr].category.name}}
                            </vs-td>

                            <vs-td :data="data[indextr].materials">
                                {{data[indextr].materials}}
                            </vs-td>
                            <vs-td :data="data[indextr].weaving">
                                {{data[indextr].weaving}}
                            </vs-td>

                            <vs-td :data="data[indextr].info">
                                {{data[indextr].info}}
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
                <vs-pagination
                    class="p-2"
                    :total="total_record"
                    v-model="current_page"
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
                subDisable: true,
                subcategory_id: this.$route.query.subcategory_id || 0,
                category_id: this.$route.query.category_id || 0,
                color: null,
                // Filter Options
                search: '',
                price: [0, 100000000],
            }
        }
        ,
        watch: {
            roleFilter(obj) {
                this.setColumnFilter('role', obj.value)
            }
            ,
        }
        ,
        computed: {
            products() {
                return this.$store.state.product.products;
            }
            ,
            colorOptions() {
                return this.$store.state.product.colors;
            }
            ,
            categoryOptions() {
                return this.$store.state.product.categories;
            }
            ,
            subcategoryOptions() {
                return this.$store.state.product.subcategories;
            }
            ,
            total_record() {
                return this.$store.state.product.total_record;
            }
            ,
            ...
                mapState({
                    user: state => state.auth.user
                })
        }
        ,
        methods: {
            cambio(value) {
                this.widthx = value
                this.heightx = value
            },
            categoryChange(cate_id) {
                if (cate_id == 0) {
                    this.subDisable = true;
                } else {
                    this.subDisable = false;
                }
                this.current_page = 1;
                this.subcategory_id = 0;
                this.color = null;
                this.search = '';

                return this.submitQuery();
            },
            subcategoryChange(subcate_id) {
                this.current_page = 1;
                this.color = null;
                this.search = '';
                return this.submitQuery();
            },
            colorChange(color) {
                this.current_page = 1;
                return this.submitQuery();
            },
            changePrice() {
                // setTimeout(() => this.submitQuery(), 1000);
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
            handleChangePage(page) {
                return this.submitQuery();
            },
            handleSearch(search) {
                this.search = search;
                this.current_page = 1;
                return this.submitQuery();
            },
            resetColFilters() {
                this.category_id = 0;
                this.subcategory_id = 0;
                this.color = null;
                this.search = '';
                this.current_page = 1;
                this.$refs.filterCard.removeRefreshAnimation()
                return this.submitQuery();

            },
            submitQuery() {
                let query = {
                    category_id: this.category_id,
                    subcategory_id: this.subcategory_id,
                    color: this.color,
                    search: this.search,
                    page: this.current_page,
                    price: this.price,
                };
                this.$router.push({
                    name: 'ProductList',
                    query
                }).catch(() => {
                });
                this.$store.dispatch('product/FETCH_PRODUCTS', query).catch(err => {
                    console.error(err)
                })
            },
            add() {
                this.$router.push({name: 'ProductCreate'})
            },
            edit(id) {
                this.$router.push({name: 'ProductEdit', params: {id: id}});
            },
            remove() {
                this.$store
                    .dispatch("product/DELETE_PRODUCT", this.id)
                    // go to which page after successfully login
                    .then(this.$vs.notify({
                        title: 'Success',
                        text: 'Product deleted successfully!',
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
            let category_id = (this.$route.query.category_id) ? (this.$route.query.category_id) : 0;
            let subcategory_id = (this.$route.query.subcategory_id) ? (this.$route.query.subcategory_id) : 0;
            this.$store.dispatch('product/FETCH_PRODUCTS', {
                category_id,
                subcategory_id,
                page: 1,
                search: '',
                color: null,
                price: [0, 10000000]
            }).catch(err => {
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
