<template>
    <table class="table table-striped dt-responsive table-bordered nowrap no-footer dtr-inline w-100">
        <tbody>
        <tr>
            <th>{{$t('pages.name')}}</th>
            <td>{{ gatewaySetting.name}}</td>
        </tr>
        <tr>
            <th>{{$t('pages.mode')}}</th>
            <td>{{ gatewaySetting.type}}</td>
        </tr>
        <tr>
            <th>{{$t('pages.client_id')}}</th>
            <td>{{ gatewaySetting.client_id}}</td>
        </tr>
        <tr>
            <th>{{$t('pages.client_secret')}}</th>
            <td>{{ gatewaySetting.client_secret}}</td>
        </tr>
        <tr>
            <th>{{$t('pages.currency')}}</th>
            <td>{{ gatewaySetting.currency}}</td>
        </tr>
        <tr>
            <th>{{$t('pages.status')}}</th>
            <td>{{ gatewaySetting.status_text}}</td>
        </tr>
        <tr>
            <th>{{$t('pages.response_url')}}</th>
            <td>{{ gatewaySetting.response_url}}</td>
        </tr>
        <tr>
            <th>{{$t('pages.cancel_url')}}</th>
            <td>{{ gatewaySetting.cancel_url}}</td>
        </tr>
        </tbody>
    </table>
</template>

<script>

export default {
    name: "gateway-setting-view",
    emits:[],
    props:{
        gatewaySetting:{
            type: [Array, Object],
            required:true,
        },
    },
}
</script>

<style scoped>

</style>
