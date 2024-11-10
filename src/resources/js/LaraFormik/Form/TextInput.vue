<template>
    <div class="flex !p-0 border-none relative items-center">
        <!-- Prefix Slot for dynamic icons or content before input -->
        <div v-if="$slots.prefix" class="absolute left-0-0 p-0.5 h-full  overflow-hidden cursor-pointer">
            <div :class="prefixBg && 'bg-gray-100'" class="h-full flex items-center px-2 rounded-l-md ">
                <slot name="prefix"></slot>
            </div>
        </div>
        <input
            v-bind="$attrs"
            :type="isShow?'text':type"
            class="border-dark-light focus:border-primary focus:ring-primary rounded-md shadow-sm w-full"
            v-model="model"
            :class="{'pl-12': $slots.prefix,'!pr-12': ($slots.suffix||type==='password')}"
            ref="input"
        />
        <div v-if="$slots.suffix||type==='password'" @click="handleShowPassword"
             class="absolute right-0 p-0.5 h-full  overflow-hidden cursor-pointer">
            <div :class="suffixBg && 'bg-gray-100'" class=" h-full flex items-center px-2 rounded-r-md ">
                <slot name="suffix">
                    <EyeIcon v-if="isShow && type==='password'"
                             class="size-6 text-blue-500 "/>
                    <EyeSlashIcon v-else-if="type==='password'" class="size-6 text-blue-500"/>
                </slot>
            </div>
        </div>
    </div>

</template>
<script setup>
import {onMounted, ref} from 'vue';
import {EyeIcon, EyeSlashIcon} from "@heroicons/vue/24/outline/index.js";

const isShow = ref(false)
const props = defineProps({
    suffixBg: Boolean,
    prefixBg: Boolean,
    showPassword: Boolean,
    type: {
        type: String,
        default: 'text' // Default to text if no type is provided
    }
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
</script>
