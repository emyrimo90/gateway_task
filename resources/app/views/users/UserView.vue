<template>
    <div class="main-content side-content">
        <div class="container">
            <page-header title="sidebar.users" :active="false">
                <li class="breadcrumb-item active" aria-current="page">{{ $t('pages.user_show') }}
                    <span v-if="user.id">: {{ user.name }}</span>
                </li>
            </page-header>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card custom-card">
                        <div class="card-header rounded-bottom-0 my-3">
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="table-responsive p-0 pt-3">
                                        <table class="table border mb-0" id="basic-table">
                                            <tbody>
                                                <tr>
                                                    <th class="table-secondary">{{ $t('pages.name') }}</th>
                                                    <td>{{ user.name }}</td>
                                                    <th class="table-secondary">{{ $t('pages.email') }}</th>
                                                    <td>{{ user.email }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="table-secondary">{{ $t('pages.phone') }}</th>
                                                    <td>{{ user.phone }}</td>
                                                    <th class="table-secondary">{{ $t('pages.role') }}</th>
                                                    <td>{{ user.roles }}</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <user-log :pagination="pagination" :logs="logs" @getUserLog="getUserLog"/>
                                <pagination :pagination="pagination" @paginate="getUserLog"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import UserApi from '@api/user.api';
import LogApi from "@api/logs.api";
import UserLog from "@views/users/UserLog.vue";
import Pagination from "@/components/Pagination.vue";

export default {
    name: 'user-show',
    components: {Pagination, UserLog},
    data() {
        return {
            isLoading: false,
            filters: {
                page: 1,
                user: this.$route.params.id,
            },
            pagination: {},
            user: {},
            logs: [],
        }
    },
    async created() {
        await this.getUser();
        await this.getUserLog();
    },
    methods: {
        async getUser() {
            await UserApi.get({ id: this.$route.params.id })
                .then(resp => {
                    this.user = resp.data.data
                });
        },
        async getUserLog(page = 1) {
            this.filters.page = page
            await LogApi.list(this.filters)
                .then(({ data }) => {
                    this.logs = data.data
                    this.pagination = data.meta
                })
        }
    }
}

</script>
