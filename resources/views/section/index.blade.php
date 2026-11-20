
@extends('layouts.app')

@section('title')
    Section
@endsection

@section('content')
<div class="fm-page">

    {{-- Page Header --}}
    <div class="fm-page-header">
        <div class="fm-heading-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb fm-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/dashboard') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">Location Management</li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Section
                    </li>
                </ol>
            </nav>

            <div class="d-flex align-items-center gap-3">
                <div class="fm-heading-icon">
                    <i class="lni lni-grid-alt"></i>
                </div>
                <div>
                    <h2 class="fm-heading-title">{{ __('Section Management') }}</h2>
                    <p class="fm-heading-subtitle">
                        Manage sections and their assigned divisions.
                    </p>
                </div>
            </div>
        </div>

        <button type="button"
                class="btn fm-create-btn"
                data-bs-toggle="modal"
                data-bs-target="#addModal"
                id="openAddModal">
            <i class="lni lni-plus"></i>
            Add Section
        </button>
    </div>

    {{-- Section Table --}}
    <div class="fm-card">
        <div class="fm-card-header">
            <div class="fm-card-title-group">
                <div class="fm-card-title-icon">
                    <i class="lni lni-list"></i>
                </div>
                <div>
                    <h5 class="fm-card-title">Section Directory</h5>
                    <p class="fm-card-subtitle">
                        View and manage registered sections.
                    </p>
                </div>
            </div>
        </div>

        <div class="fm-table-container">
            <table id="table" class="table fm-table w-100">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Section</th>
                        <th>Department</th>
                        <th>Division</th>
                        <th>Added Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="fm-card-footer">
            <span>
                <i class="lni lni-information"></i>
                Use the action column to update or change a section's status.
            </span>
        </div>
    </div>

</div>

@include('section.modals.create')
@include('section.modals.edit')
@endsection

