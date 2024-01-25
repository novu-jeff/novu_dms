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
                                <input name="filename" type="hidden" value="{{ $file->file_name }}">
                                <div class="d-flex align-items-end gap-3">
                                    <a class="text-uppercase" href="#!" onclick="document.getElementById('download-form-{{ $doc->id }}-{{ $file->id }}').submit()">{{ $file->file_name }}</a>
                                </div>
                            </form>
                            @endforeach
                        </div>
                        <div class="dropdown">
                            <a class="btn btn-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Action
                            </a>

                            <ul class="dropdown-menu">
                              <li><a id="change-permission-btn" class="dropdown-item" data-id="{{ $doc->id }}" href="#!" data-bs-toggle="modal" data-bs-target="#exampleModal">Change Permission</a></li>
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
        <div class="d-flex justify-content-start">
            {{ $documents->links() }}
        </div>
    </div>

    @include('document_finder.modals.change_permission')

@endsection
@section('scripts')
<script>
    $(document).ready(function() {

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

    });
</script>
@endsection
