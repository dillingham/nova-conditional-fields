<template>
    <div>
        <h1>Hello</h1>
        <div v-for="condition in field.conditions" :key="condition.value">
            <div v-if="condition.value == value">
                <component
                    v-bind="$props"
                    :key="subfield"
                    :field="subfield"
                    :is="'detail-' + subfield.component"
                    v-for="subfield in condition.fields"
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
            value: null
        }
    },
    mounted() {
        alert()
        this.$parent.$children.forEach(component => {
            if(component.field !== undefined && component.field.attribute == this.field.attribute) {
                this.value = component.value;
            }
        });
    }
}
</script>
