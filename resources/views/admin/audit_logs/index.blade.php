@extends('layouts.app')

@section('title', 'Audit Logs')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-semibold mb-0">🧾 Audit Logs</h2>
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="user" value="{{ request('user') }}" class="form-control form-control-sm" placeholder="Search by user">
            <input type="text" name="action" value="{{ request('action') }}" class="form-control form-control-sm" placeholder="Search by action">
            <button class="btn btn-primary btn-sm"><i class="bi bi-search"></i> Filter</button>
            @if(request('user') || request('action'))
                <a href="{{ route('audit-logs.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
            @endif
        </form>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Description</th>
                            <th>IP Address</th>
                            <th>Created At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>{{ $log->id }}</td>
                                <td>
                                    <div class="fw-semibold">
                                        {{ $log->user?->name ?? 'Guest' }}
                                    </div>
                                    <small class="text-muted">{{ $log->user?->email ?? '' }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ $log->action }}</span>
                                </td>
                                <td style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $log->description }}
                                </td>
                                <td>
                                    <span class="text-muted small">{{ $log->ip_address }}</span>
                                </td>
                                <td>
                                    <span class="text-muted small">{{ $log->created_at->format('Y-m-d H:i') }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('audit-logs.show', $log->id) }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    No audit logs found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($logs->hasPages())
        <div class="card-footer bg-white border-top-0">
            <div class="d-flex justify-content-center">
                {{ $logs->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
