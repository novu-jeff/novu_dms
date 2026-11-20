
@extends('layouts.app')

@section('title')
    Department
@endsection

@section('content')
    <div class="fm-page">

        {{-- Page Header --}}
        <div class="fm-page-header">
            <div class="fm-page-heading">
                <div class="fm-breadcrumb">
                    <a href="#!">Home</a>
                    <i class="lni lni-chevron-right"></i>
                    <a href="#!">Location Management</a>
                    <i class="lni lni-chevron-right"></i>
                    <span>Department</span>
                </div>

                <div class="fm-heading-content">
                    <div class="fm-heading-icon">
                        <i class="lni lni-apartment"></i>
                    </div>

                    <div>
                        <h2 class="fm-heading-title">Department Management</h2>
                        <p class="fm-heading-subtitle">
                            Manage departments and their assigned branches.
                        </p>
                    </div>
                </div>
            </div>

            <button
                type="button"
                class="btn fm-create-btn"
                data-bs-toggle="modal"
                data-bs-target="#addModal"
            >
                <i class="lni lni-plus"></i>
                <span>Add Department</span>
            </button>
        </div>

        {{-- Department Table --}}
        <div class="fm-card">
            <div class="fm-card-header">
                <div class="fm-card-title-group">
                    <div class="fm-card-title-icon">
                        <i class="lni lni-list"></i>
                    </div>

                    <div>
                        <h5 class="fm-card-title">Department Directory</h5>
                        <p class="fm-card-subtitle">
                            View and manage registered departments.
                        </p>
                    </div>
                </div>
            </div>

            <div class="fm-table-container">
                <table id="table" class="table fm-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Department</th>
                            <th>Branch</th>
                            <th>Added Date</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="fm-card-footer">
                <span>
                    <i class="lni lni-information"></i>
                    Department records are managed through this directory.
                </span>
            </div>
        </div>

    </div>

    @include('department.modals.create')
    @include('department.modals.edit')
@endsection

