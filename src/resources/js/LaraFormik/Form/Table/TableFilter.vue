<template>

  <div v-if="isStatus && isFilter && selectedValues.length" class="bg-gray-50 w-full px-6 py-2">

    <div class="flex justify-between gap-4" v-if="selectedValues.length">
      <div class="flex gap-2 flex-wrap ">
        <p @click="getParameters()" class="font-semibold text-sm">Applied Filters:</p>
        <div
            class="  px-2 rounded py-0.5  flex items-center gap-1"
            :class="colors.chip"
            v-for="(item,index) in selectedValues" :key="index">
          <span class="text-nowrap text-sm">{{ item.value === true ? item?.name : item.value }}</span>
          <span title="Remove">
                    <svg @click="handleRemove(item)" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                         class="h-5 w-5 cursor-pointer font-semibold  ease-in-out duration-300" :class="colors.close">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                    </span>
        </div>
      </div>
      <div title="Clear all filters">
        <svg @click="handleClearAll" xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
             class="h-5 w-5 cursor-pointer font-semibold ease-in-out duration-300 text-danger/70 hover:text-danger" >
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M6 18 18 6M6 6l12 12"/>
        </svg>
      </div>
    </div>
  </div>
  <Dropdown v-else-if="isFilter && !isStatus" align="right" widthPx="450" :is-close="false">
    <template #trigger="{open}">
          <span class="inline-flex rounded-md">
                                                <button type="button"
                                                        class="inline-flex items-center px-2 py-2 rounded-full
                                                         text-sm font-medium leading-4  transition duration-150
                                                          ease-in-out  border
                                                          border-transparent  focus:outline-none"
                                                        :class="colors.filter"
                                                >
                                                     <svg v-show="!open" class="h-6 w-6"
                                                          xmlns="http://www.w3.org/2000/svg"
                                                          fill="none" viewBox="0 0 24 24"
                                                          stroke-width="1.5"
                                                          stroke="currentColor"
                                                     >
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/>
                                                        </svg>
                                                    <svg v-show="open" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                         class="h-6 w-6 ">
                                                      <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18 18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </span>
    </template>

    <template #content>
      <div
          class=" w-full px-4 py-4 text-sm
                leading-5 text-left text-gray-700 transition grid gap-4"
      >
        <div v-for="(item,index) in form.options" :key="index">
          <FormMultiselect
              @change="(val)=>handleItem(item,val)"
              v-if="item.type==='multiselect'"
              :options="item.options"
              :label="item.label"
              track-key="title"
              label-key="title"
              :object="false"
              :mode="item?.mode"
              returnValue="id"
              v-model="item.value"
              placeholder="Select Course"/>
          <FormRadioGroup :mode="mode" v-else-if="item.type ==='radio'"
                          v-model="item.value"
                          :options="item.options"
                          :label="item.label"
                          :id-key="`filter_${index}`"
          />
          <FormSwitch :mode="mode" v-model="item.value"
                      :name="item?.name"
                      :label="item?.label"
                      v-else-if="item.type ==='toggle'"/>
          <FormMultiCheckBox
              :mode="mode"
              :id-key="`filter_${index}`"
              v-else-if="item.type ==='checkbox'" v-model="item.value"
              :options="item.options"
              :label="item?.label"/>

        </div>
        <div v-if="filters?.filterButton" class="col-span-full flex justify-end">
          <ButtonComponent :mode="mode" @click="handleFilter">Filter</ButtonComponent>
        </div>

      </div>
    </template>
  </Dropdown>
</template>
<script setup>
import Dropdown from "@/LaraFormik/Form/Dropdown.vue";
import {computed} from "vue";
import {router, useForm, usePage} from "@inertiajs/vue3";
import {getParameters, makeParameter} from "@/LaraFormik/Form/utils.js";
import ButtonComponent from "@/LaraFormik/Form/ButtonComponent.vue";
import FormMultiselect from "@/LaraFormik/Form/FormMultiselect.vue";
import FormRadioGroup from "@/LaraFormik/Form/FormRadioGroup.vue";
import FormSwitch from "@/LaraFormik/Form/FormSwitch.vue";
import FormMultiCheckBox from "@/LaraFormik/Form/FormMultiCheckBox.vue";

const props = defineProps({
  isStatus: {
    type: Boolean,
    default: false
  },
  mode: {
    type: String,
    default: 'primary'
  }
})
const filters = computed(() => usePage().props?.modelFilter ?? []);

