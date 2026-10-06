@extends('layouts.app')

@section('title') Document Finder @endsection

@section('content')
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Document Finder') }}</h2>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- ========== title-wrapper end ========== -->

    <div class="card-styles">
        <div class="card-style-3 mb-30">
            <div class="card-content">
                <form action="{{ route('document_finder.index') }}">
                    <div class="row">
                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="search">{{ __('Search') }}</label>
                                <input type="text" @error('search') class="form-control is-invalid" @enderror name="search"
                                       id="search"
                                       value="">
                                <div id="tagsHelpBlock" class="form-text">
                                    (Tags, Title, Author, etc.)
                                </div>
                                @error('search')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="button-group d-flex justify-content-center flex-wrap">
                                <button type="submit" class="main-btn primary-btn btn-hover w-100 text-center">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(request()->input('search'))
        <p class="mb-3">Results for <i>{{ request()->input('search') }}</i></p>
    @else
        <p class="mb-3">Showing all results</p>
    @endif

    @forelse($documents as $doc)
        <div class="card-styles">
            <div class="card-style-3 mb-30">
                <div class="card-content">
                    <div class="d-flex justify-content-between">
                        <div class="content">
                            <h4>{{ $doc->title }}</h4>
                            <p>Author: {{ $doc->author }}</p>
                            <div class="mb-3">{{ \Illuminate\Support\Carbon::parse($doc->created_at)->format('Y-m-d') }}</div>
                            <p>Document Permission: <span id="document-access-{{ $doc->id }}">
                                {!! ($doc->document_access == 1 ? '<span class="main-badge success-badge">Public</span>' : ($doc->document_access == 2 ? '<span class="main-badge primary-badge">Private</span>' : '<span class="main-badge warning-badge">Confidential</span>')) !!}</span>
                            </p>
                            @foreach ($doc->files as $file)
                            <form id="download-form-{{$doc->id}}-{{ $file->id }}" action="{{ route('document_finder.download', $doc->id) }}" method="post">
                                @csrf
                                <input name="document" type="hidden" value="{{ $doc->id }}">
                                <input name="file_id" type="hidden" value="{{ $file->id }}">
                                <input name="filename" type="hidden" value="{{ $file->file_name }}">
                                <div class="d-flex align-items-end gap-3">
                                    <a class="text-uppercase" href="#!" onclick="document.getElementById('download-form-{{ $doc->id }}-{{ $file->id }}').submit()">{{ $file->file_name }}@if(($file->file_version ?? 1) > 1) (v{{ $file->file_version }})@endif</a>
                                </div>
                            </form>
                            @endforeach
                        </div>
                        <div class="dropdown">
                            <a class="btn btn-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Action
                            </a>

                            <ul class="dropdown-menu">
                              <li><a id="edit-document-btn" class="dropdown-item" data-id="{{ $doc->id }}" href="#!" data-bs-toggle="modal" data-bs-target="#editModal"><?xml version="1.0" encoding="utf-8"?>
                                <!-- Generator: Adobe Illustrator 22.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                                <svg fill="#1C2033" width="16" height="16" version="1.1" id="lni_lni-pencil" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                     y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                                <path d="M61.2,13c-3.2-3.4-6.6-6.8-10-10.1c-0.7-0.7-1.5-1.1-2.4-1.1c-0.9,0-1.8,0.3-2.4,1L8.7,40.2c-0.6,0.6-1,1.3-1.3,2L1.9,59
                                    c-0.3,0.8-0.1,1.6,0.3,2.2c0.5,0.6,1.2,1,2.1,1h0.4l17.1-5.7c0.8-0.3,1.5-0.7,2-1.3l37.5-37.4c0.6-0.6,1-1.5,1-2.4
                                    S61.9,13.7,61.2,13z M20.6,52.1c-0.1,0.1-0.2,0.1-0.3,0.2L7.4,56.6l4.3-12.9c0-0.1,0.1-0.2,0.2-0.3L39.4,16l8.7,8.7L20.6,52.1z
                                     M51.2,21.5l-8.7-8.7l6.1-6.1c2.9,2.8,5.8,5.8,8.6,8.7L51.2,21.5z"/>
                                </svg>
                                Edit</a></li>
                              <li><a id="change-permission-btn" class="dropdown-item" data-id="{{ $doc->id }}" href="#!" data-bs-toggle="modal" data-bs-target="#exampleModal"><?xml version="1.0" encoding="utf-8"?>
                                <!-- Generator: Adobe Illustrator 22.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                                <svg fill="#1C2033" width="16" height="16" version="1.1" id="lni_lni-unlock" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                     y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                                <g>
                                    <path d="M50.4,21.9h-6.1v-7.4c0-6.8-5.5-12.3-12.3-12.3S19.8,7.7,19.8,14.5c0,1.2,1,2.3,2.3,2.3s2.3-1,2.3-2.3
                                        c0-4.3,3.5-7.8,7.8-7.8s7.8,3.5,7.8,7.8v7.4H13.6c-3.8,0-6.9,3-6.9,6.6V43c0,10.3,8.9,18.7,19.8,18.7h11c10.9,0,19.7-8.5,19.7-19
                                        V28.5C57.3,24.9,54.2,21.9,50.4,21.9z M52.8,42.7c0,8-6.8,14.5-15.2,14.5h-11c-8.4,0-15.3-6.4-15.3-14.2V28.5
                                        c0-1.2,1.1-2.1,2.4-2.1h36.7c1.3,0,2.4,0.9,2.4,2.1V42.7z"/>
                                    <path d="M36.1,39.4h-8.2c-1.8,0-3.3,1.5-3.3,3.3v8.2c0,1.8,1.5,3.3,3.3,3.3h8.2c1.8,0,3.3-1.5,3.3-3.3v-8.2
                                        C39.4,40.9,37.9,39.4,36.1,39.4z M34.9,49.6h-5.7v-5.7h5.7V49.6z"/>
                                </g>
                                </svg>
                                Change Permission</a></li>
                                <li><a id="manage-files-btn" class="dropdown-item" data-document-id="{{ $doc->id }}" data-folder-id="{{ $doc->folder_id }}" data-id="{{ $doc->id }}" href="#!" data-bs-toggle="modal" data-bs-target="#manage-files-modal"><?xml version="1.0" encoding="utf-8"?>
                                    <!-- Generator: Adobe Illustrator 22.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"  width="16" height="16">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                      </svg>

                                    Manage Files</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="card-styles">
            <div class="card-style-3 mb-30">
                <div class="card-content">
                    <p>No results found</p>
                </div>
            </div>
        </div>
    @endforelse

    <div class="my-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-2">
                <label class="text-muted small mb-0">Show</label>
                <form method="get" action="{{ route('document_finder.index') }}" class="d-flex align-items-center gap-2" id="per-page-form">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <select name="per_page" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                        @foreach([10, 25, 50, 100] as $n)
                            <option value="{{ $n }}" {{ (int) request('per_page', 10) === $n ? 'selected' : '' }}>{{ $n }}</option>
                        @endforeach
                    </select>
                    <span class="text-muted small">per page</span>
                </form>
            </div>
            <div>
                {{ $documents->links() }}
            </div>
        </div>
    </div>

    @include('document_finder.modals.change_permission')
    @include('document_finder.modals.edit')
    @include('document_finder.modals.manage_files')
    @include('document_finder.modals.update_file')
    @include('document_finder.modals.upload_file')

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
