<!-- =========================================================================================
  File Name: TheNavbar.vue
  Description: Navbar component
  Component Name: TheNavbar
  ----------------------------------------------------------------------------------------
  Item Name: VietNam HouseWares Admin Dashboard
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
    <div class="relative">
        <div class="vx-navbar-wrapper navbar-full p-0">
            <vs-navbar class="navbar-custom navbar-skelton items-center" :class="navbarClasses"
                       :style="navbarStyle"
                       :color="navbarColor">

                <bookmarks :navbarColor="navbarColor" v-if="windowWidth >= 992 && this.$auth.user().roles === 2"/>

                <!--                <router-link tag="div" :to="{name:'List'}"-->
                <!--                             class="vx-logo cursor-pointer mx-auto flex items-center">-->
                <div class="vx-logo cursor-pointer mx-auto flex items-center " @click="changeCategory">

                    <img src="/images/logo/logo_top.jpg" height="50" alt="Logo Top" class=" mx-auto">
                    <!--                    <logo class="w-10 mr-4 fill-current text-primary"/>-->
                    <!--                    <span class="vx-logo-text text-primary">VietNamHouseWares</span>-->
                </div>
                <!--                </router-link>-->

                <search-bar v-if="this.$auth.user().roles === 2" class="mr-4"/>
                <cart-drop-down/>
                <!--                <notification-drop-down/>-->

                <profile-drop-down/>

            </vs-navbar>
        </div>
    </div>
</template>

<script>
    import Bookmarks from './components/Bookmarks.vue'
    import SearchBar from './components/SearchBar.vue'
    import CartDropDown from './components/CartDropDown.vue'
    import NotificationDropDown from './components/NotificationDropDown.vue'
    import ProfileDropDown from './components/ProfileDropDown.vue'
    import Logo from '../Logo.vue'
    import EventBus from "../../../EventBus";

    export default {
        name: 'the-navbar-horizontal',
        props: {
            logo: {type: String},
            navbarType: {
                type: String,
                required: true
            }
        },
        components: {
            Logo,
            Bookmarks,
            SearchBar,
            CartDropDown,
            NotificationDropDown,
            ProfileDropDown
        },
        computed: {
            navbarColor() {
                let color = '#fff'
                if (this.navbarType === 'sticky') color = '#f7f7f7'
                else if (this.navbarType === 'static') {
                    if (this.scrollY < 50) {
                        color = '#f7f7f7'
                    }
                }

                if (this.isThemedark === 'dark') {
                    if (color === '#fff') {
                        color = '#10163a'
                    } else {
                        color = '#262c49'
                    }
                }

                return color
            },
            isThemedark() {
                return this.$store.state.theme
            },
            navbarStyle() {
                return this.navbarType === 'static' ? {transition: 'all .25s ease-in-out'} : {}
            },
            navbarClasses() {
                return this.scrollY > 5 && this.navbarType === 'static' ? null : 'd-theme-dark-light-bg shadow-none'
            },
            scrollY() {
                return this.$store.state.scrollY
            },
            verticalNavMenuWidth() {
                return this.$store.state.verticalNavMenuWidth
            },
            windowWidth() {
                return this.$store.state.windowWidth
            }
        },
        methods: {
            changeCategory() {
                let query = {
                    category_id: 0,
                    customer_id: null,
                    size: this.$route.query.size || 20,
                    search: '',
                    page: 1,
                };
                this.$router.push({
                    name: 'List',
                    query
                }).catch(() => {
                });
                this.$store.dispatch('home/FETCH_CATEGORY_PRODUCTS', query).catch(err => {
                    console.error(err)
                });
                EventBus.$emit('changeCat', query);
            },
        }
    }

</script>

