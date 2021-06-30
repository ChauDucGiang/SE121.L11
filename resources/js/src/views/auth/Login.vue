<template>
    <div class="h-screen flex w-full bg-img vx-row no-gutter items-center justify-center" id="page-login">
        <!--Popup Register-->
        <div class="centerx">
            <vs-popup class="holamundo" title="Don't have account ." :active.sync="registerPopup">
                <p>
                    Contact with admin !
                </p>
            </vs-popup>
        </div>
        <!--Popup Register-->
        <div class="centerx">
            <vs-popup class="holamundo" title="Forgot your password ." :active.sync="forgotpasswordPopup">
                <p>
                    Contact with admin !
                </p>
            </vs-popup>
        </div>
        <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-3/4 xl:w-3/5 sm:m-0 m-4">
            <vx-card>
                <div slot="no-body" class="full-page-bg-color">

                    <div class="vx-row no-gutter justify-center items-center">

                        <div class="vx-col hidden lg:block lg:w-1/2">
                            <img src="@assets/images/pages/login.png" alt="login" class="mx-auto">
                        </div>

                        <div class="vx-col sm:w-full md:w-full lg:w-1/2 d-theme-dark-bg">
                            <div class="p-8 login-tabs-container">

                                <div class="vx-card__title mb-4">
                                    <h4 class="mb-4">Login</h4>
                                    <p>Welcome back, please login to your account.</p>
                                </div>

                                <div>
                                    <vs-input
                                        name="email"
                                        icon-no-border
                                        icon="icon icon-user"
                                        icon-pack="feather"
                                        label-placeholder="Email"
                                        v-model="form.email"
                                        class="w-full"/>
                                    <!--                                    <span class="text-danger text-sm" v-if="errors.hasOwnProperty('email')">{{ errors.email[0] }}</span>-->
                                    <vs-input
                                        v-on:keyup.enter="login"
                                        type="password"
                                        name="password"
                                        icon-no-border
                                        icon="icon icon-lock"
                                        icon-pack="feather"
                                        label-placeholder="Password"
                                        v-model="form.password"
                                        class="w-full mt-6"/>
                                    <div class="flex flex-wrap justify-between my-5">
                                        <vs-checkbox v-model="remember_me" class="mb-3">Remember Me</vs-checkbox>
                                        <!--                                        <a @click="forgotpasswordPopup=true">Forgot Password?</a>-->
                                        <vs-button @click="forgotpasswordPopup=true" color="primary" type="flat">Forgot
                                            Password?
                                        </vs-button>
                                    </div>
                                    <vs-button @click="registerPopup=true" type="border">Register</vs-button>
                                    <vs-button @click="login" class="float-right">Login</vs-button>

                                    <vs-divider>OR</vs-divider>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </vx-card>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                registerPopup: false,
                forgotpasswordPopup: false,
                form: {
                    email: "",
                    password: "",
                },
                remember_me: false,
            }
        },
        // computed: {
        //     errors() {
        //         return this.$store.state.user.errors;
        //     },
        // },
        methods: {
            login() {
                this.$auth
                    .login({
                        data: this.form,
                        remember: this.form.remember_me ? '{"name": "Default"}' : null,
                        fetchUser: true,
                        staySignedIn: false,
                        redirect: {name: 'UserList'},
                    })
                    .then((res) => {
                        this.$vs.notify({
                            title: 'Success',
                            text: 'Login successfully!',
                            color: 'success',
                            iconPack: 'feather',
                            icon: 'icon-check',
                            position: 'top-right',
                        });
                        let redirectTo = '';
                        if (this.$auth.user().active == 0) {
                            redirectTo = 'ResetPassword'
                        } else {
                            redirectTo = this.$auth.user().roles === 2 ? 'UserList' : 'List'
                        }
                        this.$router.push({name: redirectTo});
                    }, (res) => {
                        this.$vs.notify({
                            title: 'Login fail !',
                            text: 'Email or Password is incorrect.',
                            color: 'danger',
                            iconPack: 'feather',
                            icon: 'icon-error',
                            position: 'top-right',
                        });
                    });
            },
        }
    }
</script>

<style lang="scss">
    #page-login {
        .social-login-buttons {
            .bg-facebook {
                background-color: #1551b1
            }

            .bg-twitter {
                background-color: #00aaff
            }

            .bg-google {
                background-color: #4285F4
            }

            .bg-github {
                background-color: #333
            }
        }
    }
</style>
