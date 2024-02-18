import {useAuthUserStore} from "../store/user";

export default {

    methods: {
        hasRole(role){
            return useAuthUserStore().hasRole(role)
        },
        can(action){
            if (action === undefined){
                return true;
            }
            return useAuthUserStore().can(action)
        }
    }
}
