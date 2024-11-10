<template>
    <div class="grid gap-1">
        <InputLabel class="capitalize" :value="label" v-if="label" :required="required"/>
        <div class="flex flex-wrap gap-4 capitalize">
            <div class="flex items-center gap-2 cursor-pointer" v-for="(item,index) in options">

                <input :name="name" :id="`id_${index}_${(typeOfObject?item?.[returnKey]:item)}_${idKey}`"
                       class="border-dark-light text-primary shadow-sm focus:ring-primary cursor-pointer"
                       type="radio"
                       :disabled="disabled"
                       v-bind="$attrs"
                       :checked="model === (typeOfObject?item?.[returnKey]:item)"
                       v-model="model"
                       :value="typeOfObject?item?.[returnKey]:item"
                       :required="required"/>
                <InputLabel :class="disabled?'cursor-not-allowed':'cursor-pointer'" :for="`id_${index}_${(typeOfObject?item?.[returnKey]:item)}_${idKey}`"
                            :value="typeOfObject?item?.[labelKey]:item"/>
            </div>
        </div>

        <InputError :message="error"/>
    </div>
</template>

<script setup>
import {computed} from "vue";
import InputLabel from "@/LaraFormik/Form/InputLabel.vue";
import InputError from "@/LaraFormik/Form/InputError.vue";

const model = defineModel({
    type: [String,null],
    required: true,
});

const props = defineProps({
    label: String,
    idKey: String,
    required: Boolean,
    modelValue: [String, Number, Boolean],
    type: {
        type: String,
        default: 'text'
    },
    name: {
        type: String,
        default: 'text'
    },
    labelKey: {
        type: String,
        default: 'label'
    },
    returnKey: {
        type: String,
        default: 'value'
    },
    disabled: {
        type: Boolean,
        default: false
    },
    error: String,
    options: {
        type: Object,
        default: []
    }
})

const typeOfObject = computed(() => {
    if (props.options.length) {
        return (typeof props.options[0] == 'object');
    }
    return false;
})

// defineEmits(['update:modelValue']);

const toLowercase = computed(() => {
    if (typeof model == 'string') {
        return model.toLowerCase();
    }
    return model
})

const handleISCheck = ()=>{

}
</script>
