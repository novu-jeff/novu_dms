
@extends('layouts.app')

@section('title', 'Organization Settings')
@section('page-heading', 'Organization Settings')

@section('content')
<div class="fm-page">

    <div class="fm-page-header">
        <div class="fm-heading-content">
            <div class="fm-heading-icon">
                <i class="lni lni-cog"></i>
            </div>

            <div>
                <h2 class="fm-heading-title">Organization Settings</h2>
                <p class="fm-heading-subtitle">
                    Manage your organization's identity and DMS branding.
                </p>
            </div>
        </div>

        <div class="fm-breadcrumb">
            <a href="{{ route('dashboard') }}">Home</a>
            <i class="lni lni-chevron-right"></i>
            <span>Settings</span>
            <i class="lni lni-chevron-right"></i>
            <span>Organization</span>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Please correct the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form
        action="{{ route('settings.organization.update') }}"
        method="POST"
        enctype="multipart/form-data"
        id="organization-settings-form"
    >
        @csrf
        @method('PUT')

        {{-- Organization profile --}}
        <div class="fm-card mb-4">
            <div class="fm-card-header">
                <div class="fm-card-title-group">
                    <div class="fm-card-title-icon">
                        <i class="lni lni-apartment"></i>
                    </div>
                    <div>
                        <h5 class="fm-card-title">Organization Profile</h5>
                        <p class="fm-card-subtitle">
                            Configure the official name and branding of your organization.
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-4">
                <div class="row g-4">
                    <div class="col-lg-7">
                        <label for="organization_name" class="fm-label">
                            Organization Name <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            id="organization_name"
                            name="organization_name"
                            class="fm-input @error('organization_name') is-invalid @enderror"
                            value="{{ old('organization_name', $settings->organization_name) }}"
                            placeholder="e.g. Municipality of Tabuk"
                            maxlength="255"
                            required
                        >

                        @error('organization_name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror

                        <p class="fm-help-text">
                            Used in the application branding and organization identification.
                        </p>
                    </div>

                    <div class="col-lg-5">
                        <label class="fm-label">Organization Logo</label>

                        <div class="os-logo-panel">
                            <div class="os-logo-preview">
                                <img
                                    id="organization-logo-preview"
                                    src="{{ $settings->organization_logo
                                        ? asset('storage/' . $settings->organization_logo)
                                        : asset('images/logo/novulution_logo.png') }}"
                                    alt="Organization logo preview"
                                    onerror="this.onerror=null;this.src='{{ asset('images/logo/novulution_logo.png') }}';"
                                >
                            </div>

                            <div class="flex-grow-1">
                                <strong class="os-upload-title">Upload organization logo</strong>
                                <p class="os-upload-description">
                                    PNG, JPG, JPEG or WebP. Maximum 2 MB.
                                </p>

                                <input
                                    type="file"
                                    id="organization_logo"
                                    name="organization_logo"
                                    class="form-control form-control-sm"
                                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                >

                                @error('organization_logo')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror

                                @if ($settings->organization_logo)
                                    <div class="mt-2">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#confirmRemoveOrganizationLogoModal"
                                        >
                                            <i class="lni lni-trash-can"></i>
                                            Remove logo
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- DMS branding --}}
        <div class="fm-card mb-4">
            <div class="fm-card-header">
                <div class="fm-card-title-group">
                    <div class="fm-card-title-icon">
                        <i class="lni lni-layers"></i>
                    </div>
                    <div>
                        <h5 class="fm-card-title">System Branding</h5>
                        <p class="fm-card-subtitle">
                            Configure the product name and logo displayed in the DMS.
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-4">
                <div class="row g-4">
                    <div class="col-lg-7">
                        <label for="system_name" class="fm-label">
                            System Name <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            id="system_name"
                            name="system_name"
                            class="fm-input @error('system_name') is-invalid @enderror"
                            value="{{ old('system_name', $settings->system_name ?? 'Document Management System') }}"
                            placeholder="e.g. Document Management System"
                            maxlength="255"
                            required
                        >

                        @error('system_name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror

                        <p class="fm-help-text">
                            This name can be used in the sidebar, page headings and footer.
                        </p>
                    </div>

                    <div class="col-lg-5">
                        <label class="fm-label">System Logo</label>

                        <div class="os-logo-panel">
                            <div class="os-logo-preview">
                                <img
                                    id="system-logo-preview"
                                    src="{{ $settings->system_logo
                                        ? asset('storage/' . $settings->system_logo)
                                        : asset('images/logo/dms_logo.png') }}"
                                    alt="System logo preview"
                                    onerror="this.onerror=null;this.src='{{ asset('images/logo/dms_logo.png') }}';"
                                >
                            </div>

                            <div class="flex-grow-1">
                                <strong class="os-upload-title">Upload DMS logo</strong>
                                <p class="os-upload-description">
                                    PNG, JPG, JPEG or WebP. Maximum 2 MB.
                                </p>

                                <input
                                    type="file"
                                    id="system_logo"
                                    name="system_logo"
                                    class="form-control form-control-sm"
                                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                >

                                @error('system_logo')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror

                                @if ($settings->system_logo)
                                    <div class="mt-2">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#confirmRemoveSystemLogoModal"
                                        >
                                            <i class="lni lni-trash-can"></i>
                                            Remove logo
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Branding preview --}}
        <div class="fm-card mb-4">
            <div class="fm-card-header">
                <div class="fm-card-title-group">
                    <div class="fm-card-title-icon">
                        <i class="lni lni-eye"></i>
                    </div>
                    <div>
                        <h5 class="fm-card-title">Branding Preview</h5>
                        <p class="fm-card-subtitle">
                            Preview how the organization and system branding will appear together.
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-4">
                <div class="os-brand-preview">
                    <img
                        id="combined-organization-preview"
                        src="{{ $settings->organization_logo
                            ? asset('storage/' . $settings->organization_logo)
                            : asset('images/logo/novulution_logo.png') }}"
                        alt=""
                        onerror="this.onerror=null;this.src='{{ asset('images/logo/novulution_logo.png') }}';"
                    >

                    <span class="os-preview-divider"></span>

                    <img
                        id="combined-system-preview"
                        src="{{ $settings->system_logo
                            ? asset('storage/' . $settings->system_logo)
                            : asset('images/logo/dms_logo.png') }}"
                        alt=""
                        onerror="this.onerror=null;this.src='{{ asset('images/logo/dms_logo.png') }}';"
                    >

                    <div class="os-preview-name">
                        <strong id="preview-organization-name">
                            {{ old('organization_name', $settings->organization_name ?? 'Organization Name') }}
                        </strong>
                        <span id="preview-system-name">
                            {{ old('system_name', $settings->system_name ?? 'Document Management System') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="fm-card-footer d-flex justify-content-end gap-2">
            <a href="{{ route('dashboard') }}" class="fm-btn-cancel">
                Cancel
            </a>

            <button type="submit" class="fm-btn-primary" id="save-settings-button">
                <i class="lni lni-save"></i>
                Save Settings
            </button>
        </div>
    </form>

    {{-- Separate forms for logo removal --}}
    @if ($settings->exists && $settings->organization_logo)
        <form
            id="remove-organization-logo-form"
            action="{{ route('settings.organization.logo.remove') }}"
            method="POST"
            class="d-none"
        >
            @csrf
            @method('DELETE')
        </form>
    @endif

    @if ($settings->exists && $settings->system_logo)
        <form
            id="remove-system-logo-form"
            action="{{ route('settings.organization.system-logo.remove') }}"
            method="POST"
            class="d-none"
        >
            @csrf
            @method('DELETE')
        </form>
    @endif

    {{-- Confirm Organization Logo Removal --}}
<div
    class="modal fade"
    id="confirmRemoveOrganizationLogoModal"
    tabindex="-1"
    aria-labelledby="confirmRemoveOrganizationLogoLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmRemoveOrganizationLogoLabel">
                    <i class="lni lni-warning text-danger me-2"></i>
                    Remove Organization Logo
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>

            <div class="modal-body">
                Are you sure you want to remove the organization logo?
                The default logo will be displayed instead.
            </div>

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    class="btn btn-danger"
                    id="confirm-remove-organization-logo"
                >
                    <i class="lni lni-trash-can me-1"></i>
                    Remove Logo
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Confirm System Logo Removal --}}
<div
    class="modal fade"
    id="confirmRemoveSystemLogoModal"
    tabindex="-1"
    aria-labelledby="confirmRemoveSystemLogoLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmRemoveSystemLogoLabel">
                    <i class="lni lni-warning text-danger me-2"></i>
                    Remove System Logo
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>

            <div class="modal-body">
                Are you sure you want to remove the system logo?
                The default DMS logo will be displayed instead.
            </div>

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    class="btn btn-danger"
                    id="confirm-remove-system-logo"
                >
                    <i class="lni lni-trash-can me-1"></i>
                    Remove Logo
                </button>
            </div>
        </div>
    </div>
