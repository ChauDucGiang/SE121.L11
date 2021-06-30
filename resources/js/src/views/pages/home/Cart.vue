<template>
    <div id="ecommerce-checkout-demo">
        <div class="hidden">
            <div id="canvas" ref="content">
                <!-- Page Content -->
                <div class="mainWrappers" v-for="(item_export, i) in items_export">
                    <br>
                    <div class="container">
                        <div class="header-top row">
                            <div class="col-sm-6">
                                <a><img class="image-export" src="/images/exports/title.jpg" alt=""/></a>
                            </div>
                            <div class="product-name col-sm-6 text-center font-weight-bold "><h4
                                class="text-uppercase float-right">
                                {{`${item_export.name}`}}</h4>
                            </div>
                        </div>
                        <div class="content-page row">
                            <div class="col-left col-sm-6">
                                <div class="text-center img-thumb-1"><img class="image-export"
                                                                          :src="item_export.images_export[0]"/>
                                </div>
                                <div class="text-center img-thumb img-thumb-2"><img class="image-export"
                                                                                    :src="item_export.images_export[1]"/>
                                </div>
                            </div>
                            <div class="col-right col-sm-6">
                                <div class="content-top mt-auto mb-auto">
                                    <ul class="list-unstyled">
                                        <li class="text-uppercase">CODE PRODUCT: <strong>{{item_export.code}}</strong>
                                        </li>
                                        <li class="text-uppercase" v-if="item_export.weaving">PRODUCT SPEC: <strong>{{`${item_export.materials}-${item_export.weaving}-${item_export.color}`}}</strong>
                                        </li>
                                        <li class="text-uppercase" v-else>PRODUCT
                                            SPEC: <strong>{{`${item_export.materials}-${item_export.color}`}}</strong>
                                        </li>
                                        <li>
                                            SIZE:<strong>{{`L${item_export.size_l}xW${item_export.size_w}xH${item_export.size_h}cm.`}}</strong>
                                            CARTON QTY:<strong>{{`
                                            ${('0' +
                                            item_export.ctn_qty).slice(-2)}${item_export.package.name}.`}}</strong>
                                            CARTON SIZE:<strong>{{`L${formatNumber(item_export.ctn_l)}xW${formatNumber(item_export.ctn_w)}xH${formatNumber(item_export.ctn_h)}cm`}}</strong>
                                        </li>
                                        <li>CARTON CBM:<strong>{{item_export.cbm}}.</strong>LOADABILITY<strong>{{`:
                                            20'DC:${formatNumber(parseInt((27/item_export.cbm)*item_export.ctn_qty))}(${item_export.package.name})-40DC:${formatNumber(parseInt((57/item_export.cbm)*item_export.ctn_qty))}(${item_export.package.name})-50HC:${formatNumber(parseInt((64/item_export.cbm)*item_export.ctn_qty))}(${item_export.package.name})`}}</strong>
                                        </li>
                                        <li class="text-uppercase">FOB
                                            HCMC(USD):<strong>{{currencyFormat(parseInt(item_export.new_price))}}</strong>
                                        </li>

                                    </ul>
                                </div>
                                <div class="justify-content-center img-thumb img-thumb-3"><img class="image-export"
                                                                                               :src="item_export.images_export[2]"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <form-wizard
            ref="checkoutWizard"
            color="rgba(var(--vs-primary), 1)"
            :title="null"
            :subtitle="null"
            :hide-buttons="true">

            <!-- tab 1 content -->
            <tab-content title="Selected" icon="feather icon-shopping-cart" class="mb-5">

                <!-- IF CART HAVE ITEMS -->
                <div class="vx-row" v-if="cartItems.length">
                    <!-- LEFT COL -->
                    <div class="vx-col lg:w-2/3 w-full relative">
                        <div class="items-list-view" v-for="(item, index) in cartItems" :key="item.id">
                            <item-list-view-cart :item="item" class="mb-base">

                                <!-- SLOT: ITEM META -->
                                <template slot="item-meta">
                                    <h6
                                        class="item-name font-semibold mb-1 cursor-pointer hover:text-primary"
                                        @click="$router.push({name: 'ProductDetail', params: {id: item.id }}).catch(() => {})">
                                        {{ item.name }}</h6>
                                    <p class="text-sm mb-2 font-semibold">Product code: <span
                                        class="cursor-pointer font-normal">{{ item.code }}</span></p>
                                    <p class="text-success font-bold">${{item.price}}</p>
                                    <vs-divider position="left-center" class="py-0 mt-0">
                                        Product Info
                                    </vs-divider>
                                    <p class="my-2">
                                        <span class="mr-2 font-bold">Size: </span>
                                        <span>{{ `L${item.size_l} x W${item.size_w} x H${item.size_h}` }} cm</span>
                                    </p>
                                    <p class="my-2">
                                        <span class="mr-2 font-bold">Materials: </span>
                                        <span>{{ item.materials }}</span>
                                    </p>
                                    <p class="my-2">
                                        <span class="mr-2 font-bold">Weaving: </span>
                                        <span>{{ item.weaving }}</span>
                                    </p>
                                    <p class="my-2">
                                        <span class="mr-2 font-bold">Extra Info: </span>
                                        <span>{{ item.info }}</span>
                                    </p>
                                    <vs-divider class="py-0 mt-0"/>
                                    <p class="my-2">
                                        <span class="mr-2 font-bold">Color: </span>
                                        <span>{{ item.color }}</span>
                                    </p>
                                    <vs-divider position="left-center" class="py-0 mt-0">
                                        Packing and Loading
                                    </vs-divider>
                                    <div class="vx-row">
                                        <div class="vx-col md:w-1/2 w-full">
                                            <div class="w-full mx-auto mb-16 md:mb-0">
                                                <p class="my-2">
                                                    <span class="mr-2 font-bold">Carton QTY: </span>
                                                    <span>{{ item.ctn_qty }} units/CTN</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="vx-col md:w-1/2 w-full">
                                            <p class="my-2">
                                                <span class="mr-2 font-bold">Carton CBM: </span>
                                                <span>{{ item.cbm }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="vx-row text-center my-3">
                                        <div class="vx-col md:w-1/3 w-full">
                                            <div class="w-full mx-auto mb-16 md:mb-0 text-left">
                                                <span class="font-bold">QTY 20'DC</span>
                                                <p class="mt-2 pl-8">{{ item.ctn_l }}</p>
                                            </div>
                                        </div>
                                        <div class="vx-col md:w-1/3 w-full">
                                            <span class="font-bold">QTY 40'DC</span>
                                            <p class="mt-2">{{ item.ctn_w }}</p>
                                        </div>
                                        <div class="vx-col md:w-1/3 w-full">
                                            <span class="font-bold">QTY 40'HC</span>
                                            <p class="mt-2">{{ item.ctn_h }}</p>
                                        </div>
                                    </div>
                                </template>

                                <!-- SLOT: ACTION BUTTONS -->
                                <template slot="action-buttons">
                                    <div class="my-6 text-center">
                                        <p class="mt-4 font-bold text-sm">New price</p>
                                        <vs-input-number min="1" :value="item.new_price"
                                                         @input="updateItemPrice($event, index)"
                                                         class="inline-flex"/>
                                    </div>
                                    <!-- PRIMARY BUTTON: REMOVE -->
                                    <div
                                        class="item-view-primary-action-btn p-3 rounded-lg flex flex-grow items-center justify-center cursor-pointer mb-3"
                                        @click="removeItemFromCart(item)">
                                        <feather-icon icon="XIcon" svgClasses="h-4 w-4"/>
                                        <span class="text-sm font-semibold ml-2">REMOVE</span>
                                    </div>

                                    <!-- SECONDARY BUTTON: MOVE-TO/VIEW-IN WISHLIST -->
                                    <div
                                        class="item-view-secondary-action-btn p-3 rounded-lg flex flex-grow items-center justify-center text-white cursor-pointer mb-3"
                                        :class="(item.images_export.length == 3 )?('bg-success'):('bg-danger')"
                                        @click="selectImages(item, index)">
                                        <feather-icon icon="ImageIcon" svgClasses="h-4 w-4"/>
                                        <span class="text-sm font-semibold ml-2">Select Images</span>
                                    </div>
                                    <!-- SECONDARY BUTTON: MOVE-TO/VIEW-IN WISHLIST -->
                                    <vs-button @click="createPDF(item)" color="warning" icon="picture_as_pdf"
                                               :disabled="(item.images_export[0] && item.images_export[1] && item.images_export[2]  )?false:true"
                                               type="filled">
                                        View PDF
                                    </vs-button>
                                </template>
                            </item-list-view-cart>
                        </div>
                    </div>

                    <!-- RIGHT COL -->
                    <div class="vx-col lg:w-1/3 w-full">
                        <vx-card>
                            <div class="vx-row">
                                <div class="vx-col w-1/2">
                                    <vs-button @click="downloadPdf()" :disabled="!isReadyToDowload" class="w-full"
                                               icon="cloud_download"
                                               type="gradient">
                                        Download All PDF
                                    </vs-button>
                                    <vs-progress v-if="progress > 0" :height="8" :percent="progress" color="primary">
                                        danger
                                    </vs-progress>
                                </div>
                                <div class="vx-col w-1/2">
                                    <vs-select
                                        :success="true"
                                        autocomplete
                                        placeholder="Select Photo Offer"
                                        class="w-full"
                                        v-model="photoOffers_type">
                                        <vs-select-item :key="index" :value="item.type" :text="item.text"
                                                        v-for="(item,index) in photoOffers"/>
                                    </vs-select>
                                </div>
                            </div>
                            <vs-divider/>
                            <p class="text-grey mb-3">Customer</p>
                            <div class="flex justify-between">
                                <vs-select
                                    autocomplete
                                    placeholder="Select Customer"
                                    class="w-full"
                                    v-model="customer"
                                    @change="department = null"
                                >
                                    <vs-select-item :key="index" :value="item" :text="item.code"
                                                    v-for="(item,index) in customers"/>
                                </vs-select>
                            </div>

                            <vs-divider/>

                            <p class="font-semibold mb-3">Customer Info</p>
                            <div v-if="customer.hasOwnProperty('id')">
                                <div class="flex justify-between mb-2">
                                    <span>Code</span>
                                    <span class="text-success">{{customer.code}}</span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span>Company Name</span>
                                    <span>{{customer.company}}</span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span>Country</span>
                                    <span>{{customer.country.name}}</span>
                                </div>

                                <div class="flex justify-between mb-2">
                                    <span>Email</span>
                                    <span>{{customer.email}}</span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span>Phone</span>
                                    <span>{{customer.phone}}</span>
                                </div>
                            </div>

                            <vs-divider/>
                            <div v-if="customer.hasOwnProperty('id') && customer.department">
                                <p class="text-grey mb-3">Department</p>
                                <div class="flex justify-between">
                                    <vs-select
                                        :danger="!department"
                                        autocomplete
                                        placeholder="Select Department"
                                        class="w-full"
                                        v-model="department">
                                        <vs-select-item :key="index" :value="item" :text="item"
                                                        v-for="(item,index) in customer.department.split(' ')"/>
                                    </vs-select>
                                </div>

                                <vs-divider/>
                            </div>
                            <vs-button :disabled="!customer.hasOwnProperty('id')" class="w-full" color="success"
                                       @click="submitCheckout">COMPLETE
                            </vs-button>
                        </vx-card>
                    </div>
                </div>

                <!-- IF NO ITEMS IN CART -->
                <vx-card title="You don't have any items in your cart." v-else>
                    <vs-button @click="$router.push({name:'List'}).catch(() => {})">Back To Shop
                    </vs-button>
                </vx-card>

            </tab-content>

            <!-- tab 3 content -->
            <tab-content title="Done" icon="feather icon-check" class="mb-5">

                <div class="vx-row">

                    <!-- LEFT COL: PAYMENT OPTIONS -->
                    <div class="vx-col lg:w-2/3 w-full">
                        <vx-card title="Order Details"
                                 class="mb-base">

                            <div class="mt-3" v-if="order">
                                <vs-table :data="order.orderdetails">
                                    <template slot="thead">
                                        <vs-th>
                                            ID
                                        </vs-th>
                                        <vs-th>
                                            Product Code
                                        </vs-th>
                                        <vs-th>
                                            Product Name
                                        </vs-th>
                                        <vs-th>
                                            Image
                                        </vs-th>
                                        <vs-th>
                                            Price
                                        </vs-th>
                                    </template>

                                    <template slot-scope="{data}">
                                        <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                                            <vs-td>
                                                {{indextr + 1}}
                                            </vs-td>
                                            <vs-td :data="data[indextr].product.code">
                                                {{data[indextr].product.code}}
                                            </vs-td>
                                            <vs-td :data="data[indextr].product.name">
                                                {{data[indextr].product.name}}
                                            </vs-td>
                                            <vs-td :data="data[indextr].product.name">
                                                <div class="con-userx flex items-center justify-start">
                                                    <div class="md:flex-shrink-0">
                                                        <img class="rounded-lg md:w-56"
                                                             :src="data[indextr].product.images[0]['url']"
                                                             width="98"
                                                             height="65" :alt="data[indextr].product.name">
                                                    </div>
                                                </div>
                                            </vs-td>
                                            <vs-td :data="data[indextr].new_price">
                                                $ {{data[indextr].new_price}}
                                            </vs-td>
                                        </vs-tr>
                                    </template>
                                </vs-table>

                            </div>
                        </vx-card>
                    </div>

                    <!-- RIGHT COL: PRICE -->
                    <div class="vx-col lg:w-1/3 w-full">
                        <vx-card title="Price Details" v-if="order">

                            <div class="flex justify-between mb-2">
                                <span>Order Code</span>
                                <span class="font-semibold">{{order.code}}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span>Customer Code</span>
                                <span class="font-semibold">{{customer.code}}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span>Customer Company</span>
                                <span class="font-semibold">{{customer.company}}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span>Total Quantity</span>
                                <span class="font-semibold">{{order.orderdetails.length}}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span>Total Price</span>
                                <span class="font-semibold">$ {{total_price}}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span>Total New Price</span>
                                <span class="font-semibold">$ {{total_new_price}}</span>
                            </div>

                            <vs-divider/>

                            <div class="flex justify-between">
                                <span>Amount Payable</span>
                                <span class="font-semibold">$ {{total_new_price}}</span>
                            </div>
                            <vs-divider/>

                            <vs-button :disabled="!customer.hasOwnProperty('id')" class="w-full" color="success"
                                       @click="continueSelect">REFRESH SELECTED & CONTINUE
                            </vs-button>
                        </vx-card>
                    </div>
                </div>
            </tab-content>
            <!--Popup-->
            <div class="centerx">
                <vs-popup class="holamundo" title="Select images for export file .PDF" :active.sync="popupActivo">
                    <vs-divider>
                        1020 x 750
                    </vs-divider>
                    <div class="vx-row">
                        <div class="vx-col w-full lg:w-1/3 sm:w-1/2 mb-base"
                             v-for="(image, i) in images" v-if="image['type'] == 1">
                            <vx-card
                                class="overlay-card overflow-hidden cursor-pointer h-full w-full  items-center"
                                @click="changeImages(image)">
                                <template slot="no-body">
                                    <img class="rounded-lg md:w-full" :src="image['url']"
                                         height="95" alt="image">
                                    <div v-if="isInImagesExport(image)"
                                         class="card-overlay text-white flex flex-col justify-between">
                                        <h4 class="text-white mb-4 text-center">{{isInImagesExport(image)}}</h4>
                                    </div>
                                </template>
                            </vx-card>
                        </div>
                    </div>
                    <vs-divider>
                        1020 x 500
                    </vs-divider>
                    <div class="vx-row">
                        <div class="vx-col w-full lg:w-1/3 sm:w-1/2 mb-base"
                             v-for="(image, i) in images" v-if="image['type'] == 2">
                            <vx-card
                                class="overlay-card overflow-hidden cursor-pointer h-full w-full  items-center"
                                @click="changeImages(image)">
                                <template slot="no-body">
                                    <img class="rounded-lg md:w-full" :src="image['url']"
                                         height="95" alt="image">
                                    <div v-if="isInImagesExport(image)"
                                         class="card-overlay text-white flex flex-col justify-between">
                                        <h4 class="text-white mb-4 text-center">{{isInImagesExport(image)}}</h4>
                                    </div>
                                </template>
                            </vx-card>
                        </div>

                    </div>
                    <vs-divider>
                        710 x 710
                    </vs-divider>
                    <div class="vx-row">
                        <div class="vx-col w-full lg:w-1/3 sm:w-1/2 mb-base"
                             v-for="(image, i) in images" v-if="image['type'] == 3">
                            <vx-card
                                class="overlay-card overflow-hidden cursor-pointer h-full w-full  items-center"
                                @click="changeImages(image)">
                                <template slot="no-body">
                                    <img class="rounded-lg md:w-full" :src="image['url']"
                                         height="95" alt="image">
                                    <div v-if="isInImagesExport(image)"
                                         class="card-overlay text-white flex flex-col justify-between">
                                        <h4 class="text-white mb-4 text-center">{{isInImagesExport(image)}}</h4>
                                    </div>
                                </template>
                            </vx-card>
                        </div>

                    </div>
                </vs-popup>
            </div>

        </form-wizard>
    </div>
</template>

<script>
    import {FormWizard, TabContent} from 'vue-form-wizard'
    import axios from "../../../axios";
    import 'vue-form-wizard/dist/vue-form-wizard.min.css'

    const ItemListViewCart = () => import('./components/ItemListViewCart.vue')

    export default {
        data() {
            return {
                render: false,
                contentRendered: false,
                department: null,
                progress: 0,
                itemsExport: [],
                photoOffers: [
                    {type: 3, text: 'Photo Offer CM & INCH'},
                    {type: 1, text: 'Photo Offer CM'},
                    {type: 2, text: 'Photo Offer INCH'}
                ],
                photoOffers_type: 3,
                items_export: [],
                customer: [],
                customer_id: 1,
                images: [],
                popupActivo: false,
                index_item_select: 0,
                item_select: [],
                errors: [],
                item_ids: [],
                item_price: [],
                // TAB 2
                total_price: 0,
                total_new_price: 0,

            }
        },
        computed: {
            customers() {
                return this.$store.state.home.customers;
            },
            order() {
                return this.$store.state.home.order;
            },
            cartItems() {
                return this.$store.state.home.cartItems.slice().reverse()
            },
            isInWishList() {
                return (itemId) => this.$store.getters['home/isInWishList'](itemId)
            }
        },
        methods: {
            currencyFormat(num) {
                return '$' + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
            },
            formatNumber(num) {
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
            },
            isComplete() {
                if (this.customer.hasOwnProperty('id')) {
                    if (this.customer.department) {
                        if (this.department) {
                            return true;
                        }
                        return false;
                    }
                    return true;
                }
                return false;
            }
            ,
            downloadPdf() {
                if (this.isReadyToDowload() != true) {
                    this.$vs.dialog({
                        color: 'danger',
                        title: `Errors`,
                        text: 'Some error occurred . Please change images for all products export!',
                    });
                    return false;
                }
                let time = this.cartItems.length;
                this.items_export = this.cartItems;
                var self = this;
                document.title = 'Export';
                this.$vs.loading()
                setTimeout(function () {
                    self.$vs.loading.close()
                    self.$htmlToPaper('canvas');
                }, time * 1000);
                setTimeout(function () {
                    document.title = 'VietNam HouseWares';
                }, time * 1050);
            }
            ,
            isReadyToDowload() {
                for (let i = 0; i < this.cartItems.length; i++) {
                    for (let j = 0; j < 3; j++) {
                        if (!this.cartItems[i].images_export[j]) {
                            return false;
                        }
                    }
                }
                return true;
            }
            ,
            createPDF(item) {
                this.items_export.splice(0, this.items_export.length);
                this.items_export.push(item);
                var self = this;
                document.title = item.code;
                this.$vs.loading()
                setTimeout(function () {
                    self.$vs.loading.close()
                    self.$htmlToPaper('canvas');
                }, 250);
                setTimeout(function () {
                    document.title = 'VietNam HouseWares';
                }, 300);
            }
            ,
            submitCheckout() {
                var self = this;
                if (this.isComplete() != true) {
                    self.$vs.dialog({
                        color: 'danger',
                        title: `Errors`,
                        text: 'Some error occurred . Please change Customer & Department!',
                    });
                    return;
                }
                for (let i = 0; i < this.cartItems.length; i++) {
                    if (Number(this.cartItems[i].new_price) <= 0) {
                        self.$vs.notify({
                            title: 'Errors',
                            text: 'New price greater than zero',
                            color: 'danger',
                            iconPack: 'feather',
                            icon: 'icon-x',
                            position: 'top-right',
                        });
                        return;
                    }
                }
                this.totalPrice()
                // document.title = item.code;
                self.$vs.loading()
                setTimeout(function () {
                    let formData = new FormData()
                    formData.append('products', JSON.stringify(self.cartItems))
                    formData.append('customer_id', self.customer.id)
                    formData.append('department', self.department || '')
                    formData.append('user_id', self.$auth.user().id)
                    formData.append('total_new_price', self.total_new_price)
                    self.$store
                        .dispatch("home/STORE_ORDER", formData)
                        // go to which page after successfully
                        .then(() => {
                                self.downloadFile();
                            }
                        ).catch((errs) => {
                        self.$vs.notify({
                            title: 'Errors',
                            text: 'Some Errors! Please try again',
                            color: 'danger',
                            iconPack: 'feather',
                            icon: 'icon-x',
                            position: 'top-right',
                        });
                        this.$store.dispatch('home/removeCartItem');
                    });
                }, 250);
                self.$vs.loading.close()
                // this.$router.push({name: 'List'});
            }
            ,
            totalPrice() {
                this.total_price = this.cartItems.reduce(function (a, b) {
                    return Number(Number(b.price) + a);
                }, 0);

                this.total_new_price = this.cartItems.reduce(function (a, b) {
                    return Number(Number(b.new_price) + a);
                }, 0);
            }
            ,
            getParams() {
                for (let i = 0; i < this.cartItems.length; i++) {
                    this.item_ids.push(this.cartItems[i].id);
                    this.item_price.push(this.cartItems[i].new_price);
                }
            }
            ,
            downloadFile() {
                var self = this;
                this.getParams();
                this.$vs.loading()
                axios({
                    method: 'get',
                    url: '/api/export-excel/',
                    params: {

                        type: this.photoOffers_type,
                        customer_id: this.customer_id,
                        product_ids: this.item_ids,
                        products_price: this.item_price,
                        department: this.department

                    },
                    responseType: 'arraybuffer'
                }).then(res => {
                    let blob = new Blob([res.data], {type: 'application/*'})
                    let link = document.createElement('a')
                    link.href = window.URL.createObjectURL(blob)
                    link.download = 'Photo Offer.xlsx'
                    link.click();
                    self.$vs.loading.close();
                    self.$refs.checkoutWizard.nextTab()
                    self.$vs.notify({
                        title: 'Success',
                        text: 'Order successfully!',
                        color: 'success',
                        iconPack: 'feather',
                        icon: 'icon-check',
                        position: 'top-right',
                    });
                    this.$store.dispatch('home/removeCartItem');
                }).catch((errs) => {
                    self.$vs.loading.close();
                    self.$vs.notify({
                        title: 'Errors',
                        text: 'Some Errors! Please try again',
                        color: 'danger',
                        iconPack: 'feather',
                        icon: 'icon-x',
                        position: 'top-right',
                    });
                    // this.$store.dispatch('home/removeCartItem');
                })
            }
            ,
            isInImagesExport(image) {
                const index = this.item_select.images_export.findIndex(i => i === image.url)

                if (index < 0) {
                    return false;
                } else {
                    return index + 1;
                }
            }
            ,
            selectImages(item, index) {
                this.popupActivo = true;
                this.index_item_select = index;
                this.item_select = item;
                this.images = item.images;
            }
            ,
            changeImages(image) {
                // this.item_select.images_export[image.type - 1] = image.url;
                const itemIndex = Math.abs(this.index_item_select + 1 - this.cartItems.length)
                this.$store.dispatch('home/updateItemImages', {image, index: itemIndex})
            }
            ,
            // TAB 1
            removeItemFromCart(item) {
                this.$store.dispatch('home/toggleItemInCart', item)
            }
            ,
            wishListButtonClicked(item) {
                // Toggle in Wish List
                if (this.isInWishList(item.id)) this.$router.push('/apps/eCommerce/wish-list').catch(() => {
                })
                else {
                    this.toggleItemInWishList(item)
                    this.removeItemFromCart(item)
                }
            }
            ,
            toggleItemInWishList(item) {
                this.$store.dispatch('eCommerce/toggleItemInWishList', item)
            }
            ,
            updateItemPrice(event, index) {
                const itemIndex = Math.abs(index + 1 - this.cartItems.length)
                this.$store.dispatch('home/updateItemNewPrice', {new_price: event, index: itemIndex})
            }
            ,

            // TAB 2
            continueSelect() {
                this.$store.dispatch('home/removeCartItem')
                this.customer = [];
                this.$router.push({name: 'List'});
            }
        },
        components: {
            ItemListViewCart,
            FormWizard,
            TabContent,
            // VueHtml2pdf,
            // PdfContent,
        }
        ,
        created() {
            this.$store.dispatch('home/FETCH_CUSTOMERS').catch(err => {
                console.error(err)
            });
        }
        ,

    }
</script>

<style lang="scss" scoped>
    #ecommerce-checkout-demo {
        .item-view-primary-action-btn {
            color: #2c2c2c !important;
            background-color: #f6f6f6;
        }

        .item-name {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
            -webkit-line-clamp: 2;
        }

        .vue-form-wizard {
            padding-bottom: 0;

            ::v-deep .wizard-header {
                padding: 0;
            }

            ::v-deep .wizard-tab-content {
                padding-right: 0;
                padding-left: 0;
                padding-bottom: 0;

                .wizard-tab-container {
                    margin-bottom: 0 !important;
                }
            }
        }
    }
</style>
