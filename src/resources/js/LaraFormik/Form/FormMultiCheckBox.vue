<template>
    <div>
        <InputLabel class="w-full " v-if="label" :value="label"/>
        <div class="flex gap-4 flex-wrap mt-1">
            <div v-for="(option,index) in options" :key="index" class="flex items-center gap-2">
                <input
                    type="checkbox"
                    :id="`id_${option}_${idKey}_${index}`"
                    :value="option"
                    v-model="model"
                    class="rounded border-dark-light text-primary shadow-sm focus:ring-primary cursor-pointer"
                />
                <InputLabel class="cursor-pointer" :for="`id_${option}_${idKey}_${index}`" v-if="option"
                            :value="option"></InputLabel>
            </div>
        </div>
        <InputError :message="error"/>
    </div>
</template>
<script setup>
import InputLabel from "@/LaraFormik/Form/InputLabel.vue";
import InputError from "@/LaraFormik/Form/InputError.vue";

const model = defineModel({
    type: [Object],
    required: false,
    default: []
});

const props = defineProps({
    options: {
        type: Object,
        default: []
    },
    label: String,
    error: String,
    idKey: String,
});

</script>
