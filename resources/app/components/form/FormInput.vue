<template>
    <div class="mb-3">
        <label class="form-label">{{$t(label)}} <span v-if="required" class="text-danger">*</span></label>
        <input :class="errors[name] ? 'form-control is-invalid' : 'form-control'"
               :type="type" v-model="model[name]" :placeholder="$t('placeholder') + $t(label)"
               @keydown.stop="clearError" :readonly="disabled" autocomplete="">

        <form-validation-errors :errors="errors" :name="name"/>
    </div>
</template>
<script>
export default {
    name: 'FormInput',
    emits:['clearErrors'],
    props: {
        label:{
            type:String,
            default:''
        },
        type:{
            type:String,
            default:'text'
        },
        model: {
            type: [Array, Object],
        },
        name:{
            type:String,
            default:''
        },
        errors:{
            type: [Array, Object],
            default:[]
        },
        disabled:{
            type:Boolean,
            default:false
        },
        required:{
            type:Boolean,
            default:false
        }
    },
    methods: {
        clearError(){
            this.$emit('clearErrors', this.name)
        },
    },
}

</script>
