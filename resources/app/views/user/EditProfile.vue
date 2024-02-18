<template>
    <div class="main-content side-content">
        <div class="container">
            <page-header :active="false" title="sidebar.profile">
                <li aria-current="page" class="breadcrumb-item active">{{ $t('pages.edit_profile') }}</li>
            </page-header>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card custom-card">
                        <div class="card-header rounded-bottom-0 my-3">
                            <div class="card-body">
                                <form class="d-flex flex-column">
                                    <div class="mb-3">
                                        <form-input :errors="formErrors" :model="user"
                                                    label="pages.name" name="name" type="text"
                                                    @clearErrors="clearInput"/>
                                    </div>
                                    <div class="mb-3">
                                        <form-input :errors="formErrors" :model="user"
                                                    label="pages.email" name="email" type="email"
                                                    @clearErrors="clearInput"/>
                                    </div>
                                    <div class="mb-3">
                                        <form-input :errors="formErrors" :model="user"
                                                    label="pages.password" name="password" type="password"
                                                    @clearErrors="clearInput"/>
                                    </div>
                                    <div class="mb-3">
                                        <form-input :errors="formErrors" :model="user"
                                                    label="pages.password_confirm" name="password_confirmation" type="password"
                                                    @clearErrors="clearInput"/>
                                    </div>
                                    <div class="mb-3">
                                        <form-input :errors="formErrors" :model="user"
                                                    label="pages.phone" name="phone" type="number"
                                                    @clearErrors="clearInput"/>
                                    </div>
                                    <div aria-label="Basic example">
                                        <button :disabled="submitFormDisabled" class="btn ripple btn-primary me-2"
                                                @click.prevent="submit">{{ $t('forms.save') }}
                                        </button>
                                        <cancel-button/>
                                    </div>
                                </form>
                                <hr>
                                <template v-if="logs">
                                    <user-log :logs="logs" :pagination="pagination" @getUserLog="getUserLog"/>
                                    <pagination :pagination="pagination" @paginate="getUserLog"/>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {useToast} from "vue-toastification"
import UserApi from '@api/user.api';
import Pagination from "@/components/Pagination.vue";
import UserLog from "@views/users/UserLog.vue";
import LogApi from "@api/logs.api";

export default {
    name: 'edit-profile',
    components: {UserLog, Pagination},
    data() {
        return {
            user: {},
            filters: {
                page: 1,
            },
            pagination: {},
            logs: [],
        }
    },
    async created() {
        this.user = this.$store.userStore.getUserData
        await this.getUserLog();
    },
    methods: {
        submit() {
            UserApi.update(this.user)
                .then(resp => {
                    this.$store.userStore.setUserData(resp.data.data)
                    useToast().success(this.$t('messages.success'));
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.formErrors = error.response.data.errors
                    }
                });
        },
        async getUserLog(page = 1) {
            this.filters.page = page
            this.filters.user = this.user.id
            await LogApi.list(this.filters)
                .then(({data}) => {
                    this.logs = data.data
                    this.pagination = data.meta
                })
        }
    },
}

</script>
