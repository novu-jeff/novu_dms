@extends('layouts.app')

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

                <form action="#" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="title">{{ __('Document Title') }}</label>
                                <input type="text" @error('title') class="form-control is-invalid" @enderror name="title"
                                       id="title"
                                       value="" required>
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
                                            <select name="branch" id="branch">
                                                <option value="" selected disabled>Choose branch</option>
                                                @forelse($branches as $branch)
                                                    <option value="{{ $branch->id }}">{{ $branch->description }}</option>
                                                @empty
                                                @endforelse
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
                                        @error('folder')
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
                                            <select name="division" id="division">
                                                <option value="">Choose division</option>
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
                                        @error('folder')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>

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

                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="tags">{{ __('Tags') }}</label>
                                <input type="text" @error('tags') class="form-control is-invalid" @enderror name="tags"
                                       id="tags"
                                       value="" required>
                                @error('tags')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                            <div class="col-12">
                                <div class="select-style-1">
                                    <label for="folder">{{ __('Folder') }}</label>
                                    <div class="select-position">
                                        <select name="folder">
                                          <option value="">Select category</option>
                                          <option value="">Category one</option>
                                          <option value="">Category two</option>
                                          <option value="">Category three</option>
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
                                <input type="file" @error('file') class="form-control is-invalid" @enderror name="file"
                                       id="file"
                                       value="" required>
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
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
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
    });
</script>
@endsection
