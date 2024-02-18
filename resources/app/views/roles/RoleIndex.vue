<template>
    <div class="main-content side-content">
        <div class="container">
            <div class="page-header">
                <div>
                    <h2 class="main-content-title">{{ $t('sidebar.roles') }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">{{ $t('sidebar.dashboard') }}</li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $t('sidebar.roles') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card custom-card">
                        <div class="card-header rounded-bottom-0">
                            <div class="card-body">
                                <router-link  v-if="can('create_role')" to="/roles/create" id="table2-new-row-button" class="btn btn-primary mb-4">
                                    <span class="fa fa-plus"></span>
                                    <span>{{$t('pages.add_button')}}</span>
                                </router-link>
                                <filters @submit="getRoles" :model="filters"></filters>
                                <div class="table-responsive">
                                    <table class="table table-bordered border text-nowrap mb-0" id="new-edit" v-if="roles.length">
                                        <thead>
                                        <tr>
                                            <th>{{ $t('global.name') }}</th>
                                            <th name="bstable-actions">{{ $t('global.actions') }}</th></tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(role, index) in roles" :key="role.id">
                                            <td>{{role.name}}</td>
                                            <td name="bstable-actions">
                                                <div class="btn-list">
                                                    <router-link  v-if="can('read_role')" :to="`/roles/show/${role.id}`" id="bShow" type="button" class="btn btn-sm btn-info text-white">
                                                        <span class="fa fa-eye"></span> {{$t('pages.permissions')}}
                                                    </router-link>
                                                    <router-link  v-if="can('update_role')" :to="`/roles/edit/${role.id}`" id="bEdit" type="button" class="btn btn-sm btn-primary m-1">
                                                        <span class="fa fa-edit"></span>
                                                    </router-link>
                                                    <delete-button  v-if="can('delete_role')" @del-model="delRole(role, index)"/>
                                                </div>
                                            </td>
                                        </tr>
                                       </tbody>
                                    </table>
                                </div>
                                <spinner v-if="this.$store.loaderStore.loading"></spinner>
                                <pagination :pagination="pagination" @paginate="getRoles"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {useToast} from "vue-toastification";
import RoleApi from '@api/role.api'

export default {
    name: 'role-index',
    components: {},

    data() {
        return {
            roles: [],
            filters: {
                page: 1,
                embed:'permissions'
            },
            permissions:[],
            pagination: {},
        }
    },
    created() {
        this.getRoles();
    },
    methods: {
        getRoles(page = 1) {
            this.filters.page = page;
            RoleApi.list(this.filters)
                .then(({data}) => {
                    this.roles = data.data;
                    this.pagination = data.meta;
                })
                .catch(error => {
                        console.log(error);
                    }
                );
        },
        delRole(role, index) {
            RoleApi.delete(role)
                .then(resp => {
                    this.roles.splice(index, 1);
                    useToast().success(resp.data.message);
                });
        },
    }
}

</script>
