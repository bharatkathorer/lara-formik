<template>
    <div class="grid gap-1">
        <InputLabel :for="`id_${name}_${idKey}`" v-if="label" :value="label" :required="required"></InputLabel>
        <div class="flex items-center gap-2">
            <Checkbox :mode="mode"
                      v-bind="$attrs"
                      :id="`id_${name}_${idKey}`"
                      v-model="model"

            />
            <!--            <input-->
            <!--                :id="`id_${name}_${idKey}`"-->
            <!--                v-bind="$attrs"-->
            <!--                type="checkbox"-->
            <!--                :checked="model"-->
            <!--                :value="value"-->
            <!--                v-model="model"-->
            <!--                :class="[colors.active]"-->
            <!--                class="rounded shadow-sm  cursor-pointer"-->
            <!--            />-->
            <InputLabel class="cursor-pointer" :for="`id_${name}_${idKey}`" v-if="name" :value="name"></InputLabel>
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
    type: [String, Boolean],
    required: false,
});
const props = defineProps({
    label: {
        type: String,
    },
    required: Boolean,
    error: String,
    name: {
        type: String,
        default: null,
    },
    value: {
        default: null,
    },
    idKey: String,
    mode: {
        type: String,
        default: 'dark'
    }

});


// const colors = computed(() => {
//     switch (props.mode) {
//         case "primary":
//             return {
//                 active: 'border-primary-light text-primary focus:ring-primary',
//             }
//         case "secondary":
//             return {
//                 active: 'border-secondary-light text-secondary focus:ring-secondary',
//             }
//         case "success":
//             return {
//                 active: 'border-success-light text-success focus:ring-success',
//             }
//         case "warning":
//             return {
//                 active: 'border-warning-light text-warning focus:ring-warning',
//             }
//         case "danger":
//             return {
//                 active: 'border-danger-light text-danger focus:ring-danger',
//             }
//         case "info":
//             return {
//                 active: 'border-info-light text-info focus:ring-info',
//             }
//         case "light":
//             return {
//                 active: 'border-light-light text-light focus:ring-light',
//             }
//         case "dark":
//             return {
//                 active: 'border-dark-light text-dark focus:ring-dark',
//             }
//     }
//     return {
//         active: 'border-dark-light text-primary focus:ring-primary',
//     }
// })

</script>
