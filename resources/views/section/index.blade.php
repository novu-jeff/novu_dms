@extends('layouts.app')

@section('title') Section @endsection

@section('content')


    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">

        <div class="breadcrumb-wrapper">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#0">Location Management</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Section
                    </li>
                </ol>
            </nav>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="title mb-30">
                    <h2>{{ __('Section Management') }}</h2>
                </div>
            </div>
            <div>
                <!-- Button trigger modal -->
                <button type="button" class="main-btn primary-btn btn-hover w-100 text-center btn-sm" data-bs-toggle="modal" data-bs-target="#addModal" id="openAddModal">
                    Add
                    <span class="fs-5">+</span>
                </button>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- ========== title-wrapper end ========== -->

    <div class="tables-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="table-responsive">
                        <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                            <div class="dataTable-container">
                                <table id="table" class="table dataTable-table">
                                    <thead>
                                    <tr>
                                        <th><h6>No.</h6></th>
                                        <th><h6>Description</h6></th>
                                        <th><h6>Department</h6></th>
                                        <th><h6>Division</h6></th>
                                        <th><h6>Added Date</h6></th>
                                        <th><h6>Status</h6></th>
                                        <th><h6>Action</h6></th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>

    @include('section.modals.create')
    @include('section.modals.edit')
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {

            let dataTable = $('#table').DataTable({
                ajax: {
                    processing: true,
                    serverSide: true,
                    url: '/sections',
                    type: 'GET',
                    "order": [[1,'desc']]
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: true },
                    { data: 'description', name: 'description' },
                    { data: 'department', name: 'department' },
                    { data: 'division', name: 'division' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'status', name: 'status', searchable: false, orderable: false },
                    { data: 'actions', searchable: false, orderable: false },
                ]
            });

            const handleError = (xhr) => {
                if(xhr.status === 422) {
                    let errorsHtml = "<ul>";
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        errorsHtml += "<li>" + value[0] + "</li>";
                    });

                    Swal.fire({
                        icon: "warning",
                        title: "Oops...",
                        html: errorsHtml,
                    });
                } else {
                    console.error(xhr.responseJSON)
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Server Error: Something went wrong!",
                    });
                }
            }

            let addModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('addModal'));

            let updateModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('updateModal'));


            const fetchDivision = (selectedDepartmentId, htmlDom = '#division_add', update = false, divisionID) => {
                $.ajax({
                    type: 'GET',
                    url: `/get-division-by-department/${selectedDepartmentId}`,
                    success: function (response) {
                        $(htmlDom).empty();
                        response.forEach(division => {
                            $(htmlDom).append(`<option value="${division.id}">${division.description}</option>`);
                        });

                        // For Update
                        if(update && divisionID != null) {
                            $(htmlDom).val(divisionID).change();
                        }

                        return response;
                    }
                })
            }

            let selectedDepartmentId = null;
            $('#department_add').change(e => {
                selectedDepartmentId = e.target.value;
                if(selectedDepartmentId != null || selectedDepartmentId !== '') {
                    fetchDivision(selectedDepartmentId);
                }
            })

            // Open Modal
            $('#openAddModal').click(e => {
                $('#division_add').empty();
                $('#division_add').append('<option selected disabled>Choose division</option>');

                $('#department_add').val('').change();
            })

            // Ajax
            // Add record
            $('#add-form-submit').click(function () {
                // Serialize the form data
                var formData = $('#add-form').serialize();

                // Perform the Ajax request
                $.ajax({
                    type: 'POST',
                    url: '/sections',
                    data: formData,
                    success: function (response) {
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success"
                        });
                        addModal.hide();
                        $('#add-form')[0].reset();
                        dataTable.ajax.reload();
                    },
                    error: function (xhr) {
                        handleError(xhr);
                    }
                });
            });

            let sectionId;

            $('html').on('click', '#edit-button', function () {

                sectionId = $(this).attr('data-id');

                $.ajax({
                    type: 'GET',
                    url: `/sections/${sectionId}`,
                    success: function (response) {

                        let section = response;
                        let isArchived = section.department.status !== 1;
                        $('#department_update').val(section.department_id).change();

                        fetchDivision(section.department_id, '#division_update', true, response.division.id);

                        $('#update-form #description').val(section.description);

                        $('#update-form #department').val(section.department_id).change();

                        if (isArchived) {
                            $('#update-form #department').append(`<option selected value="" disabled>${section.department.description}</option>`)
                        }
                    },
                    error: function (xhr) {
                        handleError(xhr);
                    }
                });
            });

            $('#update-form-submit').click(function () {
                // Serialize the form data
                var formData = $('#update-form').serialize() + '&_method=PUT';

                // Perform the Ajax request
                $.ajax({
                    type: 'POST',
                    url: '/sections/' + sectionId,
                    data: formData,
                    success: function (response) {
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success"
                        });
                        updateModal.hide();
                        $('#update-form')[0].reset();
                        dataTable.ajax.reload();
                    },
                    error: function (xhr) {
                        handleError(xhr);
                    }
                });
            });

            // Delete record
            $('html').on('click', '#delete-button', function () {

                sectionId = $(this).attr('data-id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "Please confirm to change the status!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, do it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Perform delete request
                        $.ajax({
                            type: 'DELETE',
                            url: '/sections/' + sectionId, // Change the URL to match your Laravel route
                            success: function (response) {
                                Swal.fire({
                                    title: "Success!",
                                    text: response.message,
                                    icon: "success"
                                });
                                addModal.hide();
                                $('#update-form')[0].reset();
                                dataTable.ajax.reload();
                            },
                            error: function (xhr) {
                                chandleError(xhr);
                            }
                        });

                    }
                });
            });

        });
    </script>
@endsection
