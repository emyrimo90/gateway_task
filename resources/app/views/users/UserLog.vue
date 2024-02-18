<template>
    <h5>{{ $t('pages.activity_log') }}</h5>
    <spinner v-if="this.$store.loaderStore.loading"></spinner>
    <div v-if="logs.length" class="table-responsive">
        <table id="new-edit" class="table table-bordered border text-nowrap mb-0">
            <thead>
            <tr>
                <th>#</th>
                <th>{{ $t('pages.action') }}</th>
                <th>{{ $t('pages.module') }}</th>
                <th>{{ $t('pages.message') }}</th>
                <th>{{ $t('pages.date') }}</th>
                <th>{{ $t('pages.time') }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(log, index) in logs" :key="log.id">
                <td>{{ index + pagination.from }}</td>
                <td>{{ log.action }}</td>
                <td>{{ log.module }}</td>
                <td>{{ log.message }}</td>
                <td>{{ log.date }}</td>
                <td>{{ log.time }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <strong v-if="!logs.length && !this.$store.loaderStore.loading" class="text-danger">
        {{ $t('global.no_results') }}
    </strong>
</template>

<script>
export default {
    name: "UserLog",
    emits: ['getUserLog'],
    props: {
        logs: {
            type: Array,
            required: true
        },
        pagination: {
            type: Object,
            required: true
        }
    }
}
</script>

<style scoped>

</style>
