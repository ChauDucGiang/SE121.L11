<template>
    <div class="">
        <div class="algolia-header mb-4">
            <div class="flex md:items-end items-center justify-between flex-wrap">
                <!-- TOGGLE SIDEBAR BUTTON -->
                <feather-icon
                    class="inline-flex lg:hidden cursor-pointer mr-4"
                    icon="MenuIcon"
                    @click.stop="toggleFilterSidebar"/>

                <!--                <p class="lg:inline-flex hidden font-semibold algolia-filters-label">Filters</p>-->

                <div class="flex justify-between items-end flex-grow">
                    <!-- Stats -->
                    <p class="font-semibold md:block hidden">
                        <!--                        100 results found-->
                    </p>

                    <div class="flex flex-wrap">
                        <div class="range" height="36">
                            <vs-dropdown vs-custom-content
                                         class="text-primary mr-4 vs-input-shadow-drop vs-select-no-border d-theme-input-dark-bg w-56">
                                <vs-button color="primary" class="items-center" type="border">
                                    <span v-if="min_price == null">Range Price</span>
                                    <span v-else class="text-bold text-black">{{min_price}}$ - {{max_price}}$</span>
                                    <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4 ml-1"/>
                                </vs-button>
                                <!--                            <vs-button class="btnx" type="filled">Dropdown</vs-button>-->
                                <vs-dropdown-menu class="w-56">

                                    <!--                                    <h3 class="mb-0 text-center"></h3>-->
                                    <div class="flex">
                                        <div class="w-1/2 m-1">
                                            <vs-input type="number" label="From" placeholder="Min Price" min="0"
                                                      icon="attach_money"
                                                      v-model="min_price"/>

                                        </div>
                                        <div class="w-1/2 m-1">
                                            <vs-input type="number" label="To" placeholder="Max Price"
                                                      icon="attach_money"
                                                      v-model="max_price" min="0"/>

                                        </div>
                                    </div>


                                    <vs-button width="100%" color="primary" type="gradient" class="mt-4 w-full"
                                               @click="changePrice">Filter
                                    </vs-button>

                                </vs-dropdown-menu>
                            </vs-dropdown>
                        </div>

                        <vs-select autocomplete @change="changeColor" v-model="color"
                                   class="text-warning mr-4 vs-input-shadow-drop vs-select-no-border d-theme-input-dark-bg w-48">
                            <vs-select-item text="All Color"/>
                            <vs-select-item v-for="(item, i) in colors" :key="i" :value="item.color"
                                            :text="item.color"/>
                        </vs-select>
                        <vs-select autocomplete @change="changeCustomer" v-model="customer_id" :success="true"
                                   class="text-success mr-4 vs-input-shadow-drop vs-select-no-border d-theme-input-dark-bg w-48">
                            <vs-select-item text="All Customer"/>
                            <vs-select-item v-for="(item, i) in customers" :key="i" :value="item.id"
                                            :text="item.code"/>
                        </vs-select>

                        <vs-select @change="changePageSize(item)" v-model="qtySelect" autocomplete
                                   class="mr-4 vs-input-shadow-drop vs-select-no-border d-theme-input-dark-bg w-48">
                            <vs-select-item v-for="(item, i) in qty" :key="i" :value="item"
                                            :text="`${item} items/Page`"/>
                        </vs-select>

                        <!-- ITEM VIEW - GRID/LIST -->
                        <div>
                            <feather-icon
                                icon="GridIcon"
                                @click="currentItemView='item-grid-view'"
                                class="p-2 shadow-drop rounded-lg d-theme-dark-bg cursor-pointer"
                                :svgClasses="{'text-primary stroke-current': currentItemView == 'item-grid-view'}"/>
                            <!--                            <feather-icon-->
                            <!--                                icon="ListIcon"-->
                            <!--                                @click="currentItemView='item-list-view'"-->
                            <!--                                class="p-2 ml-4 shadow-drop rounded-lg d-theme-dark-bg cursor-pointer hidden sm:inline-flex"-->
                            <!--                                :svgClasses="{'text-primary stroke-current': currentItemView == 'item-list-view'}"/>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="algolia-content-container" class="h-full relative clearfix">
            <vs-sidebar class="items-no-padding vs-sidebar-rounded background-absolute"
                        parent="#algolia-content-container"
                        :click-not-close="clickNotClose"
                        :hidden-background="clickNotClose"
                        v-model="isFilterSidebarActive">
                <div class="p-6 filter-container">
                    <!-- CATEGORIES -->
                    <h6 class="font-bold mb-4">Category</h6>
                    <div>
                        <ul>
                            <li v-for="(item, i) in categories" :key="i"
                                class="flex items-center cursor-pointer py-1">
                                <vs-radio @change="selectCategory" v-model="category_id" vs-name="radios1"
                                          :vs-value="item.id"><span
                                    class="ml-2 text-primary">{{ item.name }}</span>
                                </vs-radio>
                            </li>
                        </ul>
                    </div>
                    <vs-divider/>                    <!-- CATEGORIES -->
                    <div v-if="subcategories.length > 0">
                        <h6 class="font-bold mb-4">SubCategory</h6>
                        <div>
                            <ul>
                                <li class="flex items-center cursor-pointer py-1">
                                    <vs-checkbox :disabled="(subcategory_id.length == 0)?true:false"
                                                 @change="selectAllSubcategory" vs-name="all" vs-value="all"
                                                 v-model="all"><span
                                        class="ml-2 text-primary">All</span>
                                    </vs-checkbox>
                                </li>
                                <li v-for="(item, index) in subcategories" :key="index"
                                    class="flex items-center cursor-pointer py-1">
                                    <vs-checkbox @change="selectSubcategory" v-model="subcategory_id"
                                                 vs-name="radios1"
                                                 :vs-value="item.id"><span
                                        class="ml-2 text-primary">{{ item.name }}</span>
                                    </vs-checkbox>
                                </li>
                            </ul>
                        </div>
                        <vs-divider/>
                    </div>
                    <vs-button @click="removeFilter" class="w-full">Remove Filters
                    </vs-button>
                </div>
            </vs-sidebar>
            <!-- RIGHT COL -->
            <div :class="{'sidebar-spacer-with-margin': clickNotClose}">
                <!--Search box-->
                <!--    <div slot-scope="{ currentRefinement, isSearchStalled, refine }">-->
                <div class="relative mb-8">

                    <!-- SEARCH INPUT -->
                    <vs-input class="w-full vs-input-shadow-drop vs-input-no-border d-theme-input-dark-bg"
                              placeholder="Search here"
                              v-model="search" @input="changeSearch" @keyup.esc="refine('')" size="large"/>
                    <!-- SEARCH LOADING -->
                    <!--                    <p :hidden="!isSearchStalled" class="mt-4 text-grey">-->
                    <!--                        <feather-icon icon="ClockIcon" svgClasses="w-4 h-4" class="mr-2 align-middle"/>-->
                    <!--                        <span>Loading...</span>-->
                    <!--                    </p>-->

                    <!-- SEARCH ICON -->
                    <div slot="submit-icon" class="absolute top-0 right-0 py-4 px-6" v-show="search.length == 0">
                        <feather-icon icon="SearchIcon" svgClasses="h-6 w-6"/>
                    </div>

                    <!-- CLEAR INPUT ICON -->
                    <div slot="reset-icon" class="absolute top-0 right-0 py-4 px-6" v-show="search.length > 0">
                        <feather-icon icon="XIcon" svgClasses="h-6 w-6 cursor-pointer" @click="changeResetSearch"/>
                    </div>
                </div>
                <!--    </div>-->
                <!--List Items-->
                <!--        <div slot-scope="{ items }">-->
                <div class="ais-Hits">
                    <div>
                        <!-- GRID VIEW -->
                        <template v-if="currentItemView == 'item-grid-view'">
                            <div class="items-grid-view vx-row match-height">
                                <div class="vx-col lg:w-1/4 sm:w-1/3 w-full" v-for="item in items" :key="item.id">

                                    <item-grid-view :item="item">

                                        <!-- SLOT: ACTION BUTTONS -->
                                        <template slot="action-buttons">
                                            <div class="flex flex-wrap">

                                                <!-- PRIMARY BUTTON: ADD TO WISH LIST -->
                                                <div
                                                    class="item-view-primary-action-btn p-3 flex flex-grow items-center justify-center cursor-pointer"
                                                    @click="detailButtonClicked(item)">
                                                    <feather-icon icon="EyeIcon"
                                                                  svgClasses="h-4 w-4"/>

                                                    <span class="text-sm font-semibold ml-2">DETAIL</span>
                                                </div>

                                                <!-- SECONDARY BUTTON: ADD-TO/VIEW-IN CART -->
                                                <div
                                                    class="item-view-secondary-action-btn bg-primary p-3 flex flex-grow items-center justify-center text-white cursor-pointer"
                                                    @click="cartButtonClicked(item)">
                                                    <feather-icon icon="ShoppingBagIcon" svgClasses="h-4 w-4"/>

                                                    <span class="text-sm font-semibold ml-2" v-if="isInCart(item.id)">VIEW SELECTED</span>
                                                    <span class="text-sm font-semibold ml-2" v-else>SELECT</span>
                                                </div>
                                            </div>
                                        </template>
                                    </item-grid-view>

                                </div>
                            </div>
                        </template>

                        <!-- LIST VIEW -->
                        <template v-else>
                            <div class="items-list-view mb-base" v-for="item in items" :key="item.id">

                                <item-list-view :item="item">

                                    <!-- SLOT: ACTION BUTTONS -->
                                    <template slot="action-buttons">
                                        <div
                                            class="item-view-primary-action-btn p-3 rounded-lg flex flex-grow items-center justify-center cursor-pointer mb-3"
                                            @click="toggleItemInWishList(item)">
                                            <feather-icon icon="HeartIcon"
                                                          :svgClasses="[{'text-danger fill-current' : isInWishList(item.id)}, 'h-4 w-4']"/>
                                            <span class="text-sm font-semibold ml-2">WISHLIST</span>
                                        </div>
                                        <div
                                            class="item-view-secondary-action-btn bg-primary p-3 rounded-lg flex flex-grow items-center justify-center text-white cursor-pointer"
                                            @click="cartButtonClicked(item)">
                                            <feather-icon icon="ShoppingBagIcon" svgClasses="h-4 w-4"/>

                                            <span class="text-sm font-semibold ml-2"
                                                  v-if="isInCart(item.id)">VIEW IN CART</span>
                                            <span class="text-sm font-semibold ml-2" v-else>ADD TO CART</span>
                                        </div>
                                    </template>
                                </item-list-view>

                            </div>
                        </template>
                        <!--        </div>-->
                    </div>
                </div>

                <!--Page-->
                <div class="ais-Pagination">
                    <div>
                        <vs-pagination
                            :total="total_page"
                            v-model="current_page"
                            @input="(val) => { handleChangePage(current_page) }"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import EventBus from "../../../EventBus";

    export default {
        components: {
            ItemGridView: () => import('./components/ItemGridView.vue'),
            ItemListView: () => import('./components/ItemListView.vue'),
        },
        data() {
            return {
                // price: [5, 1000],
                min_price: null,
                max_price: null,
                all: false,
                current_page: 1,
                qty: [20, 40, 60],
                search: '',
                color: null,
                category_id: this.$route.query.category_id || 0,
                customer_id: this.$route.query.customer_id || null,
                subcategory_id: this.$route.query.subcategory_id || [],
                qtySelect: this.$route.query.size || 20,
                // Filter Sidebar
                isFilterSidebarActive: true,
                clickNotClose: true,
                currentItemView: 'item-grid-view',
            }
        },
        computed: {
            colors() {
                return this.$store.state.home.colors;
            },
            price() {
                return this.$store.state.home.price;
            },
            categories() {
                return this.$store.state.home.categories;
            },
            customers() {
                return this.$store.state.home.customers;
            },
            subcategories() {
                return this.$store.state.home.subcategories;
            },
            total_page() {
                return this.$store.state.home.total;
            },
            items() {
                return this.$store.state.home.products;
            },
            toValue() {
                return (value, range) => [
                    value.min !== null ? value.min : range.min,
                    value.max !== null ? value.max : range.max
                ]
            },

            // GRID VIEW
            isInCart() {
                return (itemId) => this.$store.getters['home/isInCart'](itemId)
            },
            isInWishList() {
                return (itemId) => this.$store.getters['home/isInWishList'](itemId)
            },
            windowWidth() {
                return this.$store.state.windowWidth
            }
        },
        watch: {
            windowWidth() {
                this.setSidebarWidth()
            }
        },
        methods: {
            changePrice() {
                if (Number(this.min_price) > Number(this.max_price) || !this.max_price || !this.min_price || this.min_price < 0 || this.max_price < 0) {
                    this.$vs.dialog({
                        color: 'danger',
                        title: `Errors`,
                        text: 'Some error occurred . Please try again!',
                    });
                    this.min_price = null;
                    this.max_price = null;
                } else {
                    this.current_page = 1;
                    this.submitFilter();
                }
            },
            handleChangePage(page) {
                this.submitFilter();
            },
            changeCustomer() {
                this.category_id = 0;
                this.subcategory_id = [];
                this.current_page = 1;
                this.search = '';
                this.submitFilter();
            },
            changeColor() {
                this.submitFilter();
            },
            removeFilter() {
                this.category_id = 0;
                this.customer_id = null;
                this.color = null;
                this.subcategory_id = [];
                this.current_page = 1;
                this.search = '';
                this.min_price = null;
                this.max_price = null;
                this.submitFilter();
            },
            changeSearch() {
                this.current_page = 1;
                this.submitFilter();
            },
            changeResetSearch() {
                this.current_page = 1;
                this.search = '';
                this.submitFilter();
            },
            changePageSize() {
                this.current_page = 1;
                this.submitFilter();
            },
            selectCategory() {
                this.all = true;
                this.subcategory_id = [];
                this.current_page = 1;
                this.customer_id = null;
                this.color = null;
                this.submitFilter();
            },
            selectAllSubcategory() {
                this.all = true;
                this.subcategory_id = [];
                this.current_page = 1;
                this.customer_id = null;
                this.color = null;
                this.submitFilter();
            },
            selectSubcategory() {
                this.all = false;
                if (this.subcategory_id.length == 0) {
                    this.all = true;
                }
                this.current_page = 1;
                this.customer_id = null;
                this.color = null;
                this.submitFilter();
            },
            submitFilter() {
                let query = {
                    category_id: this.category_id,
                    subcategory_id: this.subcategory_id,
                    size: this.qtySelect,
                    search: this.search,
                    color: this.color,
                    price: (this.min_price != null) ? [this.min_price, this.max_price] : null,
                    customer_id: this.customer_id,
                    page: this.current_page,
                };
                this.$router.push({
                    name: 'List',
                    query
                }).catch(() => {
                });
                this.$store.dispatch('home/FETCH_CATEGORY_PRODUCTS', query).catch(err => {
                    this.$vs.notify({
                        title: 'Errors',
                        text: 'Some Errors! Please try again',
                        color: 'danger',
                        iconPack: 'feather',
                        icon: 'icon-x',
                        position: 'top-right',
                    });
                });
            },
            setSidebarWidth() {
                if (this.windowWidth < 992) {
                    this.isFilterSidebarActive = this.clickNotClose = false
                } else {
                    this.isFilterSidebarActive = this.clickNotClose = true
                }
            },
            detailButtonClicked(item) {
                this.$router.push({name: 'ProductDetail', params: {id: item.id}})
            },
            // GRID VIEW - ACTIONS
            toggleFilterSidebar() {
                if (this.clickNotClose) return
                this.isFilterSidebarActive = !this.isFilterSidebarActive
            },
            toggleItemInWishList(item) {
                this.$store.dispatch('home/toggleItemInWishList', item)
            },
            additemInCart(item) {
                this.$store.dispatch('home/additemInCart', item)
            },
            cartButtonClicked(item) {
                this.isInCart(item.id) ? this.$router.push({name: 'Cart'}).catch(() => {
                }) : this.additemInCart(item)
            }
        },
        created() {
            EventBus.$on('changeCat', (data) => {
                this.category_id = data.category_id;
                this.subcategory_id = data.subcategory_id;
                this.customer_id = data.customer_id;
                this.current_page = 1;
                this.min_price = null;
                this.max_price = null;
                this.all = false;
            })

            this.$store.dispatch('home/FETCH_PRODUCTS').catch(err => {
                this.$vs.notify({
                    title: 'Errors',
                    text: 'Some Errors! Please try again',
                    color: 'danger',
                    iconPack: 'feather',
                    icon: 'icon-x',
                    position: 'top-right',
                });
            });
            this.$store.dispatch('home/FETCH_CATEGORIES').catch(err => {
                this.$vs.notify({
                    title: 'Errors',
                    text: 'Some Errors! Please try again',
                    color: 'danger',
                    iconPack: 'feather',
                    icon: 'icon-x',
                    position: 'top-right',
                });
            });
            this.$store.dispatch('home/FETCH_CUSTOMERS').catch(err => {
                this.$vs.notify({
                    title: 'Errors',
                    text: 'Some Errors! Please try again',
                    color: 'danger',
                    iconPack: 'feather',
                    icon: 'icon-x',
                    position: 'top-right',
                });
            });
            this.setSidebarWidth()
        },
        destroyed() {
            // Stop listening the event hello with handler
            EventBus.$off();
        },
    }

