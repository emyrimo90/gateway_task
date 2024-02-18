<template>
    <div class="mb-3">
        <label v-if="title" class="form-label">{{ $t(title) }} <span v-if="required" class="text-danger">*</span></label>
        <el-select :multiple="multiple"
                   v-model="model[name]" :clearable="true" :filterable="true" @change="clearError"
                   :placeholder="$t('forms.select')">
            <el-option
                v-for="item in myOptions"
                :key="item.id"
                :label="item[label]"
                :value="item.id"
            />
        </el-select>
        <span class="text-danger" v-if="errors[name]" v-for="error in errors[name]">
        <strong>{{ error }}</strong><br>
    </span>
    </div>
</template>
<script>
export default {
    name: 'FormSelect',
    emits:['clearErrors'],
    props: {
        title:{
            type:String,
            default:''
        },
        label:{
            type:String,
            default:''
        },
        name:{
            type:String,
            default:''
        },
        myOptions:{
            type:Array,
            default:''
        },
        modelValue:{
            type:[String, Number],
            default:''
        },
        model: {
            type: [Array, Object],
        },
        errors:{
            type: [Array, Object],
            default:[]
        },
        multiple:{
            type:Boolean,
            default:false
        },
        required:{
            type:Boolean,
            default:false
        }
    },
    methods:{
        clearError () {
            this.$emit('clearErrors', this.name)
        },
    }
}

</script>
<style scoped>
:deep() {
    --vs-dropdown-option--active-bg: #07a55c;
    --vs-dropdown-option--active-color: #eeeeee;
    --form-select-color: #eeeeee
}
</style>
