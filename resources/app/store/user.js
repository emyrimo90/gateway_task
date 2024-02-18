import {defineStore} from 'pinia'
import AuthApi from '@api/auth.api'

export const useAuthUserStore = defineStore('authUser', {
    // convert to a function
    state() {
        return {
            user: {},
            id: '',
            token: '',
            name: '',
            avatar: '',
            roles: [],
            permissions: [],
            title: {},
        }
    },
    getters: {
        getUserData(state)
        {
            return state.user
        }
    },
    actions: {

        async login(userInfo) {
            const {email, password} = userInfo;
            await AuthApi.csrf();
            return await AuthApi.login({
                email: email.trim(),
                password: password
            }).then((response) => {
                this.setUserData(response.data.data.user)
                return response;
            });
        },

        async resetPassword({}, resetData) {
            const {email} = resetData;
            return await AuthApi.resetPassword({
                email: email.trim(),
            }).then((response) => {
                // console.log('reset password done...');
                return response;
            });
        },

        async changePassword(params) {
            return await AuthApi.changePassword(params)
                .then((response) => {
                    this.setUserData(response.data.data.user)
                    return response;
            });
        },

        setUserData(data) {
            this.user = data;
            this.permissions = data.permissions;
            this.roles = data.roles_ids
        },

        // user logout
        logout() {
            return new Promise((resolve, reject) => {
                try {
                    AuthApi.logout()
                        .then((response) => {
                            this.resetUser()
                            resolve(response);
                        }).catch((error) => {
                        reject(error);
                    });
                } catch (error) {
                    reject(error);
                }
            });
        },

        // remove token
        resetUser() {
            this.user = {};
            this.permissions = []
        },

        can(action){
            let check = false;
            if (this.permissions.length <= 0){
                return check;
            }

            const permissions = this.user.permissions;
            return _.includes(permissions, action);
        },

        hasRole(role){
            return this.user.roles &&this.user.roles.includes(role);
        }

    },
    persist: true,
});
