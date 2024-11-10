# Notification for Laravel + Inertia + Vue js

This package provide integration easily make design & functionality

## Installation

You can easily install this library using Composer. Just request the package with the following command:

```bash
composer require kathore/lara-formik
```

if getting any error install this package using composer:

```bash
composer require kathore/lara-formik --ignore-platform-reqs
```

## Configuration

publish LaraFormik Component file

```bash
php artisan lara-formik:publish
```

Set color configuration in tailwind.config.js replace theme

```

theme: {
    extend: {
        fontSize: {
            'xs'
        :
            '0.625rem',   // 10px
                'xss'
        :
            '0.5rem',    // 8px
        } ,
        screens: {
            'xs'
        :
            '480px',  // Custom breakpoint for extra small screens
                'xss'
        :
            '320px', // Custom breakpoint for extra extra small screens
        } ,
        colors: {
            primary: {
                DEFAULT: '#3490dc',       // Primary color
                    light
            :
                '#6cb2eb',         // Light variant of primary color
                    dark
            :
                '#1d4ed8',          // Dark variant of primary color
                    disable
            :
                '#d1d5db',       // Disabled variant of primary color
                    hover
            :
                '#2779bd',         // Slightly darker for hover
                    active
            :
                '#1c64b0',        // Darker for active state
                    focus
            :
                '#93c5fd',         // Lighter, for focus ring or highlights
            } ,
            secondary: {
                DEFAULT: '#ffed4a',       // Secondary color
                    light
            :
                '#fff5d9',         // Light variant of secondary color
                    dark
            :
                '#f9d104',          // Dark variant of secondary color
                    disable
            :
                '#d1d5db',       // Disabled variant of secondary color
                    hover
            :
                '#fadb0a',         // Slightly darker for hover
                    active
            :
                '#f1c40f',        // Darker for active state
                    focus
            :
                '#ffeb8e',         // Lighter, for focus ring or highlights
            } ,
            success: {
                DEFAULT: '#38c172',       // Success color
                    light
            :
                '#6ee7b7',         // Light variant of success color
                    dark
            :
                '#2f855a',          // Dark variant of success color
                    disable
            :
                '#d1d5db',       // Disabled variant of success color
                    hover
            :
                '#2f9e69',         // Slightly darker for hover
                    active
            :
                '#267849',        // Darker for active state
                    focus
            :
                '#81e6d9',         // Lighter, for focus ring or highlights
            } ,
            warning: {
                DEFAULT: '#ffcc00',       // Warning color
                    light
            :
                '#fff5d9',         // Light variant of warning color
                    dark
            :
                '#f59e0b',          // Dark variant of warning color
                    disable
            :
                '#d1d5db',       // Disabled variant of warning color
                    hover
            :
                '#ffbb00',         // Slightly darker for hover
                    active
            :
                '#e5a500',        // Darker for active state
                    focus
            :
                '#ffe066',         // Lighter, for focus ring or highlights
            } ,
            danger: {
                DEFAULT: '#e3342f',       // Danger color
                    light
            :
                '#f56565',         // Light variant of danger color
                    dark
            :
                '#c53030',          // Dark variant of danger color
                    disable
            :
                '#d1d5db',       // Disabled variant of danger color
                    hover
            :
                '#cc1f1a',         // Slightly darker for hover
                    active
            :
                '#b91c1c',        // Darker for active state
                    focus
            :
                '#fc8181',         // Lighter, for focus ring or highlights
            } ,
            info: {
                DEFAULT: '#17a2b8',       // Info color
                    light
            :
                '#63c2de',         // Light variant of info color
                    dark
            :
                '#117a8b',          // Dark variant of info color
                    disable
            :
                '#d1d5db',       // Disabled variant of info color
                    hover
            :
                '#138496',         // Slightly darker for hover
                    active
            :
                '#0e7490',        // Darker for active state
                    focus
            :
                '#8bd3ea',         // Lighter, for focus ring or highlights
            } ,
            light: {
                DEFAULT: '#efe7e7',       // White (primary color in light mode)
                    light
            :
                '#d8dadc',         // Light gray (slightly off-white for backgrounds or surfaces)
                    dark
            :
                '#e9ecef',          // Darker gray (for borders or secondary elements)
                    disable
            :
                '#adb5bd',       // Disabled gray color (muted)
                    hover
            :
                '#e5ebf1',         // Slightly darker for hover
                    active
            :
                '#e2e6ea',        // Darker for active state
                    focus
            :
                '#ece8e8',         // Retain default for focus (no change)
            } ,
            dark: {
                DEFAULT: '#000000',       // Black (primary info color in dark mode)
                    light
            :
                '#4a4a4a',         // Lighter variant of black
                    dark
            :
                '#1a1a1a',          // Darker shade of black (almost pure black)
                    disable
            :
                '#6b7280',       // Disabled gray color (muted)
                    hover
            :
                '#222222',         // Slightly lighter for hover
                    active
            :
                '#111111',        // Darker for active state
                    focus
            :
                '#333333',         // Lighter, for focus ring or highlights
            } ,
            disable: {
                DEFAULT: '#d1d5db',       // General disabled color
            } ,
        } ,

        fontFamily: {
            sans: ['Figtree', ...defaultTheme.fontFamily.sans],
        } ,
    } ,
} ,
```

