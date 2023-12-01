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
                                    <label for="branch">{{ __('Branch') }}</label>
                                    <input @error('branch') class="form-control is-invalid" @enderror type="text"
                                        name="branch" id="branch"
                                        value="" required>
                                    @error('branch')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label for="department">{{ __('Department') }}</label>
                                    <input @error('department') class="form-control is-invalid" @enderror type="text"
                                        name="department" id="department"
                                        value="" required>
                                    @error('department')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end col -->

                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label for="division">{{ __('Division') }}</label>
                                    <input @error('division') class="form-control is-invalid" @enderror type="text"
                                        name="division" id="division"
                                        value="" required>
                                    @error('division')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-md-6">
                                <div class="input-style-1">
                                    <label for="section">{{ __('Section') }}</label>
                                    <input @error('section') class="form-control is-invalid" @enderror type="text"
                                        name="section" id="section"
                                        value="" required>
                                    @error('section')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
                                    <div class="select-position" name="folder">
                                        <select>
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
