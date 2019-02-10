<template>
    <div>
        <h1>Hello</h1>
        <div v-for="condition in field.conditions" :key="condition.value">

            <div v-show="condition.value == value">
                <component
                    :key="index"
                    v-for="(field, index) in panel.fields"
                    :is="resolveComponentName(field)"
                    :resource-name="resourceName"
                    :resource-id="resourceId"
                    :resource="resource"
                    :field="field"
                    @actionExecuted="actionExecuted"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { BehavesAsPanel } from 'laravel-nova'

export default {
    mixins: [BehavesAsPanel],
    data() {
        return {
            value: null,
            components: []
        }
    },
    mounted() {
        alert()
        console.log(this.panel.fields);
        // this.$parent.$children.forEach(component => {
        //     if(component.field !== undefined && component.field.attribute == this.field.attribute) {
        //         component.$watch('value', (value) => {
        //             this.value = value
        //         }, { immediate: true });
        //     }
        // });
    },
    methods: {
        resolveComponentName(field) {
            return field.prefixComponent ? 'detail-' + field.component : field.component
        },
        // fill(formData) {
        //     this.$children.forEach(component => {
        //         component.fill(formData);
        //     })
        // }
    }
}
</script>
