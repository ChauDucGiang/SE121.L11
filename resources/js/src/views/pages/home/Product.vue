<template>
    <div id="item-detail-page">

        <vs-alert color="danger" title="Error Fetching Product Data" :active.sync="error_occured">
            <span>{{ error_msg }}. </span>
            <span>
        <span>Check </span><router-link :to="{name:'ecommerce-shop'}"
                                        class="text-inherit underline">All Items</router-link>
      </span>
        </vs-alert>

        <vx-card v-if="item_data" :key="item_data.id">


            <template slot="no-body">

                <div class="item-content">
                    <!-- Item Main Info -->
                    <div class="product-details p-6">
                        <div class="vx-row mt-6">
                            <div class="vx-col md:w-2/5 w-full flex items-center justify-center">
                                <div class="product-img-container w-full mx-auto mb-10 md:mb-0">
                                    <swiper :options="swiperOptionTop" class="gallery-top items-center"
                                            ref="swiperTop"
                                            :dir="$vs.rtl ? 'rtl' : 'ltr'">
                                        <swiper-slide :key="i" v-for="(image, i ) in item_data.images">
                                            <img class="responsive" :src="image['url']"
                                                 alt="images">
                                        </swiper-slide>
                                        <div class="swiper-button-next swiper-button-green" slot="button-next"></div>
                                        <div class="swiper-button-prev swiper-button-green" slot="button-prev"></div>
                                    </swiper>

                                    <!-- swiper2 Thumbs -->
                                    <!--                                    <swiper :options="swiperOptionThumbs" class="gallery-thumbs "-->
                                    <!--                                            ref="swiperThumbs"-->
                                    <!--                                            :dir="$vs.rtl ? 'rtl' : 'ltr'">-->
                                    <!--                                        <swiper-slide :key="index" v-for="(image, index ) in productData.images">-->
                                    <!--                                            <img class="responsive" :src="image['url']"-->
                                    <!--                                                 alt="thumbs">-->
                                    <!--                                        </swiper-slide>-->
                                    <!--                                    </swiper>-->
                                </div>
                            </div>
                            <!-- Item Content -->
                            <div class="vx-col md:w-3/5 w-full">
                                <h3 class="uppercase">{{ item_data.name }}</h3>
                                <p class="my-2">
                                    <span class="mr-2">Product code: </span>
                                    <span>{{ item_data.code }}</span>
                                </p>
                                <p class="flex items-center flex-wrap">
                                    <!--                  <span class="mr-2 font-bold">Product price: </span>-->
                                    <span class="text-2xl leading-none font-medium text-primary mr-4 mt-2">${{ item_data.price }}</span>
                                </p>

                                <h3 class="pt-4">Product Info</h3>
                                <vs-divider class="py-0 mt-0"/>
                                <p class="my-2">
                                    <span class="mr-2 font-bold">Size: </span>
                                    <span>{{ `L${item_data.size_l} x W${item_data.size_w} x H${item_data.size_h}` }} cm</span>
                                </p>
                                <p class="my-2">
                                    <span class="mr-2 font-bold">Materials: </span>
                                    <span>{{ item_data.materials }}</span>
                                </p>
                                <p class="my-2">
                                    <span class="mr-2 font-bold">Weaving: </span>
                                    <span>{{ item_data.weaving }}</span>
                                </p>
                                <p class="my-2">
                                    <span class="mr-2 font-bold">Extra Info: </span>
                                    <span>{{ item_data.info }}</span>
                                </p>

                                <vs-divider/>

                                <!-- Color -->
                                <div class="vx-row">
                                    <div class="vx-col w-full">
                                        <p class="my-2">
                                            <span class="mr-2 font-bold">Color: </span>
                                            <span>{{ item_data.color }}</span>
                                        </p>
                                    </div>
                                </div>
                                <!-- /Color -->

                                <h3 class="pt-4">Packing Loading</h3>
                                <vs-divider class="py-0 mt-0"/>

                                <div class="vx-row">
                                    <div class="vx-col md:w-1/2 w-full">
                                        <div class="w-full mx-auto mb-16 md:mb-0">
                                            <p class="my-2">
                                                <span class="mr-2 font-bold">Carton QTY: </span>
                                                <span>{{ item_data.ctn_qty }} units/CTN</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="vx-col md:w-1/2 w-full">
                                        <p class="my-2">
                                            <span class="mr-2 font-bold">Carton CBM: </span>
                                            <span>{{ item_data.cbm }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="vx-row text-center my-3">
                                    <div class="vx-col md:w-1/3 w-full">
                                        <div class="w-full mx-auto mb-16 md:mb-0 text-left">
                                            <span class="font-bold">QTY 20'DC</span>
                                            <p class="mt-2 pl-8">{{ item_data.ctn_l }}</p>
                                        </div>
                                    </div>
                                    <div class="vx-col md:w-1/3 w-full">
                                        <span class="font-bold">QTY 40'DC</span>
                                        <p class="mt-2">{{ item_data.ctn_w }}</p>
                                    </div>
                                    <div class="vx-col md:w-1/3 w-full">
                                        <span class="font-bold">QTY 40'HC</span>
                                        <p class="mt-2">{{ item_data.ctn_h }}</p>
                                    </div>
                                </div>
                                <vs-divider/>
                                <!-- Color -->
                                <div class="vx-row">
                                    <div class="vx-col w-full">
                                        <p class="my-2">
                                            <span class="mr-2 font-bold">Ref: </span>
                                            <span class="text-primary cursor-pointer"
                                                  v-for="(customer, i) in item_data.customers"
                                                  @click="$router.push({name:'List', query:{page:1, category_id:0, customer_id: customer.id}})">{{customer.code}}<span
                                                class="text-bold text-black">, </span></span>
                                        </p>
                                    </div>
                                </div>
                                <vs-divider/>
                                <!-- Quantity -->
                                <div class="vx-row">

                                    <div class="vx-col w-full">
                                        <div class="flex flex-wrap items-start mb-4">


                                            <!-- Add To Cart Button -->
                                            <vs-button
                                                class="mr-4 mb-4"
                                                icon-pack="feather"
                                                icon="icon-shopping-cart"
                                                v-if="!isInCart(item_data.id)"
                                                @click="toggleItemInCart(item_data)">
                                                SELECT
                                            </vs-button>

                                            <vs-button
                                                v-else
                                                class="mr-4 mb-4"
                                                color="success"
                                                icon-pack="feather"
                                                icon="icon-shopping-cart"
                                                @click="$router.push({name: 'Cart'}).catch(err => {})">
                                                VIEW SELECTED
                                            </vs-button>
                                            <!-- /Add To Cart Button -->


                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <vs-divider/>
                <!-- Related Products -->
                <div class="related-products text-center px-6">

                    <div class="related-headings mb-8 text-center">
                        <h2 class="uppercase">Related Products</h2>
                    </div>
                    <swiper :options="swiperOption" :dir="$vs.rtl ? 'rtl' : 'ltr'" :key="$vs.rtl"
                            class="related-product-swiper px-12 py-6">
                        <swiper-slide v-for="item in related_items" :key="item.id" class="p-6 rounded cursor-pointer"
                        >
                            <div @click="navigate_to_detail_view(item.id)">

                                <!-- Item Heading -->
                                <div class="item-heading mb-4">
                                    <p class="text-lg font-semibold truncate">{{ item.name }}</p>
                                    <p class="text-sm">
                                        <span class="mr-2">Product code:</span>
                                        <span>{{ item.code }}</span>
                                    </p>
                                </div>

                                <!-- Item Image -->
                                <div class="img-container w-32 mx-auto my-base">
                                    <img class="responsive" :src="item.images[0]['url']" :alt="item.name">
                                </div>

                                <!-- Item Meta -->
                                <div class="item-meta">
                                    <p class="item-description truncate text-sm font-medium"><small class="text-black">{{
                                        `L${item.size_l} x
                                        W${item.size_w} x H${item.size_h}` }} cm</small></p>
                                </div>
                            </div>
                        </swiper-slide>
                        <div class="swiper-button-prev" slot="button-prev"></div>
                        <div class="swiper-button-next" slot="button-next"></div>
                    </swiper>
                </div>

            </template>
        </vx-card>
    </div>
</template>

<script>
    import 'swiper/dist/css/swiper.min.css'
    import {swiper, swiperSlide} from 'vue-awesome-swiper'
    import EventBus from "../../../EventBus";

    export default {
        components: {
            swiper,
            swiperSlide,
        },
        data() {
            return {
                users: [
                    {
                        "id": 1,
                        "name": "Leanne Graham",
                        "username": "Bret",
                        "email": "Sincere@april.biz",
                        "website": "hildegard.org",
                    }],
                item_data: [],
                error_occured: false,
                error_msg: '',
                // Related Products Swiper
                swiperOptionTop: {
                    spaceBetween: 10,
                    centeredSlides: true,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev'
                    }
                },
                swiperOptionThumbs: {
                    spaceBetween: 10,
                    centeredSlides: true,
                    slidesPerView: 'auto',
                    touchRatio: 0.2,
                    slideToClickedSlide: true
                },
                // Related Products Swiper
                swiperOption: {
                    slidesPerView: 5,
                    spaceBetween: 55,
                    breakpoints: {
                        1600: {
                            slidesPerView: 4,
                            spaceBetween: 55
                        },
                        1300: {
                            slidesPerView: 3,
                            spaceBetween: 55
                        },
                        900: {
                            slidesPerView: 2,
                            spaceBetween: 55
                        },
                        640: {
                            slidesPerView: 1,
                            spaceBetween: 55
                        }
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev'
                    }
                },

                // Below is data which is common in any item
                // Algolia's dataSet don't provide this kind of data. So, here's dummy data for demo
                available_item_colors: ['#7367F0', '#28C76F', '#EA5455', '#FF9F43', '#1E1E1E'],
                opt_color: '#7367F0',
                is_hearted: false,

                related_items: []
            }
        },
        computed: {
            item_qty() {
                const item = this.$store.getters['home/getCartItem'](this.item_data.id)
                return Object.keys(item).length ? item.quantity : 1
            },
            itemColor() {
                return (obj) => {
                    const style_obj = {}

                    obj.style.forEach(p => {
                        style_obj[p] = obj.color
                    })

                    return style_obj
                }
            },
            isInWishList() {
                return (itemId) => this.$store.getters['home/isInWishList'](itemId)
            },
            isInCart() {
                return (itemId) => this.$store.getters['home/isInCart'](itemId)
            }
        },
        methods: {
            navigate_to_detail_view(id) {
                this.$router.push({name: 'ProductDetail', params: {id: id}}).catch(() => {
                });
                this.$store.dispatch('home/FETCH_PRODUCT', id).then(res => {
                    this.item_data = res.item_data;
                    this.related_items = res.related_items;
                })
            },
            toggleItemInWishList(item) {
                this.$store.dispatch('home/toggleItemInWishList', item)
            },
            toggleItemInCart(item) {
                this.$store.dispatch('home/toggleItemInCart', item)
            },
        },
        created() {
            EventBus.$on('changeProductDetail', (data) => {
                this.$store.dispatch('home/FETCH_PRODUCT', data.id).then(res => {
                    this.item_data = res.item_data;
                    this.related_items = res.related_items;
                }).catch(err => {
                    console.error(err)
                })
            })
            this.$store.dispatch('home/FETCH_PRODUCT', this.$route.params.id).then(res => {
                this.item_data = res.item_data;
                this.related_items = res.related_items;
            }).catch(err => {
                console.error(err)
            })
        },
        // mounted() {
        //     this.$nextTick(() => {
        //         const swiperTop = this.$refs.swiperTop.swiper
        //         const swiperThumbs = this.$refs.swiperThumbs.swiper
        //         swiperTop.controller.control = swiperThumbs
        //         swiperThumbs.controller.control = swiperTop
        //     })
        // },
    }
