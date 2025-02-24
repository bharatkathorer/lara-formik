<script setup>
import {computed} from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        required: false,
    },
    value: {
        type: [String, Number],
        default: null,
    },
    mode: {
        type: String,
        default: 'dark'
    }
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);
    },
});

const model = defineModel({
    type: [String, Number, Object, Array],
    required: false,
});
const colors = computed(() => {
    switch (props.mode) {
        case "primary":
            return {
                active: 'border-primary-light text-primary focus:ring-primary',
            }
        case "secondary":
            return {
                active: 'border-secondary-light text-secondary focus:ring-secondary',
            }
        case "success":
            return {
                active: 'border-success-light text-success focus:ring-success',
            }
        case "warning":
            return {
                active: 'border-warning-light text-warning focus:ring-warning',
            }
        case "danger":
            return {
                active: 'border-danger-light text-danger focus:ring-danger',
            }
        case "info":
            return {
                active: 'border-info-light text-info focus:ring-info',
            }
        case "light":
            return {
                active: 'border-light-light text-light focus:ring-light',
            }
        case "dark":
            return {
                active: 'border-dark-light text-dark focus:ring-dark',
            }
    }
    return {
        active: 'border-dark-light text-primary focus:ring-primary',
    }
})
</script>

<template>
    <input
        :checked="proxyChecked"
        class="rounded  shadow-sm" :class="colors.active"
        type="checkbox" v-model="model" :value="value"/>
    <!--    <input-->
    <!--        type="checkbox"-->
    <!--        :value="value"-->
    <!--        v-model="proxyChecked"-->
    <!--        class="rounded  shadow-sm" :class="colors.active"-->
    <!--    />-->
</template>
