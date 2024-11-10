<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Kathore\LaraFormik\Notification\ToastNotification;
use Kathore\LaraFormik\Table\Action\CustomItem;
use Kathore\LaraFormik\Table\Action\DeleteItems;
use Kathore\LaraFormik\Table\Action\Table;
use Kathore\LaraFormik\Table\Action\TableActionMenu;
use Kathore\LaraFormik\Table\Filter\CheckBoxInput;
use Kathore\LaraFormik\Table\Filter\RadioInput;
use Kathore\LaraFormik\Table\Filter\SelectInput;
use Kathore\LaraFormik\Table\Filter\SwitchInput;
use Kathore\LaraFormik\Table\Filter\TableFilter;

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
