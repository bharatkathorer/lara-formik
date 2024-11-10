<template>
    <div class="flex items-center justify-between border-t py-5 px-4 md:px-6" v-if="paginate">
        <div class="flex-1 flex justify-between " :class="isNumber&&'md:hidden'">
            <div v-if="_items.prev_page_url" @click="redirectPage(_items.prev_page_url)"
                 class="relative inline-flex cursor-pointer items-center px-4 py-2 border border-stroke text-sm
                 font-medium rounded-l-md text-primary bg-white hover:text-white hover:bg-primary-hover ease-in-out duration-500"
                 :class="classes">
                Previous
            </div>
            <slot v-else name="leftDisable">
                <div
                    class="relative inline-flex cursor-pointer items-center px-4 py-2 border border-stroke text-sm
                 font-medium rounded-l-md text-primary bg-white hover:text-primary-hover">
                    Previous
                </div>
            </slot>
            <div v-if="_items.next_page_url" @click="redirectPage(_items.next_page_url)"
                 :class="classes"
                 class="ml-3 relative inline-flex cursor-pointer items-center px-4 py-2 border border-stroke
                 text-sm font-medium rounded-r-md text-primary bg-white hover:text-white hover:bg-primary-hover ease-in-out duration-500">
                Next
            </div>
            <slot v-else name="rightDisable">
                <div
                    class="ml-3 relative inline-flex cursor-pointer items-center px-4 py-2 border border-stroke
                 text-sm font-medium rounded-r-md text-primary bg-white hover:text-primary-hover">
                    Next
                </div>
            </slot>
        </div>
        <div v-if="isNumber" class="hidden md:flex-1 md:flex flex-wrap gap-4 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-primary-light">
                    Showing
                    <span class="font-medium">{{ _items.from }}</span>
                    to
                    <span class="font-medium">{{ _items.to }}</span>
                    of
                    <span class="font-medium">{{ _items.total }}</span>
                    results
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex rounded-l-md shadow-sm -space-x-px"
                     aria-label="Pagination">
                    <!--                    :href="_items.prev_page_url"-->
                    <div v-if="_items.prev_page_url" @click="redirectPage(_items.prev_page_url)"
                         class="relative cursor-pointer inline-flex items-center px-3 py-1.5 rounded-l-md border
                         border-stroke bg-white text-sm font-medium text-primary-light hover:text-white hover:bg-primary-hover transition-all ease-in-out duration-300">
                        <span class="sr-only">Previous</span>
                        <ChevronLeftIcon class="h-5 w-5"/>
                    </div>
                    <div v-else
                         class="relative  inline-flex items-center px-3 py-1.5 rounded-l-md
                           border border-stroke  text-sm font-medium
                           text-primary-light cursor-not-allowed
                           transition-all ease-in-out duration-300">
                        <span class="sr-only">Next </span>
                        <ChevronLeftIcon class="h-5 w-5 "/>
                    </div>
                    <!--                    :href="link.url"-->
                    <div
                        @click="(!link.active)&&redirectPage(link.url)"
                        class="relative cursor-pointer inline-flex items-center px-3 py-1.5 border text-sm font-semibold
                         "
                        v-for="(link, index) in pageLinks" :key="index"
                        :class="{'bg-body border border-primary text-primary z-10': link.active,
                        'bg-white border-stroke text-primary-light hover:bg-gray-50':
                        !link.active}">
                        {{ link.label }}
                    </div>
                    <!--:href="_items.next_page_url"-->
                    <div v-if="_items.next_page_url" @click="redirectPage(_items.next_page_url)"
                         class="relative cursor-pointer inline-flex items-center px-3
                         py-1.5  border border-stroke bg-white text-sm
                       rounded-r-md  font-medium text-primary-light hover:text-white hover:bg-primary-hover transition-all ease-in-out duration-300">
                        <span class="sr-only">Next</span>
                        <ChevronLeftIcon class="h-5 w-5 rotate-180"/>
                    </div>
                    <div v-else
                         class="relative  inline-flex items-center px-3 py-2
                           border border-stroke  text-sm font-medium
                           text-primary-light
                         rounded-r-md  cursor-not-allowed
                           transition-all ease-in-out duration-300">
                        <span class="sr-only">Next</span>
                        <ChevronLeftIcon class="h-5 w-5 rotate-180 "/>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</template>
<script setup>
import {computed, defineProps, onBeforeMount, ref} from "vue";
import {router, useForm, usePage} from "@inertiajs/vue3";
import {ChevronLeftIcon} from "@heroicons/vue/24/outline/index.js";
import {makeParameter} from "@/LaraFormik/Form/utils.js";
const actions = usePage().props?.actions ?? {};
const paginate = ref(false);

const props = defineProps({
    options: {
        type: [Object, Array],
        default: []
    },
    params: {
        type: [Object, Array],
        default: {}
    },
    getPage: Boolean,
    isNumber: {
        type: Boolean,
        default: true
    },
    classes: String,
});

const pageLinks = computed(() => _items.value.links.filter(({label}) => label !== "&laquo; Previous" && label !== "Next &raquo;"));
const _items = computed(() => {
    return props.options;
});
onBeforeMount(() => {
    if (_items.value.data) {
        if (_items.value.data.length) {
            paginate.value = true
        }
    }
})
const emit = defineEmits(['changePage']);
const testForm = useForm({});

function redirectPage(url) {
    if (url !== null) {
        if (props.getPage) {
            let data = url.split("?page=");
            emit('changePage', data[1]);
        } else {

            testForm.get(`${url}${makeParameter(false, false, false)}`, {
                preserveState: actions.isPaginateSelect,
                preserveScroll:true
            });
            // router.get(url, props.params);
        }
    }
}
</script>
