<template>
    <component
            v-if="needShow"
            :is="`form-${field.original_component}`"
            v-bind="$attrs"
            v-on="$listeners"
    ></component>
</template>

<script>
    export default {
        data() {
            return {
                value: null
            }
        },
        mounted() {
            this.field.fill = () => {}
            this.$parent.$children.forEach(component => {
                if (component.field !== undefined && component.field.attribute == this.field.condition[1]) {
                    let attribute = 'value';

                    if(component.field.component === 'belongs-to-field') {
                        attribute = 'selectedResourceId'
                    }

                    component.$watch(attribute, (value) => {
                        this.value = value
                    }, {deep: true, immediate: true})
                }
            })
        },
        watch: {
            needShow(val) {
                if (!val) {
                    this.field.fill = () => {}
                }
            }
        },
        computed: {
            needShow() {
                switch (this.field.condition[0]) {
                    case 'not':
                        return this.value != this.field.condition[2]
                    default:
                        return this.value == this.field.condition[2]
                }
            },
            field() {
                return this.$attrs.field
            }
        },
    }
</script>
