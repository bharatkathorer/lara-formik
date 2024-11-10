<template>
    <label class="block font-medium text-sm text-dark-dark capitalize">
        <span v-if="value">{{ value }} </span> <span v-if="required" class="text-danger">*</span>
        <span v-else><slot/></span>
    </label>
</template>
<script setup>
defineProps({
    value: {
        type: String,
    },
    required: Boolean
});
</script>