</script>

<style lang="scss">

    @import "@sass/vuexy/_variables.scss";

    /*.list-item {*/
    /*    display: block;*/
    /*    float: left;*/
    /*}*/

    /*.preview {*/
    /*    display: -webkit-box;*/
    /*    display: -webkit-flex;*/
    /*    display: -ms-flexbox;*/
    /*    display: flex;*/
    /*    -webkit-box-orient: vertical;*/
    /*    -webkit-box-direction: normal;*/
    /*    -webkit-flex-direction: column;*/
    /*    -ms-flex-direction: column;*/
    /*    flex-direction: column;*/
    /*}*/

    @media screen and (max-width: 996px) {
        .preview {
            margin-bottom: 20px;
        }
    }


    @media screen and (min-width: 997px) {
        .wrapper {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
        }
    }

    .details {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
    }

    .colors {
        -webkit-box-flex: 1;
        -webkit-flex-grow: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
    }

    .product-title, .price, .sizes, .colors {
        text-transform: UPPERCASE;
        font-weight: bold;
    }

    .checked, .price span {
        color: #ff9f1a;
    }

    .product-title, .rating, .product-description, .price, .vote, .sizes {
        margin-bottom: 15px;
    }

    .product-title {
        margin-top: 0;
    }

    .size {
        margin-right: 10px;
    }

    .size:first-of-type {
        margin-left: 40px;
    }

    .color {
        display: inline-block;
        vertical-align: middle;
        margin-right: 10px;
        height: 2em;
        width: 2em;
        border-radius: 2px;
    }

    .color:first-of-type {
        margin-left: 20px;
    }

    .add-to-cart, .like {
        background: #ff9f1a;
        padding: 1.2em 1.5em;
        border: none;
        text-transform: UPPERCASE;
        font-weight: bold;
        color: #fff;
        -webkit-transition: background .3s ease;
        transition: background .3s ease;
    }

    .add-to-cart:hover, .like:hover {
        background: #b36800;
        color: #fff;
    }

    .not-available {
        text-align: center;
        line-height: 2em;
    }

    .not-available:before {
        font-family: fontawesome;
        content: "\f00d";
        color: #fff;
    }

    .orange {
        background: #ff9f1a;
    }

    .green {
        background: #85ad00;
    }

    .blue {
        background: #0076ad;
    }

    .tooltip-inner {
        padding: 1.3em;
    }

    @-webkit-keyframes opacity {
        0% {
            opacity: 0;
            -webkit-transform: scale(3);
            transform: scale(3);
        }
        100% {
            opacity: 1;
            -webkit-transform: scale(1);
            transform: scale(1);
        }
    }

    @keyframes opacity {
        0% {
            opacity: 0;
            -webkit-transform: scale(3);
            transform: scale(3);
        }
        100% {
            opacity: 1;
            -webkit-transform: scale(1);
            transform: scale(1);
        }
    }


    #item-detail-page {
        .color-radio {
            height: 2.28rem;
            width: 2.28rem;

            > div {
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
        }

        .item-features {
            background-color: #f7f7f7;

            .theme-dark & {
                background-color: $theme-dark-secondary-bg;
            }
        }

        .product-sales-meta-list {
            .vs-list--icon {
                padding-left: 0;
            }
        }

        .related-product-swiper {
            // padding-right: 2rem;
            // padding-left: 2rem;

            .swiper-wrapper {
                padding-bottom: 2rem;

                > .swiper-slide {
                    background-color: #f7f7f7;
                    box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.1), 0 5px 12px 0 rgba(0, 0, 0, 0.08) !important;

                    .theme-dark & {
                        background-color: $theme-light-dark-bg;
                    }
                }
            }

            .swiper-button-next,
            .swiper-button-prev {
                transform: scale(.5);
                filter: hue-rotate(40deg);
            }

            .swiper-button-next {
                right: 0
            }

            .swiper-button-prev {
                left: 0;
            }
        }
    }

    .swiper-container {
        /*background-color: #000;*/
    }

    .gallery-top {
        height: 60% !important;
        width: 100%;
    }

    /*.gallery-top .swiper-slide image {*/
    /*    height: 60% !important;*/
    /*    width: 100%;*/
    /*}*/

    .gallery-thumbs {
        height: 20% !important;
        box-sizing: border-box;
        padding: 10px 0;
    }

    .gallery-thumbs .swiper-slide {
        width: 25%;
        height: 100%;
        opacity: 0.4;
    }

    .gallery-thumbs .swiper-slide-active {
        opacity: 1;
    }

    .gallery-top .swiper-wrapper {
        align-items: center;
    }
</style>
