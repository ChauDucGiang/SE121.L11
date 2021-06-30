<template>
    <div class="the-navbar__user-meta flex items-center" v-if="activeUserInfo.name">

        <div class="text-right leading-tight hidden sm:block">
            <p class="font-semibold">{{ activeUserInfo.name }}</p>
            <small>Available</small>
        </div>

        <vs-dropdown vs-custom-content vs-trigger-hover class="cursor-pointer">

            <div class="con-img ml-3">
                <img v-if="activeUserInfo.avatar" key="onlineImg" :src="activeUserInfo.avatar" alt="user-img"
                     width="40" height="40" class="rounded-full shadow-md cursor-pointer block"/>
            </div>

            <vs-dropdown-menu class="vx-navbar-dropdown">
                <ul style="min-width: 9rem">

                    <li @click="$router.push({name: 'OfferView', query:{user_id:$auth.user().id}});"
                        class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white">
                        <feather-icon icon="ShoppingCartIcon" svgClasses="w-4 h-4"/>
                        <span class="ml-2">Offer</span>
                    </li>
                    <li @click="$router.push({name: 'Profile'});"
                        class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white">
                        <feather-icon icon="UserIcon" svgClasses="w-4 h-4"/>
                        <span class="ml-2">Profile</span>
                    </li>
                    <li @click="$router.push({name: 'ResetPassword'});"
                        class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white">
                        <feather-icon icon="KeyIcon" svgClasses="w-4 h-4"/>
                        <span class="ml-2">Password</span>
                    </li>

                    <vs-divider class="m-1"/>

                    <li
                        class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
                        @click="logout">
                        <feather-icon icon="LogOutIcon" svgClasses="w-4 h-4"/>
                        <span class="ml-2">Logout</span>
                    </li>
                </ul>
            </vs-dropdown-menu>
        </vs-dropdown>
    </div>
</template>

<script>
    export default {
        computed: {
            activeUserInfo() {
                // return this.$store.state.AppActiveUser
                return this.$auth.user();
            }
        },
        methods: {
            logout() {
                this.$auth
                    .logout({
                        redirect: null
                    })
                    .then(() => {
                        localStorage.clear();
                        this.$router.push({name: 'Login'});
                    });
            },
        }
    }
</script>
