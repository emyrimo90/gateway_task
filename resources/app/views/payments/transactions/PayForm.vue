<template>
    <form @keydown="clearInput($event.target.name)">
        <div class="mb-3">
            <form-input label="pages.amount" type="text"
                        :model="payment" name="amount" :errors="formErrors" @clearErrors="clearInput"/>
        </div>
        <button type="submit" class="btn btn-primary" @click.prevent="submit" :disabled="submitFormDisabled">
            {{$t('save')}} <i v-if="submitFormDisabled" class="fas fa-circle-notch fa-spin"></i>
        </button>
        <button type="button" class="btn btn-secondary" style="margin-right: 5px; margin-left: 5px;"
                @click="$emit('closed')">
            {{ $t('cancel') }}
        </button>
    </form>
</template>

<script>
import paymentApi from "@api/transaction.api";
import {useToast} from "vue-toastification";
import Storage from "@services/storage";

export default {
    name: "payment-form",
    emits:[],
    props:{
        payment:{
            type: [Array, Object],
            required:false,
        },
    },
    methods:{
        submit(){
            this.submitFormDisabled = true;
            this.savePayment();
        },
        savePayment(){
            paymentApi.processTransaction(this.payment)
                .then(({data}) => {
                    this.submitFormDisabled = false;
                    // Storage.set('current_transaction', data);
                    useToast().success(data.message);
                    this.$emit('created', data.data);
                    console.table(data);
                    window.location.href = data.redirectLink;
                })
                .catch(error => {
                    this.formErrors = error.response?.data.errors;
                    this.submitFormDisabled = false;
                })
        },
        clearForm(){
            this.resetForm(this.payment);
            this.clearErrors();
        },
    }
}
</script>

<style scoped>

</style>
