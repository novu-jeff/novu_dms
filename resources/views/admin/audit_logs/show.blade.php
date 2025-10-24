@extends('layouts.app')

@section('title', 'Audit Log Details')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-semibold mb-0">
            🧾 Audit Log #{{ $log->id }}
        </h2>
        <a href="{{ route('audit-logs.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-light fw-semibold">
            Log Information
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="text-muted small">User</label>
                    <div class="fw-semibold">
                        {{ $log->user?->name ?? 'Guest' }}
                        @if($log->user?->email)
                            <div class="text-muted small">{{ $log->user->email }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small">IP Address</label>
                    <div>{{ $log->ip_address }}</div>
                </div>
            </div>

            <div class="mb-3">
                <label class="text-muted small">Action</label>
                <div><span class="badge bg-info text-dark">{{ $log->action }}</span></div>
            </div>

            <div class="mb-3">
                <label class="text-muted small">Description</label>
                <div class="border rounded p-2 bg-light">
                    {{ $log->description }}
                </div>
            </div>

            <div class="mb-3">
                <label class="text-muted small">User Agent</label>
                <div class="text-break small text-muted">
                    {{ $log->user_agent }}
                </div>
            </div>

            <div class="mb-0">
                <label class="text-muted small">Created At</label>
                <div>{{ $log->created_at->format('F d, Y h:i A') }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
