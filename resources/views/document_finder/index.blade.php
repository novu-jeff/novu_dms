@extends('layouts.app')

@section('title', 'Document Finder')
@section('page-heading', 'Document Finder')

@section('content')
    <!-- ========== title-wrapper start ========== -->
    <div class="df-page">
    <div class="df-page-header">
        <div>
            <div class="df-eyebrow">WORKSPACE / DOCUMENTS</div>
            <h2>Document Finder</h2>
            <p>Search, access, and manage documents in your repository.</p>
        </div>
    </div>

    <div class="df-search-card">
        <form action="{{ route('document_finder.index') }}" method="GET">
            <label for="search" class="df-search-label">Search documents</label>

            <div class="df-search-row">
                <div class="df-search-input-wrap">
                    <i class="lni lni-search-alt"></i>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ request('search') }}"
                        class="form-control @error('search') is-invalid @enderror"
                        placeholder="Search by title, author, tags..."
                    >
                </div>

                <button type="submit" class="df-search-button">
                    <i class="lni lni-search-alt"></i>
                    Search
                </button>

                @if(request('search'))
                    <a href="{{ route('document_finder.index') }}"
                       class="df-clear-button">Clear</a>
                @endif
            </div>

            @error('search')
                <span class="invalid-feedback d-block" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </form>
    </div>

    <div class="df-results-heading">
        <div>
            <h3>Document Repository</h3>
            <p>
                @if(request('search'))
                    Results for <strong>{{ request('search') }}</strong>
                @else
                    Browse available document records
                @endif
            </p>
        </div>
    </div>

   
