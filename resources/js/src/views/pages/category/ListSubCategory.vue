<template>

    <div id="page-user-list">
        <!--Subcategory-->
        <div class="centerx">
            <vs-popup class="holamundo" :title="titleSubCategory" :active.sync="popupCreateSubActive">
                <div class="vx-row">
                    <div class="vx-col w-full">
                        <vs-input label="SubCategory name" class="w-full" placeholder="SubCategory name"
                                  v-model="form.subcategory.name"/>
                        <span class="text-danger text-sm"
                              v-if="errors.hasOwnProperty('name')">{{ errors.name[0] }}</span>
                    </div>
                </div>
                <br>
                <div class="vx-row">
                    <div class="vx-col w-full">
                        <vs-select
                            placeholder="Select Parent Category"
                            class="w-full"
                            label="Parent Category"
                            autocomplete
                            label-placeholder="Select Category"
                            v-model="form.subcategory.parent_id"
                        >
                            <vs-select-item :key="i" :value="category.id" :text="category.name"
                                            v-for="(category,i) in listCategory"/>
                        </vs-select>
                    </div>
                </div>
                <!-- Save & Reset Button -->
                <div class="vx-row">
                    <div class="vx-col w-full">
                        <div class="mt-8 flex flex-wrap items-center justify-end">
                            <vs-button class="ml-auto mt-2" @click="submitStoreSubCategory(isEdit)">Save Changes
                            </vs-button>
                            <vs-button @click="popupCreateSubActive=false" class="ml-4 mt-2" type="border"
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
                <vs-table search max-items="10" pagination stripe :data="categories">
                    <template slot="header">
                        <vs-button
                            @click="popupShow"
                            color="primary"
                            type="gradient"
                            icon="add">Add new SubCategory
                        </vs-button>
                    </template>
                    <template slot="thead">
                        <vs-th>
                            ID
                        </vs-th>
                        <vs-th sort-key="name">
                            Category
                        </vs-th>
                        <vs-th sort-key="name">
                            SubCategory
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
                                <router-link
                                    :to="{name: 'CategoryShow', params:{id:(data[indextr].parent_id)?data[indextr].category.id:data[indextr].id}}">
                                    {{
                                    (data[indextr].parent_id)?data[indextr].category.name:data[indextr].name }}
                                </router-link>

                            </vs-td>

                            <vs-td :data="data[indextr].name">
                                <router-link
                                    :to="{name: 'ProductList', query:{subcategory_id:data[indextr].id, category_id:data[indextr].category.id}}">
                                    {{(data[indextr].parent_id)?data[indextr].name:''}}
                                </router-link>

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
                                        <vs-button @click="openConfirm(data[indextr].id)" class="mb-2" color="danger"
                                                   type="gradient">Delete
                                        </vs-button>
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
                categoryId: '',
                titleSubCategory: 'Create SubCategory',

                form: {
                    subcategory: {
                        name: '',
                        parent_id: this.$route.params.id,
                    },
                },
                popupCreateSubActive: false,
            }
        },
        computed: {
            categories() {
                return this.$store.state.category.categories;
                // return cat.filter(item => item.parent_id === this.$route.params.id);
            },
            listCategory() {
                return this.$store.state.category.listCategory;
            },
            errors() {
                return this.$store.state.category.errors;
            },
            ...mapState({
                user: state => state.auth.user
            })
        },
        methods: {
            popupShow() {
                this.popupCreateSubActive = true;
                this.titleCategory = 'Create SubCategory';
                this.isEdit = false;
                this.form.subcategory.name = '';
            },
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
            subAdd(id) {
                this.form.subcategory.parent_id = id;
                this.popupCreateSubActive = true;
                this.isEdit = false;
            },
            edit(category) {
                this.categoryId = category.id;
                this.isEdit = true;

                if (category.parent_id) {
                    this.popupCreateSubActive = true;
                    this.titleSubCategory = 'Edit SubCategory';
                    this.form.subcategory.name = category.name;
                    this.form.subcategory.parent_id = category.category.id;
                } else {
                    this.popupCreateActive = true;
                    this.titleCategory = 'Edit Category';
                    this.form.category.name = category.name;
                }
            },
            remove() {
                this.$store
                    .dispatch("category/DELETE_CATEGORY", this.id)
                    // go to which page after successfully login
                    .then(
                        this.$vs.notify({
                            title: 'Success',
                            text: 'Category deleted successfully!',
                            color: 'success',
                            iconPack: 'feather',
                            icon: 'icon-check',
                            position: 'top-right',
                        }));
            },
            submitStoreSubCategory(isEdit) {
                let uri = 'category/STORE_CATEGORY';
                let formData = new FormData()
                formData.append('name', this.form.subcategory.name);
                formData.append('parent_id', this.form.subcategory.parent_id);
                let data = formData;
                if (isEdit) {
                    const id = this.categoryId;
                    formData.append('_method', 'PUT');
                    uri = 'category/UPDATE_CATEGORY';
                    data = {params: formData, id};
                }
                this.$store
                    .dispatch(`${uri}`, data)
                    // go to which page after successfully login
                    .then(() => {
                            this.$vs.notify({
                                title: 'Success',
                                text: 'Category created successfully!',
                                color: 'success',
                                iconPack: 'feather',
                                icon: 'icon-check',
                                position: 'top-right',
                            });
                            this.popupCreateSubActive = false;
                            this.$store.dispatch('category/FETCH_SUBCATEGORIES', this.$route.params.id).catch(err => {
                                console.error(err)
                            })
                        }
                    );
            },
        },
        mounted() {
            if (this.$vs.rtl) {
                const header = this.$refs.agGridTable.$el.querySelector('.ag-header-container')
                header.style.left = `-${String(Number(header.style.transform.slice(11, -3)) + 9)}px`
            }
        },
        created() {
            this.$store.dispatch('category/FETCH_SUBCATEGORIES', this.$route.params.id).catch(err => {
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
