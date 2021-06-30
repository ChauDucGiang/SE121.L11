<template>
    <vx-card class="list-view-item overflow-hidden" v-on="$listeners">

        <template slot="no-body">
            <div class="vx-row item-details no-gutter">

                <!-- IMG COL -->
                <div
                    class="vx-col sm:w-1/4 w-full item-img-container bg-white flex items-center justify-center cursor-pointer"
                    @click="navigate_to_detail_view">
                    <img :src="item.images[0]['url']" :alt="item.name" class="grid-view-img p-4">
                </div>

                <!-- ITEM NAME & DESC COL -->
                <div class="vx-col sm:w-1/2">
                    <div class="p-4 pt-6">
                        <slot name="item-meta">
                            <h6 class="item-name font-semibold mb-1 hover:text-primary cursor-pointer"
                                @click="navigate_to_detail_view">{{ item.name }}</h6>
                            <p class="text-sm mb-4">By <span
                                class="font-semibold cursor-pointer">{{ item.brand }}</span></p>
                            <p class="item-description text-sm">{{ item.index }}</p>
                        </slot>
                    </div>
                </div>

                <!-- PURCHASE COL -->
                <div
                    class="vx-col sm:w-1/4 w-full flex items-center sm:border border-0 border-solid d-theme-border-grey-light border-r-0 border-t-0 border-b-0">

                    <div class="p-4 flex flex-col w-full">


                        <!-- SLOT: ACTION BUTTONS -->
                        <slot name="action-buttons"/>
                    </div>
                </div>
            </div>
        </template>

    </vx-card>
</template>

<script>
    export default {
        props: {
            item: {
                type: Object,
                required: true
            }
        },
        computed: {
            isInCart() {
                return (itemId) => this.$store.getters['home/isInCart'](itemId)
            },
            isInWishList() {
                return (itemId) => this.$store.getters['home/isInWishList'](itemId)
            }
        },
        methods: {
            toggleItemInWishList(item) {
                this.$store.dispatch('home/toggleItemInWishList', item)
            },
            additemInCart(item) {
                this.$store.dispatch('home/additemInCart', item)
            },
            cartButtonClicked(item) {
                this.isInCart(item.id) ? this.$router.push('/apps/home/checkout').catch(() => {
                }) : this.additemInCart(item)
            },
            navigate_to_detail_view() {
                this.$router.push({name: 'ProductDetail', params: {id: this.item.id}})
                    .catch(() => {
                    })
            },
        }
    }
</script>

<style lang="scss" scoped>
    .list-view-item {
        .item-name, .item-description {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .item-name {
            -webkit-line-clamp: 2;
        }

        .item-description {
            -webkit-line-clamp: 5;
        }

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
