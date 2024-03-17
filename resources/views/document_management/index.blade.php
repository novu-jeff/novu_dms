@extends('layouts.app')

@section('title') Document Management @endsection

@section('content')
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Document Management') }}</h2>
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

                <form id="document_form" action="{{ route('documents.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="title">{{ __('Document Title') }}</label>
                                <input type="text" class="form-control" name="title"
                                       id="title"
                                       value="" autofocus>
                                <span id="title_error" class="text-error text-danger d-none" role="alert"></span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="author">{{ __('Author') }}</label>
                                <input type="text" class="form-control"
                                       name="author"
                                       id="author"
                                       value="">
                                <span id="author_error" class="text-error text-danger d-none" role="alert"></span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="description">{{ __('Description') }}</label>
                                <textarea type="text" class="form-control" name="description"
                                    rows="3"
                                    id="description"
                                    value=""></textarea>
                                <span id="description_error" class="text-error text-danger d-none" role="alert"></span>
                            </div>
                        </div>
                        <!-- end col -->

                        <div class="row">

                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <div class="select-style-1">
                                        <label for="branch">{{ __('Branch') }}</label>
                                        <div class="select-position">
                                            <select name="branch" id="branch">
                                                <option value="" selected disabled>Choose branch</option>
                                                @forelse($branches as $branch)
                                                    <option value="{{ $branch->id }}">{{ $branch->description }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <span id="branch_error" class="text-error text-danger d-none" role="alert"></span>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <div class="select-style-1">
                                        <label for="department">{{ __('Department') }}</label>
                                        <div class="select-position">
                                            <select name="department" id="department">
                                                <option value="">Choose department</option>
                                            </select>
                                        </div>
                                        <span id="department_error" class="text-error text-danger d-none" role="alert"></span>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <div class="select-style-1">
                                        <label for="division">{{ __('Division') }}</label>
                                        <div class="select-position">
                                            <select name="division" id="division">
                                                <option value="">Choose division</option>
                                            </select>
                                        </div>
                                        <span id="division_error" class="text-error text-danger d-none" role="alert"></span>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <div class="select-style-1">
                                        <label for="section">{{ __('Section') }}</label>
                                        <div class="select-position">
                                            <select name="section" id="section">
                                                <option value="">Choose section</option>
                                            </select>
                                        </div>
                                        <span id="section_error" class="text-error text-danger d-none" role="alert"></span>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>

                        <div class="col-12 input-style-1">
                            <label for="permission">{{ __('Document Permission') }}</label>
                            <div class="col-12 d-flex">
                                <div class="form-check radio-style mb-20 me-3">
                                    <input class="form-check-input"
                                           name="permission"
                                           type="radio" value="1" id="radio-1">
                                    <label class="form-check-label" for="radio-1">
                                        Public</label>
                                </div>

                                <div class="form-check radio-style mb-20 me-3">
                                    <input class="form-check-input"
                                           name="permission" type="radio" value="2" id="radio-2">
                                    <label class="form-check-label" for="radio-2">
                                        Private</label>
                                </div>

                                <div class="form-check radio-style mb-20 me-3">
                                    <input class="form-check-input"
                                           name="permission" type="radio" value="3" id="radio-2">
                                    <label class="form-check-label" for="radio-2">
                                        Confidential</label>
                                </div>
                            </div>
                            <span id="permission_error" class="text-error text-danger d-none" role="alert"></span>
                        </div>

                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="tags">{{ __('Tags') }}</label>
                                <input type="text" class="form-control" name="tags"
                                       id="tags"
                                       value="">
                                <div id="tagsHelpBlock" class="form-text">
                                    Indicate multiple tags by comma seperated values e.g. (tag1, tag2, tag3)
                                </div>
                                <span id="tags_error" class="text-error text-danger d-none" role="alert"></span>
                            </div>
                        </div>

                        <div class="col-12 input-style-1">
                            <label for="type">{{ __('Document Type') }}</label>
                            <div class="col-12 d-flex">
                                <div class="form-check radio-style mb-20 me-3">
                                    <input class="form-check-input"
                                           name="type"
                                           type="radio" value="1" id="radio-4">
                                    <label class="form-check-label" for="radio-4">
                                        Committee Report</label>
                                </div>

                                <div class="form-check radio-style mb-20 me-3">
                                    <input class="form-check-input"
                                           name="type" type="radio" value="2" id="radio-5">
                                    <label class="form-check-label" for="radio-5">
                                        Resolution</label>
                                </div>

                                <div class="form-check radio-style mb-20 me-3">
                                    <input class="form-check-input"
                                           name="type" type="radio" value="3" id="radio-6">
                                    <label class="form-check-label" for="radio-6">
                                        Ordinance</label>
                                </div>

                                <div class="form-check radio-style mb-20 me-3">
                                    <input class="form-check-input"
                                           name="type" type="radio" value="4" id="radio-6">
                                    <label class="form-check-label" for="radio-6">
                                        Session Meeting</label>
                                </div>

                                <div class="form-check radio-style mb-20 me-3">
                                    <input class="form-check-input"
                                           name="type" type="radio" value="5" id="radio-6">
                                    <label class="form-check-label" for="radio-6">
                                        Executive Order</label>
                                </div>
                            </div>
                            <span id="type_error" class="text-error text-danger d-none" role="alert"></span>
                        </div>

                            <div class="col-12">
                                <div class="select-style-1">
                                    <label for="folder">{{ __('Folder') }}</label>
                                    <div class="select-position">
                                        <select id="folder" name="folder">
                                          <option disabled selected>Select folder</option>
                                        </select>
                                    </div>
                                    <span id="folder_error" class="text-error text-danger d-none" role="alert"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="file">{{ __('Document Date') }}</label>
                                <input id="doc_date" type="date" class="form-control" name="doc_date"
                                       value="">
                                <span id="doc_date_error" class="text-error text-danger d-none" role="alert"></span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="file">{{ __('Upload') }}</label>
                                <input type="file" class="form-control" name="file[]"
                                       id="file"
                                       value="" multiple>
                                <div id="fileHelpBlock" class="form-text">
                                    Supported file formats e.g(jpeg, png, pdf, docx)
                                </div>
                                <span id="file_error" class="text-error text-danger d-none" role="alert"></span>
                            </div>
                        </div>

                        <!-- end col -->
                        <div class="col-12">
                            <div class="button-group d-flex justify-content-center flex-wrap">
                                <button id="submit-btn" type="submit" class="main-btn primary-btn btn-hover w-100 text-center">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
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
