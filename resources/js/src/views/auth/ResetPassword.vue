<!-- =========================================================================================
    File Name: ResetPassword.vue
    Description: Reset Password Page
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
    <div class="h-screen flex w-full bg-img">
        <div class="vx-col sm:w-3/5 md:w-3/5 lg:w-3/4 xl:w-3/5 mx-auto self-center">
            <vx-card>
                <div slot="no-body" class="full-page-bg-color">
                    <div class="vx-row">
                        <div class="vx-col hidden sm:hidden md:hidden lg:block lg:w-1/2 mx-auto self-center">
                            <img src="@assets/images/pages/reset-password.png" alt="login" class="mx-auto">
                        </div>
                        <div class="vx-col sm:w-full md:w-full lg:w-1/2 mx-auto self-center  d-theme-dark-bg">
                            <div class="p-8">
                                <div class="vx-card__title mb-8">
                                    <h4 class="mb-4">Reset Password</h4>
                                    <p>Please enter your new password.</p>
                                </div>


                                <div class="vx-row">
                                    <div class="vx-col w-full">
                                        <vs-input type="email" disabled label-placeholder="Your Email" v-model="email"
                                                  class="w-full mb-6"/>
                                    </div>
                                </div>
                                <div class="vx-row mb-6">
                                    <div class="vx-col w-full">
                                        <vs-input type="password" label-placeholder="New Password" v-model="password"
                                                  v-on:keyup.enter="submit"
                                                  class="w-full"/>
                                        <span class="text-danger text-sm"
                                              v-if="required !== null">{{ required }}</span>
                                    </div>
                                </div>
                                <div class="vx-row mb-6">
                                    <div class="vx-col w-full">
                                        <vs-input type="password" label-placeholder="Confirm New Password"
                                                  v-model="confirm"
                                                  v-on:keyup.enter="submit"
                                                  class="w-full"/>
                                        <span class="text-danger text-sm"
                                              v-if="errors !== null">{{ errors }}</span>
                                    </div>
                                </div>
                                <div class="vx-row">
                                    <div class="vx-col w-full">
                                        <div class="mt-8 flex flex-wrap justify-between flex-col-reverse sm:flex-row">
                                            <vs-button type="border"
                                                       @click="$router.go(-1)||$router.push('List')"
                                                       class="w-full sm:w-auto mb-8 sm:mb-auto mt-3 sm:mt-auto">Back
                                            </vs-button>
                                            <vs-button @click="submit" class="w-full sm:w-auto">Save</vs-button>
                                        </div>
                                    </div>
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
    import axios from "../../axios";

    export default {
        data() {
            return {
                email: this.$auth.user().email,
                password: '',
                confirm: '',
                errors: null,
                required: null,
            }
        },
        methods: {
            submit() {
                if (this.password !== this.confirm) {
                    this.errors = 'Password confirm is fail !';
                } else {
                    axios({
                        method: 'post',
                        url: '/api/reset-password',
                        params: {
                            id: this.$auth.user().id,
                            password: this.password,
                        },
                    }).then(res => {
                        this.openConfirm()
                    }).catch(errors => {
                        this.required = 'The password field is required.';
                    })
                }
            },
            openConfirm(id) {
                this.$vs.dialog({
                    color: 'success',
                    title: `Success`,
                    text: 'Your password has been changed. Login to continue!',
                    accept: this.logout
                })
            },
            logout() {
                var self = this;
                this.$auth
                    .logout({
                        redirect: null
                    })
                    .then(() => {
                        this.$vs.loading()
                        setTimeout(function () {
                            self.$vs.loading.close()
                            localStorage.clear();
                        }, 250);
                        this.$router.push({name: 'Login'});
                    });
            }
        }
    }
</script>
