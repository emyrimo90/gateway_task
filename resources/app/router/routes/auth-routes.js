import Login from '@views/Auth/Login.vue'
import i18n from "@/lang";

const {t} = i18n.global;

export default [
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            requiresAuth: true,
            title: t('global.sign_in'),
        }
    },
    {
        name:'forget-password',
        path:'/forget-password',
        component: ()=> import('@views/Auth/ForgetPassword.vue'),
        meta: {
            requireAuth:false,
            title: t('global.forget_password'),
        }
    },
    {
        name:'reset-password',
        path:'/reset-password',
        component: ()=> import('@views/Auth/NewPassword.vue'),
        meta: {
            requireAuth:false,
            title: t('global.reset_password'),
        }
    },
]
