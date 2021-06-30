<template>
    <!-- Page Content -->
    <section slot="pdf-content" id="content-export">

        <div class="content" v-for="(item_export , i) in itemsExport">
            <section class="pdf-item">
                <!-- Page Content -->
                <div class="mainWrappers">
                    <div class="container">
                        <div class="header-top row">
                            <div class="col-sm-6">
                                <a><img class="image-export" src="/images/exports/title.png" alt=""/></a>
                            </div>
                            <div class="product-name col-sm-6 text-right font-weight-bold"><h4 class="text-uppercase">
                                {{`${item_export.name}`}}</h4>
                            </div>
                        </div>
                        <div class="content-page row">
                            <div class="col-left col-sm-6">
                                <div class="text-center img-thumb-1"><img class="image-export"
                                                                          :src="item_export.images_export[0]"/>
                                </div>
                                <div class="img-thumb img-thumb-2 justify-content-center"><img
                                    class="image-export"
                                    :src="item_export.images_export[1]"/>
                                </div>
                            </div>
                            <div class="col-right col-sm-6">
                                <div class="content-top mt-auto mb-auto">
                                    <ul class="list-unstyled">
                                        <li class="text-uppercase"><strong>CODE PRODUCT</strong>: {{item_export.code}}
                                        </li>
                                        <li class="text-uppercase"><strong>PRODUCT SPEC</strong>:
                                            {{`${item_export.materials}-${item_export.weaving}-${item_export.color}`}}
                                        </li>
                                        <li><strong>SIZE</strong>{{`:
                                            L${item_export.size_l}xW${item_export.size_w}xH${item_export.size_h}
                                            cm. `}}<strong>CARTON QUANLITY</strong>{{`: 0${item_export.ctn_qty}PC`}}
                                        </li>
                                        <li><strong>CARTON SIZE</strong>{{`:L${item_export.ctn_l}xW${item_export.ctn_w}xH${item_export.ctn_h}
                                            cm `}}<strong>LOADABILITY</strong>{{`:
                                            20'DC:${parseInt((27/item_export.cbm)*item_export.ctn_qty)}-40DC:${parseInt((57/item_export.cbm)*item_export.ctn_qty)}-50DC:${parseInt((64/item_export.cbm)*item_export.ctn_qty)}`}}
                                        </li>
                                        <li class="text-uppercase"><strong>FOB HCMC(USD)</strong>:
                                            {{item_export.new_price}}
                                        </li>

                                    </ul>
                                </div>
                                <div class="text-center img-thumb img-thumb-3"><img class="image-export"
                                                                                    :src="item_export.images_export[2]"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--            <div v-if="(i != itemsExport.length-1)" class="html2pdf__page-break"/>-->
        </div>
    </section>
</template>
<script>
    export default {
        props: ['itemsExport'],
        mounted() {
            this.$nextTick(() => {
                setTimeout(() => {
                    this.$emit("domRendered");
                }, 1000);
            });
        },
    }
</script>
<style lang="scss" scoped>
    @import "https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css";

    img.image-export {
        max-width: 100%;
        height: auto;
    }

    .header-top {
        padding: 10px 0px;
    }

    .content-page {
        border: 3px solid rgb(0, 0, 0);
    }

    .content-page .col-left,
    .content-page .col-right {
        padding: 0px;
    }

    .content-page .col-left {
        border-right: 3px solid rgb(0, 0, 0);
    }

    .content-page .img-thumb {
        display: block;
        position: relative;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
    }

    .content-page .img-thumb.img-thumb-1 {
        height: 400px;
        border-bottom: 3px solid rgb(0, 0, 0);
    }

    .content-page .img-thumb.img-thumb-2 {
        border-top: 3px solid rgb(0, 0, 0);
        /* height: 200px; */
    }

    .content-page .img-thumb.img-thumb-3 {
        /* height: 400px; */
    }

    .content-page .content-top {
        display: block;
        border-bottom: 3px solid rgb(0, 0, 0);
        padding: 13px 20px;
        height: 105px;
    }

    .content-page .content-top ul {
        display: block;
        margin: 0px;
    }

    .content-page .content-top ul li {
        display: block;
        font-size: 9px;
        margin: auto;
    }

    .product-name {
        margin: auto;
    }

</style>
