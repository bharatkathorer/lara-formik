<template>
    <div class="grid gap-1">
        <InputLabel class="capitalize" :value="label" v-if="label" :required="required"/>
        <div class="flex flex-wrap gap-4 capitalize">
            <div class="flex items-center gap-2 cursor-pointer" v-for="(item,index) in options">

                <input :name="name" :id="`id_${index}_${(typeOfObject?item?.[returnKey]:item)}_${idKey}`"
                       class="shadow-sm  cursor-pointer"
                       :class="[colors.active]"
                       type="radio"
                       :disabled="disabled"
                       v-bind="$attrs"
                       :checked="model === (typeOfObject?item?.[returnKey]:item)"
                       v-model="model"
                       :value="typeOfObject?item?.[returnKey]:item"
                       :required="required"/>
                <InputLabel :class="disabled?'cursor-not-allowed':'cursor-pointer'"
                            :for="`id_${index}_${(typeOfObject?item?.[returnKey]:item)}_${idKey}`"
                            :value="typeOfObject?item?.[labelKey]:item"/>
            </div>
        </div>

        <InputError :message="error"/>
    </div>
</template>

<script setup>
import {computed} from "vue";
import InputLabel from "@/LaraFormik/Form/InputLabel.vue";
import InputError from "@/LaraFormik/Form/InputError.vue";

const model = defineModel({
    type: [String, null],
    required: true,
});

const props = defineProps({
    label: String,
    idKey: String,
    required: Boolean,
    modelValue: [String, Number, Boolean],
    type: {
        type: String,
        default: 'text'
    },
    name: {
        type: String,
        default: 'text'
    },
    labelKey: {
        type: String,
        default: 'label'
    },
    returnKey: {
        type: String,
        default: 'value'
    },
    disabled: {
        type: Boolean,
        default: false
    },
    error: String,
    options: {
        type: Object,
        default: []
    },
    mode: {
        type: String,
        default: 'dark'
    }
})

const typeOfObject = computed(() => {
    if (props.options.length) {
        return (typeof props.options[0] == 'object');
    }
    return false;
})

// defineEmits(['update:modelValue']);

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
