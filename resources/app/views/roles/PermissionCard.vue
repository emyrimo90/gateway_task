<script>
export default {
    name: 'permission-card',
    props: {
        modelValue: {
            type: [Object],
            required: true,
        },
        permissions: {
            type: Array,
            default: []
        },
        groupTitle: {
            type: String,
            default: null
        },
        selectedPermissions: {
            type: Array,
            default: []
        },
    },

    data() {
    },

    computed: {
        allSelected() {
            return this.modelValue[this.groupTitle].length === this.permissions.length;
        }
    },

    created() {
        if (!this.modelValue[this.groupTitle]) this.modelValue[this.groupTitle] = [];
    },

    methods: {
        selectAll(ev) {
            if (ev.target.checked) {
                return this.permissions.forEach(perm => this.modelValue[this.groupTitle].push(perm.id))
            }
            this.modelValue[this.groupTitle] = [];
        }
    },
}

</script>

<template>
    <div class="card custom-card">
            <div class="card-header custom-card-header">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                           :id="`${groupTitle}-checkbox`" :checked="allSelected" @click="selectAll($event)">
                    <label class="form-check-label" for="flexCheckChecked" :for="`${groupTitle}-checkbox`">
                        {{ $t(`${groupTitle}`) }}
                    </label>
                </div>
            </div>
            <div class="card-body">
                <div class="form-check" v-for="(permission,index) in permissions" :key="index">
                    <input class="form-check-input" type="checkbox" v-model="modelValue[groupTitle]"
                           :id="`checkbox-${permission.id}`" :value="permission.id"
                    >
                    <label class="form-check-label" :for="`checkbox-${permission.id}`">
                        {{ $t(`${permission.name}`) }}
                    </label>
                </div>
            </div>
        </div>
</template>
