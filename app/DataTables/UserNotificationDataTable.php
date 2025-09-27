<?php

namespace App\DataTables;

use App\Models\UserNotification;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserNotificationDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<UserNotification> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('type', function($row){
                return ucfirst($row->data['type']);
            })
            ->addColumn('message', function($row){
                return $row->data['text'];
            })
            ->addColumn('expires_at', function($row){
                return $row->expires_at ? date('Y-m-d h:i:m',strtotime($row->expires_at)) : '-';
            })
            ->addColumn('created_at', function($row){
                return date('Y-m-d h:i:m',strtotime($row->created_at));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<UserNotification>
     */
    public function query(DatabaseNotification $model): QueryBuilder
    {
         $query = $model->newQuery();
         return $query->where('notifiable_id',Auth::user()->id)->where(function ($query) {
                        $query->whereNull('expires_at')
                            ->orWhere('expires_at', '>', now());
                    });
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('usernotification-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    // ->selectStyleSingle()
                    ->buttons([
                        
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('type'),
            Column::computed('message'),
            Column::make('expires_at'),
            Column::make('created_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'UserNotification_' . date('YmdHis');
    }
}
