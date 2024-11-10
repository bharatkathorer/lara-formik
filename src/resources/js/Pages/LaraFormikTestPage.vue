<template>
    <Layout1>
        <SideBarComponent v-model="form.switch" backdrop-class="bg-light-disable">
        </SideBarComponent>

        <div class="mb-10">
            <FormAction title="Add Users" class="grid grid-cols-2 gap-6"
                        :loading="form.check"
                        :disabled="form.check"
                        @submit="()=>{
                        form.check=true;
                        console.log('sample')}">

                <FormInput v-model="form.name" label="Full name"/>
                <FormInput v-model="form.password" label="Password" type="password"/>
                <FormMultiselect
                    label="Select name"
                    :options="options"
                    label-key="label"
                    mode="multiple"
                    v-model="form.select"
                />
                <FormRadioGroup :options="genderOptions" label="Gender" v-model="form.gender"/>
                <FormSwitch class="col-span-2" name="Open Sidebar" required size="md" v-model="form.switch"/>
                <FormSwitch class="col-span-2" name="Open Modal" required size="md" v-model="form.modal"/>
                <FormCheckbox v-model="form.check" name="Toggle submitting form "/>
            </FormAction>
        </div>
        <div>
            <TableComponent label="Users"
                            :action="{
                        label:'Add USer',
                        href:'/login'
                        }"
                            searchLink="/"
                            :options="users"
                            :fields="fields"

            >
                <template #action="{item}">
                    <ActionComponent
                        edit-href="/"
                        delete-href="/"
                        view-href="/"
                        :options="options"
                        @dropdown-click="handleDropdown"
                    />
                </template>
            </TableComponent>
        </div>
        <div class=" mt-4 ">
            <TabComponent :options="tabs"></TabComponent>
            <!--        <RichTextArea/>-->
        </div>
        <ModalComponent
            title="sample"
            body="Are you sure delete this item"
            v-model="form.modal"
            @submit="form.modal=false"
        >
            <FormInput v-model="form.name" label="Full name"/>
        </ModalComponent>
    </Layout1>
</template>
<script setup>
import {useForm, usePage} from "@inertiajs/vue3";
import {computed} from "vue";
import ModalComponent from "@/LaraFormik/Form/ModalComponent.vue";
import TableComponent from "@/LaraFormik/Form/Table/TableComponent.vue";
import ActionComponent from "@/LaraFormik/Form/Table/ActionComponent.vue";
import FormInput from "@/LaraFormik/Form/FormInput.vue";
import FormRadioGroup from "@/LaraFormik/Form/FormRadioGroup.vue";
import FormCheckbox from "@/LaraFormik/Form/FormCheckbox.vue";
import FormMultiselect from "@/LaraFormik/Form/FormMultiselect.vue";
import FormSwitch from "@/LaraFormik/Form/FormSwitch.vue";
import SideBarComponent from "@/LaraFormik/Other/SideBarComponent.vue";
import TabComponent from "@/LaraFormik/Other/TabComponent.vue";
import FormAction from "@/LaraFormik/Form/FormAction.vue";
import Layout1 from "@/LaraFormik/Layouts/LayoutComponent.vue";

const users = computed(() => usePage().props.users);
const form = useForm({
    name: '',
    gender: 'Female',
    password: '',
    check: false,
    switch: false,
    modal: false,
    select: [1, 2, 3],
    tab: '',
});
const fields = [
    {key: 'name', label: 'name', sortKey: "name"},
    {key: 'email', label: 'email'},
    {key: 'action', label: 'action'}
];
const tabs = [
    {key: 'customer', label: 'Customer',},
    {key: 'admin', label: 'Admin',},
    {key: 'new', label: 'Latest',},
    {key: 'st', label: 'bharat',},
    {key: 'dk', label: 'Kathore',},
    {key: 'user', label: 'User', href: '/'},
];

const genderOptions = [
    {id: 1, label: 'Male', value: 'male'},
    {id: 1, label: 'Female', value: 'f_male'},
]
const options = [
    {id: 1, label: 'Customer', isReturn: true},
    {id: 2, label: 'Admin', target: '_blank', href: "/#"},
    {id: 3, label: 'User', href: "/#", method: 'post'},
]
const handleDropdown = (item) => {
    console.log(item)
}
const submitForm = () => {
    form.post(route('actions'));
}
</script>
