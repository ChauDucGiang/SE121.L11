<template>
    <div id="item-detail-page">

        <vx-card v-if="productData" :key="productData.id">


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
                                        <swiper-slide :key="i" v-for="(image, i ) in productData.images">
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
                                <h3 class="uppercase">{{ productData.name }}</h3>
                                <p class="my-2">
                                    <span class="mr-2">Product code: </span>
                                    <span>{{ productData.code }}</span>
                                </p>
                                <p class="flex items-center flex-wrap">
                                    <!--                  <span class="mr-2 font-bold">Product price: </span>-->
                                    <span class="text-2xl leading-none font-medium text-primary mr-4 mt-2">${{ productData.price }}</span>
                                </p>

                                <h3 class="pt-4">Product Info</h3>
                                <vs-divider class="py-0 mt-0"/>
                                <p class="my-2">
                                    <span class="mr-2 font-bold">Size: </span>
                                    <span>{{ `L${productData.size_l} x W${productData.size_w} x H${productData.size_h}` }} cm</span>
                                </p>
                                <p class="my-2">
                                    <span class="mr-2 font-bold">Materials: </span>
                                    <span>{{ productData.materials }}</span>
                                </p>

                                <p class="my-2">
                                    <span class="mr-2 font-bold">Weaving: </span>
                                    <span>{{ productData.weaving }}</span>
                                </p>
                                <p class="my-2">
                                    <span class="mr-2 font-bold">Extra Info: </span>
                                    <span>{{ productData.info }}</span>
                                </p>

                                <vs-divider/>

                                <!-- Color -->
                                <div class="vx-row">
                                    <div class="vx-col w-full">
                                        <p class="my-2">
                                            <span class="mr-2 font-bold">Color: </span>
                                            <span>{{ productData.color }}</span>
                                        </p>
                                    </div>
                                </div>
                                <!-- /Color -->

                                <h3 class="pt-4">Packing and Loading</h3>
                                <vs-divider class="py-0 mt-0"/>

                                <div class="vx-row">
                                    <div class="vx-col md:w-1/2 w-full">
                                        <div class="w-full mx-auto mb-16 md:mb-0">
                                            <p class="my-2">
                                                <span class="mr-2 font-bold">Carton QTY: </span>
                                                <span>{{ productData.ctn_qty }} units/CTN</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="vx-col md:w-1/2 w-full">
                                        <p class="my-2">
                                            <span class="mr-2 font-bold">Carton CBM: </span>
                                            <span>{{ productData.cbm }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="vx-row text-center my-3">
                                    <div class="vx-col md:w-1/3 w-full">
                                        <div class="w-full mx-auto mb-16 md:mb-0 text-left">
                                            <span class="font-bold">QTY 20'DC</span>
                                            <p class="mt-2 pl-8">{{ productData.ctn_l }}</p>
                                        </div>
                                    </div>
                                    <div class="vx-col md:w-1/3 w-full">
                                        <span class="font-bold">QTY 40'DC</span>
                                        <p class="mt-2">{{ productData.ctn_w }}</p>
                                    </div>
                                    <div class="vx-col md:w-1/3 w-full">
                                        <span class="font-bold">QTY 40'HC</span>
                                        <p class="mt-2">{{ productData.ctn_h }}</p>
                                    </div>
                                </div>
                                <vs-divider/>

                                <!-- Color -->
                                <div class="vx-row">
                                    <div class="vx-col w-full">
                                        <p class="my-2">
                                            <span class="mr-2 font-bold">Ref: </span>
                                            <span class="text-primary cursor-pointer"
                                                  v-for="(customer, i) in productData.customers"
                                                  @click="$router.push({name: 'OrderList', query: {page: 1, customer_id: customer.id}})">{{ customer.code }} <span
                                                class="text-bold text-black">, </span></span>
                                        </p>
                                    </div>
                                </div>
                                <!-- /Color -->
                                <vs-divider/>
                                <!-- Quantity -->
                                <div class="vx-row">

                                    <div class="vx-col w-full">
                                        <div class="flex flex-wrap items-start mb-4">

                                            <!-- Add To Cart Button -->
                                            <vs-button
                                                class="mr-4 mb-4"
                                                icon-pack="feather"
                                                icon="icon-edit"
                                                @click="$router.push({name: 'ProductEdit', params:{id: productData.id}}).catch(err => {})">
                                                EDIT
                                            </vs-button>

                                            <vs-button
                                                class="mr-4 mb-4"
                                                icon-pack="feather"
                                                icon="icon-delete"
                                                color="danger"
                                                @click="$router.push({name: 'home-checkout'}).catch(err => {})">
                                                DELETE
                                            </vs-button>
                                            <!-- /Add To Cart Button -->


                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </template>
        </vx-card>
    </div>
</template>

<script>
    import 'swiper/dist/css/swiper.min.css'
    import {swiper, swiperSlide} from 'vue-awesome-swiper'

    export default {
        components: {
            swiper,
            swiperSlide,
        },
        data() {
            return {
                productData: [],
                image_show: null,
                // Related Products Swiper
                swiperOptionTop: {
                    spaceBetween: 10,
                    centeredSlides: true,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev'
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    },
                },
                swiperOptionThumbs: {
                    spaceBetween: 10,
                    centeredSlides: true,
                    slidesPerView: 'auto',
                    touchRatio: 0.2,
                    slideToClickedSlide: true
                }
            }
        },
        methods: {
            changeImage(image) {
                this.image_show = image;
            }
        },
        created() {
            this.$store.dispatch('product/FETCH_PRODUCT', this.$route.params.id).then(data => {
                this.productData = data.data;
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


    #item-detail-page {
        .con-example-images {
            max-height: 80px;
            /*overflow-x: auto;*/
        }

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

        .swiper-container {
            /*background-color: #000;*/
        }

        .gallery-top {
            /*height: 10% !important;*/
            width: 100%;
        }

        .gallery-thumbs {
            height: 15% !important;
            box-sizing: border-box;
            padding: 10px 0;
        }

        .gallery-thumbs .swiper-slide {
            width: 25%;
            height: 15%;
            opacity: 0.4;
        }

        .gallery-thumbs .swiper-slide-active {
            opacity: 1;
        }

        .swiper-wrapper {
            align-items: center;
        }
    }
</style>
