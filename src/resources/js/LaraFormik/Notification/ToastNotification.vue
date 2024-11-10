<template>
    <teleport to="body">
        <div aria-live="assertive"
             class="fixed inset-0 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start z-[9999]">
            <div class="w-full flex flex-col items-center space-y-4 sm:items-end">

                <transition enter-active-class="transform ease-out duration-300 transition"
                            enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                            enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
                            leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100"
                            leave-to-class="opacity-0">
                    <div v-if="open"
                         class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                        <div class="p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <CheckCircleIcon v-if="message.type === 'success'" class="h-6 w-6 text-green-400"
                                                     aria-hidden="true"/>
                                    <XCircleIcon v-if="message.type === 'error'" class="h-6 w-6 text-red-600"
                                                 aria-hidden="true"/>
                                    <ExclamationTriangleIcon v-if="message.type === 'warning'"
                                                             class="h-6 w-6 text-yellow-600"
                                                             aria-hidden="true"/>
                                </div>
                                <div class="ml-3 w-0 flex-1 pt-0.5">
                                    <p class="text-sm font-medium text-gray-900">{{ message.title }}</p>
                                    <p class="mt-1 text-sm text-gray-500">{{ message.message }}</p>
                                </div>
                                <div class="ml-4 flex-shrink-0 flex">
                                    <button @click="open = false"
                                            class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <span class="sr-only">Close</span>
                                        <XMarkIcon class="h-5 w-5" aria-hidden="true"/>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </teleport>
</template>

<script setup>
import {ref, computed, watch} from 'vue'
import {CheckCircleIcon, XCircleIcon, XMarkIcon, ExclamationTriangleIcon} from '@heroicons/vue/24/outline';
import {usePage} from "@inertiajs/vue3";

const open = ref(false);
const props = computed(() => usePage().props);

// Create a reactive message object
const message = ref({
    open: false,
    message: '',
    title: '',
    type: '',
});

watch(props, (newProps) => {
    const {success = null, error = null, warning = null} = newProps;
    const _data = success ?? error ?? warning;

    // Reset message to default before each change
    message.value = {
        open: false,
        message: '',
        title: '',
        type: '',
    };

    // If no data is present, return early
    if (!_data) return;

    // Set message details
    message.value.open = true;
    if (success) {
        message.value.title = "Success!";
        message.value.type = "success";
    } else if (error) {
        message.value.title = "Error!";
        message.value.type = "error";
    } else if (warning) {
        message.value.title = "Warning!";
        message.value.type = "warning";
    }

    // Handle both object and string types for message
    if (typeof _data === 'object') {
        message.value.title = _data?.title ?? message.value.title;
        message.value.message = _data?.message ?? message.value.message;
    } else if (typeof _data === 'string') {
        message.value.message = _data;
    }

    // Automatically close the message after 5 seconds
    autoClose();
}, {immediate: true});

function autoClose() {
    open.value = true;
    setTimeout(() => {
        open.value = false;
    }, 5000);
}
</script>
