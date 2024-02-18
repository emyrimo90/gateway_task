<script>
    export default {
        name: 'spinner',
        props: {
            style: {
                type: [String],
                default: "success"
            }
        }
    }

</script>

<template>
    <div class="d-flex justify-content-center">
        <div :class="`spinner-border text-${style}`" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</template>