const isFilter = computed(() => (filters.value.options ?? []).length !== 0);
const selectedValues = computed(() => {
  const options = [];
  filters.value.options.map((item, index) => {
    if (typeof item.value === 'object') {
      item.value?.map((_item) => {
        if (_item) {
          options.push({
            value: _item,
            key: item.key,
            index,
            mode: item.mode,
            name: item.label ?? item.name ?? 'N/A'
          });
        }
      })
    } else if (item.value) {
      options.push({
        value: item.value,
        key: item.key,
        index,
        mode: item.mode,
        name: item.label ?? item.name ?? 'N/A'
      });
    }
  });
  return options;
})
const form = useForm({
  options: filters.value.options,
})
const handleItem = (item, val = null) => {
  if (filters.value.filterButton) {
    return;
  }
  let data = {
    [item.key]: item.mode === 'tags' ? val.length ? val : null : val ?? null,
  }
  item?.resetKey.map((_key) => {
    data[_key] = null;
  });
  let query = makeParameter(data);
  changeUrl(`${window.location.pathname}${query}`);
}

const handleRemove = (item) => {
  if (item.mode === 'tags') {
    form.options[item.index].value = form.options[item.index].value.filter((_item) => _item !== item.value)
  } else {
    form.options[item.index].value = '';
  }
  handleFilter();
}

const handleFilter = () => {
  let data = {};
  form.options.map((item) => {
    data[item.key] = item.mode === 'tags' ? item.value.length ? item.value : null : item.value ?? null
  })
  let query = makeParameter(data);

  changeUrl(`${window.location.pathname}${query}`);
}
const handleClearAll = () => {
  let data = {};
  form.options.map((item) => {
    data[item.key] = null
  })
  let query = makeParameter(data);
  changeUrl(`${window.location.pathname}${query}`);
}

const changeUrl = (url) => {
  router.visit(url, {
    preserveScroll: true
  });
}

const colors = computed(() => {
  switch (props.mode) {
    case "primary":
      return {
        close2: 'text-primary/50 hover:text-primary',
        chip: 'text-primary border-primary  bg-primary-light/20',
        close: 'text-primary/50 hover:text-primary',
        filter: 'bg-primary-light/20 text-primary/80 hover:text-primary hover:bg-primary-light/30'
      }
    case "secondary":

      return {
        close2: 'text-secondary/50 hover:text-secondary',
        chip: 'bg-secondary text-black',
        close: 'text-dark/50 hover:text-dark',
        filter: 'bg-secondary-light/20 text-secondary/80 hover:text-secondary hover:bg-secondary-light/30'
      }
    case "success":
      return {
        close2: 'text-success/50 hover:text-success',
        chip: 'bg-success text-white',
        close: 'text-gray-200 hover:text-white',
        filter: 'bg-success-light/20 text-success/80 hover:text-success hover:bg-success-light/30'
      }
    case "warning":
      return {
        close2: 'text-warning/50 hover:text-warning',
        chip: 'bg-warning text-white',
        close: 'text-gray-200 hover:text-white',
        filter: 'bg-warning-light/20 text-warning/80 hover:text-warning hover:bg-warning-light/30'
      }
    case "danger":
      return {
        close2: 'text-danger/50 hover:text-danger',
        chip: 'bg-danger text-white',
        close: 'text-gray-200 hover:text-white',
        filter: 'bg-danger-light/20 text-danger/80 hover:text-danger hover:bg-danger-light/30'
      }
    case "info":

      return {
        close2: 'text-info/50 hover:text-info',
        chip: 'bg-info text-white',
        close: 'text-gray-200 hover:text-white',
        filter: 'bg-info-light/20 text-info/80 hover:text-info hover:bg-info-light/30'
      }
    case "light":

      return {
        close2: 'text-light/50 hover:text-light',
        chip: 'bg-light text-black',
        close: 'text-dark/50 hover:text-dark',
        filter: 'bg-light-light/20 text-light/80 hover:text-light hover:bg-light-light/30'
      }
    case "dark":

      return {
        close2: 'text-dark/50 hover:text-dark',
        chip: 'bg-dark text-white',
        close: 'text-gray-400 hover:text-white',
        filter: 'bg-dark-light/20 text-dark/80 hover:text-dark hover:bg-dark-light/30'
      }
  }
  return {
    close2: 'text-primary/50 hover:text-primary',
    chip: 'bg-primary text-white',
    close: 'text-primary/50 hover:text-primary',
    filter: 'bg-primary-light/20 text-primary/80 hover:text-primary hover:bg-primary-light/30'
  }
})

</script>
