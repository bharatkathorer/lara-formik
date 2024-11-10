<template>
    <TabGroup :default-index="active">
        <TabList class="flex  bg-gray-100 rounded-lg divide-white divide-x">
            <Tab v-for="(item,idx) in options" as="template" :key="idx"
                 class="last:rounded-r-lg first:rounded-l-lg">
                <button @click="handleTab(item)"
                        :class="[ 'w-full py-2.5 text-sm font-medium ',
                        'focus:outline-none ',
                         (idx === active) ? `${colors.active} shadow` : colors.hover]"
                >
                    {{ item.label }}
                </button>
            </Tab>
        </TabList>

        <TabPanels class="mt-2">
            <TabPanel
                v-for="(item, idx) in options"
                :key="idx">
                <slot :name="item?.key" :item="item">
                    <div>
                        slot key: {{ item.key }}
                    </div>
                </slot>
            </TabPanel>
        </TabPanels>
    </TabGroup>
</template>

<script setup>
import {Tab, TabGroup, TabList, TabPanel, TabPanels} from '@headlessui/vue'
import {getParameters, makeParameter} from "@/LaraFormik/Form/utils.js";
import {router} from "@inertiajs/vue3";
import {computed, ref} from "vue";

const parameters = getParameters();
const loading = ref(true);
const model = defineModel({
    type: [Boolean, String, Number, Object, Array],
    required: null,
    default: null,

});

const {options, tabKey, preserveState, mode} = defineProps({
    options: {
        type: [Array],
        default: []
    },
    tabKey: {
        type: String,
        default: 'active'
    },
    preserveState: {
        type: Boolean,
        default: true
    },
    mode: {
        type: String,
        default: 'primary'
    }
})

const active = computed(() => {
    let _active = null;
    if (parameters?.[tabKey]) {
        _active = parameters?.[tabKey];
    } else if (!model) {
        _active = options?.[0]?.key;
    } else {
        _active = model.value ?? options?.[0]?.key ?? '';
    }
    if (preserveState && model) {
        _active = model.value;
    }
    if (!_active) {
        if (parameters?.[tabKey]) {
            _active = parameters?.[tabKey];
        } else if (!model) {
            _active = options?.[0]?.key;
        } else {
            _active = model.value ?? options?.[0]?.key ?? '';
        }
    }
    return options.findIndex((item) => item.key === _active)

})

const handleTab = (item) => {
    model.value = item.key;
    loading.value = true;
    const params = makeParameter(tabKey, null, false);
    router.visit(`${item.href ?? '/'}?${tabKey}=${item.key}&${params}`, {
        preserveScroll: true,
        preserveState,
    });
}

const colors = computed(() => {
    switch (mode) {
        case "primary":
            return {
                active: 'bg-primary text-white',
                hover: 'text-black hover:bg-primary-focus hover:text-white'
            }
        case "secondary":

            return {
                active: 'bg-secondary text-black',
                hover: 'text-black hover:bg-secondary-focus hover:text-black'
            }
        case "success":

            return {
                active: 'bg-success text-white',
                hover: 'text-black hover:bg-success-focus hover:text-white'
            }
        case "warning":

            return {
                active: 'bg-warning text-white',
                hover: 'text-black hover:bg-warning-focus hover:text-white'
            }
        case "danger":

            return {
                active: 'bg-danger text-white',
                hover: 'text-black hover:bg-danger-focus hover:text-white'
            }
        case "info":

            return {
                active: 'bg-info text-white',
                hover: 'text-black hover:bg-info-focus hover:text-white'
            }
        case "light":

            return {
                active: 'bg-light text-black',
                hover: 'text-black hover:bg-light-focus hover:text-black'
            }
        case "dark":

            return {
                active: 'bg-dark text-white',
                hover: 'text-black hover:bg-dark-focus hover:text-white'
            }
    }
    return {
        active: 'bg-primary text-white',
        hover: 'text-black hover:bg-primary-focus hover:text-white'
    }
})

</script>
