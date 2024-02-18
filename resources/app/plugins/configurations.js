import Configurations from "@/mixins/configurations";

export default {
    install(Vue, options) {

        const optionsDefaults = {}

        // Merge options argument into options defaults
        options = {
            ...optionsDefaults,
            ...options
        }

        Vue.mixin(Configurations);
    }
}
