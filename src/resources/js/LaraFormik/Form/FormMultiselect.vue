<template>
    <div class="grid gap-1">
        <InputLabel :value="label" :required="required"/>
        <Multiselect
            v-bind="$attrs"
            autocomplete="off"
            :class="customClass"
            :required="required"
            :placeholder="placeholder"
            :label="labelKey"
            :trackBy="trackKey??labelKey"
            v-model="model"
            :valueProp="returnValue"
            :disabled="disabled"
            :object="returnObject"
            :mode="mode"
            :searchable="searchable"
            :max="max"
            :canClear="canClear"
            :searchStart="searchStart"
            @change="emit('change',$event)"
            :options="options"
            :search="true"

        >
            <slot/>
        </Multiselect>
        <InputError :message="error"/>
    </div>
</template>

<script setup>
import Multiselect from '@vueform/multiselect';
import InputLabel from "@/LaraFormik/Form/InputLabel.vue";
import InputError from "@/LaraFormik/Form/InputError.vue";

const props = defineProps({
    label: String,
    customClass: String,
    required: Boolean,
    max: [Number],
    type: {
        type: String,
        default: 'text'
    },
    trackKey: {
        type: String,
        default: null
    },
    labelKey: {
        type: String,
        default: 'title'
    },
    returnValue: {
        type: String,
        default: 'id'
    },
    placeholder: {
        type: String,
        default: 'Select'
    },
    disabled: {
        type: Boolean,
        default: false
    },

    canClear: {
        type: Boolean,
        default: true
    },
    returnObject: {
        type: Boolean,
        default: false
    },
    searchStart: {
        type: Boolean,
        default: true
    },
    mode: {
        type: String,
        default: 'single'
    },
    searchable: {
        type: Boolean,
        default: true
    },
    error: String,
    options: {
        type: [Object, Array],
        default: []
    },


})
const model = defineModel({
    type: [String, Number, Boolean, Array, Object],
    required: true,
});
const emit = defineEmits(['change']);
</script>

<style src="../../../../node_modules/@vueform/multiselect/themes/default.css"></style>

<style>
.is-open {
    z-index: 99 !important;
}

.multiselect-placeholder {
    text-wrap: nowrap !important;
}

.multiselect-option:hover, .multiselect-option.is-pointed:hover {
    color: black !important;
}

.multiselect-tag {
    background: black !important;
}

.multiselect {
    padding-right: 50px;
}

.multiselect-caret {
    left: 53px;
}

.multiselect-clear {
    right: -56px;
}

.multiselect-search,
.multiselect-search:focus,
.multiselect-search:hover,
.multiselect-search:focus-within,
.multiselect-search:focus-visible {
    border: none !important;
    outline: none !important;
    box-shadow: none !important;
}

.multiselect-option.is-selected.is-pointed,
.multiselect-option.is-selected {
    color: white !important;
    background: #3490dc;
}

.multiselect-option:hover, .multiselect-option.is-pointed:hover {
    color: white !important;
    background: #3490dc;
}

.multiselect-single-label {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.multiselect.is-active {
    box-shadow: none;
    border: 1px solid #3490dc;
    outline: 1px solid #3490dc!important;

}

.multiselect {
    box-shadow: none;
    border: 1px solid rgb(78 77 77);
}

.multiselect-dropdown {
    border-top: 2px solid white !important;
    border: 2px solid #3490dc;
    overflow: hidden;
}

</style>
