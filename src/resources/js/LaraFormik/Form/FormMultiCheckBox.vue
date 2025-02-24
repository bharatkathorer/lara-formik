<template>
    <div>
        <InputLabel class="w-full " v-if="label" :value="label"/>
        <div class="flex gap-4 flex-wrap mt-1">
            <div v-for="(option,index) in options" :key="index" class="flex items-center gap-2">
                <Checkbox type="checkbox"
                    :id="`id_${option}_${idKey}_${index}`"
                    :value="option"
                    v-model="model"
                    :class="colors.active"
                    class="rounded  shadow-sm cursor-pointer" />
<!--                <input-->
<!--                    type="checkbox"-->
<!--                    :id="`id_${option}_${idKey}_${index}`"-->
<!--                    :value="option"-->
<!--                    v-model="model"-->
<!--                    :class="colors.active"-->
<!--                    class="rounded  shadow-sm cursor-pointer"-->
<!--                />-->
                <InputLabel class="cursor-pointer" :for="`id_${option}_${idKey}_${index}`" v-if="option"
                            :value="option"></InputLabel>
            </div>
        </div>
        <InputError :message="error"/>
    </div>
</template>
<script setup>
import InputLabel from "@/LaraFormik/Form/InputLabel.vue";
import InputError from "@/LaraFormik/Form/InputError.vue";
import {computed} from "vue";
import Checkbox from "@/LaraFormik/Form/Checkbox.vue";

const model = defineModel({
    type: [Object],
    required: false,
    default: [],
});

const props = defineProps({
    options: {
        type: Object,
        default: []
    },
    label: String,
    error: String,
    idKey: String,
    mode: {
        type: String,
        default: 'dark'
    }
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
