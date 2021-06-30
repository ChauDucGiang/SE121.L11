<template>
    <!-- <div class="item-grid-view vx-row match-height">
        <div class="vx-col" :class="gridColumnWidth" v-for="item in items" :key="item.objectID"> -->
    <vx-card class="grid-view-item mb-base overflow-hidden" v-on="$listeners">
        <template slot="no-body">

            <!-- ITEM IMAGE -->
            <div class="item-img-container bg-white h-64 flex items-center justify-center mb-4 cursor-pointer"
                 @click="navigate_to_detail_view">
                <img :src="item.images[0]['url']" :alt="item.name" class="grid-view-img px-4">
            </div>
            <div class="item-details px-4">

                <!-- RATING & PRICE -->
                <div class="flex justify-between items-center">
                    <div class="text-warning border border-solid border-warning flex py-1 px-2 rounded font-bold">
                        <span class="text-sm mr-1">{{ item.code }}</span>
                    </div>
                    <h6 class="font-bold">${{ item.price }}</h6>
                </div>

                <!-- TITLE & DESCRIPTION -->
                <div class="my-4">
                    <h6 class="truncate font-semibold mb-1 hover:text-primary cursor-pointer"
                        @click="navigate_to_detail_view">{{
                        item.name }}</h6>
                    <p class="item-description truncate text-sm font-medium"><small class="text-black">{{
                        `L${item.size_l} x
                        W${item.size_w} x H${item.size_h}` }} cm</small></p>
                    <p class="item-description truncate text-sm">Ref: <small class="text-primary"
                                                                             v-for="(customer,i) in item.customers">{{
                        customer.code }},</small></p>
                </div>
            </div>

            <!-- SLOT: ACTION BUTTONS -->
            <slot name="action-buttons"/>
        </template>
    </vx-card>
    <!--  </div>
  </div> -->
</template>

<script>
    export default {
        props: {
            item: {
                type: Object,
                required: true
            }
        },
        methods: {
            getPathImage(path) {
                return `http://127.0.0.1:8000/storage/${path}`;
            },
            navigate_to_detail_view() {
                this.$router.push({name: 'ProductDetail', params: {id: this.item.id}})
                    .catch(() => {
                    })
            }
        }
    }
</script>

<style lang="scss" scoped>
    .grid-view-item {
        .grid-view-img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            transition: .35s;
        }

        &:hover {
            transform: translateY(-5px);
            box-shadow: 0px 4px 25px 0px rgba(0, 0, 0, .25);

            .grid-view-img {
                opacity: 0.9;
            }
        }
    }
</style>
