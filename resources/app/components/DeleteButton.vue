<template>
    <button @click="delRow(row, index)" id="bDel" type="button"
            :class="`btn btn-${size} btn-danger`"
            data-bs-toggle="tooltip" data-bs-placement="top" :title="$t('forms.delete')">
        <span v-if="icon" class="fa fa-trash"> </span>
        <span v-if="btnText"> Delete</span>
    </button>
</template>

<script>

export default {
    name: "delete-button",
    props:{
        'icon' : {
            type: Boolean,
            default: true
        },
        'btnText' : {
            type: Boolean,
            default: false
        },
        'size' : {
            type: String,
            default: 'sm'
        },
    },
    methods:{
        delRow(row, index) {
            this.$swal.fire({
                customClass: {
                    confirmButton: 'btn btn-success m-2',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$emit('del-model')
                }
            })
        }
    }
}
</script>
