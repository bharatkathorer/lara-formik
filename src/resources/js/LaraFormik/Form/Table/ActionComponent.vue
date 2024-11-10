<template>
    <ModalComponent
        title="Delete"
        :body="deleteMessage||'Are you sure you want to delete this item!'"
        v-model="form.isOpen"
        @submit="confirmDelete"
        submit-type="danger"
        submit-label="Delete"
    />
    <div class="flex  gap-2 items-center">
        <slot name="prefix"/>
        <Link v-if="viewHref" :href="viewHref">
            <EyeIcon class="cursor-pointer size-5"/>
        </Link>
        <Link v-if="editHref" :href="editHref">
            <PencilSquareIcon class="cursor-pointer size-5"/>
        </Link>
        <TrashIcon @click="form.isOpen=true" v-if="deleteHref" class="cursor-pointer size-5 text-danger"/>

        <DropdownComponent v-if="options.length" :options="options"
                           @submit="emit('dropdownClick',$event)"/>
        <slot name="suffix"/>
    </div>


</template>
<script setup>
import {Link, useForm} from "@inertiajs/vue3";
import {PencilSquareIcon, EyeIcon, TrashIcon} from "@heroicons/vue/24/outline/index.js";
import ModalComponent from "@/LaraFormik/Form/ModalComponent.vue";
import DropdownComponent from "@/LaraFormik/Form/Table/DropdownComponent.vue";

const emit = defineEmits(['deleteResponse', 'dropdownClick']);
const props = defineProps({
    deleteMethode: {
        mimeTypes: String,
        default: 'delete',
    },
    deleteHref: String,
    deleteMessage: String,
    options: Array,
    editHref: String,
    viewHref: String,
})

const form = useForm({
    isOpen: false,
});

function confirmDelete() {
    form[props.deleteMethode](props.deleteHref, {
        preserveScroll: true,
        onSuccess: (resp) => {
            form.isOpen = false;
            emit('deleteResponse', resp.props);
        }
    });
}


</script>
