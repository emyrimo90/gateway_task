<template>
    <div class="d-flex flex-column align-items-center justify-content-center min-vh-100">
        <div class="authForm mx-auto">
            <div class="text-center mb-2">
                <img :src="`${publicPath}/assets/images/logo.svg`" class="header-brand-img" alt="logo">
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center fs-20">{{ $t('global.new_password') }}</h4>
                    <form method="POST" action="#">
                        <div class="mb-3">
                            <form-input :errors="formErrors" :model="resetPasswordForm"
                                        label="pages.password" name="password" type="password"
                                        @clearErrors="clearInput"/>
                        </div>
                        <div class="mb-3">
                            <form-input :errors="formErrors" :model="resetPasswordForm"
                                        label="pages.password_confirm" name="password_confirmation" type="password"
                                        @clearErrors="clearInput"/>
                        </div>
                        <button type="submit" @click.prevent="handleRestPassword" class="btn ripple btn-primary w-100">
                            {{ $t('global.change') }}
                        </button>
                    </form>
                    <div class="mt-3 text-center">
                        <p class="mb-1">
                            <router-link to="/login">{{ $t('global.sign_in') }}</router-link>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import toast from "@/plugins/toast";
    import {useToast} from "vue-toastification";

    export default {
        name: 'new-password',
        data(){
            return{
                resetPasswordForm:{
                    password:'',
                    password_confirmation:'',
                }
            }
        },
        methods:{
            handleRestPassword(){
                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString);
                this.resetPasswordForm.token = urlParams.get('token');
                this.resetPasswordForm.email = urlParams.get('email');

                this.$store.userStore.changePassword(this.resetPasswordForm)
                    .then((response) => {
                        useToast().success(response.data.message);
                        this.$router.push({
                            path: '/dashboard'
                        });
                    })
                    .catch((error) => {
                        console.log(error)
                        this.formErrors = error.response.data.errors;
                    });
            }
        }
    }

</script>
