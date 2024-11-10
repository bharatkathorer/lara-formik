<template>
    <div class="flex !p-0 border-none relative items-center">
        <!-- Prefix Slot for dynamic icons or content before input -->
        <div v-if="$slots.prefix" class="absolute left-0-0 p-0.5 h-full  overflow-hidden cursor-pointer">
            <div :class="[prefixBg && colors.text]" class="h-full flex items-center px-2 rounded-l-md ">
                <slot name="prefix"></slot>
            </div>
        </div>
        <input
            v-bind="$attrs"
            :type="isShow?'text':type"
            class="rounded-md shadow-sm w-full"
            v-model="model"
            :class="[{'pl-12': $slots.prefix,'!pr-12': ($slots.suffix||type==='password')},colors.active]"
            ref="input"
        />
        <div v-if="$slots.suffix||type==='password'" @click="handleShowPassword"
             class="absolute right-0 p-0.5 h-full  overflow-hidden cursor-pointer">
            <div :class="[suffixBg && colors.text]" class=" h-full flex items-center px-2 rounded-r-md ">
                <slot name="suffix">
                    <EyeIcon v-if="isShow && type==='password'"
                             class="size-6 "/>
                    <EyeSlashIcon v-else-if="type==='password'" class="size-6"/>
                </slot>
            </div>
        </div>
    </div>

</template>
<script setup>
import {computed, onMounted, ref} from 'vue';
import {EyeIcon, EyeSlashIcon} from "@heroicons/vue/24/outline/index.js";

const isShow = ref(false)
const props = defineProps({
    suffixBg: Boolean,
    prefixBg: Boolean,
    showPassword: Boolean,
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
    type: [String, Number],
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

const handleShowPassword = () => {
    isShow.value = !isShow.value;
}
defineExpose({focus: () => input.value.focus()});


const colors = computed(() => {
    switch (props.mode) {
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
