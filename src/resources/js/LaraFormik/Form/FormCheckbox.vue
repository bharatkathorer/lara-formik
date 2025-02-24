<template>
    <div class="grid gap-1">
        <InputLabel  :for="`id_${name}_${idKey}`" v-if="label" :value="label" :required="required"></InputLabel>
        <div class="flex items-center gap-2">
            <input
                :id="`id_${name}_${idKey}`"
                v-bind="$attrs"
                type="checkbox"
                :checked="model"
                :value="value"
                v-model="model"
                class="rounded border-dark-light text-primary shadow-sm focus:ring-primary cursor-pointer"
            />
            <InputLabel class="cursor-pointer" :for="`id_${name}_${idKey}`" v-if="name" :value="name"></InputLabel>
        </div>
        <InputError :message="error"/>
    </div>
</template>
<script setup>
import InputLabel from "@/LaraFormik/Form/InputLabel.vue";
import InputError from "@/LaraFormik/Form/InputError.vue";

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
    idKey:String
});

</script>
