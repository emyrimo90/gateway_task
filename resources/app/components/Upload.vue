<script>
    import {
        ref,
        watch
    } from "vue";
    import UploadApi from '@api/upload.api'

    export default {
        name: 'upload',

        emits: ['select'],

        props: {
            label: {
                type: String,
                default: null
            },

            fileType: {
                type: String,
                required: true
            },

            multiple: {
                type: Boolean,
                default: false
            },

            required: {
                type: Boolean,
                default: false
            },
        },

        setup(props, {
            emit
        }) {
            const files = ref([{
                "label": '',
                "file": {},
                "loading": false,
            }]);

            watch(files, () => {
                emit('select', files.value);
            }, {
                deep: true
            });

            return {
                files
            }
        },

        methods: {
            addFile() {
                this.files.push({
                    "label": '',
                    "file": {},
                    "loading": false,
                });
            },

            removeFile(index) {
                this.files.splice(index, 1);
            },

            setSelectedFile(e, index) {
                const selectedFiles = e.target.files || e.dataTransfer.files;
                if (!selectedFiles.length) {
                    return;
                }

                this.files[index].file = selectedFiles[0];
                this.files[index].loading = true;

                let formData = new FormData();
                formData.append('type', this.fileType);
                formData.append('label', this.files[index].label || 'no label');
                formData.append('file', selectedFiles[0]);

                UploadApi.store(formData)
                    .then(resp => {
                        console.log(resp);
                    })
                    .finally(() => {
                        this.files[index].loading = false;
                    });
            },

            clearRow(index) {
                this.files[index] = {
                    "label": '',
                    "file": {},
                    "loading": false,
                };
            },
        },
    }

</script>

<template>
    <div class="py-2 incremental-items-blk">
        <div class="form-row align-items-center mb-2 incrementalItem">
            <span class="mx-2">{{ label ?? $t('messages.attachments') }}</span>
        </div>

        <div class="form-row align-items-end mb-3 decrementalItem" v-for="(row, index) in files" :key="index">
            <div class="form-group  mb-0 col-lg-4 col-md-4 ">
                <label :for="`label${index}`">إسم المرفق </label>
                <input type="text" class="form-control" v-model="row.label" :id="`label${index}`"
                    placeholder=" إسم المرفق ">
            </div>

            <div class="form-group mb-0 col-lg-4 col-md-4 ">
                <label :for="`file${index}`">أرفع المرفق </label>
                <input type="file" class="inputFileCustom" @change="setSelectedFile($event, index)"
                    :id="`file${index}`">

                <label :for="`file${index}`"
                    class="mb-0 inputFileCustomLabel form-control justify-content-between h_50">
                    <span class="mx-2">
                        {{ row.file.name ?? 'أرفع المرفق' }}
                    </span>
                    <span>
                        <svg class="mx-2 ico-svg" @click.prevent="clearRow(index)">
                            <i class="fas fa-times-circle" title="مسح الملف"></i>
                        </svg>
                        <svg class="ico-svg">
                            <use xlink:href="#ico-upload" />
                        </svg>
                    </span>
                </label>
            </div>

            <button type="button" class="btn btn-secondary btn-icon rounded p-0 my-0 h_50 w_50" @click="addFile"
                v-if="multiple && ! index">
                <svg class="ico-svg">
                    <use xlink:href="#ico-plus" />
                </svg>
            </button>

            <button v-else-if="index" type="button" class="btn btn-light-danger btn-icon rounded p-0 my-0 h_50 w_50"
                @click="removeFile(index)">
                <svg class="ico-svg">
                    <use xlink:href="#ico-trash" />
                </svg>
            </button>

            <a class="btn btn-primary btn-icon rounded p-0 my-0 h_50 w_50" :id="`loading${index}`" v-if="row.loading">
                <i class="fas fa-spinner fa-spin"></i>
            </a>
        </div>

    </div>
</template>
