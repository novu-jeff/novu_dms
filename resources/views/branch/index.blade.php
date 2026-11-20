
@extends('layouts.app')

@section('title', 'Branch Management')

@section('content')
<div class="fm-page">

    {{-- Page heading --}}
    <div class="fm-page-header">
        <div>
            <div class="fm-breadcrumb">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <i class="lni lni-chevron-right"></i>
                <span>Location Management</span>
                <i class="lni lni-chevron-right"></i>
                <span class="fm-breadcrumb-active">Branch</span>
            </div>

            <div class="fm-heading-title">
                <div class="fm-heading-icon">
                    <i class="lni lni-apartment"></i>
                </div>
                <div>
                    <h2>Branch Management</h2>
                    <p>Manage organizational branches and their status.</p>
                </div>
            </div>
        </div>

        <button type="button"
                class="fm-create-btn"
                data-bs-toggle="modal"
                data-bs-target="#addModal">
            <i class="lni lni-plus"></i>
            <span>Add Branch</span>
        </button>
    </div>

    {{-- Branch table --}}
    <div class="fm-card">

        <div class="fm-card-header">
            <div>
                <h5>Branches</h5>
                <p>View and manage registered branches.</p>
            </div>

            <div class="fm-card-header-icon">
                <i class="lni lni-list"></i>
            </div>
        </div>

        <div class="fm-table-container">
            <table id="table" class="table fm-table align-middle w-100">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Branch Description</th>
                        <th>Added Date</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="fm-card-footer">
            <span>
                <i class="lni lni-information"></i>
                Use the action buttons to edit a branch or change its status.
            </span>
        </div>

    </div>
</div>

@include('branch.modals.create')
@include('branch.modals.edit')
@endsection

@section('scripts')
<script>
$(document).ready(function () {

    const dataTable = $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/branches',
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
                render: function (data) {
                    return `
                        <div class="fm-name-cell">
                            <div class="fm-name-icon">
                                <i class="lni lni-apartment"></i>
                            </div>
                            <span>${escapeHtml(data ?? '')}</span>
                        </div>
                    `;
                }
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
            search: '',
            searchPlaceholder: 'Search branches...',
            lengthMenu: 'Show _MENU_ entries',
            emptyTable: 'No branches found',
            zeroRecords: 'No matching branches found',
            processing: 'Loading branches...'
        },
        drawCallback: function () {
            $('#table').addClass('fm-table-ready');
        }
    });

    function escapeHtml(value) {
        return String(value).replace(/[&<>"']/g, function (char) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[char];
        });
    }

    const handleError = (xhr) => {
        if (xhr.status === 422 && xhr.responseJSON?.errors) {
            let errorsHtml = '<ul class="text-start mb-0">';

            $.each(xhr.responseJSON.errors, function (key, value) {
                errorsHtml += '<li>' + escapeHtml(value[0]) + '</li>';
            });

            errorsHtml += '</ul>';

            Swal.fire({
                icon: 'warning',
                title: 'Please check your input',
                html: errorsHtml
            });
        } else {
            console.error(xhr.responseJSON || xhr.responseText);

            Swal.fire({
                icon: 'error',
                title: 'Something went wrong',
                text: xhr.responseJSON?.message ||
                    'Unable to complete the request. Please try again.'
            });
        }
    };

    const addModal = bootstrap.Modal.getOrCreateInstance(
        document.getElementById('addModal')
    );

    const updateModal = bootstrap.Modal.getOrCreateInstance(
        document.getElementById('updateModal')
    );

    // Reset the Add form when opening the modal.
    $('#addModal').on('show.bs.modal', function () {
        $('#add-form')[0].reset();
    });

    // Add branch.
    $('#add-form-submit').on('click', function () {
        const form = $('#add-form')[0];

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        $.ajax({
            type: 'POST',
            url: '/branches',
            data: $('#add-form').serialize(),
            success: function (response) {
                addModal.hide();
                form.reset();
                dataTable.ajax.reload(null, false);

                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success'
                });
            },
            error: handleError
        });
    });

    let branchId = null;

    // Load branch details into the Edit modal.
    $('html').on('click', '#edit-button', function () {
        branchId = $(this).attr('data-id');

        $.ajax({
            type: 'GET',
            url: '/branches/' + branchId,
            success: function (response) {
                $('#update-form #description').val(response.description);
            },
            error: handleError
        });
    });

    // Update branch.
    $('#update-form-submit').on('click', function () {
        const form = $('#update-form')[0];

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const formData = $('#update-form').serialize() + '&_method=PUT';

        $.ajax({
            type: 'POST',
            url: '/branches/' + branchId,
            data: formData,
            success: function (response) {
                updateModal.hide();
                form.reset();
                dataTable.ajax.reload(null, false);

                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success'
                });
            },
            error: handleError
        });
    });

    // Delete or restore branch.
    $('html').on('click', '#delete-button', function () {
        branchId = $(this).attr('data-id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'This will change the branch status.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#315cce',
            cancelButtonColor: '#98a2b3',
            confirmButtonText: 'Yes, continue',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (!result.isConfirmed) {
                return;
            }

            $.ajax({
                type: 'DELETE',
                url: '/branches/' + branchId,
                success: function (response) {
                    dataTable.ajax.reload(null, false);

                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success'
                    });
                },
                error: handleError
            });
        });
    });

});
</script>
@endsection
