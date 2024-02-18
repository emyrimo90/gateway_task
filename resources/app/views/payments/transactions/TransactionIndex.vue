<template>
    <div class="main-content side-content">
        <div class="container">
            <page-header title="sidebar.payments" :showAddButton="can('create_gateway_setting')" @openCreate="openForm"
                         @openPrintPdf="print('report')"/>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card custom-card">
                        <div class="card-header rounded-bottom-0">
                            <div class="card-body">
                                <filters @submit="getPayments" :model="filters"/>
                                <div class="table-responsive">
                                    <table class="table table-bordered border text-nowrap mb-0" id="new-edit"
                                           v-if="payments.length">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ $t('pages.trace_id') }}</th>
<!--                                            <th>{{ $t('pages.payment_status') }}</th>-->
                                            <th>{{ $t('pages.status') }}</th>
                                            <th>{{ $t('pages.currency') }}</th>
                                            <th>{{ $t('pages.amount') }}</th>
                                            <th>{{ $t('pages.transaction_date') }}</th>
                                            <th>{{ $t('pages.client') }}</th>
                                            <th>{{ $t('pages.gateway_used') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(
                                                payment, index) in payments" :key="payment.id">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ payment.trace_id }}</td>
<!--                                            <td>{{ payment.payment_status }}</td>-->
                                            <td>{{ payment.status }}</td>
                                            <td>{{ payment.currency }}</td>
                                            <td>{{ payment.amount }}</td>
                                            <td>{{ payment.paid_at }}</td>
                                            <td>{{ _get(payment, 'user.name') }}</td>
                                            <td>{{ _get(payment, 'gatewaySetting.name') }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <strong v-if="!payments.length && !isLoading" class="text-danger">
                                    {{ $t('global.no_results') }}
                                </strong>
                                <pagination v-if="payments.length" :pagination="pagination" @paginate="getPayments"/>

                                <spinner v-if="this.$store.loaderStore.loading"></spinner>

                                <modal target="form-modal" ref="formModal">
                                    <template #body>
                                        <payment-form :payment="selectedPayment" ref="paymentForm"
                                                      @closed="this.$refs.formModal.close()"
                                                      @created="onCreate"/>
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
import paymentApi from '@api/transaction.api'
import PaymentForm from "@views/payments/transactions/PayForm.vue";
import {useToast} from "vue-toastification";

export default {
    name: 'payments-index',
    components: {PaymentForm},
    data() {
        return {
            selectedPayment: {},
            payments: [],
            isLoading: false,
            filters: {
                page: 1,
                embed: 'user,gatewaySetting'
            },
            pagination: {},
            title: 'add_payment',
        }
    },
    created() {
        this.getPayments();
        if(this.$route.params.id){
            paymentApi.get({
                id: this.$route.params.id,
            }).then(({data}) => {
                    useToast().success(data.data.comment);
                    this.$router.push({
                        path: '/transactions'
                    });
                }).catch(error => {
console.log(error)
                }
            );
        }
    },
    methods: {
        getPayments(page = 1) {
            this.payments = [];
            this.isLoading = true;
            this.filters.page = page;
            paymentApi.list(this.filters)
                .then(({data}) => {
                    this.isLoading = false;
                    this.payments = data.data;
                    this.pagination = data.meta;
                }).catch(error => {
                    this.isLoading = false;
                }
            );
        },

        openForm(payment = {}) {
            this.title = 'add_payment';
            this.selectedPayment = _.cloneDeep({})
            this.$refs.paymentForm.clearErrors();
            this.$refs.formModal.open(this.title);
        },
        onCreate(data) {
            this.$refs.formModal.close();
            this.getPayments();
        }
    }
}
</script>
