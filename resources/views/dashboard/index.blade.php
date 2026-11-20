@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-heading', 'Dashboard')

@section('content')
<div class="dms-dashboard">
    <div class="dms-page-heading">
        <div>
            <div class="dms-eyebrow">WORKSPACE / OVERVIEW</div>
            <h1>Welcome back, {{ auth()->user()->name ?? 'User' }}</h1>
            <p>Here’s an overview of your document repository.</p>
        </div>
        <div class="dms-date"><span class="dms-date-label">TODAY</span><strong>{{ now()->format('D, M j, Y') }}</strong></div>
    </div>

    <div class="dms-stat-grid">
        <article class="dms-stat-card">
            <div class="dms-stat-icon icon-blue"><i class="lni lni-files"></i></div>
            <div><span class="dms-stat-label">Total documents</span><strong>{{ number_format($stats['documents']) }}</strong><small>Registered in the system</small></div>
        </article>
        <article class="dms-stat-card">
            <div class="dms-stat-icon icon-green"><i class="lni lni-folder"></i></div>
            <div><span class="dms-stat-label">Folders</span><strong>{{ number_format($stats['folders']) }}</strong><small>Organized repository folders</small></div>
        </article>
        <article class="dms-stat-card">
            <div class="dms-stat-icon icon-violet"><i class="lni lni-files"></i></div>
            <div><span class="dms-stat-label">Stored files</span><strong>{{ number_format($stats['files']) }}</strong><small>Uploaded file records</small></div>
        </article>
        <article class="dms-stat-card">
            <div class="dms-stat-icon icon-amber"><i class="lni lni-map-marker"></i></div>
            <div><span class="dms-stat-label">Organization units</span><strong>{{ number_format($stats['locations']) }}</strong><small>Branches and departments</small></div>
        </article>
    </div>

    <section class="dms-panel dms-quick-panel">
        <div class="dms-panel-heading"><div><h2>Quick actions</h2><p>Common tasks to help you get started</p></div></div>
        <div class="dms-action-grid">
            <a class="dms-action action-blue" href="{{ route('document_management.index') }}"><span class="dms-action-icon"><i class="lni lni-upload"></i></span><span><strong>Upload document</strong><small>Register a new document</small></span><i class="lni lni-chevron-right dms-action-arrow"></i></a>
            <a class="dms-action action-green" href="{{ route('folders.index') }}"><span class="dms-action-icon"><i class="lni lni-folder"></i></span><span><strong>Manage folders</strong><small>Organize your repository</small></span><i class="lni lni-chevron-right dms-action-arrow"></i></a>
            <a class="dms-action action-violet" href="{{ route('document_finder.index') }}"><span class="dms-action-icon"><i class="lni lni-search-alt"></i></span><span><strong>Find a document</strong><small>Search existing records</small></span><i class="lni lni-chevron-right dms-action-arrow"></i></a>
            <a class="dms-action action-slate" href="{{ route('document_finder.index') }}"><span class="dms-action-icon"><i class="lni lni-archive"></i></span><span><strong>Browse repository</strong><small>Review stored documents</small></span><i class="lni lni-chevron-right dms-action-arrow"></i></a>
        </div>
    </section>

    <section class="dms-panel dms-recent-panel">
        <div class="dms-panel-heading dms-recent-heading">
            <div><h2>Recently added documents</h2><p>The latest documents registered in the system</p></div>
            <a class="dms-secondary-button" href="{{ route('document_finder.index') }}">View all <i class="lni lni-arrow-top-right"></i></a>
        </div>
        <div class="table-responsive">
            <table class="dms-table">
                <thead><tr><th>Document</th><th>Author</th><th>Folder</th><th>Access</th><th>Date added</th><th class="text-end">Files</th></tr></thead>
                <tbody>
                @forelse($recentDocuments as $document)
                    <tr>
                        <td><div class="dms-document-cell"><span class="dms-file-icon"><i class="lni lni-files"></i></span><span><strong>{{ $document->title ?? 'Untitled document' }}</strong><small>DOC-{{ str_pad((string) $document->id, 5, '0', STR_PAD_LEFT) }}</small></span></div></td>
                        <td>{{ $document->author ?? '—' }}</td>
                        <td>{{ optional($document->folder)->name ?? 'Unassigned' }}</td>
                        <td>
                            @php($access = (int) ($document->document_access ?? 0))
                            <span class="dms-access-badge {{ $access === 1 ? 'access-public' : ($access === 2 ? 'access-private' : 'access-confidential') }}">{{ $access === 1 ? 'Public' : ($access === 2 ? 'Private' : 'Confidential') }}</span>
                        </td>
                        <td>{{ optional($document->created_at)->format('M j, Y') ?? '—' }}</td>
                        <td class="text-end"><span class="dms-file-count">{{ $document->files->count() }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="6"><div class="dms-empty-state"><span class="dms-empty-icon"><i class="lni lni-files"></i></span><strong>No documents yet</strong><p>Once documents are registered, your recent activity will appear here.</p><a href="{{ route('document_management.index') }}" class="dms-primary-button">Go to Document Management</a></div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
    <div class="dms-footer-note"><i class="lni lni-shield"></i> Keep documents organized and make sure access permissions are appropriate for each record.</div>
</div>
@endsection
