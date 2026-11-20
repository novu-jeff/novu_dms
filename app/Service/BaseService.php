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

    public function dataTable(array $additionalColumns = [], $additionalRawColumns = [], $updateModalId = '#updateModal'): JsonResponse
    {
        $dataTable = DataTables::of($this->query)
            ->addIndexColumn()
            ->addColumn('created_at', fn ($row) => Carbon::parse($row->created_at)->format('Y-m-d'))
            ->addColumn('status', function ($row) {
                return $row->status == 1 ?
                    '<span class="main-badge success-badge">Active</span>' :
                    '<span class="main-badge danger-badge">Inactive</span>';
            })
            
            ->addColumn('actions', function ($row) use ($updateModalId) {
                $isActive = (int) $row->status === 1;

                $tooltip = $isActive ? 'Delete' : 'Restore';
                $actionClass = $isActive
                    ? 'fm-action-delete'
                    : 'fm-action-restore';

                $actionIcon = $isActive
                    ? 'lni lni-trash-can'
                    : 'lni lni-reload';

                $editButton = $isActive
                    ? '<button
                            title="View/Edit"
                            aria-label="View/Edit"
                            data-id="' . $row->id . '"
                            type="button"
                            class="fm-action-btn fm-action-edit"
                            data-bs-toggle="modal"
                            data-bs-target="' . $updateModalId . '"
                            id="edit-button">
                            <i class="lni lni-pencil"></i>
                    </button>'
                    : '';

                $statusButton = '
                    <button
                        title="' . $tooltip . '"
                        aria-label="' . $tooltip . '"
                        data-id="' . $row->id . '"
                        type="button"
                        class="fm-action-btn ' . $actionClass . '"
                        id="delete-button">
                        <i class="' . $actionIcon . '"></i>
                    </button>';

                return '<div class="fm-actions">'
                    . $editButton
                    . $statusButton
                    . '</div>';
            });


            foreach ($additionalColumns as $column) {
                $dataTable->addColumn($column['name'], $column['callback']);
            }

            return $dataTable->rawColumns(array_merge(['status', 'actions']), $additionalRawColumns)->toJson();

    }
}
