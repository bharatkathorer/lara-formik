<template>
    <form  v-bind="$attrs" @submit.prevent="!loading && emit('submit')" :class="loading && 'opacity-90'">
        <div class="col-span-full flex gap-2" v-if="$slots.header || title">
            <slot name="header">
                <span class="font-medium">{{title}}</span>
            </slot>
        </div>
        <slot/>
        <div class="col-span-full flex gap-2" v-if="isActions">
            <slot name="action">
                <ButtonComponent @click="handleCancel" label="Cancel" mode="light"/>
                <ButtonComponent :loading="loading"
                                 :disabled="disabled"
                                 type="submit" :label="actionLabel"/>
            </slot>
        </div>
    </form>
</template>
<script setup>
import ButtonComponent from "@/LaraFormik/Form/ButtonComponent.vue";

const emit = defineEmits(['submit', 'cancel'])
const props = defineProps({
    loading: Boolean,
    disabled: Boolean,
    title: String,
    actionLabel: {
        type: String,
        default: "Submit"
    },
    isActions: {
        type: Boolean,
        default: true
    }
});
const handleCancel = () => {
    window.history.back();
}
</script>
