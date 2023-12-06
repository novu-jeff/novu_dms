@extends('layouts.app')

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
                    <h4>{{ $doc->title }}</h4>
                    <p>Author: {{ $doc->author }}</p>
                    <div class="mb-3">{{ \Illuminate\Support\Carbon::parse($doc->created_at)->format('Y-m-d') }}</div>
                    <p>Document Permission: {!!  ($doc->document_access == 1 ? '<span class="main-badge success-badge">Public</span>' : ($doc->document_access == 2 ? '<span class="main-badge primary-badge">Private</span>' : '<span class="main-badge warning-badge">Confidential</span>')) !!}</p>
                    <form id="download-form-{{$doc->id}}" action="{{ route('document_finder.download', $doc) }}" method="post">
                        @csrf
                        <input name="document" type="hidden" value="{{ $doc->id }}">
                        <div class="d-flex align-items-end gap-3">
                            <a href="#!" onclick="document.getElementById('download-form-{{ $doc->id }}').submit()">Download File</a>
                        </div>
                    </form>

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
        <div class="d-flex justify-content-start">
            {{ $documents->links() }}
        </div>
    </div>

@endsection