@section('scripts')
<script>
    $(document).ready(function () {

        /**
         * Escape values before inserting text into HTML.
         */
        const escapeHtml = (value) => {
            return $('<div>').text(value ?? '').html();
        };

        /**
         * DataTable initialization.
         */
        let dataTable = $('#table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            ajax: {
                url: '/departments',
                type: 'GET'
            },
            order: [[1, 'asc']],
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: true,
                    width: '65px'
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
                                <div class="fm-name-icon">
                                    <i class="lni lni-apartment"></i>
                                </div>
                                <span>${escapeHtml(data)}</span>
                            </div>
                        `;
                    }
                },
                {
                    data: 'branch',
                    name: 'branch'
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
                    orderable: false,
                    className: 'text-center'
                }
            ],
            language: {
                emptyTable: 'No departments have been registered yet.',
                zeroRecords: 'No matching departments found.',
                processing: 'Loading departments...'
            },
            drawCallback: function () {
                $('#table').addClass('fm-table-ready');
            }
        });

        /**
         * Centralized AJAX error handling.
         */
        const handleError = (xhr) => {
            if (xhr.status === 422 && xhr.responseJSON?.errors) {
                let errorsHtml = '<ul class="fm-validation-list">';

                $.each(xhr.responseJSON.errors, function (key, value) {
                    errorsHtml += `<li>${escapeHtml(value[0])}</li>`;
                });

                errorsHtml += '</ul>';

                Swal.fire({
                    icon: 'warning',
                    title: 'Please check your input',
                    html: errorsHtml
                });

                return;
            }

            console.error(xhr.responseJSON || xhr.responseText);

            Swal.fire({
                icon: 'error',
                title: 'Something went wrong',
                text: xhr.responseJSON?.message ||
                    'The server could not complete your request. Please try again.'
            });
        };

        /**
         * Bootstrap modal instances.
         */
        const addModalElement = document.getElementById('addModal');
        const updateModalElement = document.getElementById('updateModal');

        const addModal = addModalElement
            ? bootstrap.Modal.getOrCreateInstance(addModalElement)
            : null;

        const updateModal = updateModalElement
            ? bootstrap.Modal.getOrCreateInstance(updateModalElement)
            : null;

        /**
         * Validate forms before submitting.
         */
        const isFormValid = (formSelector) => {
            const form = $(formSelector)[0];

            if (!form) {
                return false;
            }

            if (!form.checkValidity()) {
                form.reportValidity();
                return false;
            }

            return true;
        };

        /**
         * Add department.
         */
        $('#add-form-submit').on('click', function (event) {
            event.preventDefault();

            if (!isFormValid('#add-form')) {
                return;
            }

            const formData = $('#add-form').serialize();
            const submitButton = $(this);

            submitButton.prop('disabled', true);

            $.ajax({
                type: 'POST',
                url: '/departments',
                data: formData,

                success: function (response) {
                    Swal.fire({
                        title: 'Department Created',
                        text: response.message,
                        icon: 'success'
                    });

                    if (addModal) {
                        addModal.hide();
                    }

                    $('#add-form')[0].reset();
                    dataTable.ajax.reload(null, false);
                },

                error: function (xhr) {
                    handleError(xhr);
                },

                complete: function () {
                    submitButton.prop('disabled', false);
                }
            });
        });

        let departmentId;

        /**
         * Load department information for editing.
         */
        $('html').on('click', '#edit-button', function () {
            departmentId = $(this).attr('data-id');

            $.ajax({
                type: 'GET',
                url: `/departments/${departmentId}`,

                success: function (department) {
                    const loadBranches = $.ajax({
                        type: 'GET',
                        url: '/branches/all'
                    });

                    loadBranches.done(function (branches) {
                        const branchSelect = $('#update-form #branch');

                        branchSelect.empty();

                        let currentBranchExists = branches.some(function (branch) {
                            return String(branch.id) === String(department.branch_id);
                        });

                        branches.forEach(function (branch) {
                            branchSelect.append(
                                new Option(
                                    branch.description,
                                    branch.id
                                )
                            );
                        });

                        // Preserve the current branch if it is archived
                        // and therefore absent from the active branch list.
                        if (!currentBranchExists && department.branch) {
                            const archivedOption = new Option(
                                department.branch.description +
                                    ' (Archived)',
                                department.branch_id
                            );

                            branchSelect.append(archivedOption);
                        }

                        $('#update-form #description')
                            .val(department.description);

                        branchSelect
                            .val(String(department.branch_id))
                            .trigger('change');
                    });

                    loadBranches.fail(function (xhr) {
                        handleError(xhr);
                    });
                },

                error: function (xhr) {
                    handleError(xhr);
                }
            });
        });

        /**
         * Update department.
         */
        $('#update-form-submit').on('click', function (event) {
            event.preventDefault();

            if (!isFormValid('#update-form')) {
                return;
            }

            if (!departmentId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No department selected',
                    text: 'Please select a department to update.'
                });

                return;
            }

            const formData =
                $('#update-form').serialize() + '&_method=PUT';

            const submitButton = $(this);

            submitButton.prop('disabled', true);

            $.ajax({
                type: 'POST',
                url: `/departments/${departmentId}`,
                data: formData,

                success: function (response) {
                    Swal.fire({
                        title: 'Department Updated',
                        text: response.message,
                        icon: 'success'
                    });

                    if (updateModal) {
                        updateModal.hide();
                    }

                    $('#update-form')[0].reset();
                    dataTable.ajax.reload(null, false);
                },

                error: function (xhr) {
                    handleError(xhr);
                },

                complete: function () {
                    submitButton.prop('disabled', false);
                }
            });
        });

        /**
         * Change department status.
         * Existing backend DELETE route is preserved.
         */
        $('html').on('click', '#delete-button', function () {
            departmentId = $(this).attr('data-id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to change the status of this department?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#315cce',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, continue',
                cancelButtonText: 'Cancel'
            }).then(function (result) {
                if (!result.isConfirmed) {
                    return;
                }

                $.ajax({
                    type: 'DELETE',
                    url: `/departments/${departmentId}`,

                    success: function (response) {
                        Swal.fire({
                            title: 'Status Updated',
                            text: response.message,
                            icon: 'success'
                        });

                        dataTable.ajax.reload(null, false);
                    },

                    error: function (xhr) {
                        handleError(xhr);
                    }
                });
            });
        });

        /**
         * Reset forms when their respective modal is closed.
         */
        if (addModalElement) {
            addModalElement.addEventListener('hidden.bs.modal', function () {
                $('#add-form')[0]?.reset();
            });
        }

        if (updateModalElement) {
            updateModalElement.addEventListener('hidden.bs.modal', function () {
                $('#update-form')[0]?.reset();
                departmentId = null;
            });
        }
    });
</script>
@endsection
