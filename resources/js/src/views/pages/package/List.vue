<template>

    <div id="page-user-list">
        <!--Popup-->
        <div class="centerx">
            <vs-popup class="holamundo" :title="titleCategory" :active.sync="popupCreateActive">
                <vs-input class="w-full" placeholder="Package name" v-model="form.name"/>
                <span class="text-danger text-sm" v-if="errors.hasOwnProperty('name')">{{ errors.name[0] }}</span>
                <!-- Save & Reset Button -->
                <div class="vx-row">
                    <div class="vx-col w-full">
                        <div class="mt-8 flex flex-wrap items-center justify-end">
                            <vs-button class="ml-auto mt-2" @click="submitStoreCategory(isEdit)">Save Changes
                            </vs-button>
                            <vs-button @click="popupCreateActive= false;" class="ml-4 mt-2"
                                       type="border"
                                       color="warning">Cancel
                            </vs-button>
                        </div>
                    </div>
                </div>
            </vs-popup>
        </div>
        <!--End popup-->
        <div class="vx-card p-6">
            <div class="flex-wrap items-center">
                <vs-table search max-items="10" pagination stripe :data="packages">
                    <template slot="header">
                        <vs-button
                            @click="popupCreateActive=true;titleCategory='Create Package';isEdit=false;form.name=''"
                            color="primary"
                            type="gradient"
                            icon="add">Add new package
                        </vs-button>
                    </template>
                    <template slot="thead">
                        <vs-th>
                            ID
                        </vs-th>
                        <vs-th sort-key="name">
                            Name
                        </vs-th>
                        <vs-th sort-key="name">
                            Count Products
                        </vs-th>
                        <vs-th sort-key="created">
                            Created At
                        </vs-th>
                        <vs-th>
                            Action
                        </vs-th>
                    </template>

                    <template slot-scope="{data}">
                        <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                            <vs-td>
                                {{indextr+1}}
                            </vs-td>

                            <vs-td :data="data[indextr].name">
                                {{ data[indextr].name}}
                            </vs-td>

                            <vs-td :data="data[indextr].products_count">
                                {{(data[indextr].products_count)}}
                            </vs-td>

                            <vs-td :data="data[indextr].created">
                                {{(data[indextr].created)}}
                            </vs-td>

                            <vs-td>
                                <div class="vx-row">
                                    <div class="vx-col w-full">
                                        <vs-button @click="edit(data[indextr])" class="mb-2 mr-3" color="primary"
                                                   type="gradient">Edit
                                        </vs-button>
                                        <!--                                        <vs-button @click="openConfirm(data[indextr].id)" class="mb-2" color="danger"-->
                                        <!--                                                   type="gradient">Delete-->
                                        <!--                                        </vs-button>-->
                                    </div>
                                </div>
                                <div class="demo-alignment centerx">
                                </div>
                            </vs-td>
                        </vs-tr>
                    </template>


                </vs-table>
            </div>

        </div>
    </div>

</template>

<script>
    import vSelect from 'vue-select'


    // Cell Renderer
    import {mapState} from "vuex";


    export default {
        components: {
            vSelect,
        },
        data() {
            return {
                isEdit: false,
                packageId: '',
                titleCategory: 'Create Package',
                form: {
                    name: ''
                },
                popupCreateActive: false,
            }
        },
        computed: {
            packages() {
                return this.$store.state.package.packages;
            },
            errors() {
                return this.$store.state.package.errors;
            },
            ...mapState({
                user: state => state.auth.user
            })
        },
        methods: {
            openConfirm(id) {
                this.id = id
                this.$vs.dialog({
                    type: 'confirm',
                    color: 'danger',
                    title: `Delete`,
                    text: 'Are you sure you want to delete selected items?',
                    accept: this.remove
                })
            },
            edit(item) {
                this.packageId = item.id;
                this.isEdit = true;
                this.popupCreateActive = true;
                this.titleCategory = 'Edit Package';
                this.form.name = item.name;
            },
            remove() {
                this.$store
                    .dispatch("package/DELETE_PACKAGE", this.id)
                    // go to which page after successfully login
                    .then(
                        this.$vs.notify({
                            title: 'Success',
                            text: 'Package deleted successfully!',
                            color: 'success',
                            iconPack: 'feather',
                            icon: 'icon-check',
                            position: 'top-right',
                        }));
            },
            submitStoreCategory(isEdit) {
                let uri = 'package/STORE_PACKAGE';
                let formData = new FormData()
                formData.append('name', this.form.name);
                let data = formData;
                if (isEdit) {
                    formData.append('_method', 'PUT');
                    uri = 'package/UPDATE_PACKAGE';
                    data = {id: this.packageId, params: formData};
                }
                this.$store
                    .dispatch(`${uri}`, data)
                    // go to which page after successfully login
                    .then(() => {
                            this.$vs.notify({
                                title: 'Success',
                                text: 'Package created successfully!',
                                color: 'success',
                                iconPack: 'feather',
                                icon: 'icon-check',
                                position: 'top-right',
                            });
                            this.popupCreateActive = false;
                            this.$store.dispatch('package/FETCH_PACKAGES').catch(err => {
                                console.error(err)
                            })
                        }
                    )
                ;
            },
        },
        mounted() {
            if (this.$vs.rtl) {
                const header = this.$refs.agGridTable.$el.querySelector('.ag-header-container')
                header.style.left = `-${String(Number(header.style.transform.slice(11, -3)) + 9)}px`
            }
        },
        created() {
            this.$store.dispatch('package/FETCH_PACKAGES').catch(err => {
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
