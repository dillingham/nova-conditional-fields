<template>
    <div>
        <div v-for="condition in field.conditions" :key="condition.value">
            <div v-if="condition.value == value">
                <component
                    v-bind="$props"
                    :key="subfield"
                    :field="subfield"
                    :is="'form-' + subfield.component"
                    v-for="subfield in condition.fields"
                />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['resourceName', 'resourceId', 'field'],
    data() {
        return {
            value: null
        }
    },
    mounted() {
        this.$parent.$children.forEach(component => {
            if(component.field !== undefined && component.field.attribute == this.field.attribute) {
                component.$watch('value', (value) => {
                    this.value = value
                }, {deep: true, immediate: true});
            }
        });
    }
}
</script>
