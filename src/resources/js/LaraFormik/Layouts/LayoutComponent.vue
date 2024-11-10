<template>
    <ToastNotification/>
    <div>
        <SideBarComponent v-model="sidebarOpen">
            <SidebarData/>
        </SideBarComponent>

        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
            <SidebarData/>
        </div>
        <div class="lg:pl-72">
            <div
                class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" @click="sidebarOpen = true">
                    <span class="sr-only">Open sidebar</span>
                    <Bars3Icon class="h-6 w-6" aria-hidden="true"/>
                </button>


                <!-- Separator -->
                <div class="h-6 w-px bg-gray-200 lg:hidden" aria-hidden="true"/>

                <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">

                    <form v-if="isSearch" class="relative flex flex-1" action="#" method="GET">
                        <label for="search-field" class="sr-only">Search</label>
                        <MagnifyingGlassIcon
                            class="pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-gray-400"
                            aria-hidden="true"/>
                        <input id="search-field"
                               class="block h-full w-full border-0 py-0 pl-8 pr-0
                               text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm"
                               placeholder="Search..." type="search" name="search"/>
                    </form>
                    <div v-else class="relative flex flex-1">
                        <slot name="headerLeft"/>
                    </div>

                    <div class="flex items-center gap-x-4 lg:gap-x-6">
                        <slot name="headerRight"/>
                        <button type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500">
                            <span class="sr-only">View notifications</span>
                            <BellIcon class="h-6 w-6" aria-hidden="true"/>
                        </button>

                        <!-- Separator -->
                        <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-200" aria-hidden="true"/>
                        <!-- Profile dropdown -->
                        <DropdownComponent
                            :options="userNavigation"
                            title-key="name"
                            @submit="(item)=>console.log(item)"
                        >
                            <span class="sr-only">Open user menu</span>
                            <img class="h-8 w-8 rounded-full bg-gray-50"
                                 src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                 alt=""/>
                            <span class="hidden lg:flex lg:items-center">
                              <span class="ml-4 text-sm/6 font-semibold text-gray-900"
                                    aria-hidden="true">Tom Cook</span>
                              <ChevronDownIcon class="ml-2 h-5 w-5 text-gray-400" aria-hidden="true"/>
                            </span>
                        </DropdownComponent>
                    </div>
                </div>
            </div>

            <main class="py-10">
                <div class="px-4 sm:px-6 lg:px-8">
                    <slot/>
                </div>
            </main>
        </div>
    </div>
</template>

<script setup>
import {ref} from 'vue'
import {Bars3Icon, BellIcon,} from '@heroicons/vue/24/outline'
import {ChevronDownIcon, MagnifyingGlassIcon} from '@heroicons/vue/20/solid'
import SideBarComponent from "@/LaraFormik/Other/SideBarComponent.vue";
import SidebarData from "@/LaraFormik/Layouts/Sidebar/SidebarData.vue";
import DropdownComponent from "@/LaraFormik/Form/Table/DropdownComponent.vue";
import ToastNotification from "@/LaraFormik/Notification/ToastNotification.vue";

const userNavigation = [
    {name: 'Your profile', href: '#'},
    {name: 'Sign out', href: '#'},
]
const sidebarOpen = ref(false)
defineProps({
    isSearch: {
        type: Boolean,
        default: false
    }
})
</script>
