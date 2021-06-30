<template>
    <div class="">
        <div class="algolia-header mb-4">
            <div class="flex md:items-end items-center justify-between flex-wrap">
                <!-- TOGGLE SIDEBAR BUTTON -->
                <feather-icon
                    class="inline-flex lg:hidden cursor-pointer mr-4"
                    icon="MenuIcon"
                    @click.stop="toggleFilterSidebar"/>

                <p class="lg:inline-flex hidden font-semibold algolia-filters-label">Filters</p>

                <div class="flex justify-between items-end flex-grow">
                    <!-- Stats -->
                    <!--                    <ais-stats>-->
                    <!--                        <p slot-scope="{ hitsPerPage, nbPages, nbHits, page, processingTimeMS, query }"-->
                    <!--                           class="font-semibold md:block hidden">-->
                    <!--                            {{ nbHits }} results found in {{ processingTimeMS }}ms-->
                    <!--                        </p>-->
                    <!--                    </ais-stats>-->

                    <div class="flex flex-wrap">

                        <!-- ITEM VIEW - GRID/LIST -->
                        <div>
                            <feather-icon
                                icon="GridIcon"
                                @click="currentItemView='item-grid-view'"
                                class="p-2 shadow-drop rounded-lg d-theme-dark-bg cursor-pointer"
                                :svgClasses="{'text-primary stroke-current': currentItemView == 'item-grid-view'}"/>
                            <feather-icon
                                icon="ListIcon"
                                @click="currentItemView='item-list-view'"
                                class="p-2 ml-4 shadow-drop rounded-lg d-theme-dark-bg cursor-pointer hidden sm:inline-flex"
                                :svgClasses="{'text-primary stroke-current': currentItemView == 'item-list-view'}"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="algolia-content-container" class="relative clearfix">
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
                            <li v-for="(item, index) in categories" :key="index"
                                class="flex items-center cursor-pointer py-1">
                                <vs-radio @change="selectCategory(item.id)" v-model="category" vs-name="radios1"
                                          :vs-value="item.id"><span
                                    class="ml-2 text-primary">{{ item.name }}</span>
                                </vs-radio>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <vs-divider/>
                        <!-- SUBCATEGORIES -->
                        <h6 class="font-bold mb-4">SubCategories</h6>
                        <div>
                            <ul>
                                <li class="flex items-center cursor-pointer py-1">
                                    <vs-checkbox vs-name="all" vs-value="all"><span
                                        class="ml-2 text-primary">All</span>
                                    </vs-checkbox>
                                </li>
                                <li v-for="(item, index) in subcategories" :key="index"
                                    class="flex items-center cursor-pointer py-1">
                                    <vs-checkbox @change="selectSubcategory(item.id)" v-model="subcategory"
                                                 vs-name="radios1"
                                                 :vs-value="item.id"><span
                                        class="ml-2 text-primary">{{ item.name }}</span>
                                    </vs-checkbox>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <vs-divider/>
                    <vs-button class="w-full">Remove Filters
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
                              v-model="currentRefinement" @input="refine($event)" @keyup.esc="refine('')" size="large"/>
                    <!-- SEARCH LOADING -->
                    <p :hidden="!isSearchStalled" class="mt-4 text-grey">
                        <feather-icon icon="ClockIcon" svgClasses="w-4 h-4" class="mr-2 align-middle"/>
                        <span>Loading...</span>
                    </p>

                    <!-- SEARCH ICON -->
                    <div slot="submit-icon" class="absolute top-0 right-0 py-4 px-6" v-show="!currentRefinement">
                        <feather-icon icon="SearchIcon" svgClasses="h-6 w-6"/>
                    </div>

                    <!-- CLEAR INPUT ICON -->
                    <div slot="reset-icon" class="absolute top-0 right-0 py-4 px-6" v-show="currentRefinement">
                        <feather-icon icon="XIcon" svgClasses="h-6 w-6 cursor-pointer" @click="refine('')"/>
                    </div>
                </div>
                <!--    </div>-->
                <!--List Items-->
                <!--        <div slot-scope="{ items }">-->

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
                                            @click="toggleItemInWishList(item)">
                                            <feather-icon icon="HeartIcon"
                                                          :svgClasses="[{'text-danger fill-current' : isInWishList(item.id)}, 'h-4 w-4']"/>

                                            <span class="text-sm font-semibold ml-2">WISHLIST</span>
                                        </div>

                                        <!-- SECONDARY BUTTON: ADD-TO/VIEW-IN CART -->
                                        <div
                                            class="item-view-secondary-action-btn bg-primary p-3 flex flex-grow items-center justify-center text-white cursor-pointer"
                                            @click="cartButtonClicked(item)">
                                            <feather-icon icon="ShoppingBagIcon" svgClasses="h-4 w-4"/>

                                            <span class="text-sm font-semibold ml-2" v-if="isInCart(item.id)">VIEW IN CART</span>
                                            <span class="text-sm font-semibold ml-2" v-else>ADD TO CART</span>
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
                <!--Page-->
                <vs-pagination
                    :total="total"
                    :max="7"
                    :value="1 + 1"
                    v-model="current_page"
                    @input="(val) => { changPage(current_page) }"/>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        components: {
            ItemGridView: () => import('./components/ItemGridView.vue'),
            ItemListView: () => import('./components/ItemListView.vue'),
        },
        data() {
            return {
                currentRefinement: null,
                category: this.$route.params.id,
                subcategory: [],
                current_page: 1,
                // Filter Sidebar
                isFilterSidebarActive: true,
                clickNotClose: true,
                currentItemView: 'item-grid-view',
            }
        },
        computed: {
            categories() {
                return this.$store.state.home.categories;
            },
            subcategories() {
                return this.$store.state.home.subcategories;
            },
            total() {
                return this.$store.state.home.total;
            },
            items() {
                return this.$store.state.home.products;
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
        }
        ,
        watch: {
            windowWidth() {
                this.setSidebarWidth()
            }
        }
        ,
        methods: {
            changPage(page) {
                this.$router.push({
                    name: 'CategoryDetail',
                    params: {id: this.$route.params.id},
                    query: {category_id: this.subcategory, page: page}
                })
                this.$store.dispatch('home/FETCH_CATEGORY_PRODUCTS', {
                    id: this.$route.params.id,
                    params: {category_id: this.subcategory, page: page}
                }).catch(err => {
                    console.error(err)
                });
            },
            selectCategory(id) {
                this.subcategory = [];
                this.$router.push({name: 'CategoryDetail', params: {id: id}})
                this.$store.dispatch('home/FETCH_CATEGORY_PRODUCTS', {
                    id: this.$route.params.id,
                    params: []
                }).catch(err => {
                    console.error(err)
                });
                this.$store.dispatch('home/FETCH_CATEGORIES').catch(err => {
                    console.error(err)
                });
            },
            selectSubcategory(id) {
                this.current_page = 1;
                this.$router.push({
                    name: 'CategoryDetail',
                    params: {id: this.$route.params.id},
                    query: {category_id: this.subcategory}
                })
                this.$store.dispatch('home/FETCH_CATEGORY_PRODUCTS', {
                    id: this.$route.params.id,
                    params: {category_id: this.subcategory}
                }).catch(err => {
                    console.error(err)
                });
                this.$store.dispatch('home/FETCH_CATEGORIES').catch(err => {
                    console.error(err)
                });
            },

            setSidebarWidth() {
                if (this.windowWidth < 992) {
                    this.isFilterSidebarActive = this.clickNotClose = false
                } else {
                    this.isFilterSidebarActive = this.clickNotClose = true
                }
            }
            ,

            // GRID VIEW - ACTIONS
            toggleFilterSidebar() {
                if (this.clickNotClose) return
                this.isFilterSidebarActive = !this.isFilterSidebarActive
            }
            ,
            toggleItemInWishList(item) {
                this.$store.dispatch('home/toggleItemInWishList', item)
            }
            ,
            additemInCart(item) {
                this.$store.dispatch('home/additemInCart', item)
            }
            ,
            cartButtonClicked(item) {
                this.isInCart(item.id) ? this.$router.push({name: 'Cart'}).catch(() => {
                }) : this.additemInCart(item)
            }
        }
        ,
        created() {
            this.$store.dispatch('home/FETCH_CATEGORY_PRODUCTS', {
                id: this.$route.params.id,
                params: []
            }).catch(err => {
                console.error(err)
            });
            this.$store.dispatch('home/FETCH_CATEGORIES').catch(err => {
                console.error(err)
            });
            this.setSidebarWidth()
        }
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
                position: relative;
                float: left;
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
            background-color: #f6f6f6;
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
                }
            }
        }
    }

    @media (min-width: 992px) {
        .vs-sidebar-rounded {
            .vs-sidebar {
                border-radius: .5rem;
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
            }
        }
    }

</style>