</script>


<style lang="scss">

    #algolia-instant-search-demo {
        .algolia-header {
            .algolia-filters-label {
                width: calc(260px + 2.4rem);
            }
        }

        #algolia-content-container {

            .vs-sidebar {
                position: fixed;
                float: left;
                height: auto !important;
                min-height: 30px;
            }
        }

        .algolia-search-input-right-aligned-icon {
            padding: 1rem 1.5rem;
        }

        .algolia-price-slider {
            min-width: unset;
        }

        .item-view-primary-action-btn {
            color: #2c2c2c !important;
            background-color: #f6f6f6 !important;
            min-width: 50%;
        }

        .item-view-secondary-action-btn {
            min-width: 50%;
        }
    }

    .theme-dark {
        #algolia-instant-search-demo {
            #algolia-content-container {
                .vs-sidebar {
                    background-color: #10163a;
                    height: auto !important;
                    min-height: 30px;
                }
            }
        }
    }

    .item-view-primary-action-btn {
        color: #2c2c2c !important;
        background-color: #f6f6f6 !important;
        min-width: 50%;
    }

    #algolia-content-container {

        .vs-content-sidebar.items-no-padding.vs-sidebar-rounded.background-absolute {
            position: fixed;
            overflow-y: auto;
            height: 65%;
            width: 19rem;
        }

        .vs-sidebar.vs-sidebar-primary.vs-sidebar-parent {
            position: initial !important;
        }

        .sidebar-spacer-with-margin {
            position: relative;
        }

        /* width */
        .vs-content-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        /* Track */
        .vs-content-sidebar::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px grey;
            border-radius: 6px;
        }

        /* Handle */
        .vs-content-sidebar::-webkit-scrollbar-thumb {
            background: #64e185;
            border-radius: 6px;
        }

        /* Handle on hover */
        .vs-content-sidebar::-webkit-scrollbar-thumb:hover {
            background: red;
        }

    }

    @media (min-width: 992px) {
        .vs-sidebar-rounded {
            .vs-sidebar {
                border-radius: .5rem;
                height: auto !important;
                min-height: 30px;
            }

            .vs-sidebar--items {
                border-radius: .5rem;
            }
        }
    }

    @media (max-width: 992px) {
        #algolia-content-container {
            .vs-sidebar {
                position: absolute !important;
                float: none !important;
                height: auto !important;
                min-height: 30px;
            }
        }
    }

</style>

