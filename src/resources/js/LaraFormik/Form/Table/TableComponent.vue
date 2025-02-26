<template>
    <div class="shadow ring-1 ring-black ring-opacity-5 rounded-lg">
        <div class="flex p-4 flex-wrap items-center" v-if="label||_action.href||$slots.actions">
            <div class="flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">{{ actions?.label ?? label }}</h1>
            </div>
            <div class="ml-16 flex gap-2 items-center">
                <p class=" text-sm"
                   v-if="actions?.options && actions.isPaginateSelect && actionForm.selectedData.length">
                    Selected {{ actionForm.selectedData.length }}
                </p>
                <Dropdown :mode="mode" align="left" width="48" v-if="actionForm.selectedData?.length">

                    <template #trigger>
                                            <span class="inline-flex rounded-md cursor-pointer">
                                                <button type="button"
                                                        class="inline-flex items-center px-4 py-3 text-sm font-medium leading-4
                                                         text-gray-500 transition duration-150 ease-in-out  border
                                                        d hover:text-gray-700 focus:outline-none border-primary-light focus:border-primary focus:ring-primary rounded-md shadow-sm">
                                                    Actions
                                                    <ChevronDownIcon class="ml-2 -mr-0.5 h-4 w-4"/>
                                                </button>
                                            </span>
                    </template>

                    <template #content>
                        <button
                            class="block w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                            as="button" v-for="(item,index) in actions?.actionMethod??[]" :key="index"
                            @click="handleAction(item)">
                            {{ item.name }}
                        </button>
                    </template>
                </Dropdown>
                <TextInput
                    v-if="actions.columns.find((item)=>item.isSearchable)"
                    :mode="mode"
                    v-model="searchKeyword"
                    ref="searchRef"
                    placeholder="Search"
                    name="search"
                    autocomplete="off"
                    :suffixBg="false"
                    :prefixBg="false"
                    @input="handleSearch">
                    <template #prefix="{item}">
                        <MagnifyingGlassIcon :class="item.text" class="size-6"/>
                    </template>
                    <template #suffix="{item}">
                        <XMarkIcon class="size-5 text-danger/70 hover:text-danger font-bold ease-in-out duration-300"
                                   @click="handleResetSearch"/>
                    </template>
                </TextInput>
                <slot name="actions">
                    <ButtonComponent :mode="mode" v-if="_action?.href" :label="_action.label" :href="_action?.href"/>
                </slot>
                <TableFilter :mode="mode"/>
            </div>
        </div>
        <div class=" overflow-x-auto rounded-lg">
            <div>
                <div class="inline-block min-w-full">

                    <TableFilter :mode="mode" :is-status="true"/>
                    <div class="overflow-hidden">

                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" v-if="actions?.options"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 w-4">
                                    <label
                                    >
                                        <Checkbox
                                            :mode="mode"
                                            :checked="isChecked"
                                            @change="(event)=>{
                                                if(event.target.checked){
                                                    actionForm.selectedData = [...actionForm.selectedData,...data_ids.filter((i)=>!actionForm.selectedData.includes(i))]
                                                }else {
                                                    actionForm.selectedData=actionForm.selectedData.filter((i)=>!data_ids.includes(i));
                                                }
                                            }"
                                        />
                                    </label>
                                </th>
                                <th scope="col"
                                    v-for="(field, index) in _fields" :key="index"
                                    @click="handleSort(field, sortByASC ? 'asc' : 'desc')"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                    :class="field?.thClass"
                                >
                                    <div class="group inline-flex cursor-pointer capitalize">
                                        <slot :name="`th_${field.key}`">{{ field.label?.replaceAll('_', ' ') }}</slot>
                                        <span
                                            v-if="(field?.sortKey === sortKey)&& (field?.sortKey)"
                                            class="ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300">
                                        <ChevronDownIcon v-if="sortByASC" class="h-5 w-5 ease-in-out duration-500"
                                                         aria-hidden="true"/>
                                        <ChevronUpIcon v-else class="h-5 w-5 ease-in-out duration-500"
                                                       aria-hidden="true"/>
                                      </span>
                                        <span v-else-if="(field?.sortKey !== sortKey)&& (field?.sortKey)"
                                              class="invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible">
                                        <ChevronDownIcon class="h-5 w-5" aria-hidden="true"/>
                                    </span>
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody v-if="!loading" class="divide-y divide-gray-200 bg-white">
                            <tr v-for="(it, ind) in tableItems" :key="ind">
                                <td v-if="actions?.options"
                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-500 sm:pl-6">
                                    <div>
                                        <Checkbox
                                            :mode="mode"
                                            :value="it?.id" v-model="actionForm.selectedData"/>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-500 sm:pl-6"
                                    v-for="(field, index) in _fields" :key="index" :class="field?.trClass">
                                    <p v-if="field?.isNo">
                                        {{
                                            ((options?.current_page ?? 0) - 1) * (options?.per_page ?? field.isNo) + (ind + 1)
                                        }}
                                    </p>

                                    <slot v-else
                                          :name="field.key"
                                          :item="it"
                                          :index="ind"
                                          :page="(options?.current_page??0)-1"
                                          :field="field"
                                          :value="it[field.key] ?? 'N/A'">
                                        {{ it[field.key] ?? 'N/A' }}
                                    </slot>
                                </td>
                            </tr>
                            </tbody>
                            <tbody v-if="!tableItems.length">
                            <tr>
                                <td :colspan="_fields.length +(actions?.options?1:0)">
                                    <div class="flex text-center flex-col justify-center py-32 gap-4">
                                        <div class="text-center">No item Found</div>
                                        <div>
                                            <slot name="actions">
                                                <ButtonComponent v-if="_action?.href"
                                                                 :label="_action.label"
                                                                 :mode="mode"
                                                                 :href="_action?.href"/>
                                            </slot>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <Pagination :mode="mode" :options="_options"/>

    </div>
    <ModalComponent
        :title="actionForm.name"
        :body="actionForm.confirm_message||'Are you sure you want to delete this item!'"
        v-model="actionForm.is_open"
        @submit="submitAction"
        submit-type="danger"
        :submit-label="actionForm.name"
    />