@section('scripts')
<script>
$(document).ready(function () {

    const escapeHtml = (value) => {
        return $('<div>').text(value ?? '').html();
    };

    const dataTable = $('#table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        ajax: {
            url: '/sections',
            type: 'GET'
        },
        order: [[1, 'asc']],
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'description',
                name: 'description',
                render: function (data, type) {
                    if (type !== 'display') {
                        return data ?? '';
                    }

                    return `
                        <div class="fm-name-cell">
                            <span class="fm-name-icon">
                                <i class="lni lni-grid-alt"></i>
                            </span>
                            <span>${escapeHtml(data)}</span>
                        </div>
                    `;
                }
            },
            {
                data: 'department',
                name: 'department'
            },
            {
                data: 'division',
                name: 'division'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'status',
                name: 'status',
                searchable: false,
                orderable: false
            },
            {
                data: 'actions',
                name: 'actions',
                searchable: false,
                orderable: false
            }
        ],
        language: {
            processing: 'Loading sections...',
            emptyTable: 'No sections found.',
            zeroRecords: 'No matching sections found.'
        }
    });

    const handleError = (xhr) => {
        if (xhr.status === 422 && xhr.responseJSON?.errors) {
            const errors = Object.values(xhr.responseJSON.errors)
                .flat()
                .map(error => $('<div>').text(error).html());

            Swal.fire({
                icon: 'warning',
                title: 'Please check your input',
                html: '<ul class="text-start mb-0"><li>' +
                    errors.join('</li><li>') +
                    '</li></ul>'
            });
        } else {
            console.error(xhr.responseJSON || xhr.responseText);

            Swal.fire({
                icon: 'error',
                title: 'Something went wrong',
                text: xhr.responseJSON?.message ||
                    'A server error occurred. Please try again.'
            });
        }
    };

    const addModal = bootstrap.Modal.getOrCreateInstance(
        document.getElementById('addModal')
    );

    const updateModal = bootstrap.Modal.getOrCreateInstance(
        document.getElementById('updateModal')
    );

    let sectionId = null;

    /**
     * Populate divisions belonging to a department.
     */
    const fetchDivision = (
        selectedDepartmentId,
        htmlDom = '#division_add',
        update = false,
        divisionID = null
    ) => {
        if (!selectedDepartmentId) {
            $(htmlDom).empty().append(
                '<option value="" selected disabled>Choose division</option>'
            );
            return;
        }

        $.ajax({
            type: 'GET',
            url: `/get-division-by-department/${encodeURIComponent(selectedDepartmentId)}`,
            success: function (response) {
                const $division = $(htmlDom);
                $division.empty();

                $division.append(
                    '<option value="" disabled>Choose division</option>'
                );

                response.forEach(division => {
                    $('<option>', {
                        value: division.id,
                        text: division.description
                    }).appendTo($division);
                });

                if (update && divisionID != null) {
                    $division.val(String(divisionID)).trigger('change');
                }
            },
            error: handleError
        });
    };

    // Update the division list when the create department changes.
    $('#department_add').on('change', function () {
        fetchDivision(this.value, '#division_add');
    });

    // Reset the create form whenever Add Section is opened.
    $('#openAddModal').on('click', function () {
        $('#add-form')[0].reset();

        $('#division_add').empty().append(
            '<option value="" selected disabled>Choose division</option>'
        );

        $('#department_add').val('').trigger('change');
    });

    // Create section.
    $('#add-form-submit').on('click', function () {
        const form = $('#add-form')[0];

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const $button = $(this);
        $button.prop('disabled', true);

        $.ajax({
            type: 'POST',
            url: '/sections',
            data: $('#add-form').serialize(),
            success: function (response) {
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success'
                });

                addModal.hide();
                form.reset();

                $('#division_add').empty().append(
                    '<option value="" selected disabled>Choose division</option>'
                );

                dataTable.ajax.reload(null, false);
            },
            error: handleError,
            complete: function () {
                $button.prop('disabled', false);
            }
        });
    });

    // Load section data into the edit modal.
    $('html').on('click', '#edit-button', function () {
        sectionId = $(this).attr('data-id');

        $.ajax({
            type: 'GET',
            url: `/sections/${sectionId}`,
            success: function (section) {
                $('#update-form #description').val(section.description);

                const departmentId = section.department_id;
                const divisionId = section.division?.id;

                const $department = $('#department_update');
                const $editDepartment = $('#update-form #department');

                $department.val(departmentId).trigger('change');
                $editDepartment.val(departmentId).trigger('change');

                fetchDivision(
                    departmentId,
                    '#division_update',
                    true,
                    divisionId
                );

                // Preserve the assigned department if it is archived.
                if (section.department && Number(section.department.status) !== 1) {
                    const existingOption = $editDepartment.find(
                        `option[value="${departmentId}"]`
                    );

                    if (!existingOption.length) {
                        $('<option>', {
                            value: departmentId,
                            text: section.department.description
                        }).appendTo($editDepartment);
                    }

                    $editDepartment.val(String(departmentId));
                }

                updateModal.show();
            },
            error: handleError
        });
    });

    // Update section.
    $('#update-form-submit').on('click', function () {
        const form = $('#update-form')[0];

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        if (!sectionId) {
            handleError({
                status: 0,
                responseJSON: {
                    message: 'Unable to identify the section to update.'
                }
            });
            return;
        }

        const $button = $(this);
        $button.prop('disabled', true);

        $.ajax({
            type: 'POST',
            url: `/sections/${sectionId}`,
            data: $('#update-form').serialize() + '&_method=PUT',
            success: function (response) {
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success'
                });

                updateModal.hide();
                form.reset();

                dataTable.ajax.reload(null, false);
            },
            error: handleError,
            complete: function () {
                $button.prop('disabled', false);
            }
        });
    });

    // Change section status.
    $('html').on('click', '#delete-button', function () {
        sectionId = $(this).attr('data-id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'Please confirm that you want to change this section’s status.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, do it!'
        }).then((result) => {
            if (!result.isConfirmed) {
                return;
            }

            $.ajax({
                type: 'DELETE',
                url: `/sections/${sectionId}`,
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success'
                    });

                    dataTable.ajax.reload(null, false);
                },
                error: handleError
            });
        });
    });

});
</script>
@endsection
