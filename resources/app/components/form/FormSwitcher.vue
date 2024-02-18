<template>
    <label>{{$t(title)}}</label>
    <div class="form-check form-switch m-2">
        <input class="form-check-input form-check-md" type="checkbox" @input="clearError" id="flexSwitchCheckDefault" v-model="model[name]">
        <label class="form-check-label" for="flexSwitchCheckDefault">
            {{ $t(label) }}
        </label>
    </div>
    <form-validation-errors :errors="errors" :name="name"/>
</template>

<script>
export default {
    name: "FormSwitcher",
    emits:['clearErrors'],
    props:{
        title:{
            type:String,
            default:''
        },
        label:{
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

<style scoped>

</style>