</template>
<script setup>
import Pagination from "@/LaraFormik/Form/Table/Pagination.vue";
import {ChevronDownIcon, ChevronUpIcon, MagnifyingGlassIcon, XMarkIcon} from "@heroicons/vue/24/outline/index.js";
import {computed, onMounted, ref} from "vue";
import ButtonComponent from "@/LaraFormik/Form/ButtonComponent.vue";
import TextInput from "@/LaraFormik/Form/TextInput.vue";
import {router, useForm, usePage} from "@inertiajs/vue3";
import {getParameters, makeParameter, setPath} from "@/LaraFormik/Form/utils.js";
import Dropdown from "@/LaraFormik/Form/Dropdown.vue";
import ModalComponent from "@/LaraFormik/Form/ModalComponent.vue";
import TableFilter from "@/LaraFormik/Form/Table/TableFilter.vue";
import Checkbox from "@/LaraFormik/Form/Checkbox.vue";

const emit = defineEmits(['handleAction']);
const backend_props = computed(() => usePage().props);
const actions = usePage().props?.modelFilter ?? {};
const props = defineProps({
    options: {
        type: [Array, Object],
        default: []
    },
    fields: Array,
    label: String,
    searchLink: String,
    action: {
        type: [Object],
        default: {}
    }, mode: {
        type: String,
        default: 'primary'
    }
})

const _fields = computed(() => {
    if (backend_props.value.modelFilter.columns.length) {
        return backend_props.value.modelFilter.columns
    } else {
        return props.fields;
    }
})
const _action = computed(() => {
    if (backend_props.value.modelFilter?.createAction) {
        return backend_props.value.modelFilter.createAction
    } else {
        return props.action;
    }
})

