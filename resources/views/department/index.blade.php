@extends('layouts.app')

@section('title') Department @endsection

@section('content')
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">

        <div class="breadcrumb-wrapper">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#!">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Folder
                    </li>
                </ol>
            </nav>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="title mb-30">
                    <h2>{{ __('Folder Management') }}</h2>
                </div>
            </div>
            <div>
                <!-- Button trigger modal -->
                <button type="button" class="main-btn primary-btn btn-hover w-100 text-center btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
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
                                        <th><h6>Branch</h6></th>
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

    @include('department.modals.create')
    @include('department.modals.edit')
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {

            let dataTable = $('#table').DataTable({
                ajax: {
                    processing: true,
                    serverSide: true,
                    url: '/departments',
                    type: 'GET',
                    "order": [[1,'desc']]
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: true },
                    { data: 'description', name: 'description' },
                    { data: 'branch', name: 'branch' },
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

            // Ajax
            // Add record
            $('#add-form-submit').click(function () {
                // Serialize the form data
                var formData = $('#add-form').serialize();

                // Perform the Ajax request
                $.ajax({
                    type: 'POST',
                    url: '/departments',
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

            let departmentId;

            $('html').on('click', '#edit-button', function () {

                departmentId = $(this).attr('data-id');

                $.ajax({
                    type: 'GET',
                    url: `/departments/${departmentId}`,
                    success: function (response) {

                        let department = response;
                        let isArchived = department.branch.status !== 1;

                        $.ajax({
                            type: 'GET',
                            url: `/branches/all`,
                            success: function (response) {
                                $('#update-form #branch').empty();

                                response.forEach(branch => {
                                    $('#update-form #branch').append(`<option value="${branch.id}">${branch.description}</option>`)
                                });

                                $('#update-form #description').val(department.description);

                                $('#update-form #branch').val(department.branch_id).change();

                                if (isArchived) {
                                    $('#update-form #branch').append(`<option selected value="" disabled>${department.branch.description}</option>`)
                                }
                            }
                        })
                        //
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
                    url: '/departments/' + departmentId,
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

                departmentId = $(this).attr('data-id');

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
                            url: '/departments/' + departmentId, // Change the URL to match your Laravel route
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
