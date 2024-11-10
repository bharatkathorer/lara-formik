<template>
    <div class="grid gap-1">
        <InputLabel @click="model=!model" v-if="label" :value="label" :required="required"></InputLabel>
        <div class="flex items-center gap-2">
            <Switch
                :disabled="disabled"
                v-model="model"
                :class="[model ? 'bg-primary-active' : 'bg-primary',styles.switch]"
                class="relative inline-flex  shrink-0 cursor-pointer rounded-full
                border-2 border-transparent transition-colors duration-200
                ease-in-out focus:outline-none focus-visible:ring-2
                focus-visible:ring-white/75 disabled:cursor-not-allowed disabled:bg-primary-disable"
            >
                <span class="sr-only">Use setting</span>
                <span
                    aria-hidden="true"
                    :class="styles.circle"
                    class="pointer-events-none inline-block transform rounded-full bg-white shadow-lg ring-0 transition duration-200 ease-in-out"
                />
            </Switch>
            <InputLabel class="cursor-pointer" @click="model=!model" v-if="name" :value="name"></InputLabel>
        </div>
        <InputError :message="error"/>
    </div>
</template>
<script setup>
import InputLabel from "@/LaraFormik/Form/InputLabel.vue";
import InputError from "@/LaraFormik/Form/InputError.vue";
import {Switch} from '@headlessui/vue'
import {computed} from "vue";

const model = defineModel({
    type: [String, Boolean],
    required: true,
});
const props = defineProps({
    label: {
        type: String,
    },
    required: Boolean,
    disabled: Boolean,
    error: String,
    name: {
        type: String,
        default: null,
    },
    value: {
        default: null,
    },
    size: {
        type: String,
        default: 'md'
    },
});

const styles = computed(() => {
    switch (props.size) {
        case 'sm':
            return {
                switch: 'h-[14px] w-[26px]',
                circle: ` h-[11px] w-[11px]  ${model.value ? 'translate-x-3' : 'translate-x-0'}`,
            };
        case 'md':
            return {
                switch: 'h-[18px] w-[30px]',
                circle: ` h-[14px] w-[14px]  ${model.value ? 'translate-x-3' : 'translate-x-0'}`,
            };
        case 'lg':
            return {
                switch: 'h-[23px] w-[40px]',
                circle: ` h-[20px] w-[20px]  ${model.value ? 'translate-x-4' : 'translate-x-0'}`,
            };
        case 'xl':
            return {
                switch: 'h-[28px] w-[51px]',
                circle: ` h-[24px] w-[24px]  ${model.value ? 'translate-x-6' : 'translate-x-0'}`,
            };
    }

})

</script>

