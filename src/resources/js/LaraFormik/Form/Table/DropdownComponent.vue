<template>
    <div>
        <Menu as="div" class="relative">
            <div class="">
                <MenuButton class="flex items-center">
                    <slot>
                        <EllipsisVerticalIcon class="size-5"/>
                    </slot>
                </MenuButton>
            </div>
            <transition enter-active-class="transition ease-out duration-100"
                        enter-from-class="transform opacity-0 scale-95"
                        enter-to-class="transform opacity-100 scale-100"
                        leave-active-class="transition ease-in duration-75"
                        leave-from-class="transform opacity-100 scale-100"
                        leave-to-class="transform opacity-0 scale-95">

                <MenuItems
                    class="absolute right-0 z-10 mt-2 w-48 rounded-md bg-white  shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">

                    <div v-for="item in options" :key="item.label"
                         class="hover:bg-gray-100 block py-2 px-4 text-sm text-gray-700 cursor-pointer">
                        <div v-if="item?.isReturn" @click="emit('submit',item)">
                            {{ item.label }}
                        </div>
                        <a v-else-if="item?.target" :target="item?.target" :href="item?.href">
                            {{ item.label }}
                        </a>
                        <Link v-else :href="item?.href" :method="item?.method??'get'" as="button">
                            {{ item.label }}
                        </Link>
                    </div>
                </MenuItems>
            </transition>
        </Menu>
    </div>
</template>
<script setup>
import {Menu, MenuButton, MenuItems} from "@headlessui/vue";
import {Link} from "@inertiajs/vue3";
import {EllipsisVerticalIcon} from "@heroicons/vue/24/outline/index.js";

defineProps({
    options: Array,
})

// const options = [
//     {label:'sample',isReturn:true},
//     {label:'sample',target:'_blank',href:"/#"},
//     {label:'sample',href:"/#",method:'post'},
// ]
const emit = defineEmits(['submit']);
</script>
