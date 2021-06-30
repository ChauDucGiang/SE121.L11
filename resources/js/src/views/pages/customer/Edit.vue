<template>

    <div id="page-user-create">

        <vx-card title="Customer info" class="mb-base">
            <form action="">
                <div class="vx-row">
                    <!-- required -->
                    <div class="vx-col w-1/2">
                        <vs-input v-model="form.code" :class="(!form.code)?'required':''"
                                  label="Customer Code *"
                                  class="mt-5 w-full" placeholder="Customer Code"/>
                        <span class="text-danger text-sm"
                              v-if="errors.hasOwnProperty('code')">{{ errors.code[0] }}</span>
                    </div>
                    <div class="vx-col w-1/2">
                        <vs-select
                            autocomplete
                            :class="(!form.country_id)?'required':''"
                            class="mt-5 w-full"
                            label="Customer Country *"
                            v-model="form.country_id">
                            <vs-select-item :key="index" :value="item.id" :text="item.name"
                                            v-for="(item,index) in countries"/>
                        </vs-select>
                        <span class="text-danger text-sm"
                              v-if="errors.hasOwnProperty('country_id')">{{ errors.country_id[0] }}</span>
                    </div>
                </div>

                <div class="vx-row">
                    <!-- required -->
                    <div class="vx-col w-1/2">
                        <vs-input v-model="form.company" :class="(!form.company)?'required':''"
                                  label="Customer Company *"
                                  class="mt-5 w-full" placeholder="Customer Company"/>
                        <span class="text-danger text-sm"
                              v-if="errors.hasOwnProperty('company')">{{ errors.company[0] }}</span>
                    </div>
                    <div class="vx-col w-1/2">
                        <vs-input v-model="form.department"
                                  label="Department"
                                  class="mt-5 w-full" placeholder="Department"/>
                        <span class="text-danger text-sm"
                              v-if="errors.hasOwnProperty('department')">{{ errors.department[0] }}</span>
                    </div>
                </div>
                <div class="vx-row">
                    <!-- required -->
                    <div class="vx-col w-1/2">
                        <vs-input v-model="form.email"
                                  label="Customer Email"
                                  class="mt-5 w-full" placeholder="Customer Email"/>
                        <span class="text-danger text-sm"
                              v-if="errors.hasOwnProperty('email')">{{ errors.email[0] }}</span>
                    </div>
                    <div class="vx-col w-1/2">
                        <vs-input v-model="form.phone" label="Customer Phone"
                                  class="mt-5 w-full" placeholder="Customer Phone"/>
                        <span class="text-danger text-sm"
                              v-if="errors.hasOwnProperty('phone')">{{ errors.phone[0] }}</span>
                    </div>
                </div>


                <!-- Save & Reset Button -->
                <div class="vx-row">
                    <div class="vx-col w-full">
                        <div class="mt-8 flex flex-wrap items-center justify-end">
                            <vs-button class="ml-auto mt-2" @click="submit">Save Changes</vs-button>
                            <vs-button class="ml-4 mt-2" type="border" color="warning"
                                       @click="$router.push({name:'CustomerList'})">
                                Cancel
                            </vs-button>
                        </div>
                    </div>
                </div>
            </form>

        </vx-card>
    </div>

</template>

<script>
    import {mapState} from "vuex";

    export default {
        data() {
            return {
                // Customer Data
                form: [],
            }
        },
        methods: {
            submit() {
                let formData = new FormData()
                formData.append('code', this.form.code)
                formData.append('company', this.form.company)
                formData.append('department', this.form.department || '')
                formData.append('email', this.form.email || '')
                formData.append('phone', this.form.phone || '')
                formData.append('country_id', this.form.country_id)
                formData.append('_method', 'put')
                this.$store
                    .dispatch("customer/UPDATE_CUSTOMER", {params: formData, id: this.id})
                    // go to which page after successfully
                    .then(() => {
                            this.$vs.notify({
                                title: 'Success',
                                text: 'Customer updated successfully!',
                                color: 'success',
                                iconPack: 'feather',
                                icon: 'icon-check',
                                position: 'top-right',
                            });
                            this.$router.push({name: 'CustomerList'});
                        }
                    )
                ;
            },
        },
        computed: {
            errors() {
                return this.$store.state.customer.errors;
            },
            countries() {
                return this.$store.state.customer.countries;
            },
        },
        mounted() {
            if (this.$vs.rtl) {
                const header = this.$refs.agGridTable.$el.querySelector('.ag-header-container')
                header.style.left = `-${String(Number(header.style.transform.slice(11, -3)) + 9)}px`
            }
        },
        created() {
            this.$store.dispatch('customer/FETCH_COUNTRIES').catch(err => {
                console.error(err)
            });
            this.$store.dispatch('customer/FETCH_CUSTOMER', this.$route.params.id).then(res => {
                this.id = this.$route.params.id
                this.form = res.data;
            })
                .catch(err => {
                    console.error(err)
                })
        }
    }
</script>

<style lang="scss">
    #page-user-list {
        .user-list-filters {
            .vs__actions {
                position: absolute;
                right: 0;
                top: 50%;
                transform: translateY(-58%);
            }
        }
    }

    div.required > label {
        color: red;
    }
</style>
