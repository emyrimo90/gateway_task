<template>
    <div class="main-content side-content">
        <div class="container">
            <page-header title="sidebar.roles" :active="false">
                <li class="breadcrumb-item active" aria-current="page">{{ isUpdateForm ? $t('pages.edit_role') : $t('pages.add_new_role') }}</li>
            </page-header>
            <div class="py-2">
                <div class="card rounded border-0 shadow-sm mt-4">
                    <div class="card-body">
                        <form class="d-flex flex-column">
                            <div class="mb-3">
                                <form-input label="pages.name" type="text"
                                            :model="form" name="name" :errors="formErrors" @clearErrors="clearInput"/>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-md-4" v-for="(model_permissions, index) in this.system_permissions" :key="index">
                                    <permission-card :permissions="model_permissions" :group-title="index"
                                                     v-model="form.role_permissions" :update-form="isUpdateForm">
                                    </permission-card>
                                </div>
                            </div>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button class="btn ripple btn-primary me-2" @click.prevent="submit">{{ $t('forms.save') }}</button>
                                <cancel-button/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import RoleApi from '@api/role.api';
import PermissionApi from '@api/permission.api';
import PermissionCard from "./PermissionCard.vue";

export default {
    name: 'role-form',
    components: {
        PermissionCard,
    },

    data() {
        return {
            isUpdateForm: !!this.$route.params.id,
            isReadonly: false,
            form: {
                name: '',
                role_permissions: {},
            },
            system_permissions: [],
        }
    },
    created() {
        if (this.isUpdateForm) {
            this.getRole();
        }
        this.getSystemPermissions();
    },

    methods: {
        getRole() {
            return RoleApi.get({
                id: this.$route.params.id,
            })
                .then(resp => {
                    const role = resp.data.data.role;
                    this.form.id = role.id;
                    this.form.name = role.name;
                    this.form.role_permissions = role.permissions;
                    console.log(this.form.role_permissions);
                    if ((role.id == 1) || (role.id == 2)) this.isReadonly = true;
                });
        },

        getSystemPermissions() {
            return PermissionApi.list()
                .then(resp => {
                    this.system_permissions = resp.data;
                });
        },

        submit() {
            if (this.isUpdateForm) {
                return RoleApi.update(this.form)
                    .then((response) => {
                        this.$router.back();
                    }).catch((error) => {
                        this.formErrors = error.response.data.errors;
                    });
            }

            return RoleApi.store(this.form)
                .then((response) => {
                    this.$router.back();
                }).catch((error) => {
                    this.formErrors = error.response.data.errors;
                });
        }
    }
}

</script>
