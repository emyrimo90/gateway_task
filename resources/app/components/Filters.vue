<script>
    export default {
        name: 'filters',
        emits: ['submit'],
        props: {
            model: {
                type: [Array, Object]
            },
            enableKeyword: {
                type: Boolean,
                default: true,
            },
            enableSubmit: {
                type: Boolean,
                default: true,
            },
            keyword:{
                type:String,
                default:'global.search'
            }
        },
        methods: {
            submit() {
                this.$emit('submit');
            },
            hitSearch() {
                this.$refs.filterSubmitBtn.click();
            },
        },
    }

</script>

<template>
    <form class="white-form"  @keydown.enter.prevent="submit">
        <div class="row mt-3 mb-3">
            <div class="col-sm-3 col-md-3" v-if="enableKeyword">
                <div class="mb-3">
                    <input type="text" v-model="model['keyword']" class="form-control"
                           id="inputBox" :placeholder="$t(keyword)">
                </div>
            </div>
            <slot></slot>
            <div class="col col-md-1">
                <button class="btn btn-success" type="button" ref="filterSubmitBtn"
                        @click.prevent="submit" :disabled="!this.enableSubmit">
                    {{ $t('global.search') }}
                </button>
            </div>
        </div>
    </form>
</template>
