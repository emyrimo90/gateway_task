<template>
    <div class="mb-3">
        <label class="form-label">{{$t(label)}}</label>
        <div>
<!--            <el-time-picker :model="model" :name="name" :placeholder="$t(label)" @change="clearError"/>-->
            <el-time-select
                :start="start"
                :end="end"
                :placeholder="$t(label)"
                value-format="HH:mm"
                v-model="model[name]"
                @keydown.stop="clearError"
                @change="clearError">
            </el-time-select>
        </div>
        <form-validation-errors :errors="errors" :name="name"/>
    </div>
</template>
<script>
export default {
    name: 'FormTimeSelect',
    emits:['clearErrors'],
    props: {
        label:{
            type:String,
            default:''
        },
        type:{
            type:String,
            default:''
        },
        model: {
            type: [Array, Object],
        },
        name:{
            type:String,
            default:''
        },
        start:{
            type:String,
            default:'00:00'
        },
        end:{
            type:String,
            default:'23:45'
        },
        errors:{
            type: [Array, Object],
            default:[]
        }
    },
    methods: {
        clearError(){
            this.$emit('clearErrors', this.name)
        },
    },
}

</script>
