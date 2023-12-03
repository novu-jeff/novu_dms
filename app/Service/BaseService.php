<?php

namespace App\Service;

use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;

class BaseService
{
    public Builder $query;

    public function __construct(Builder $builder)
    {
        $this->query = $builder;
    }

    public function dataTable(array $additionalColumns = [], $additionalRawColumns = []): JsonResponse
    {
        $dataTable = DataTables::of($this->query)
            ->addIndexColumn()
            ->addColumn('created_at', fn ($row) => Carbon::parse($row->created_at)->format('Y-m-d'))
            ->addColumn('status', function ($row) {
                return $row->deleted_at == null ?
                    '<span class="main-badge success-badge">Active</span>' :
                    '<span class="main-badge danger-badge">Inactive</span>';
            })
            ->addColumn('actions', function ($row) {
                $buttonClass = $row->deleted_at == null ? 'main-btn danger-btn' : 'main-btn primary-btn';

                $svgIcon = $row->deleted_at == null ?
                    '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>' :
                    '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>';

                $tooltip = $row->deleted_at ? 'Restore' : 'Delete';

                $canEdit = $row->deleted_at == null ? '                    <button title="View/Edit" data-id="'.$row->id.'" type="button" class="main-btn warning-btn btn-hover btn-sm text-white text-center" data-bs-toggle="modal" id="edit-button" data-bs-target="#updateModal">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </button>' : '';

                return '
                     '.$canEdit.'
                    <button title="'.$tooltip.'" data-id="'.$row->id.'" type="button" class="'.$buttonClass.' btn-hover btn-sm text-white text-center" id="delete-button">
                        '. $svgIcon .'
                    </button>
                    ';
            });

            foreach ($additionalColumns as $column) {
                $dataTable->addColumn($column['name'], $column['callback']);
            }

            return $dataTable->rawColumns(array_merge(['status', 'actions']), $additionalRawColumns)->toJson();

    }
}
