<template>

    <div id="page-user-list">
        <vx-card ref="filterCard" title="Filters" class="user-list-filters mb-8" actionButtons
                 @refresh="resetColFilters"
                 @remove="resetColFilters">
            <div class="vx-row">
                <div class="vx-col md:w-1/2 sm:w-1/2 w-full">
                    <label class="text-sm opacity-75">Role</label>
                    <vs-select autocomplete @change="filterRole"
                               :dir="$vs.rtl ? 'rtl' : 'ltr'"
                               v-model="roleFilter"
                               class="w-full mb-4 md:mb-0">
                        <vs-select-item :key="index" :value="item.value" :text="item.label"
                                        v-for="(item,index) in roleOptions"/>
                    </vs-select>
                </div>
                <div class="vx-col md:w-1/2 sm:w-1/2 w-full">
                    <label class="text-sm opacity-75">Status</label>
                    <v-select disabled :options="statusOptions" :clearable="false"
                              :dir="$vs.rtl ? 'rtl' : 'ltr'"
                              v-model="statusFilter"
                              class="mb-4 md:mb-0"/>
                </div>
            </div>
        </vx-card>
        <div class="vx-card p-6">

            <div class="flex-wrap items-center">
                <vs-table @search="handleSearch" max-items="1" stripe :data="users" search :sst="true">
                    <template slot="header">
                        <vs-button @click="add" color="primary" type="gradient" icon="add">Add new user
                        </vs-button>
                    </template>
                    <template slot="thead">
                        <vs-th>
                            ID
                        </vs-th>
                        <vs-th sort-key="name">
                            Name
                        </vs-th>
                        <vs-th sort-key="email">
                            Email
                        </vs-th>
                        <vs-th>
                            Phone
                        </vs-th>
                        <vs-th sort-key="role">
                            Role
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
                                <div class="con-userx flex items-center justify-start">
                                    <vs-avatar size="45px" :src="data[indextr].avatar"/>
                                    <span>{{ data[indextr].name }}</span>
                                </div>
                            </vs-td>

                            <vs-td :data="data[indextr].email">
                                {{data[indextr].email}}
                            </vs-td>

                            <vs-td :data="data[indextr].phone">
                                {{data[indextr].phone}}
                            </vs-td>

                            <vs-td :data="data[indextr].RoleName">
                                {{data[indextr].RoleName}}
                            </vs-td>

                            <vs-td :data="data[indextr].created">
                                {{data[indextr].created}}
                            </vs-td>

                            <vs-td>
                                <div class="vx-row">
                                    <div class="vx-col w-full">
                                        <vs-button @click="openConfirmReset(data[indextr].id)" class="mb-2 mr-3"
                                                   color="warning"
                                                   type="gradient">Reset Password
                                        </vs-button>
                                        <vs-button @click="edit(data[indextr].id)" class="mb-2 mr-3" color="primary"
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
                <vs-pagination
                    class="p-2"
                    :total="total"
                    v-model="current_page"
                    @input="(val) => { handleChangePage(current_page) }"/>
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
                current_page: 1,
                // Filter Options
                roleFilter: null,
                roleOptions: [
                    {label: 'All', value: null},
                    {label: 'Sales', value: '1'},
                    {label: 'Manager', value: '2'},
                ],
                statusFilter: {label: 'Active', value: 'all'},
                statusOptions: [
                    {label: 'All', value: 'all'},
                    {label: 'Active', value: 'active'},
                    {label: 'Deactivated', value: 'deactivated'},
                    {label: 'Blocked', value: 'blocked'}
                ],

                search: '',
            }
        },
        computed: {
            users() {
                return this.$store.state.user.users
            },
            total() {
                return this.$store.state.user.total
            },
            ...mapState({
                user: state => state.auth.user
            })
        },
        methods: {
            handleSearch(searching) {
                console.log(searching)
                this.current_page = 1;
                this.search = searching;
                this.submitFilter();
            },
            handleChangePage() {
                this.submitFilter();
            },
            filterRole() {
                this.current_page = 1;
                this.submitFilter();
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
            openConfirmReset(id) {
                this.id = id
                this.$vs.dialog({
                    type: 'confirm',
                    color: 'warning',
                    title: `Reset Pasword`,
                    text: 'Are you sure you want to reset password selected items?',
                    accept: this.reset
                })
            },
            setColumnFilter(column, val) {
                const filter = this.gridApi.getFilterInstance(column)
                let modelObj = null

                if (val !== 'all') {
                    modelObj = {type: 'equals', filter: val}
                }

                filter.setModel(modelObj)
                this.gridApi.onFilterChanged()
            },
            resetColFilters() {
                this.current_page = 1;
                this.roleFilter = null;
                this.search = '';
                let params = {role: this.roleFilter}
                this.$store.dispatch('user/FETCH_USERS', params).catch(err => {
                    console.error(err)
                })
                this.$refs.filterCard.removeRefreshAnimation()
            },
            add() {
                this.$router.push({name: 'UserCreate'})
            },
            edit(id) {
                this.$router.push({name: 'UserEdit', params: {id: id}});
            },
            reset() {
                let formData = new FormData()
                let id = this.id;
                formData.append('reset', true)
                formData.append('_method', 'put')
                this.$store
                    .dispatch("user/UPDATE_USER", {id, params: formData})
                    // go to which page after successfully login
                    .then(this.$vs.notify({
                        title: 'Success',
                        text: 'User reset password successfully!',
                        color: 'success',
                        iconPack: 'feather',
                        icon: 'icon-check',
                        position: 'top-right',
                    }));
            },
            remove() {
                this.$store
                    .dispatch("user/DELETE_USERS", this.id)
                    // go to which page after successfully login
                    .then(this.$vs.notify({
                        title: 'Success',
                        text: 'User created successfully!',
                        color: 'success',
                        iconPack: 'feather',
                        icon: 'icon-check',
                        position: 'top-right',
                    }));
            },
            update_avatar(e) {
                const file = e.target.files[0];
                this.form.avatar = file;
                this.avt = URL.createObjectURL(file);
            },
            submitFilter() {
                let params = {role: this.roleFilter, page: this.current_page, search: this.search}
                this.$router.push({
                    name: 'UserList',
                    query: params
                }).catch(() => {
                });
                this.$store.dispatch('user/FETCH_USERS', params).catch(err => {
                    console.error(err)
                })
            },
        },
        mounted() {
            if (this.$vs.rtl) {
                const header = this.$refs.agGridTable.$el.querySelector('.ag-header-container')
                header.style.left = `-${String(Number(header.style.transform.slice(11, -3)) + 9)}px`
            }
        },
        created() {
            this.$store.dispatch('user/FETCH_USERS').catch(err => {
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

    /*.con-vs-popup .vs-popup {*/
    /*    width: 60% !important;*/
    /*    height: auto !important;*/
    /*}*/
</style>
