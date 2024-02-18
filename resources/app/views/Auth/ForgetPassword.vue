<template>
    <div class="d-flex flex-column align-items-center justify-content-center min-vh-100">
        <div class="authForm mx-auto">
            <div class="text-center mb-2">
                <img :src="`${publicPath}/assets/images/logo.svg`" class="header-brand-img" alt="logo">
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center fs-20">{{ $t('global.forget_password') }}</h4>
                    <div class="mt-5">
                        <p>{{$t("global.please_enter_your_email_to_access_your_account")}}</p>
                        <form method="POST" action="#">
                            <div class="form-group">
                                <form-input label="pages.email" type="text" :model="forgetForm"
                                            name="email" :errors="formErrors" @clearErrors="clearInput"/>
                            </div>
                            <div class="d-flex justify-content-between my-4 py-2">
                                <button type="submit" class="btn btn-secondary d-block w-100" @click.prevent="handleForget">
                                    {{$t("global.forget_password")}}
                                </button>
                            </div>
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
    </div>
</template>
<script>
import {
    useToast
} from "vue-toastification";
export default {
    name: 'forget-password',
    data() {
        return {
            forgetForm: {
                email: '',
            },
            error: ''
        }
    },
    methods: {
        handleForget() {
            this.$store.userStore.resetPassword({}, this.forgetForm)
                .then((response) => {
                    useToast().success(response.data.message);
                    this.$router.push({
                        path: '/login'
                    });
                })
                .catch((error) => {
                    console.log(error)
                    this.formErrors = error.response.data.errors;
                });

            // this.$store.dispatch('user/resetPassword', this.forgetForm)
            //     .then((response) => {
            //         useToast().success(response.data.message);
            //         this.$router.push({
            //             path: '/login'
            //         });
            //     })
            //     .catch((error) => {
            //         this.error = error.response.data.errors;
            //     });
        }
    }
}

</script>
