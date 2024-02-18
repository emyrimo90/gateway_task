<template>
    <div class="main-content side-content">
        <div class="container">
            <page-header title="sidebar.roles" :active="false">
                <li class="breadcrumb-item active" aria-current="page">{{ $t('permissions.read_role') }}</li>
            </page-header>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card custom-card">
                        <div class="card-header rounded-bottom-0 my-3">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <th>{{$t('name_en')}}</th>
                                        <td>{{role.name_en}}</td>
                                        <th>{{$t('name_ar')}}</th>
                                        <td>{{role.name_ar}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <form-label for="permissions" :label="$t('permissions.permissions')"/>
                                    <div v-if="role.role_permissions" class="col-md-3" v-for="(model_permissions, index) in role.role_permissions" :key="index">
                                        <div class="card m-2 mb-4" style="width: 18rem;">
                                            <div class="card-header bg-primary text-white">
                                                <div class="form-check me-4">
                                                    <label class="custom-control-label"
                                                           :for="`${index}-checkbox`">{{ $t(`permissions.${index}`) }}</label>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-check me-4" v-for="(permission,index) in model_permissions" :key="index">
                                                    <label class="custom-control-label" :for="`checkbox-${permission.id}`">{{ $t(`permissions.${permission}`) }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        {{$t("permissions_not_found")}}
                                    </div>
                                </div>
                                <router-link :to="redirectPath" class="btn btn-secondary m-2 text-white">{{ $t('back') }}</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import RoleApi from '@api/role.api';
import PermissionCard from "./PermissionCard.vue";
import {useRoute} from "vue-router";
import {onMounted, ref} from "vue";

export default {
    components: {
        PermissionCard,
    },
    setup(){
        const role =  ref({
            role_permissions:[]
        });
        const route = useRoute();
        let redirectPath = '/roles';
        const getRole = async ()=> {
            return await RoleApi.get({
                id: route.params.id,
                })
                .then(resp => {
                    const data = resp.data.data.role;
                    role.value = _.cloneDeep(data);
                });
        };

        onMounted(()=>{
            getRole();
        })

        return {
            role,
            getRole,
            redirectPath,
        }
    },
}

</script>

<style scoped>

</style>
