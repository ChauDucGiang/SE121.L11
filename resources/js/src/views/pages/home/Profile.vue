<template>

    <div id="page-user-create">

        <vx-card title="Account Info" class="mb-base">
            <!-- Avatar Row -->
            <div class="vx-row">
                <div class="vx-col w-full">
                    <div class="flex items-start flex-col sm:flex-row">
                        <img v-if="avt" :src="avt" class="mr-8 rounded h-24 w-24"/>
                        <img v-else :src="userData.avatar" class="mr-8 rounded h-24 w-24"/>
                        <div>
                            <p class="text-lg font-medium mb-2 mt-4 sm:mt-0">Avatar</p>
                            <input type="file" class="hidden" ref="update_avatar_input" @change="update_avatar"
                                   accept="image/*">
                            <vs-button type="border" class="mr-4" @click="$refs.update_avatar_input.click()">Change
                                Avatar
                            </vs-button>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="vx-row">
                <div class="vx-col sm:w-1/2 w-full mb-2">
                    <vs-input v-model="userData.name" class="w-full" label-placeholder="Full Name"/>
                    <span class="text-danger text-sm" v-if="errors.hasOwnProperty('name')">{{ errors.name[0] }}</span>
                </div>
                <div class="vx-col sm:w-1/2 w-full mb-6">
                    <vs-input v-model="userData.email" type="email" class="w-full" label-placeholder="Email"/>
                    <span class="text-danger text-sm" v-if="errors.hasOwnProperty('email')">{{ errors.email[0] }}</span>
                </div>
            </div>
            <div class="vx-row">
                <div class="vx-col sm:w-1/2 w-full mb-2">
                    <vs-input v-model="userData.phone" class="w-full" label-placeholder="Phone Number"/>
                    <span class="text-danger text-sm" v-if="errors.hasOwnProperty('phone')">{{ errors.phone[0] }}</span>
                </div>
                <div class="vx-col sm:w-1/2 w-full mb-2">
                    <vs-select autocomplete label="Role" v-model="userData.roles" class="w-full"
                               :disabled="$auth.user().roles != 2">
                        <vs-select-item :key="index" :value="item.value" :text="item.label"
                                        v-for="(item,index) in roleOptions"/>
                    </vs-select>
                </div>
            </div>

            <!-- Save & Reset Button -->
            <div class="vx-row">
                <div class="vx-col w-full">
                    <div class="mt-8 flex flex-wrap items-center justify-end">
                        <vs-button class="ml-auto mt-2" @click="submit">Save Changes</vs-button>
                        <vs-button class="ml-4 mt-2" type="border" color="warning"
                                   @click="$router.go(-1)">Cancel
                        </vs-button>
                    </div>
                </div>
            </div>
        </vx-card>
    </div>

</template>

<script>
    import vSelect from 'vue-select'

    export default {
        components: {
            vSelect
        },
        data() {
            return {
                id: '',
                userData: [],
                avt: null,
                roleOptions: [
                    {label: 'Sales', value: '1'},
                    {label: 'Manager', value: '2'},
                ],
            }
        },
        methods: {
            submit() {
                const formData = new FormData()
                formData.append('avatar', this.userData.avatar)
                formData.append('name', this.userData.name)
                formData.append('email', this.userData.email)
                formData.append('phone', this.userData.phone)
                formData.append('roles', this.userData.roles)
                formData.append('_method', 'put')
                this.$store
                    .dispatch("user/UPDATE_USER", {id: this.id, params: formData})
                    .then(() => {
                            this.$vs.notify({
                                title: 'Success',
                                text: 'User created successfully!',
                                color: 'success',
                                iconPack: 'feather',
                                icon: 'icon-check',
                                position: 'top-right',
                            });
                            // location.reload();
                            this.$auth.fetch();
                            this.$router.go(-1);
                            // this.$router.push({name: 'List'});
                        }
                    )
                ;
            },
            update_avatar(e) {
                const file = e.target.files[0];
                this.userData.avatar = file;
                this.avt = URL.createObjectURL(file);
            }
        },
        computed: {
            errors() {
                return this.$store.state.user.errors;
            },
        },
        created() {
            this.$store.dispatch('user/FETCH_USER', this.$auth.user().id).then(res => {
                this.id = this.$auth.user().id
                this.userData = res.data;
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
</style>