<div class="fm-document-results">
    @forelse($documents as $doc)
        <article class="fm-document-card" id="document-{{ $doc->id }}">

            <!-- Document Header -->
            <div class="fm-document-card-header">
                <div class="fm-document-heading">
                    <div class="fm-document-icon">
                        <i class="lni lni-files" aria-hidden="true"></i>
                    </div>

                    <div class="fm-document-heading-content">
                        <h4 class="fm-document-title">
                            {{ $doc->title }}
                        </h4>

                        <div class="fm-document-meta">
                            <span>
                                <i class="lni lni-user" aria-hidden="true"></i>
                                {{ $doc->author ?: 'Unknown author' }}
                            </span>

                            <span class="fm-document-meta-divider"></span>

                            <span>
                                <i class="lni lni-calendar" aria-hidden="true"></i>
                                {{ \Illuminate\Support\Carbon::parse($doc->created_at)->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="dropdown fm-document-actions">
                    <button
                        class="fm-document-action-toggle"
                        type="button"
                        id="document-actions-{{ $doc->id }}"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        aria-label="Actions for {{ $doc->title }}"
                    >
                        <i class="lni lni-more-alt" aria-hidden="true"></i>
                    </button>

                    <ul
                        class="dropdown-menu dropdown-menu-end fm-document-action-menu"
                        aria-labelledby="document-actions-{{ $doc->id }}"
                    >
                        <li>
                            <a
                                id="edit-document-btn"
                                class="dropdown-item"
                                data-id="{{ $doc->id }}"
                                href="#!"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal"
                            >
                                <i class="lni lni-pencil" aria-hidden="true"></i>
                                Edit Document
                            </a>
                        </li>

                        <li>
                            <a
                                id="change-permission-btn"
                                class="dropdown-item"
                                data-id="{{ $doc->id }}"
                                href="#!"
                                data-bs-toggle="modal"
                                data-bs-target="#exampleModal"
                            >
                                <i class="lni lni-lock" aria-hidden="true"></i>
                                Change Permission
                            </a>
                        </li>

                        <li>
                            <a
                                id="manage-files-btn"
                                class="dropdown-item"
                                data-document-id="{{ $doc->id }}"
                                data-folder-id="{{ $doc->folder_id }}"
                                data-id="{{ $doc->id }}"
                                href="#!"
                                data-bs-toggle="modal"
                                data-bs-target="#manage-files-modal"
                            >
                                <i class="lni lni-folder" aria-hidden="true"></i>
                                Manage Files
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Document Details -->
            <div class="fm-document-card-body">
                <div class="fm-document-access">
                    <span class="fm-document-access-label">
                        Access Level
                    </span>

                    <span id="document-access-{{ $doc->id }}">
                        @if ($doc->document_access == 1)
                            <span class="fm-access-badge fm-access-public">
                                <i class="lni lni-world" aria-hidden="true"></i>
                                Public
                            </span>
                        @elseif ($doc->document_access == 2)
                            <span class="fm-access-badge fm-access-private">
                                <i class="lni lni-lock" aria-hidden="true"></i>
                                Private
                            </span>
                        @else
                            <span class="fm-access-badge fm-access-confidential">
                                <i class="lni lni-shield" aria-hidden="true"></i>
                                Confidential
                            </span>
                        @endif
                    </span>
                </div>

                <!-- Attachments -->
                <div class="fm-document-files">
                    <div class="fm-document-files-heading">
                        <div>
                            <h6>
                                <i class="lni lni-paperclip" aria-hidden="true"></i>
                                Attachments
                            </h6>
                            <p>Files associated with this document</p>
                        </div>

                        <span class="fm-document-file-count">
                            {{ $doc->files->count() }}
                            {{ $doc->files->count() === 1 ? 'file' : 'files' }}
                        </span>
                    </div>

                    @forelse ($doc->files as $file)
                        <form
                            id="download-form-{{ $doc->id }}-{{ $file->id }}"
                            action="{{ route('document_finder.download', $doc->id) }}"
                            method="POST"
                            class="fm-document-file-row"
                        >
                            @csrf

                            <input name="document" type="hidden" value="{{ $doc->id }}">
                            <input name="file_id" type="hidden" value="{{ $file->id }}">
                            <input name="filename" type="hidden" value="{{ $file->file_name }}">

                            <span class="fm-document-file-icon">
                                <i class="lni lni-empty-file" aria-hidden="true"></i>
                            </span>

                            <span class="fm-document-file-info">
                                <span class="fm-document-file-name">
                                    {{ $file->file_name }}
                                    @if (($file->file_version ?? 1) > 1)
                                        <span class="fm-document-version">
                                            v{{ $file->file_version }}
                                        </span>
                                    @endif
                                </span>
                                <span class="fm-document-file-hint">
                                    Select to download
                                </span>
                            </span>

                            <button
                                type="submit"
                                class="fm-document-download-btn"
                                aria-label="Download {{ $file->file_name }}"
                                title="Download file"
                            >
                                <i class="lni lni-download" aria-hidden="true"></i>
                            </button>
                        </form>
                    @empty
                        <div class="fm-document-no-files">
                            <i class="lni lni-folder" aria-hidden="true"></i>
                            <span>No files attached to this document.</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </article>

    @empty
        <!-- Empty State -->
        <div class="fm-document-empty-state">
            <div class="fm-document-empty-icon">
                <i class="lni lni-search-alt" aria-hidden="true"></i>
            </div>

            <h5>No documents found</h5>
            <p>
                No documents match your search. Try a different keyword
                or adjust your search criteria.
            </p>
        </div>
    @endforelse
</div>

<!-- Pagination Controls -->
@if ($documents->count() || $documents->currentPage() > 1)
    <div class="fm-document-pagination">
        <div class="fm-document-pagination-size">
            <label for="per_page" class="fm-document-pagination-label">
                Show
            </label>

            <form
                method="GET"
                action="{{ route('document_finder.index') }}"
                id="per-page-form"
                class="fm-document-pagination-form"
            >
                @if (request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <select
                    name="per_page"
                    id="per_page"
                    class="form-select fm-document-per-page"
                    onchange="this.form.submit()"
                >
                    @foreach ([10, 25, 50, 100] as $n)
                        <option
                            value="{{ $n }}"
                            {{ (int) request('per_page', 10) === $n ? 'selected' : '' }}
                        >
                            {{ $n }}
                        </option>
                    @endforeach
                </select>

                <span class="fm-document-pagination-label">per page</span>
            </form>
        </div>

        <div class="fm-document-pagination-links">
            {{ $documents->appends(request()->except('page'))->links() }}
        </div>
    </div>
@endif


    @include('document_finder.modals.change_permission')
    @include('document_finder.modals.edit')
    @include('document_finder.modals.manage_files')
    @include('document_finder.modals.update_file')
    @include('document_finder.modals.upload_file')
 </div>   
@endsection
@section('scripts')
<script>
    $(document).ready(function() {

        // When the nested modal is hidden, show the parent modal again
        $('#update-files-modal').on('hidden.bs.modal', function () {
            $('#manage-files-modal').modal('show');
        });

        // When the nested modal is hidden, show the parent modal again
        $('#upload-files-modal').on('hidden.bs.modal', function () {
            $('#manage-files-modal').modal('show');
        });

        let changePermissionModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('exampleModal'));
        let editModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('editModal'));

        let fileId = null;
        let fileName = null;
        let docId = null;
        let folderId = null;
        let updateFileModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('update-files-modal'));
        let uploadFileModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('upload-files-modal'));

        let documentId = null;

        $('html').on('click', '#change-permission-btn', function() {
            documentId = $(this).attr('data-id');
        });

        $('#permission-submit').click(function() {
            updatePermission(documentId);
        });


        const updatePermission = (documentId) => {
            $.ajax({
                    method: 'POST',
                    url: `/api/documents/${documentId}/permission`,
                    data: {
                        '_token': '{{ csrf_token() }}',
                        '_method': 'PUT',
                        'permission': $('#permission').val()
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "Success",
                            text: "Document permission has been updated",
                            icon: "success"
                        });

                        if(response.success) {

                            let documentAccess = parseInt(response.data.document_access);

                            switch (documentAccess) {
                                case 1:
                                    docAccess = '<span class="main-badge success-badge">Public</span>';
                                    break;
                                case 2:
                                    docAccess = '<span class="main-badge primary-badge">Private</span>';
                                    break;
                                default:
                                    docAccess = '<span class="main-badge warning-badge">Confidential</span>';
                                    break;
                            }

                            $(`#document-access-${documentId}`).html(docAccess);

                            $('#permission').val('') // reset

                            changePermissionModal.hide();
                        }
                    },
                    error: function(err) {
                        if(err.status === 422) {
                            Swal.fire({
                                title: "Warning",
                                text: "Permission is required",
                                icon: "warning"
                            });
                        } else {
                            Swal.fire({
                                title: "Warning",
                                text: "Server Error: Try again later",
                                icon: "warning"
                            });
                        }
                    }
                });
        }

        const updateDocument = (documentId) => {

            const updateFormData = $('#edit-document-form').serializeArray();
            updateFormData.push({ name: '_token', value: '{{ csrf_token() }}' });
            updateFormData.push({ name: '_method', value: 'PUT' });

            $.ajax({
                    method: 'POST',
                    url: `/api/documents/${documentId}`,
                    data: updateFormData,
                    success: function(response) {
                        if(response.success) {
                            Swal.fire({
                                title: "Success",
                                text: "Document has been updated",
                                icon: "success"
                            });

                            editModal.hide();
                            $('#edit-document-form')[0].reset();
                        }
                    },
                    error: function(err) {
                        if(err.status === 422) {
                            let errorMessage = '<ul>';
                            const errors = err.responseJSON.errors;

                            for (const key in errors) {
                                if (errors.hasOwnProperty(key)) {
                                    errors[key].forEach(error => {
                                        errorMessage += `<li>${error}</li>`;
                                    });
                                }
                            }

                            errorMessage += '</ul>';

                            Swal.fire({
                                title: "Oops!",
                                html: errorMessage,
                                icon: "warning"
                            });
                        } else {
                            Swal.fire({
                                title: "Warning",
                                text: "Server Error: Try again later",
                                icon: "warning"
                            });
                        }
                    }
                });
        }

        $('#update-document-submit').click(function () {
            updateDocument(documentId);
        });

        const getDocumentById = (documentId) => {

            $.ajax({
                    method: 'GET',
                    url: `/api/documents/${documentId}`,
                    success: function(response) {
                        const document = response.data;

                        if(response.success) {
                            $('#edit-document-form input[name="title"]').val(document.title)
                            $('#edit-document-form input[name="author"]').val(document.author)
                            $('#edit-document-form textarea[name="description"]').val(document.description)
                            $('#edit-document-form input[name="tags"]').val(document.tags)
                            $('#edit-document-form input[name="type"][value="' + document.type + '"]').prop('checked', true);

                        }
                    },
                    error: function(err) {
                        if(err.status === 404) {
                            Swal.fire({
                                title: "Warning",
                                text: "Document not found",
                                icon: "warning"
                            });
                        } else {
                            Swal.fire({
                                title: "Warning",
                                text: "Server Error: Try again later",
                                icon: "warning"
                            });
                        }
                    }
                });
        }

        $('html').on('click', '#edit-document-btn', function() {
            documentId = $(this).attr('data-id');

            getDocumentById(documentId);
        });

        // Manage File Modal
        $('html').on('click', '#manage-files-btn', function() {
            documentId = $(this).attr('data-id');
            folderId = $(this).attr('data-folder-id');

            $.ajax({
                    method: 'GET',
                    url: `/api/documents/${documentId}`,
                    success: function(response) {
                        const document = response.data;
                        if(response.success) {

                            let tbodyElement = $('#manage-files-modal #manage-files-tbody');
                            tbodyElement.empty();

                            let token = $('meta[name="csrf-token"]').attr('content');

                            document.files.forEach(file => {
                                const versionSuffix = (file.file_version && file.file_version > 1) ? ` (v${file.file_version})` : '';
                                tbodyElement.append(`
                            <tr id="file-${file.id}">
                                <td>${file.file_name}${versionSuffix}</td>
                                <td>${file.file_size}</td>
                                <td>${moment(file.created_at).format('ll')}</td>
                                <td class="d-flex">
                                    <form class="me-1" id="download-form-modal-${document.id}-${file.id}" action="/document-finder/download/${document.id}" method="post">
                                    <input name="_token" type="hidden" value="${token}">
                                    <input name="document" type="hidden" value="${document.id}">
                                    <input name="file_id" type="hidden" value="${file.id}">
                                    <input name="filename" type="hidden" value="${file.file_name}">
                                    <div class="d-flex align-items-end gap-3">
                                        <button type="submit" class="btn btn-secondary btn-sm " href="#!">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" width="16" height="16" class="text-white">
                                            <path strokeLinecap="round" strokeLinejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                        </button>
                                    </div>
                                    </form>
                                    <button data-document-id="${document.id}" data-folder-id="${document.folder_id}" data-file-name="${file.file_name}" data-id="${file.id}" class="btn btn-warning btn-sm me-1 edit-file-button" data-bs-toggle="modal" data-bs-target="#update-files-modal">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </button>
                                    <button data-id="${file.id}" class="btn btn-danger btn-sm delete-file-button">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                                `);
                            });

                        }
                    },
                    error: function(err) {
                        if(err.status === 404) {
                            Swal.fire({
                                title: "Warning",
                                text: "Document not found",
                                icon: "warning"
                            });
                        } else {
                            Swal.fire({
                                title: "Warning",
                                text: "Server Error: Try again later",
                                icon: "warning"
                            });
                        }
                    }
                });
        });

        // Store File
        $('#upload-file-submit').click(function (){

            let myForm = document.getElementById('upload-files-form');
            var formData = new FormData(myForm);
            formData.append('document', documentId)
            formData.append('folder', folderId)

            // Remove validations
            $('#upload-files-modal input').removeClass('is-invalid');
            $('#upload-files-modal .text-error').addClass('d-none');

            //
            $.ajax({
                method: 'POST',
                url: `/files`,
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: "Your file has been added.",
                    willClose: () => {
                        window.location.reload();
                    }
                    }).then((result) => {
                        if (result.dismiss) {
                            window.location.reload();
                        }
                    });

                },
                error: function(err) {
                    let hasFileFormatError = false;

                    if(err.status === 422) {
                        var errors = err.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            // Display validation errors
                            $('#upload-files-modal #' + key).addClass('is-invalid');
                            $('#upload-files-modal #' + key + '_error').text(value).removeClass('d-none');

                            if (key.startsWith('file') && value != 'The file field is required.') {
                                hasFileFormatError = true;
                            }
                        });

                        if(hasFileFormatError) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Oops!',
                                text: 'The file(s) must be a file of type: jpeg, png, pdf, docx.'
                            });
                        }

                    } else {
                        uploadFileModal.hide();
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'Something went wrong, try again.'
                        });
                    }
                }
            });
            //

        })

        // Edit File
        $('html').on('click', '.edit-file-button', function () {
            fileId = $(this).attr('data-id');
            fileName = $(this).attr('data-file-name');
            docId = $(this).attr('data-document-id');
            folderId = $(this).attr('data-folder-id');

            $('#file-name-to-update').html(fileName);
        });


        // Update File
        $('#update-file-submit').click(function (){

            let myForm = document.getElementById('update-files-form');
            var formData = new FormData(myForm);
            formData.append('_method', 'PUT');
            formData.append('document', docId)
            formData.append('folder', folderId)

            // Remove validations
            $('#update-files-modal input').removeClass('is-invalid');
            $('#update-files-modal .text-error').addClass('d-none');

            //
            $.ajax({
                method: 'POST',
                url: `/files/${fileId}`,
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    Swal.fire({
                        icon: "success",
                        title: "Updated!",
                        text: "Your file has been updated.",
                    willClose: () => {
                        window.location.reload();
                    }
                    }).then((result) => {
                        if (result.dismiss) {
                            window.location.reload();
                        }
                    });

                },
                error: function(err) {
                    if(err.status === 422) {
                        var errors = err.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            // Display validation errors
                            $('#update-files-modal #' + key).addClass('is-invalid');
                            $('#update-files-modal #' + key + '_error').text(value).removeClass('d-none');
                        });

                    } else {
                        updateFileModal.hide();
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'Something went wrong, try again.'
                        });
                    }
                }
            });
            //

        })

        // Delete File
        $('html').on('click', '.delete-file-button', function() {
            fileId = $(this).attr('data-id');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        //
                        $.ajax({
                            method: 'DELETE',
                            url: `/files/${fileId}`,
                            success: function(response) {

                                // Remove element
                                $(`#manage-files-modal #file-${response.id}`).remove();

                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                });
                            },
                            error: function() {
                                Swal.fire({
                                    title: "Oops!",
                                    text: "Something went wrong, try again later.",
                                    icon: "error"
                                });
                            }
                        });
                        //
                    }
                });

        });

    });
</script>
@endsection
