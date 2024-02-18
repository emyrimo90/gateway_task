<template>
    <div class="main-content side-content">
        <div class="container">
            <page-header title="sidebar.gateway_settings" :showAddButton="can('create_gateway_setting')" @openCreate="openForm"
                         @openPrintPdf="print('report')"/>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card custom-card">
                        <div class="card-header rounded-bottom-0">
                            <div class="card-body">
                                <filters @submit="getGatewaySettings" :model="filters"/>
                                <div class="table-responsive">
                                    <table class="table table-bordered border text-nowrap mb-0" id="new-edit"
                                           v-if="gateway_settings.length">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ $t('pages.name') }}</th>
                                            <th>{{ $t('pages.client_id') }}</th>
<!--                                            <th>{{ $t('pages.client_secret') }}</th>-->
                                            <th>{{ $t('pages.mode') }}</th>
                                            <th>{{ $t('pages.currency') }}</th>
                                            <th>{{ $t('pages.status') }}</th>
                                            <th>{{ $t('global.actions') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(
                                                gatewaySetting, index) in gateway_settings" :key="gatewaySetting.id">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ gatewaySetting.name }}</td>
                                            <td>{{ gatewaySetting.client_id }}</td>
<!--                                            <td>{{ gatewaySetting.client_secret}}</td>-->
                                            <td>{{ gatewaySetting.type }}</td>
                                            <td>{{ gatewaySetting.currency }}</td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="flexSwitchCheckDefault"
                                                           :checked="gatewaySetting.status"
                                                           @click.prevent="changeStatus(gatewaySetting)">
                                                </div>
                                            </td>
                                            <td name="bstable-actions">
                                                <div class="btn-list">
                                                    <button class="btn btn-sm btn-info text-white"
                                                            v-if="can('update_gateway_setting')" @click="openView(gatewaySetting)">
                                                        <span class="fas fa-eye"></span>
                                                    </button>

                                                    <button class="btn btn-sm btn-primary m-1"
                                                            v-if="can('update_gateway_setting')" @click="openForm(gatewaySetting)">
                                                        <span class="fas fa-edit"></span>
                                                    </button>
                                                    <delete-button v-if="can('delete_gateway_setting')&&gatewaySetting.can_delete"
                                                                   @del-model="delGatewaySetting(gatewaySetting, index)"/>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <strong v-if="!gateway_settings.length && !isLoading" class="text-danger">
                                    {{ $t('global.no_results') }}
                                </strong>
                                <pagination v-if="gateway_settings.length" :pagination="pagination" @paginate="getGatewaySettings"/>

                                <spinner v-if="this.$store.loaderStore.loading"></spinner>

                                <modal target="form-modal" ref="formModal" @confirm="onDelete" size="lg">
                                    <template #body>
                                        <gateway-setting-form :gatewaySetting="selectedGatewaySetting" ref="gatewayForm"
                                                              @closed="this.$refs.formModal.close()"
                                                              @created="onCreate" @updated="onUpdate"/>
                                    </template>
                                </modal>
                                <modal target="view-modal" ref="viewModal" @confirm="onDelete" size="lg">
                                    <template #body>
                                        <gateway-setting-view :gatewaySetting="selectedGatewaySetting" ref="viewForm"
                                                              @closed="this.$refs.formModal.close()"
                                        />
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
import {useToast} from "vue-toastification";
import GatewaySettingApi from '@api/gateway-setting.api'
import GatewaySettingForm from "./GatewaySettingForm.vue";
import GatewaySettingView from "@views/payments/gateways/GatewaySettingView.vue";

export default {
    name: 'gateway-settings-index',
    components: {GatewaySettingView, GatewaySettingForm},
    data() {
        return {
            selectedGatewaySetting:{},
            gateway_settings: [],
            isLoading: false,
            filters: {
                page: 1,
            },
            pagination: {},
            title: 'add_gateway_setting',
        }
    },
    created() {
        this.getGatewaySettings();
    },
    methods: {
        getGatewaySettings(page = 1) {
            this.gateway_settings = [];
            this.isLoading = true;
            this.filters.page = page;
            GatewaySettingApi.list(this.filters)
                .then(({data}) => {
                    this.isLoading = false;
                    this.gateway_settings = data.data;
                    this.pagination = data.meta;
                }).catch(error => {
                    this.isLoading = false;
                    console.log(error);
                }
            );
        },
        changeStatus(gatewaySetting) {
            GatewaySettingApi.changeStatus(gatewaySetting)
                .then(({data}) => {
                    this.getGatewaySettings()
                    useToast().success(this.$t('messages.success'))
                });
        },
        delGatewaySetting(gatewaySetting, index) {
            GatewaySettingApi.delete(gatewaySetting)
                .then(resp => {
                    this.gateway_settings.splice(index, 1);
                    useToast().success(resp.data.message);
                });
        },
        openView(gatewaySetting = {}) {
            this.title = 'view_gateway_setting'
            this.selectedGatewaySetting = _.cloneDeep(gatewaySetting)
            this.$refs.viewModal.open(this.title);
        },
        openForm(gatewaySetting = {}) {
            if (gatewaySetting.id) {
                this.title = 'update_gateway_setting'
                this.selectedGatewaySetting = _.cloneDeep(gatewaySetting)
            } else {
                this.title = 'add_gateway_setting';
                this.selectedGatewaySetting = _.cloneDeep({
                    'currency':'USD',
                    'response_url':"success-transaction",
                    'cancel_url':"cancel-transaction",
                })
            }
            this.$refs.gatewayForm.clearErrors();
            this.$refs.formModal.open(this.title);
        },
        onDelete(gatewaySetting) {

        },
        onUpdate(data) {
            this.$refs.formModal.close();
            this.getGatewaySettings();
        },
        onCreate(data) {
            this.$refs.formModal.close();
            this.getGatewaySettings();
        }
    }
}

</script>
