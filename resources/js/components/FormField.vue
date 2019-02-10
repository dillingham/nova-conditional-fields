<template>
    <div>
        <div v-for="condition in field.conditions" :key="condition.value">
            <div v-show="condition.value == value">
                <component
                    :field="subfield"
                    :resource-id="resourceId"
                    :resource-name="resourceName"
                    :is="'form-' + subfield.component"
                    :key="'form-' + subfield.attribute"
                    v-for="subfield in condition.fields"
                    :ref="'field-' + subfield.attribute"
                />
            </div>
        </div>
    </div>
</template>

<script>

import {Errors, FormField, HandlesValidationErrors} from 'laravel-nova';

export default {
    mixins: [ FormField, HandlesValidationErrors ],
    props: ['resourceName', 'resourceId', 'field'],
    data() {
        return {
            value: null,
            components: []
        }
    },
    mounted() {
        this.$parent.$children.forEach(component => {
            if(component.field !== undefined && component.field.attribute == this.field.attribute) {
                component.$watch('value', (value) => {
                    this.value = value
                }, { immediate: true });
            }
        });
    },
    methods: {
        fill(formData) {
            this.$children.forEach(component => {
                component.fill(formData);
            })
        }
    }
}
</script>
