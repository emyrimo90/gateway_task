<script>
export default {
    name: 'login',
    data() {
        return {
            loginForm: {
                email: '',
                password: '',
            },
        }
    },
    methods: {
        handleLogin() {
            this.$store.userStore.login(this.loginForm)
                .then((response) => {
                    this.$router.push({
                        path: '/dashboard'
                    });
                })
                .catch((error) => {
                    console.log(error)
                    this.formErrors = error.response.data.errors;
                });
        },
        forgetPassword(){

        }
    }
}
</script>

<template>
    <div class="d-flex flex-column align-items-center justify-content-center min-vh-100">
        <div class="authForm mx-auto">
            <div class="text-center mb-2">
                <img :src="`${publicPath}/assets/images/logo.svg`" class="header-brand-img" alt="logo">
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center fs-20">{{ $t('global.sign_in_message') }}</h4>
                    <form method="POST" action="#">
                        <div class="mb-3">
                            <form-input label="pages.email" type="text" :model="loginForm"
                                        name="email" :errors="formErrors" @clearErrors="clearInput"/>
                        </div>
                        <div class="mb-3">
                            <form-input label="pages.password" type="password" :model="loginForm"
                                        name="password" :errors="formErrors" @clearErrors="clearInput" autocomplete="password"/>
                        </div>
                        <button type="submit" @click.prevent="handleLogin" class="btn ripple btn-primary w-100">
                            {{ $t('global.sign_in') }}
                        </button>
                    </form>
                    <div class="mt-3 text-center">
                        <p class="mb-1">
                            <router-link to="/forget-password">{{ $t('global.forget_password') }}</router-link>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
