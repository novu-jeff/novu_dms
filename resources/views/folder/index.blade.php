@extends('layouts.app')

@section('content')
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
        <div class="breadcrumb-wrapper">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Dashboard</a>
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
                <button type="button" id="openAddModal" class="main-btn primary-btn btn-hover w-100 text-center btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
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
                                        <th><h6>Name</h6></th>
                                        <th><h6>Branch</h6></th>
                                        <th><h6>Department</h6></th>
                                        <th><h6>Division</h6></th>
                                        <th><h6>Section</h6></th>
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

    @include('folder.modals.create')
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {

            let dataTable = $('#table').DataTable({
                ajax: {
                    processing: true,
                    serverSide: true,
                    url: '/folders',
                    type: 'GET',
                    "order": [[1,'desc']]
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: true },
                    { data: 'name', name: 'name' },
                    { data: 'branch', name: 'branch' },
                    { data: 'department', name: 'department' },
                    { data: 'division', name: 'division' },
                    { data: 'section', name: 'section' },
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

            // Open Modal
            $('#openAddModal').click(e => {

                $('#add-form-submit').show();
                $('#update-form-submit').hide();

                $('#modal-title').html('Add Folder');

                $('#division').empty();
                $('#department').empty();
                $('#section').empty();

                $('#division').append('<option selected disabled>Choose division</option>');
                $('#department').append('<option selected disabled>Choose department</option>');
                $('#section').append('<option selected disabled>Choose section</option>');

                $('#branch').val('').change();
                $('#department').val('').change();
                $('#division').val('').change();
                $('#section').val('').change();
            })

            // For Select box
            $('select[name="branch"]').change(e => {

                let branch = e.target.value;

                if(branch === '' || branch == null) return;

                // Reset
                $('#division').empty();
                $('#department').empty();
                $('#section').empty();

                $('#division').append('<option selected disabled>Choose division</option>');
                $('#department').append('<option selected disabled>Choose department</option>');
                $('#section').append('<option selected disabled>Choose section</option>');

                $('#department').val('').change();
                $('#division').val('').change();
                $('#section').val('').change();

                $.ajax({
                    type: 'GET',
                    url: `/get-department-by-branch/${branch}`,
                    success: function (response) {
                        let departmentElement = $('#department');

                        departmentElement.empty();
                        departmentElement.append('<option selected disabled>Choose division</option>');

                        response.forEach(department => {
                            departmentElement.append(`<option value="${department.id}">${department.description}</option>`)
                        });
                    },
                    error: function (xhr) {
                        handleError(xhr)
                    }
                })
            });

            $('select[name="department"]').change(e => {
                let departmentId = e.target.value;

                if(departmentId === '' || departmentId == null) return;

                $.ajax({
                    type: 'GET',
                    url: `/get-division-by-department/${departmentId}`,
                    success: function (response) {
                        let divisionElement = $('#division');

                        divisionElement.empty();
                        divisionElement.append('<option selected disabled>Choose division</option>');

                        response.forEach(division => {
                            divisionElement.append(`<option value="${division.id}">${division.description}</option>`)
                        });
                    },
                    error: function (xhr) {
                        handleError(xhr)
                    }
                })
            });

            $('select[name="division"]').change(e => {
                let divisionId = e.target.value;
                let departmentId = $('#department').val();

                if(divisionId === '' || divisionId == null) return;

                $.ajax({
                    type: 'GET',
                    url: `/get-section-by-division-and-department`,
                    data: {
                        department: departmentId,
                        division: divisionId,
                    },
                    success: function (response) {
                        let sectionElement = $('#section');

                        sectionElement.empty();
                        sectionElement.append('<option selected disabled>Choose section</option>');

                        response.forEach(section => {
                            sectionElement.append(`<option value="${section.id}">${section.description}</option>`)
                        });
                    },
                    error: function (xhr) {
                        handleError(xhr)
                    }
                })
            })

            // Ajax
            // Add record
            $('#add-form-submit').click(function () {
                // Serialize the form data
                var formData = $('#add-form').serialize();

                // Perform the Ajax request
                $.ajax({
                    type: 'POST',
                    url: '/folders',
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

            let folderId;

            $('html').on('click', '#edit-button', function () {

                folderId = $(this).attr('data-id');
                $('#add-form-submit').hide();
                $('#update-form-submit').show();
                $('#modal-title').html('Update Folder');

                $.ajax({
                    type: 'GET',
                    url: `/folders/${folderId}`,
                    success: function (response) {

                        const folder = response;
                        $('input[name="name"]').val(response.name);
                        fetchAllBranches(folder.branch.id);
                        fetchAllDepartmentByBranchId(folder.branch.id, folder.department.id);
                        fetchAllDivisionByDepartment(folder.department.id, folder.division.id);
                        fetchAllSectionByDepartmentAndDivision(folder.department.id, folder.division.id, folder.section.id);

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
                    url: '/folders/' + branchId,
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

                folderId = $(this).attr('data-id');

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
                            url: '/folders/' + folderId, // Change the URL to match your Laravel route
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

                    }
                });
        });

             const fetchAllBranches = (branchId) => {
                 $.ajax({
                     type: 'GET',
                     url: '/branches/all',
                     success: function (response) {
                         $('#branch').empty();
                         $('#branch').append('<option selected disabled>Choose branch</option>');

                         response.forEach(branch => {
                             if(branchId === branch.id) {
                                 $('#branch').append(`<option selected value="${branch.id}">${branch.description}</option>`)
                             } else {
                                 $('#branch').append(`<option value="${branch.id}">${branch.description}</option>`)
                             }
                         });
                     }
                 })
             }

            const fetchAllDepartmentByBranchId = (branchId, departmentId) => {
                $.ajax({
                    type: 'GET',
                    url: `/get-department-by-branch/${branchId}`,
                    success: function (response) {
                        $('#department').empty();
                        $('#department').append('<option selected disabled>Choose department</option>');
                        response.forEach(department => {
                            if(departmentId === department.id) {
                                $('#department').append(`<option selected value="${department.id}">${department.description}</option>`)
                            } else {
                                $('#department').append(`<option value="${department.id}">${department.description}</option>`)
                            }
                        });
                    }
                });
            };

            const fetchAllDivisionByDepartment = (departmentId, divisionId) => {
                $.ajax({
                    type: 'GET',
                    url: `/get-division-by-department/${departmentId}`,
                    success: function (response) {
                        $('#division').empty();
                        $('#division').append('<option selected disabled>Choose department</option>');
                        response.forEach(division => {
                            if(divisionId === division.id) {
                                $('#division').append(`<option selected value="${division.id}">${division.description}</option>`)
                            } else {
                                $('#division').append(`<option value="${division.id}">${division.description}</option>`)
                            }
                        });
                    }
                });
            };

            const fetchAllSectionByDepartmentAndDivision = (departmentId, divisionId, sectionId) => {
                $.ajax({
                    type: 'GET',
                    url: `/get-section-by-division-and-department`,
                    data: {
                        department: departmentId,
                        division: divisionId,
                    },
                    success: function (response) {
                        $('#section').empty();
                        $('#section').append('<option selected disabled>Choose department</option>');
                        response.forEach(section => {
                            if(sectionId === section.id) {
                                $('#section').append(`<option selected value="${section.id}">${section.description}</option>`)
                            } else {
                                $('#section').append(`<option value="${section.id}">${section.description}</option>`)
                            }
                        });
                    }
                });
            };

        });
    </script>
@endsection
