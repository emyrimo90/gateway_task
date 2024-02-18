<template>
    <div class="dropdown d-md-flex" v-if="show">
        <a class="nav-link icon full-screen-link" @click.prevent="changeLocale()">
            <i class="las la-globe"></i>
            {{ lang }}
        </a>
    </div>
</template>

<script>
import Storage from "@services/storage";

export default {
    props:{
      show:{
          type:[Boolean],
          default:false
      }

    },
    computed: {
        lang() {
            return this.$i18n.locale === 'ar' ? 'en' : 'ar';
        }
    },
    methods: {
        changeLocale() {
            axios.get("/api/v1/change-locale/" + this.lang).then(response => {
                let data = !_.includes(['ar', 'en'], response.data) ? 'en' : response.data;
                Storage.set('lang', data);
                this.$i18n.locale = this.lang;
                this.$router.go(0);
            });
        }
    }
}

</script>

<style scoped>

</style>
