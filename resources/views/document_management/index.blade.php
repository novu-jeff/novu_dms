@extends('layouts.app')


@section('title', 'Document Management')
@section('page-heading', 'Document Management')

@section('content')
<div class="dm-page">

    <div class="dm-intro">
        <div>
            <div class="dm-breadcrumb">Workspace / Documents</div>
            <h2>Register a Document</h2>
            <p>Enter the document details, assign its location, and upload the files.</p>
        </div>

        <div class="dm-required-note">
            <span class="dm-required-star">*</span> Required fields
        </div>
    </div>

    <form id="document_form"
          action="{{ route('documents.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <!-- Document details -->
        <section class="dm-form-card">
            <div class="dm-card-heading">
                <div class="dm-heading-icon dm-blue">
                    <i class="lni lni-files"></i>
                </div>
                <div>
                    <h3>Document Information</h3>
                    <p>Basic details to identify and describe the document.</p>
                </div>
            </div>

            <div class="dm-form-grid">
                <div class="dm-field dm-span-2">
                    <label for="title">Document Title <span>*</span></label>
                    <input type="text" class="form-control" name="title"
                           id="title" value="{{ old('title') }}"
                           placeholder="Enter document title" autofocus>
                    <span id="title_error" class="text-error text-danger d-none"></span>
                </div>

                <div class="dm-field">
                    <label for="author">Author <span>*</span></label>
                    <input type="text" class="form-control" name="author"
                           id="author" value="{{ old('author') }}"
                           placeholder="Enter author or originating office">
                    <span id="author_error" class="text-error text-danger d-none"></span>
                </div>

                <div class="dm-field">
                    <label for="doc_date">Document Date <span>*</span></label>
                    <input type="date" class="form-control" name="doc_date"
                           id="doc_date" value="{{ old('doc_date') }}">
                    <span id="doc_date_error" class="text-error text-danger d-none"></span>
                </div>

                <div class="dm-field dm-span-2">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description"
                              id="description" rows="4"
                              placeholder="Provide a short description of this document">{{ old('description') }}</textarea>
                    <span id="description_error" class="text-error text-danger d-none"></span>
                </div>
            </div>
        </section>

        <!-- Location and folder -->
        <section class="dm-form-card">
            <div class="dm-card-heading">
                <div class="dm-heading-icon dm-green">
                    <i class="lni lni-map-marker"></i>
                </div>
                <div>
                    <h3>Document Location</h3>
                    <p>Select the organizational location and destination folder.</p>
                </div>
            </div>

            <div class="dm-form-grid">
                <div class="dm-field">
                    <label for="branch">Branch <span>*</span></label>
                    <select name="branch" id="branch" class="form-select">
                        <option value="" selected disabled>Choose branch</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}"
                                {{ old('branch') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->description }}
                            </option>
                        @endforeach
                    </select>
                    <span id="branch_error" class="text-error text-danger d-none"></span>
                </div>

                <div class="dm-field">
                    <label for="department">Department <span>*</span></label>
                    <select name="department" id="department" class="form-select">
                        <option value="">Choose department</option>
                    </select>
                    <span id="department_error" class="text-error text-danger d-none"></span>
                </div>

                <div class="dm-field">
                    <label for="division">Division <span>*</span></label>
                    <select name="division" id="division" class="form-select">
                        <option value="">Choose division</option>
                    </select>
                    <span id="division_error" class="text-error text-danger d-none"></span>
                </div>

                <div class="dm-field">
                    <label for="section">Section <span>*</span></label>
                    <select name="section" id="section" class="form-select">
                        <option value="">Choose section</option>
                    </select>
                    <span id="section_error" class="text-error text-danger d-none"></span>
                </div>

                <div class="dm-field dm-span-2">
                    <label for="folder">Destination Folder <span>*</span></label>
                    <select id="folder" name="folder" class="form-select">
                        <option value="" selected disabled>Select folder</option>
                    </select>
                    <span id="folder_error" class="text-error text-danger d-none"></span>
                    <small class="dm-help">Available folders depend on the selected location.</small>
                </div>
            </div>
        </section>

        <!-- Classification -->
        <section class="dm-form-card">
            <div class="dm-card-heading">
                <div class="dm-heading-icon dm-purple">
                    <i class="lni lni-shield"></i>
                </div>
                <div>
                    <h3>Classification and Access</h3>
                    <p>Set the document category, access level, and search tags.</p>
                </div>
            </div>

            <div class="dm-field">
                <label>Document Permission <span>*</span></label>
                <div class="dm-choice-grid">
                    <label class="dm-choice" for="permission-public">
                        <input type="radio" name="permission" value="1"
                               id="permission-public">
                        <span class="dm-choice-content">
                            <strong>Public</strong>
                            <small>Accessible according to system permissions.</small>
                        </span>
                    </label>

                    <label class="dm-choice" for="permission-private">
                        <input type="radio" name="permission" value="2"
                               id="permission-private">
                        <span class="dm-choice-content">
                            <strong>Private</strong>
                            <small>Restricted access.</small>
                        </span>
                    </label>

                    <label class="dm-choice" for="permission-confidential">
                        <input type="radio" name="permission" value="3"
                               id="permission-confidential">
                        <span class="dm-choice-content">
                            <strong>Confidential</strong>
                            <small>For sensitive information.</small>
                        </span>
                    </label>
                </div>
                <span id="permission_error" class="text-error text-danger d-none"></span>
            </div>

            <div class="dm-field dm-type-field">
                <label>Document Type <span>*</span></label>
                <div class="dm-type-grid">
                    <label class="dm-type-option" for="type-committee">
                        <input type="radio" name="type" value="1" id="type-committee">
                        <span>Committee Report</span>
                    </label>
                    <label class="dm-type-option" for="type-resolution">
                        <input type="radio" name="type" value="2" id="type-resolution">
                        <span>Resolution</span>
                    </label>
                    <label class="dm-type-option" for="type-ordinance">
                        <input type="radio" name="type" value="3" id="type-ordinance">
                        <span>Ordinance</span>
                    </label>
                    <label class="dm-type-option" for="type-session">
                        <input type="radio" name="type" value="4" id="type-session">
                        <span>Session Meeting</span>
                    </label>
                    <label class="dm-type-option" for="type-executive">
                        <input type="radio" name="type" value="5" id="type-executive">
                        <span>Executive Order</span>
                    </label>
                </div>
                <span id="type_error" class="text-error text-danger d-none"></span>
            </div>

            <div class="dm-field dm-tags-field">
                <label for="tags">Tags</label>
                <input type="text" class="form-control" name="tags"
                       id="tags" value="{{ old('tags') }}"
                       placeholder="e.g. finance, resolution, 2026">
                <small class="dm-help">Separate multiple tags with commas.</small>
                <span id="tags_error" class="text-error text-danger d-none"></span>
            </div>
        </section>

        <!-- File upload -->
        <section class="dm-form-card">
            <div class="dm-card-heading">
                <div class="dm-heading-icon dm-orange">
                    <i class="lni lni-cloud-upload"></i>
                </div>
                <div>
                    <h3>Upload Files</h3>
                    <p>Attach the digital files associated with this document.</p>
                </div>
            </div>

            <div class="dm-upload-area">
                <div class="dm-upload-icon">
                    <i class="lni lni-upload"></i>
                </div>
                <label for="file">Choose document files <span>*</span></label>
                <p>Choose one or more files from your device.</p>
                <input type="file" class="form-control" name="file[]"
                       id="file" multiple accept=".jpeg,.jpg,.png,.pdf,.docx">
                <small class="dm-help">Supported formats: JPEG, PNG, PDF, DOCX.</small>
                <span id="file_error" class="text-error text-danger d-none"></span>
                <div id="dm-selected-files" class="dm-selected-files"></div>
            </div>
        </section>

        <!-- Actions -->
        <div class="dm-form-actions">
            <p><span class="dm-required-star">*</span> Please complete all required fields.</p>
            <button id="submit-btn" type="submit" class="dm-submit-btn">
                <i class="lni lni-checkmark-circle"></i>
                <span>Register Document</span>
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {

        $('select[name="branch"]').change(e => {
            let branch = e.target.value;

            if(branch == '' || branch == null) return;

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
                    departmentElement.append('<option selected disabled>Choose department</option>');

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

            if(departmentId == '' || departmentId == null) return;

            $('#section').empty();
            $('#section').append('<option selected disabled>Choose section</option>');
            $('#section').val('').change();

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

        $('select[name="section"]').change(e => {
            if(e.target.value == '') return;

            $.ajax({
                type: 'GET',
                url: '{{ url('/get-folder-by-location') }}',
                data: {
                    branch: $('select[name="branch"]').val(),
                    department: $('select[name="department"]').val(),
                    division: $('select[name="division"]').val(),
                    section: $('select[name="section"]').val(),
                },
                success: function(response) {
                    $('select[name="folder"]').empty();
                    $('select[name="folder"]').append('<option selected disabled value="">Select folder</option>');
                    response.forEach(folder => {
                        $('select[name="folder"]').append(`<option value="${folder.id}">${folder.name}</option>`);
                    });
                }
            })
        });


        // When submit button is clicked show loader
        $('#document_form').submit(e => {
            e.preventDefault()

            // Serialize the form data
            let myForm = document.getElementById('document_form');
            var formData = new FormData(myForm);

            // Remove existing validation error classes
            $('textarea').removeClass('is-invalid');
            $('select').removeClass('border-danger');
            $('input,select,textarea .form-control').removeClass('is-invalid');
            $('.text-error').addClass('d-none');

            $.ajax({
                url: '{{ route('documents.store') }}',
                method: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {

                    Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: "A new document has been added.",
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

                        let hasFileFormatError = false;
                        let hasValidationError = false;

                        $.each(errors, function(key, value) {
                            // Display validation errors
                            $('#' + key).addClass('is-invalid');
                            $('select#' + key).addClass('border-danger');

                            $('#' + key + '_error').text(value).removeClass('d-none');

                            hasValidationError = true;

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

                        if(hasFileFormatError === false && hasValidationError) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: 'Please check your form for validation fields.'
                            });
                        }

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'Something went wrong, try again.'
                        });
                    }

                }
            })
        })


    });
</script>
@endsection
