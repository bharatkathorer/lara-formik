<template>
    <div class="grid gap-1">
        <InputLabel v-if="label" :value="label" :required="required"></InputLabel>
        <textarea v-if="textarea"
                  class="border-dark-light focus:border-primary focus:ring-primary rounded-md shadow-sm w-full"
                  v-model="model"
                  v-bind="$attrs"/>
        <TextInput v-else
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

defineProps({
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
    }
})
const model = defineModel({
    type: String,
    required: true,
});
</script>
