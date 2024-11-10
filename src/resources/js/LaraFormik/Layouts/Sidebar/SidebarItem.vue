<template>
    <li>
        <Link :href="item.href"
              :class="[item.current ? colors.active :  colors.in_active,
                                'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold']">
                                <span
                                    v-if="item?.initial"
                                    :class="[item.current ? colors.active_1 :  colors.in_active_1,colors.other]">
                                    {{ item.initial }}
                                </span>
            <component v-else-if="item?.icon" :is="item.icon"
                       :class="['h-6 w-6 shrink-0' ]" aria-hidden="true"/>

            {{ item.name }}
        </Link>
    </li>
</template>
<script setup lang="ts">
import {Link} from '@inertiajs/vue3';
import {computed} from "vue";

const {item, mode} = defineProps({
    item: Object,
    mode: {
        type: String,
        default: 'primary'
    }
})

const colors = computed(() => {
    switch (mode) {
        case "primary":
            return {
                active: 'bg-primary-light/10 text-primary',
                in_active: 'text-primary hover:bg-primary-light/10 hover:text-primary-active',
                active_1: 'border-primary-active text-primary-active',
                in_active_1: 'border-primary text-primary group-hover:border-primary-active group-hover:text-primary-active',
                other: 'flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border bg-white text-[0.625rem] font-medium'
            }
        case "secondary":
            return {
                active: 'bg-secondary-light/10 text-secondary',
                in_active: 'text-secondary hover:bg-secondary-light/10 hover:text-secondary-active',
                active_1: 'border-secondary-active text-secondary-active',
                in_active_1: 'border-secondary text-secondary group-hover:border-secondary-active group-hover:text-primary-active',
                other: 'flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border bg-white text-[0.625rem] font-medium'
            }
        case "success":
            return {
                active: 'bg-success-light/10 text-success',
                in_active: 'text-success hover:bg-success-light/10 hover:text-success-active',
                active_1: 'border-success-active text-success-active',
                in_active_1: 'border-success text-success group-hover:border-success-active group-hover:text-primary-active',
                other: 'flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border bg-white text-[0.625rem] font-medium'
            }
        case "warning":
            return {
                active: 'bg-warning-light/10 text-warning',
                in_active: 'text-warning hover:bg-warning-light/10 hover:text-warning-active',
                active_1: 'border-warning-active text-warning-active',
                in_active_1: 'border-warning text-warning group-hover:border-warning-active group-hover:text-warning-active',
                other: 'flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border bg-white text-[0.625rem] font-medium'
            }
        case "danger":
            return {
                active: 'bg-danger-light/10 text-danger',
                in_active: 'text-danger hover:bg-danger-light/10 hover:text-danger-active',
                active_1: 'border-danger-active text-danger-active',
                in_active_1: 'border-danger text-danger group-hover:border-danger-active group-hover:text-danger-active',
                other: 'flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border bg-white text-[0.625rem] font-medium'
            }
        case "info":
            return {
                active: 'bg-info-light/10 text-info',
                in_active: 'text-info hover:bg-info-light/10 hover:text-info-active',
                active_1: 'border-info-active text-info-active',
                in_active_1: 'border-info text-info group-hover:border-info-active group-hover:text-info-active',
                other: 'flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border bg-white text-[0.625rem] font-medium'
            }
        case "light":
            return {
                active: 'bg-light-light/10 text-light',
                in_active: 'text-light hover:bg-light-light/10 hover:text-light-active',
                active_1: 'border-light-active text-light-active',
                in_active_1: 'border-light text-light group-hover:border-light-active group-hover:text-light-active',
                other: 'flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border bg-white text-[0.625rem] font-medium'
            }
        case "dark":
            return {
                active: 'bg-dark-light/10 text-dark',
                in_active: 'text-dark hover:bg-dark-light/10 hover:text-dark-active',
                active_1: 'border-dark-active text-dark-active',
                in_active_1: 'border-dark text-dark group-hover:border-dark-active group-hover:text-dark-active',
                other: 'flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border bg-white text-[0.625rem] font-medium'
            }
    }
    return {
        active: 'bg-primary-light/10 text-primary',
        in_active: 'text-primary hover:bg-primary-light/10 hover:text-primary-active',
        active_1: 'border-primary-active text-primary-active',
        in_active_1: 'border-primary text-primary group-hover:border-primary-active group-hover:text-primary-active',
        other: 'flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border bg-white text-[0.625rem] font-medium'
    }
})
</script>
