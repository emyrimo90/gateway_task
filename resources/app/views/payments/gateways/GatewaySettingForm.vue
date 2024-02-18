<template>
    <form @keydown="clearInput($event.target.name)">
        <div class="mb-3">
            <form-input label="pages.name" type="text"
                        :model="gatewaySetting" name="name" :errors="formErrors" @clearErrors="clearInput" :required="true"/>
        </div>
        <div class="mb-3">
            <form-select title="pages.mode" label="name" name="type"
                         @clearErrors="clearInput" :required="true"
                         :model="gatewaySetting" :myOptions="[{'id':'TEST', 'name':'TEST'}, {'id':'PRODUCTION', 'name':'PRODUCTION'}]" :errors="formErrors"/>
        </div>
        <div class="mb-3">
            <form-input label="pages.client_id" type="text"
                        :model="gatewaySetting" name="client_id" :errors="formErrors" @clearErrors="clearInput" :required="true"/>
        </div>
        <div class="mb-3">
            <form-input label="pages.client_secret" type="text"
                        :model="gatewaySetting" name="client_secret" :errors="formErrors" @clearErrors="clearInput" :required="true"/>
        </div>
        <div class="mb-3">
            <form-input label="pages.currency" type="text"
                        :model="gatewaySetting" name="currency" :errors="formErrors" @clearErrors="clearInput" :disabled="true"/>
        </div>
        <div class="mb-3">
            <form-input label="pages.response_url" type="text"
                        :model="gatewaySetting" name="response_url" :errors="formErrors" @clearErrors="clearInput" :disabled="true"/>
        </div>
        <div class="mb-3">
            <form-input label="pages.cancel_url" type="text"
                        :model="gatewaySetting" name="cancel_url" :errors="formErrors" @clearErrors="clearInput" :disabled="true"/>
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
import gatewaySettingApi from "@api/gateway-setting.api";
import {useToast} from "vue-toastification";

export default {
    name: "gateway-setting-form",
    emits:[],
    props:{
        gatewaySetting:{
            type: [Array, Object],
            required:false,
        },
    },
    methods:{
        submit(){
            this.submitFormDisabled = true;
            let id = this.gatewaySetting.id;
            if (id){
                this.updateGatewaySetting();
            }else{
                this.saveGatewaySetting()
            }
        },
        saveGatewaySetting(){
            gatewaySettingApi.store(this.gatewaySetting)
                .then(({data}) => {
                    this.submitFormDisabled = false;
                    useToast().success(this.$t('messages.success'));
                    this.$emit('created', data.data);
                })
                .catch(error => {
                    console.log(error);
                    this.formErrors = error.response?.data.errors;
                })
        },
        updateGatewaySetting(){
            gatewaySettingApi.update(this.gatewaySetting)
                .then(({data}) => {
                    useToast().success(this.$t('messages.success'))
                    this.submitFormDisabled = false;
                    this.$emit('updated', data.data);
                })
                .catch(error => {
                    this.formErrors = error.response.data.errors;
                })
        },
        clearForm(){
            this.resetForm(this.gatewaySetting);
            this.clearErrors();
        },
    }
}
</script>

<style scoped>

</style>