its already register if not present then add </br>
 this line ...ToastNotification::init() </br>
Register notification in HandleInertiaRequests App\Http\Middleware\HandleInertiaRequests

```php

<?php

namespace App\Http\Middleware;
use Kathore\LaraFormik\Notification\ToastNotification;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            
             ...(\Kathore\LaraFormik\Notification\ToastNotification::init()),
        ]);
    }
}

```

4.import Toast Notification component in main layout

```vue

<template>
  <div>
    <ToastNotification/>
    <main>
      <slot/>
    </main>
  </div>
</template>

<script setup>

  import ToastNotification from "@/LaraFormik/Notification/ToastNotification.vue";
</script>
```

## Usage

Create notification in any controller

```php
<?php

namespace App\Http\Controllers;
use Kathore\LaraFormik\Notification\ToastNotification;


class TestController extends Controller
{
    public function store() {
    
      ToastNotification::success(message);
      ToastNotification::error(message);
      ToastNotification::warning(message);
        
        // OR
        return redirect()->back()->with('success','message');
        // OR
        return redirect()->back()->with('error','message');
        // OR
        return redirect()->back()->with('message','message');
    }
}
```

## Example of components

All example files auto created. </br>
Please visit this route: /lara-formik </br>To get sample page.

That's it Done configuration now enjoy the package.

## This is code are added. in sample route /lara-formik

```php
<?php

namespace App\Http\Controllers;

use App\Models\User;use Illuminate\Http\Request;use Illuminate\Support\Facades\DB;use Inertia\Inertia;use Kathore\LaraFormik\Notification\ToastNotification;use Kathore\LaraFormik\Table\Action\CustomItem;use Kathore\LaraFormik\Table\Action\DeleteItems;use Kathore\LaraFormik\Table\Action\Table;use Kathore\LaraFormik\Table\Action\TableActionMenu;use Kathore\LaraFormik\Table\Filter\CheckBoxInput;use Kathore\LaraFormik\Table\Filter\RadioInput;use Kathore\LaraFormik\Table\Filter\SelectInput;use Kathore\LaraFormik\Table\Filter\SwitchInput;use Kathore\LaraFormik\Table\Filter\TableFilter;

class LaraFormikTestController extends Controller
{
    public function tableActions()
    {
        DB::beginTransaction();
        try {
            switch (Table::getActionId()) {
                case "paid":
                    $selectedData = Table::selectedItems();
                    $selectedData->query()
                        ->update([
                            'status' => true
                        ]);
                    break;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
        ToastNotification::error([
            'title' => 'Done',
            'message' => "testing error notification"
        ]);
        return redirect()->back();
    }

    public function index(Request $request)
    {

        TableActionMenu::make([
            CustomItem::make(User::class, 'paid')->name("Make action 2"),
            DeleteItems::make(User::class)->isConfirm()->name("Remove"),
        ])
            ->isPaginated();


        TableFilter::make([

            SelectInput::make('email')
                ->options(User::query()->pluck('email')->toArray())
                ->label("Course")
                ->multiple()
                ->resetKey(['batch', 'year']),

            SelectInput::make('year')
                ->options(['First Year', 'Second Year', 'Third Year'])
                ->label("Year")
                ->multiple()
                ->resetKey(['batch']),

            SelectInput::make('batch')
                ->options(['2018', '2019', '2020', '2021', '2022', '2023', '2024'])
                ->multiple()
                ->label("Batch"),

            SwitchInput::make('status')
                ->label("Status"),

            RadioInput::make('gender')
                ->label("Gender")
                ->options(['male', 'female', 'other']),

            CheckBoxInput::make('Status')
                ->label("Check")
                ->options(['Active', 'InActive', 'Deleted', 'Open']),

        ])->isFilterButton();

        return Inertia::render('LaraFormikTestPage', [
            'users' => \App\Models\User::query()
                ->when(\request('email'), function ($query) {
                    $ids = TableFilter::getIds(User::class, 'email', 'email');
                    $query->whereIn('id', $ids);
                })
                ->when(request()->get('keyword'), function ($query, $keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })->when(request()->get('direction'), function ($query) {
                    $query->orderBy(
                        request()->get('sortBy'),
                        request()->get('direction')
                    );
                })
                ->paginate(20),
        ]);
    }
}

```

already added in web.php files

```php
Route::get('/lara-formik', [\App\Http\Controllers\LaraFormikTestController::class, 'index'])->name('lara-formik');
Route::post('actions', \Kathore\LaraFormik\Controllers\TableController::class)
    ->name('actions'); //its mendatory
```

Vue js page added this sample file

```vue

<template>
  <SideBarComponent v-model="form.switch" backdrop-class="bg-light-disable">
  </SideBarComponent>
  <div class="p-10">
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
  <div class="px-10">
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
  <div class="px-10 mt-4 ">
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
  <ToastNotification/>
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
  import ToastNotification from "@/LaraFormik/Notification/ToastNotification.vue";
  import SideBarComponent from "@/LaraFormik/Other/SideBarComponent.vue";
  import TabComponent from "@/LaraFormik/Other/TabComponent.vue";
  import FormAction from "@/LaraFormik/Form/FormAction.vue";

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

```

