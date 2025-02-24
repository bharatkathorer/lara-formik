<template>
    <div class="grid gap-1">
        <InputLabel v-if="label" :value="label" :required="required"></InputLabel>
        <textarea v-if="textarea"
                  :class="[colors.active]"
                  class="rounded-md shadow-sm w-full"
                  v-model="model"
                  v-bind="$attrs"/>
        <TextInput :mode="mode" v-else
                   :type="type"
                   :required="required"
                   v-model="model"
                   v-bind="$attrs"
                   :showPassword="showPassword"
                   :suffixBg="suffixBg"
                   :prefixBg="prefixBg"
        >
            <template v-if="$slots.prefix" #prefix>
                <slot name="prefix"></slot>
            </template>
            <template v-if="$slots.suffix" #suffix>
                <slot name="suffix"></slot>
            </template>
        </TextInput>
        <InputError :message="error"/>
    </div>
</template>
<script setup>
import InputLabel from "@/LaraFormik/Form/InputLabel.vue";
import InputError from "@/LaraFormik/Form/InputError.vue";
import TextInput from "@/LaraFormik/Form/TextInput.vue";
import {computed} from "vue";

const {mode} = defineProps({
    textarea: Boolean,
    suffixBg: Boolean,
    prefixBg: Boolean,
    label: {
        type: String,
    },
    required: Boolean,
    showPassword: Boolean,
    error: {
        type: String,
    },
    type: {
        type: String,
        default: 'text' // Default to text if no type is provided
    },
    mode: {
        type: String,
        default: 'primary'
    },
})
const model = defineModel({
    type: String,
    required: true,
});


const colors = computed(() => {
    switch (mode) {
        case "primary":
            return {
                text: 'text-primary/90 hover:text-primary-active',
                active: 'hover:text-primary-active text-primary border-primary-light focus:border-primary focus:ring-primary',
            }
        case "secondary":
            return {
                text: 'text-secondary/90 hover:text-secondary-active',
                active: 'hover:text-secondary-active text-secondary border-secondary-light focus:border-secondary focus:ring-secondary',
            }
        case "success":
            return {
                text: 'text-success/90 hover:text-success-active',
                active: 'hover:text-success-active text-success border-success-light focus:border-success focus:ring-success',
            }
        case "warning":
            return {
                text: 'text-warning/90 hover:text-warning-active',
                active: 'hover:text-warning-active text-warning border-warning-light focus:border-warning focus:ring-warning',
            }
        case "danger":
            return {
                text: 'text-danger/90 hover:text-danger-active',
                active: 'hover:text-danger-active text-danger border-danger-light focus:border-danger focus:ring-danger',
            }
        case "info":
            return {
                text: 'text-info/90 hover:text-info-active',
                active: 'hover:text-info-active text-info border-info-light focus:border-info focus:ring-info',
            }
        case "light":
            return {
                text: 'text-light/90 hover:text-light-active',
                active: 'hover:text-light-active text-light border-light-light focus:border-light focus:ring-light',
            }
        case "dark":
            return {
                text: 'text-dark/90 hover:text-dark-active',
                active: 'hover:text-dark-active text-dark border-dark-light focus:border-dark focus:ring-dark',
            }
    }
    return {
        text: 'text-primary/90 hover:text-primary-active',
        active: 'hover:text-primary-active text-primary border-primary-light focus:border-primary focus:ring-primary',
    }
})
</script>
