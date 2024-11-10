<template>
    <teleport to="body">
        <TransitionRoot as="template" :show="model">
            <Dialog v-bind="$attrs" as="div" class="relative z-40" @close="model = !model">
                <!-- Backdrop -->
                <TransitionChild as="template"
                                 enter="transition-opacity ease-linear duration-300"
                                 enter-from="opacity-0"
                                 enter-to="opacity-100"
                                 leave="transition-opacity ease-linear duration-300"
                                 leave-from="opacity-100"
                                 leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-600 bg-opacity-75" :class="backdropClass"/>
                </TransitionChild>

                <div class="fixed inset-0 z-40 flex" :class="positionClass.sliderContainerClass">
                    <!-- Slider Panel -->
                    <TransitionChild as="template"
                                     enter="transition ease-in-out duration-300 transform"
                                     :enter-from="positionClass.enterFromClass"
                                     enter-to="translate-x-0"
                                     leave="transition ease-in-out duration-300 transform"
                                     leave-from="translate-x-0"
                                     :leave-to="positionClass.leaveToClass">
                        <DialogPanel class="relative flex w-full max-w-xs flex-1 flex-col bg-white"
                                     :class="sliderClass">
                            <!-- Close Button -->
                            <TransitionChild as="template" enter="ease-in-out duration-300"
                                             enter-from="opacity-0"
                                             enter-to="opacity-100"
                                             leave="ease-in-out duration-300"
                                             leave-from="opacity-100"
                                             leave-to="opacity-0">
                                <div class="absolute top-0 pt-2" :class="positionClass.closeButtonClass">
                                    <button type="button"
                                            class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                                            @click="model = !model">
                                        <span class="sr-only">Close sidebar</span>
                                        <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true"/>
                                    </button>
                                </div>
                            </TransitionChild>
                            <slot/>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>
    </teleport>
</template>

<script setup>
import {Dialog, DialogPanel, TransitionChild, TransitionRoot} from '@headlessui/vue'
import {XMarkIcon} from '@heroicons/vue/24/outline'
import {computed} from "vue";
// Model for controlling the dialog visibility
const model = defineModel({
    type: Boolean,
    required: true,
});
// Props for customizing the slider
const props = defineProps({
    isRight: {
        type: Boolean,
        default: false, // Slider will appear from the left by default
    },
    sliderClass: String,
    backdropClass: String,
});
const positionClass = computed(() => {
    return {
        enterFromClass: props.isRight ? 'translate-x-full' : '-translate-x-full',
        leaveToClass: props.isRight ? 'translate-x-full' : '-translate-x-full',
        sliderContainerClass: props.isRight ? 'justify-end' : 'justify-start',
        closeButtonClass: props.isRight ? 'left-0 -ml-12' : 'right-0 -mr-12'
    }
})
</script>
