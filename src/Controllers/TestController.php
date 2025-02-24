<?php

namespace Kathore\LaraFormik\Controllers;

use App\Models\User;
use Kathore\LaraFormik\Table;
use Kathore\LaraFormik\Table\BulkActions\CustomItem;
use Kathore\LaraFormik\Table\BulkActions\DeleteItems;
use Kathore\LaraFormik\Table\Filter\CheckBoxInput;
use Kathore\LaraFormik\Table\Filter\RadioInput;
use Kathore\LaraFormik\Table\Filter\SelectInput;
use Kathore\LaraFormik\Table\Filter\SwitchInput;
use Kathore\LaraFormik\Table\TableColumn;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TestController extends Controller
{

    public function bulkActionsHandler(): RedirectResponse
    {
        DB::beginTransaction();
        try {
            switch (Table\TableHelper::getActionId()) {
                case "paid":
                    $selectedData = Table\TableHelper::selectedItems(function ($query) {
                        $query->select('id');
                    });
                    $selectedData->update([
                        'is_verify' => true
                    ]);
                    break;
            }
            DB::commit();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
        }
//        dd('okk');
        ToastNotification::error([
            'title' => 'Done',
            'message' => "testing error notification"
        ]);
        return redirect()->back();
    }

    public function index()
    {

        Table::make(User::class)
            ->label('Users')
            ->createActionButton('Create User', '#')
            ->columns([
                TableColumn::make('name')->searchable(),
                TableColumn::make('email')->searchable()->sortable(),
                TableColumn::make('action')
            ])
            ->filters([
                SelectInput::make('email')
                    ->options(User::query()->pluck('email')->toArray())
                    ->label("Course")
                    ->multiple()
                    ->resetKey(['batch', 'year'])
                    ->query(function ($query, $value) {
                        $query->whereIn('email', $value);
                    }),
                SelectInput::make('year')
                    ->options(['First Year', 'Second Year', 'Third Year'])
                    ->label("Year")
                    ->multiple()
                    ->resetKey(['batch'])
                    ->query(function ($query, $value) {
                        $query->whereIn('email', $value);
                    }),
                SwitchInput::make('status')
                    ->label("Status")
                    ->query(function ($query, $value) {
                        $query->where('email', $value);
                    }),
                RadioInput::make('gender')
                    ->label("Gender")
                    ->options(['male', 'female', 'other'])
                    ->query(function ($query, $value) {
                        $query->where('email', $value);
                    }),
                CheckBoxInput::make('Status')
                    ->label("Check")
                    ->options(['Active', 'InActive', 'Deleted', 'Open'])
                    ->query(function ($query, $value) {
                        $query->where('email', $value);
                    }),

            ])
            ->bulkActions([
                CustomItem::make('paid')
                    ->name("Make action 2"),
                DeleteItems::make()
                    ->isConfirm()
                    ->name("Remove"),
            ])
            ->query(function ($query) {
                $query->whereNull('email_verified_at');
            })
            ->paginate();

        return Inertia::render('Welcome');
    }

    /**
     * Display the user's profile form.
     */

}
