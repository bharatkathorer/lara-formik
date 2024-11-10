<template>
    <div class="relative group">
        <ckeditor  v-model="model"
                  :config="editorConfig"

        />
    </div>
</template>
<script setup>
import {component as ckeditor} from '@mayasabha/ckeditor4-vue3'

const model = defineModel({
    type: String,
    required: false,
});
const editorConfig = {
    // toolbar: [
    //     ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates'],
    //     ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'],
    //     ['Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt'],
    //     ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
    //     ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'],
    //     ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote', 'CreateDiv'],
    //     ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
    //     ['Link', 'Unlink', 'Anchor'],
    //     ['Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe'],
    //     ['Styles', 'Format', 'Font', 'FontSize'],
    //     ['TextColor', 'BGColor'],
    //     ['Maximize', 'ShowBlocks'],
    // ],
    extraPlugins: 'placeholder',
    placeholder: 'Start typing your content here...',
    // removeButtons: 'Underline,Strike,Subscript,Source',
    height: 'auto',
}
</script>
<!--npm install @mayasabha/ckeditor4-vue3-->
