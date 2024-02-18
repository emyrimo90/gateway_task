<template>
    <div class="main-content side-content">
        <div class="container">
            <page-header title="sidebar.users" :showAddButton="can('create_user')"  @openCreate="openForm"
                         @openPrintPdf="print('report')"/>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card custom-card">
                        <div class="card-header rounded-bottom-0">
                            <div class="card-body">
                                <filters @submit="getUsers" :model="filters">
                                    <div class="col-sm-4 col-md-4">
                                        <div class="mb-3">
                                            <el-select v-model="filters.role" :clearable="true" :filterable="true"
                                                :placeholder="$t('forms.select')">
                                                <el-option v-for="item in roles" :key="item.id" :label="item.name"
                                                    :value="item.id" />
                                            </el-select>
                                        </div>
                                    </div>
                                </filters>
                                <div class="table-responsive">
                                    <table class="table table-bordered border text-nowrap mb-0" id="new-edit"
                                        v-if="users.length">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ $t('pages.name') }}</th>
                                                <th>{{ $t('pages.email') }}</th>
                                                <th>{{ $t('pages.phone') }}</th>
                                                <th>{{ $t('pages.role') }}</th>
                                                <th>{{ $t('global.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(user, index) in users" :key="user.id">
                                                <td>{{ index + 1 }}</td>
                                                <td>{{ user.name }}</td>
                                                <td>{{ user.email }}</td>
                                                <td>{{ user.phone }}</td>
                                                <td>{{ user.roles }}</td>
                                                <td name="bstable-actions">
                                                    <div class="btn-list">
                                                        <router-link class="btn btn-sm btn-info"
                                                            v-if="can('read_user')" :to="`/users/${user.id}`"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            :title="$t('pages.show_user')">
                                                            <i class="fa fa-eye text-white"></i>
                                                        </router-link>
                                                        <button class="btn btn-sm btn-primary m-1"
                                                            v-if="can('update_user')" @click="openForm(user)">
                                                            <span class="fas fa-edit"></span>
                                                        </button>
                                                        <delete-button v-if="can('delete_user')"
                                                            @del-model="delUser(user, index)" />
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <strong v-if="!users.length && !isLoading" class="text-danger">{{
                                    $t('global.no_results')
                                }}</strong>
                                <spinner v-if="this.$store.loaderStore.loading"></spinner>
                                <pagination :pagination="pagination" @paginate="getUsers" />

                                <modal target="form-modal" ref="formModal" @confirm="onDelete" :size="'lg'">
                                    <template #body>
                                        <user-form :user="user" :roles="roles" ref="userForm" @closed="this.$refs.formModal.close()"
                                                   @created="onCreate" @updated="onUpdate"/>
                                    </template>
                                </modal>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useToast } from "vue-toastification";
import UserApi from '@api/user.api'
import UserForm from "./UserForm.vue";
import RoleApi from "@api/role.api";

export default {
    name: 'user-index',
    components: { UserForm },
    data() {
        return {
            users: [],
            roles: [],
            isLoading: false,
            filters: {
                page: 1,
                embed:''
            },
            pagination: {},
            user: {},
            title: 'pages.add_new_user',
        }
    },
    created() {
        this.getUsers();
        this.getRoles();
    },
    methods: {
        getRoles() {
            RoleApi.list()
                .then(({ data }) => {
                    this.roles = data.data;
                }).catch(error => {
                console.log(error);
            })
        },
        getUsers(page = 1) {
            this.users = [];
            this.isLoading = true;
            this.filters.page = page;
            UserApi.list(this.filters)
                .then(({ data }) => {
                    this.isLoading = false;
                    this.users = data.data;
                    this.pagination = data.meta;
                }).catch(error => {
                    this.isLoading = false;
                    console.log(error);
                }
                );
        },
        delUser(user, index) {
            UserApi.delete(user)
                .then(resp => {
                    this.users.splice(index, 1);
                    useToast().success(resp.data.message);
                });
        },
        openForm(user = {}) {
            if (user.id) {
                this.title = 'pages.edit_user'
            } else {
                this.title = 'pages.add_new_user'
            }
            this.user = _.cloneDeep(user)
            this.$refs.userForm.clearErrors();
            this.$refs.formModal.open(this.title);
        },
        onDelete(user){

        },
        onUpdate(data){
            this.$refs.formModal.close();
            this.getUsers();
        },
        onCreate(data){
            this.$refs.formModal.close();
            this.getUsers();
        }
    }
}

</script>
