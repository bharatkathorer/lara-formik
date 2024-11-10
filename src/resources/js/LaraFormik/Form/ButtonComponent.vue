<template>
    <a v-if="href && target" :target="target"
       :class="`btn ${mode}`"
       v-bind="$attrs"
       :href="href">
        <LoadingSpinner v-if="loading" :class="loadingClass"/>
        <slot>{{ label }}</slot>
    </a>
    <Link v-else-if="href"
          :class="`btn ${mode}`"
          :disabled="disabled"
          v-bind="$attrs"
          :href="href">
        <LoadingSpinner v-if="loading" :class="loadingClass"/>
        <slot>{{ label }}</slot>
    </Link>
    <button v-else
            class=""
            :class="`btn ${mode}`"
            :disabled="disabled"
            v-bind="$attrs"
            :type="type"
    >
        <LoadingSpinner v-if="loading" :class="loadingClass"/>
        <slot>{{ label }}</slot>
    </button>

</template>
<script setup>
import {Link} from "@inertiajs/vue3";
import LoadingSpinner from "@/LaraFormik/Form/Table/LoadingSpinner.vue";

const props = defineProps({
    mode: {
        type: String,
        default: "primary"
    },
    type: {
        type: String,
        default: "button"
    },
    label: String,
    href: String,
    target: String,
    disabled: Boolean,
    loading: Boolean,
    loadingClass: String,
});
</script>
