<template>
    <teleport to="body">
        <TransitionRoot appear :show="model" as="template">
            <Dialog as="div" @close="closeModal" class="relative z-10">
                <TransitionChild
                    as="template"
                    enter="duration-300 ease-out"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div class="fixed inset-0 bg-black/25"/>
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <FormAction :is-actions="false"  @submit="emit('submit')"
                        class="flex min-h-full items-center justify-center p-4 text-center"
                    >
                        <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                        >
                            <DialogPanel
                                class="w-full max-w-md transform overflow-hidden rounded-md p-4 bg-white text-left align-middle shadow-xl transition-all"
                                :class="dialogClass"
                            >
                                <slot name="body">
                                    <slot name="header">
                                        <DialogTitle
                                            v-if="title"
                                            as="h3"
                                            class="text-lg font-medium leading-6 text-gray-900 mb-2"
                                        >
                                            {{ title }}
                                        </DialogTitle>
                                    </slot>
                                    <slot>
                                        <div>
                                            <p class="text-sm text-gray-500">
                                                {{ body }}
                                            </p>
                                        </div>
                                    </slot>
                                    <slot name="footer">
                                        <div class="mt-4 flex gap-2 justify-start flex-row-reverse">

                                            <ButtonComponent :label="submitLabel||'Submit'"
                                                             type="submit"
                                                             :mode="submitType"/>
                                            <ButtonComponent @click="closeModal" :label="cancelLabel||'Cancel'"
                                                             mode="light"/>
                                        </div>
                                    </slot>
                                </slot>
                            </DialogPanel>
                        </TransitionChild>
                    </FormAction>
                </div>
            </Dialog>
        </TransitionRoot>
    </teleport>
</template>

<script setup>
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot,} from '@headlessui/vue'
import ButtonComponent from "@/LaraFormik/Form/ButtonComponent.vue";
import FormAction from "@/LaraFormik/Form/FormAction.vue";

const props = defineProps({
    dialogClass: String,
    title: String,
    body: String,
    cancelLabel: String,
    submitLabel: String,
    submitType: {
        type: String,
        default: 'primary'
    },
})
const emit = defineEmits(['submit'])
const model = defineModel({
    type: [Boolean],
    required: false,
});

function closeModal() {
    model.value = false
}
</script>

