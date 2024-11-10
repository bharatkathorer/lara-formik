<template>
    <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6 pb-4">
        <div class="flex h-16 shrink-0 items-center">
            <ApplicationLogo/>
        </div>
        <nav class="flex flex-1 flex-col">
            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                <li>
                    <ul role="list" class="-mx-2 space-y-1">
                        <SidebarItem mode="dark" v-for="item in navigation" :key="item.name" :item="item"/>
                    </ul>
                </li>
                <li>
                    <div class="text-xs/6 font-semibold text-gray-400">Your teams</div>
                    <ul role="list" class="-mx-2 mt-2 space-y-1">
                        <SidebarItem mode="dark" v-for="item in teams" :key="item.name" :item="item"/>
                    </ul>
                </li>
                <li class="mt-auto">
                    <SidebarItem mode="dark" class="-mx-2"
                                 :item=" {name: 'Settings', href: '#', icon: Cog6ToothIcon, current: false}"/>

                </li>
            </ul>
        </nav>
    </div>
</template>
<script setup>
import {
    CalendarIcon,
    ChartPieIcon,
    Cog6ToothIcon,
    DocumentDuplicateIcon,
    FolderIcon,
    HomeIcon,
    UsersIcon,
} from '@heroicons/vue/24/outline'
import ApplicationLogo from "@/LaraFormik/Layouts/ApplicationLogo.vue";
import SidebarItem from "@/LaraFormik/Layouts/Sidebar/SidebarItem.vue";

const navigation = [
    {name: 'Dashboard', href: '#', icon: HomeIcon, current: true},
    {name: 'Team', href: '#', icon: UsersIcon, current: false},
    {name: 'Projects', href: '#', icon: FolderIcon, current: false},
    {name: 'Calendar', href: '#', icon: CalendarIcon, current: false},
    {name: 'Documents', href: '#', icon: DocumentDuplicateIcon, current: false},
    {name: 'Reports', href: '#', icon: ChartPieIcon, current: false},
]
const teams = [
    {id: 1, name: 'Heroicons', href: '#', initial: 'H', current: false},
    {id: 2, name: 'Tailwind Labs', href: '#', initial: 'T', current: false},
    {id: 3, name: 'Workcation', href: '#', initial: 'W', current: false},
]
</script>
