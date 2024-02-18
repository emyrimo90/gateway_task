<template>
    <div class="page-header">
        <div>
            <h2 class="main-content-title">{{ $t(title) }}</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">
                        <router-link to="/">
                            {{ $t('sidebar.dashboard') }}
                        </router-link>
                    </li>
                    <li :class="active ? 'breadcrumb-item active' : 'breadcrumb-item'" aria-current="page">
                        <span v-if="active">{{ $t(title) }}</span>
                        <a v-else @click="$router.back()">{{ $t(title) }}</a>
                    </li>
                    <slot></slot>
                </ol>
            </nav>
        </div>
            <div class="d-flex flex-wrap">
                <div class="btn-list d-inline-flex">
                    <button v-if="showAddButton" type="button"
                            class="btn btn-primary mb-4" :title="$t('add')"
                            @click="openCreate()">
                        <i class="fas fa-plus"></i> {{ $t('add') }}
                    </button>
                    <template>
                        <button type="button" class="btn btn-info me-1" :title="$t('excel')" @click="openPrint('excel')"
                                v-if="showExcel">
                            <i class="fas fa-file-excel"></i>
                        </button>
                        <button type="button" class="btn btn-danger me-1" :title="$t('pdf')" @click="openPrint('pdf')"
                                v-if="showPdf">
                            <i class="fas fa-print"></i>
                        </button>
                        <button type="button" class="btn btn-success me-1" :title="$t('pdf')" @click="openPrint('export')"
                                v-if="showExport">
                            <i class="fas fa-file-pdf"></i>
                        </button>
                    </template>
                    <slot name="buttons" />
                </div>
            </div>

    </div>
</template>

<script>
export default {
    name: "PageHeader",
    props:{
        title:{
            type:String,
            default:''
        },
        active:{
            type:Boolean,
            default:true
        },
        showAddButton:{
            type:Boolean,
            default:false
        },
        showExcel:{
            type:Boolean,
            default:false
        },
        showPdf:{
            type:Boolean,
            default:false
        },
        showExport:{
            type:Boolean,
            default:false
        },
    },
    methods:{
        openCreate() {
            this.$emit('openCreate');
        },
        openPrint(type) {
            this.$emit('openPrint', type);
        },
        openPdf() {
            this.$emit('openPdf');
        },
        openExcel() {
            this.$emit('openExcel');
        },
    }
}
</script>

<style scoped>

</style>
