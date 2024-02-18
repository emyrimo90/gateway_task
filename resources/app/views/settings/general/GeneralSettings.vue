<template>
    <div class="main-content side-content">
            <div class="container">
                <page-header title="sidebar.settings" :active="false">
                    <li class="breadcrumb-item active" aria-current="page">{{ $t('sidebar.general_settings') }}</li>
                </page-header>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card custom-card">
                            <div class="card-header rounded-bottom-0">
                                <div class="card-body">
                                    <form class="d-flex flex-column">
                                        <div class="row">
                                            <div class="col-lg-6 ">
                                                <form-input label="pages.site_name" type="text"
                                                            :model="settings" name="site_name" :errors="formErrors" @clearErrors="clearInput"/>
                                            </div>
                                        <div aria-label="Basic example">
                                            <button class="btn ripple btn-primary me-2" :disabled="submitFormDisabled" @click.prevent="submit">{{ $t('forms.save') }}</button>
                                            <cancel-button/>
                                        </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
import GeneralSettingsApi from "@api/general-settings.api";
import {useToast} from "vue-toastification";

export default {
    name: "GeneralSettings",
    data() {
        return {
            settings:{}
        }
    },
    methods: {
        getSettings()
        {
          GeneralSettingsApi.list()
              .then(({data})=>{
                  this.settings = data
              })
        },
        submit()
        {
            GeneralSettingsApi.update(this.settings)
                .then(({data}) => {
                    useToast().success(this.$t('messages.success'))
                })
                .catch(error => {
                    this.formErrors = error.response.data.errors;
                })
        }
    },
    created() {
        this.getSettings()
    }
}
</script>

<style scoped>

</style>