</div>

</div>
@endsection

@push('styles')
<style>
    .os-logo-panel {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        border: 1px solid #e8edf4;
        border-radius: 12px;
        background: #fbfcfe;
    }

    .os-logo-preview {
        display: flex;
        flex: 0 0 88px;
        width: 88px;
        height: 88px;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 1px solid #e3e9f2;
        border-radius: 12px;
        background: #fff;
    }

    .os-logo-preview img {
        width: 100%;
        height: 100%;
        padding: 8px;
        object-fit: contain;
    }

    .os-upload-title {
        display: block;
        margin-bottom: 5px;
        color: #263449;
        font-size: 13px;
        font-weight: 700;
    }

    .os-upload-description {
        margin-bottom: 12px;
        color: #8290a5;
        font-size: 11px;
    }

    .os-logo-panel input[type="file"] {
        max-width: 100%;
        font-size: 11px;
    }

    .os-brand-preview {
        display: flex;
        min-height: 100px;
        align-items: center;
        gap: 18px;
        padding: 20px;
        border: 1px solid #e8edf4;
        border-radius: 14px;
        background: #fff;
    }

    .os-brand-preview > img {
        width: 62px;
        height: 62px;
        flex: 0 0 62px;
        object-fit: contain;
    }

    .os-preview-divider {
        width: 1px;
        height: 46px;
        background: #e2e8f0;
    }

    .os-preview-name {
        display: flex;
        min-width: 0;
        flex-direction: column;
        gap: 5px;
    }

    .os-preview-name strong {
        color: #1e293b;
        font-size: 14px;
        overflow-wrap: anywhere;
    }

    .os-preview-name span {
        color: #64748b;
        font-size: 12px;
        overflow-wrap: anywhere;
    }

    .fm-input.is-invalid {
        border-color: #dc3545;
    }

    @media (max-width: 576px) {
        .os-logo-panel {
            align-items: flex-start;
            flex-direction: column;
        }

        .os-brand-preview {
            flex-wrap: wrap;
            gap: 12px;
            padding: 14px;
        }

        .os-brand-preview > img {
            width: 45px;
            height: 45px;
            flex-basis: 45px;
        }

        .os-preview-name {
            flex-basis: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const organizationInput = document.getElementById('organization_logo');
    const systemInput = document.getElementById('system_logo');

    const organizationPreview = document.getElementById('organization-logo-preview');
    const systemPreview = document.getElementById('system-logo-preview');

    const combinedOrganization = document.getElementById('combined-organization-preview');
    const combinedSystem = document.getElementById('combined-system-preview');

    const organizationNameInput = document.getElementById('organization_name');
    const systemNameInput = document.getElementById('system_name');

    const previewOrganizationName = document.getElementById('preview-organization-name');
    const previewSystemName = document.getElementById('preview-system-name');

    function previewImage(input, previews) {
        if (!input || !input.files || !input.files[0]) {
            return;
        }

        const file = input.files[0];

        if (!file.type.startsWith('image/')) {
            input.value = '';
            alert('Please select a valid image file.');
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            input.value = '';
            alert('The image must not exceed 2 MB.');
            return;
        }

        const reader = new FileReader();

        reader.onload = function (event) {
            previews.forEach(function (preview) {
                if (preview) {
                    preview.src = event.target.result;
                }
            });
        };

        reader.readAsDataURL(file);
    }

    if (organizationInput) {
        organizationInput.addEventListener('change', function () {
            previewImage(this, [
                organizationPreview,
                combinedOrganization
            ]);
        });
    }

    if (systemInput) {
        systemInput.addEventListener('change', function () {
            previewImage(this, [
                systemPreview,
                combinedSystem
            ]);
        });
    }

    if (organizationNameInput) {
        organizationNameInput.addEventListener('input', function () {
            previewOrganizationName.textContent =
                this.value.trim() || 'Organization Name';
        });
    }

    if (systemNameInput) {
        systemNameInput.addEventListener('input', function () {
            previewSystemName.textContent =
                this.value.trim() || 'Document Management System';
        });
    }

    const form = document.getElementById('organization-settings-form');
    const saveButton = document.getElementById('save-settings-button');

    if (form && saveButton) {
        form.addEventListener('submit', function () {
            if (!form.checkValidity()) {
                return;
            }

            saveButton.disabled = true;
            saveButton.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';
        });
    }

    // Confirm organization logo removal
        const confirmRemoveOrganizationLogo = document.getElementById(
            'confirm-remove-organization-logo'
        );

        if (confirmRemoveOrganizationLogo) {
            confirmRemoveOrganizationLogo.addEventListener('click', function () {
                const form = document.getElementById(
                    'remove-organization-logo-form'
                );

                if (form) {
                    form.submit();
                }
            });
        }

        // Confirm system logo removal
        const confirmRemoveSystemLogo = document.getElementById(
            'confirm-remove-system-logo'
        );

        if (confirmRemoveSystemLogo) {
            confirmRemoveSystemLogo.addEventListener('click', function () {
                const form = document.getElementById(
                    'remove-system-logo-form'
                );

                if (form) {
                    form.submit();
                }
            });
        }
});
</script>
@endpush
