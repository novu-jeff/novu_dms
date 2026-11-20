
@extends('layouts.app')

@section('title')
    Division
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
                    <span>Division</span>
                </div>

                <div class="fm-heading-content">
                    <div class="fm-heading-icon">
                        <i class="lni lni-layers"></i>
                    </div>

                    <div>
                        <h2 class="fm-heading-title">Division Management</h2>
                        <p class="fm-heading-subtitle">
                            Manage divisions and their assigned departments.
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
                <span>Add Division</span>
            </button>
        </div>

        {{-- Division Table --}}
        <div class="fm-card">
            <div class="fm-card-header">
                <div class="fm-card-title-group">
                    <div class="fm-card-title-icon">
                        <i class="lni lni-list"></i>
                    </div>

                    <div>
                        <h5 class="fm-card-title">Division Directory</h5>
                        <p class="fm-card-subtitle">
                            View and manage registered divisions.
                        </p>
                    </div>
                </div>
            </div>

            <div class="fm-table-container">
                <table id="table" class="table fm-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Division</th>
                            <th>Department</th>
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
                    Division records are managed through this directory.
                </span>
            </div>
        </div>

    </div>

    @include('division.modals.create')
    @include('division.modals.edit')
@endsection

@section('scripts')
<script>
    $(document).ready(function () {

        /**
         * Escape text before rendering it as HTML.
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
                url: '/divisions',
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
                                    <i class="lni lni-layers"></i>
                                </div>
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
                emptyTable: 'No divisions have been registered yet.',
                zeroRecords: 'No matching divisions found.',
                processing: 'Loading divisions...'
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
         * Validate forms before submission.
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
         * Add division.
         */
        $('#add-form-submit').on('click', function (event) {
            event.preventDefault();

            if (!isFormValid('#add-form')) {
                return;
            }

            const submitButton = $(this);
            const formData = $('#add-form').serialize();

            submitButton.prop('disabled', true);

            $.ajax({
                type: 'POST',
                url: '/divisions',
                data: formData,

                success: function (response) {
                    Swal.fire({
                        title: 'Division Created',
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

        let divisionId;

        /**
         * Load division details for editing.
         */
        $('html').on('click', '#edit-button', function () {
            divisionId = $(this).attr('data-id');

            $.ajax({
                type: 'GET',
                url: `/divisions/${divisionId}`,

                success: function (division) {
                    $.ajax({
                        type: 'GET',
                        url: '/departments/all',

                        success: function (departments) {
                            const departmentSelect =
                                $('#update-form #department');

                            departmentSelect.empty();

                            const currentDepartmentExists =
                                departments.some(function (department) {
                                    return String(department.id) ===
                                        String(division.department_id);
                                });

                            departments.forEach(function (department) {
                                departmentSelect.append(
                                    new Option(
                                        department.description,
                                        department.id
                                    )
                                );
                            });

                            // Preserve the assigned department if it is
                            // archived and missing from the active list.
                            if (
                                !currentDepartmentExists &&
                                division.department
                            ) {
                                departmentSelect.append(
                                    new Option(
                                        division.department.description +
                                            ' (Archived)',
                                        division.department_id
                                    )
                                );
                            }

                            $('#update-form #description')
                                .val(division.description);

                            departmentSelect
                                .val(String(division.department_id))
                                .trigger('change');
                        },

                        error: function (xhr) {
                            handleError(xhr);
                        }
                    });
                },

                error: function (xhr) {
                    handleError(xhr);
                }
            });
        });

        /**
         * Update division.
         */
        $('#update-form-submit').on('click', function (event) {
            event.preventDefault();

            if (!isFormValid('#update-form')) {
                return;
            }

            if (!divisionId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No division selected',
                    text: 'Please select a division to update.'
                });

                return;
            }

            const submitButton = $(this);
            const formData =
                $('#update-form').serialize() + '&_method=PUT';

            submitButton.prop('disabled', true);

            $.ajax({
                type: 'POST',
                url: `/divisions/${divisionId}`,
                data: formData,

                success: function (response) {
                    Swal.fire({
                        title: 'Division Updated',
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
         * Change division status.
         * Existing DELETE endpoint is preserved.
         */
        $('html').on('click', '#delete-button', function () {
            divisionId = $(this).attr('data-id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to change the status of this division?',
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
                    url: `/divisions/${divisionId}`,

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
         * Reset forms after modal closure.
         */
        if (addModalElement) {
            addModalElement.addEventListener('hidden.bs.modal', function () {
                $('#add-form')[0]?.reset();
            });
        }

        if (updateModalElement) {
            updateModalElement.addEventListener('hidden.bs.modal', function () {
                $('#update-form')[0]?.reset();
                divisionId = null;
            });
        }
    });
</script>
@endsection