const _options = computed(() => {
    if (backend_props.value?.modelFilter?.data) {
        return backend_props.value.modelFilter.data
    } else {
        return props.options;
    }
})

const parameters = getParameters();
const sortKey = ref(parameters?.sortBy ?? '');
const sortByASC = ref(parameters?.direction === "asc" ? false : true);
const loading = ref(false);
const searchKeyword = ref(parameters?.keyword ?? '');
const searchRef = ref(null);
import _lodash from 'lodash';

const tableItems = computed(() => {
    if (_options.value?.data) {
        return _options.value?.data;
    }
    return _options.value;
});
const data_ids = computed(() => {
    return tableItems.value.map((item) => item.id);
})
const isChecked = computed(() => {
    let return_value = true;
    data_ids.value.map((id) => {
        if (!actionForm.selectedData.includes(id)) {
            return_value = false;
        }
    })
    return return_value;
})
onMounted(() => {
    if (searchKeyword.value) {
        searchRef.value.focus();
    }
});
const handleSearch = _lodash.debounce(function () {

    const query = makeParameter("keyword", searchKeyword.value);
    router.visit(`${props.searchLink ?? window.location.pathname}${query}`, {
        preserveScroll: true
    });
}, 500);
const handleSort = (field, direction) => {
    if (!field.sortKey) {
        return false;
    }
    sortKey.value = field.sortKey;
    sortByASC.value = !sortByASC.value;
    setPath(makeParameter("sortBy", field.sortKey));
    setPath(makeParameter("direction", direction));
    let query = "";
    const queryData = getParameters();
    Object.keys(queryData).forEach((item, index) => {
        if (!index) {
            query = `?${item}=${queryData[item]}`;
        } else {
            query = `${query}&${item}=${queryData[item]}`;
        }
    });
    router.visit(`${props.searchLink ?? '/'}${query}`, {
        preserveScroll: true
    });
}

const handleResetSearch = () => {
    searchKeyword.value = '';
    handleSearch();
}

const actionForm = useForm({
    selectedData: [],
    is_open: false,
    confirm_message: '',
});

const tempForm = useForm({
    _data: {},
});
const handleAction = (item) => {
    const {options, ...rest} = actions;
    tempForm._data = {
        selectedData: actionForm.selectedData,
        handleActions: item?.handleActions ?? false,
        ...item,
        ...rest,
    };
    if (item?.isEmit) {
        emit('handleAction', {
            url: route('actions'),
            form: tempForm.data(),
        })
    } else if (item.confirm) {
        actionForm.is_open = true;
        actionForm.confirm_message = item?.message ?? 'Are You Sure Perform the Bulk Action?';
    } else {
        submitAction();
    }
}

const submitAction = () => {
    tempForm.post(route('actions'), {
        preserveScroll: true,
        onSuccess: () => {
            actionForm.is_open = false;
            actionForm.selectedData = [];
        }
    });
}
const colors = computed(() => {
    switch (props.mode) {
        case "primary":
            return {
                close2: 'text-primary/50 hover:text-primary',
            }
        case "secondary":

            return {
                close2: 'text-secondary/50 hover:text-secondary',
            }
        case "success":
            return {
                close2: 'text-success/50 hover:text-success',
            }
        case "warning":
            return {
                close2: 'text-warning/50 hover:text-warning',
            }
        case "danger":
            return {
                close2: 'text-danger/50 hover:text-danger',
            }
        case "info":

            return {
                close2: 'text-info/50 hover:text-info',
            }
        case "light":

            return {
                close2: 'text-light/50 hover:text-light',
            }
        case "dark":

            return {
                close2: 'text-dark/50 hover:text-dark',
            }
    }
    return {
        close2: 'text-primary/50 hover:text-primary',
    }
})
</script>
