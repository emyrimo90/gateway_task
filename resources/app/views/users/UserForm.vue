<template>
    <form @keydown="clearInput($event.target.name)">
        <div class="mb-3">
            <form-input label="pages.name" type="text"
                        :model="user" name="name" :errors="formErrors" @clearErrors="clearInput"/>
        </div>
        <div class="mb-3">
            <form-input label="pages.email" type="email"
                        :model="user" name="email" :errors="formErrors" @clearErrors="clearInput"/>
        </div>
        <div class="mb-3">
            <form-input label="pages.password" type="password"
                        :model="user" name="password" :errors="formErrors" @clearErrors="clearInput"/>
        </div>
        <div class="mb-3">
            <form-input label="pages.password_confirm" type="password"
                        :model="user" name="password_confirmation" :errors="formErrors" @clearErrors="clearInput"/>
        </div>
        <div class="mb-3">
            <form-input label="pages.phone" type="text"
                        :model="user" name="phone" :errors="formErrors" @clearErrors="clearInput"/>
        </div>
        <div class="mb-3">
            <form-select title="pages.role" label="name" name="role_id"
                         @clearErrors="clearInput"
                         :model="user" :myOptions="roles" :errors="formErrors"/>
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
import UserApi from "@api/user.api";
import {useToast} from "vue-toastification";

export default {
    name: "user-form",
    emits:[],
    props:{
        user:{
            type: [Array, Object],
            required:false,
        },
        roles:{
            type: [Array, Object],
            required:false,
        },
    },
    methods:{
        submit(){
            this.submitFormDisabled = true;
            let id = this.user.id;
            if (id){
                this.updateUser();
            }else{
                this.saveUser()
            }
        },
        saveUser(){
            UserApi.store(this.user)
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
        updateUser(){
            UserApi.update(this.user)
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
            this.resetForm(this.user);
            this.clearErrors();
        },
    }
}
</script>

<style scoped>

</style>
