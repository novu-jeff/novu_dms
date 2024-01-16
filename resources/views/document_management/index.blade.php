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

                @if ($message = Session::get('success'))
                    <div class="alert-box success-alert">
                        <div class="alert">
                            <h4 class="alert-heading">Success</h4>
                            <p class="text-medium">
                                {{ $message }}
                            </p>
                        </div>
                    </div>
                @endif

                    @if ($message = Session::get('error'))
                        <div class="alert-box danger-alert">
                            <div class="alert">
                                <h4 class="alert-heading">Error</h4>
                                <p class="text-medium">
                                    {{ $message }}
                                </p>
                            </div>
                        </div>
                    @endif

                <form id="document_form" action="{{ route('documents.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="title">{{ __('Document Title') }}</label>
                                <input type="text" @error('title') class="form-control is-invalid" @enderror name="title"
                                       id="title"
                                       value="" required autofocus>
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="author">{{ __('Author') }}</label>
                                <input type="text" @error('author') class="form-control is-invalid" @enderror name="author"
                                       id="author"
                                       value="" required>
                                @error('author')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- end col -->

                        <div class="row">

                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <div class="select-style-1">
                                        <label for="branch">{{ __('Branch') }}</label>
                                        <div class="select-position">
                                            <select name="branch" id="branch" required>
                                                <option value="" selected disabled>Choose branch</option>
                                                @forelse($branches as $branch)
                                                    <option value="{{ $branch->id }}">{{ $branch->description }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        @error('branch')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <div class="select-style-1">
                                        <label for="department">{{ __('Department') }}</label>
                                        <div class="select-position">
                                            <select name="department" id="department" required>
                                                <option value="">Choose department</option>
                                            </select>
                                        </div>
                                        @error('department')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
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
                                            <select name="division" id="division" required>
                                                <option value="">Choose division</option>
                                            </select>
                                        </div>
                                        @error('division')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <div class="select-style-1">
                                        <label for="section">{{ __('Section') }}</label>
                                        <div class="select-position">
                                            <select name="section" id="section" required>
                                                <option value="">Choose section</option>
                                            </select>
                                        </div>
                                        @error('section')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
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
                                           type="radio" value="1" id="radio-1" required>
                                    <label class="form-check-label" for="radio-1">
                                        Public</label>
                                </div>

                                <div class="form-check radio-style mb-20 me-3">
                                    <input class="form-check-input"
                                           name="permission" type="radio" value="2" id="radio-2" required>
                                    <label class="form-check-label" for="radio-2">
                                        Private</label>
                                </div>

                                <div class="form-check radio-style mb-20 me-3">
                                    <input class="form-check-input"
                                           name="permission" type="radio" value="3" id="radio-2" required>
                                    <label class="form-check-label" for="radio-2">
                                        Confidential</label>
                                </div>
                            </div>
                            @error('permission')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="tags">{{ __('Tags') }}</label>
                                <input type="text" @error('tags') class="form-control is-invalid" @enderror name="tags"
                                       id="tags"
                                       value="" required>
                                <div id="tagsHelpBlock" class="form-text">
                                    Indicate multiple tags by comma seperated values e.g. (tag1, tag2, tag3)
                                </div>
                                @error('tags')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 input-style-1">
                            <label for="type">{{ __('Document Type') }}</label>
                            <div class="col-12 d-flex">
                                <div class="form-check radio-style mb-20 me-3">
                                    <input class="form-check-input"
                                           name="type"
                                           type="radio" value="1" id="radio-4" required>
                                    <label class="form-check-label" for="radio-4">
                                        Committee Report</label>
                                </div>

                                <div class="form-check radio-style mb-20 me-3">
                                    <input class="form-check-input"
                                           name="type" type="radio" value="2" id="radio-5" required>
                                    <label class="form-check-label" for="radio-5">
                                        Resolution</label>
                                </div>

                                <div class="form-check radio-style mb-20 me-3">
                                    <input class="form-check-input"
                                           name="type" type="radio" value="3" id="radio-6" required>
                                    <label class="form-check-label" for="radio-6">
                                        Ordinance</label>
                                </div>

                                <div class="form-check radio-style mb-20 me-3">
                                    <input class="form-check-input"
                                           name="type" type="radio" value="4" id="radio-6" required>
                                    <label class="form-check-label" for="radio-6">
                                        Session Meeting</label>
                                </div>
                            </div>
                            @error('permission')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                            <div class="col-12">
                                <div class="select-style-1">
                                    <label for="folder">{{ __('Folder') }}</label>
                                    <div class="select-position">
                                        <select name="folder" required>
                                          <option value="" disabled selected>Select folder</option>
                                        </select>
                                    </div>
                                    @error('folder')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="file">{{ __('Upload') }}</label>
                                <input id="file_upload" type="file" @error('file') class="form-control is-invalid" @enderror name="file[]"
                                       id="file"
                                       value="" required multiple>
                                <div id="fileHelpBlock" class="form-text">
                                    Supported file formats e.g(jpeg, png, pdf, docx)
                                </div>
                                @error('file')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- end col -->
                        <div class="col-12">
                            <div class="button-group d-flex justify-content-center flex-wrap">
                                <button id="submit-btn" type="button" class="main-btn primary-btn btn-hover w-100 text-center">
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
        $('#submit-btn').click(e => {
            e.preventDefault()

            // Flag to check if any non-file input is empty
            let anyEmpty = false;

            // Iterate through all input elements
            $('input, select').each(function () {
                // Check if the input is not a file input and is empty
                if ($(this).attr('type') !== 'file' && !$(this).val()) {
                    anyEmpty = true;
                    return false; // Exit the loop early if any empty non-file input is found
                }
            });

            // If any non-file input is empty, show a warning
            if (anyEmpty) {
                Swal.fire({
                    title: "Oops!",
                    text: "Please fill out all the required information.",
                    icon: "warning"
                });
                return false;
            }

            let files = $('#file_upload')[0].files;

            // Check if there are files
            if (files.length === 0) {
                Swal.fire(
                    'Oops!',
                    'Please select at least one file.',
                    'warning'
                );
                return false;
            }

            // Check each file for supported formats
            for (let i = 0; i < files.length; i++) {
                let fileType = files[i].type;
                let supportedFormats = ['image/jpeg', 'image/png', 'application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

                // Check if file type is supported
                if (!supportedFormats.includes(fileType)) {
                    Swal.fire(
                        'Oops!',
                        'File type is not supported for one or more selected files.',
                        'warning'
                    );
                    return false;
                }
            }

            // Show Loader
            swal.fire({
                html: '<h5>Please wait while the form is processing...</h5>',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading()
            });

            // Proceeds to process the submit
            document.getElementById('document_form').submit(); // Submit form

        })


    });
</script>
@endsection
