<template>
<span class="text-danger" v-if="errors[name]" v-for="error in errors[name]">
        <li class="list-unstyled">
            <strong>{{ error }}</strong><br>
        </li>
    </span>
</template>

<script>
export default {
    name: "FormValidationErrors",
    props:{
        errors:{
            type: [Array, Object],
            default:[]
        },
        name:{
            type:String,
            default:''
        }
    }
}
</script>

<style scoped>

</style>
