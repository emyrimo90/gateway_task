<template>
    <div class="modal fade" :id="target" tabindex="-1" role="dialog" aria-labelledby="modal-label"
         data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog" :class="sizeClass" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex">
                    <h5 class="modal-title flex-grow-1" id="modal-label">{{headTitle.modalTitle}}</h5>
                    <button type="button" class="btn-close" @click="close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div v-if="hasBody" class="modal-body">
                    <slot name="body"></slot>
                </div>
                <div v-if="hasFooter" class="modal-footer">
                    <slot name="footer">
                        <button type="button" class="btn btn-primary" @click="confirm" :disabled="submitStatus">
                            {{$t('confirm')}}
                        </button>

                        <button type="button" class="btn btn-secondary" @click="redirect" v-if="redirect">
                            {{$t(redirectText)}}
                        </button>

                        <button type="button" class="btn btn-danger" @click="close" v-if="!redirect">
                            {{$t(cancelText)}}
                        </button>

                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {onMounted, onUpdated, reactive, ref} from 'vue';
import i18n from "@/lang";
const {t} = i18n.global;

    export default {
        props: {
            title: {
                type: String
            },
            target: {
                type: String,
                required: true
            },
            size: {
                validator: function (value) {
                    return ['xl', 'lg', 'sm', 'md'].indexOf(value) !== -1
                }
            },
            redirect:{
                type:Boolean,
                default:false
            },
            cancelText:{
                type:String,
                default:'cancel'
            },
            redirectText:{
                type:String,
                default:'redirect'
            },
        },

        setup(props, { slots, emit }) {
            const submitStatus = ref(false);
            const headTitle = reactive({
                modalTitle:'',
            });
            // methods
            const hasSlot = name => !!slots[name];

            const open = (title = null)=> {
                submitStatus.value = false;
                $(document).find(`#${props.target}`).modal({backdrop: 'static', keyboard: false});
                if (title) {
                    headTitle.modalTitle = t(''+title);
                }
                $(document).find(`#${props.target}`).modal("show");
            };

            const close = () => {
                $(document).find(`#${props.target}`).modal("hide");
                emit("close");
            };

            const redirect = () => {
                $(document).find(`#${props.target}`).modal("hide");
                emit("redirect");
            };

            const confirm = (payload) =>{
                submitStatus.value = true;
                emit("confirm", payload);
            }

            return {
                headTitle,
                submitStatus,
                hasSlot,
                open,
                close,
                redirect,
                confirm,
            }
        },

        computed: {
            sizeClass() {
                return this.size ? `modal-${this.size}` : '';
            },

            hasFooter() {
              return this.hasSlot("footer");
            },

            hasBody() {
                return this.hasSlot("body");
            }
        },
    };
</script>

<style>
    .h-scroll {
        overflow-x: auto;
    }
</style>
