
<div class="modal fade fm-modal" id="addModal" tabindex="-1"
     aria-labelledby="addDepartmentModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content fm-modal-content">

            {{-- Modal Header --}}
            <div class="modal-header fm-modal-header">
                <div>
                    <span class="fm-modal-eyebrow">LOCATION MANAGEMENT</span>
                    <h5 class="modal-title fm-modal-title" id="addDepartmentModalTitle">
                        Add Department
                    </h5>
                    <p class="fm-modal-subtitle">
                        Register a department and assign it to a branch.
                    </p>
                </div>

                <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Modal Body --}}
            <div class="modal-body fm-modal-body">
                <form id="add-form">

                    <div class="fm-branch-form-icon">
                        <i class="lni lni-apartment"></i>
                    </div>

                    {{-- Branch --}}
                    <div class="mb-4">
                        <label for="add-branch" class="form-label fm-label">
                            Branch <span class="text-danger">*</span>
                        </label>

                        <select
                            id="add-branch"
                            class="form-select fm-input"
                            name="branch"
                            required
                        >
                            <option value="" disabled selected>
                                Select a branch
                            </option>

                            @forelse($branches as $branch)
                                <option value="{{ $branch->id }}">
                                    {{ $branch->description }}
                                </option>
                            @empty
                                <option value="" disabled>
                                    No branches available
                                </option>
                            @endforelse
                        </select>

                        <small class="fm-help-text">
                            Select the branch where this department belongs.
                        </small>
                    </div>

                    {{-- Department Name --}}
                    <div class="mb-3">
                        <label for="add-department-description" class="form-label fm-label">
                            Department Name / Description
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            id="add-department-description"
                            name="description"
                            type="text"
                            class="form-control fm-input"
                            placeholder="e.g., Human Resources Department"
                            maxlength="255"
                            autocomplete="organization-title"
                            required
                        >

                        <small class="fm-help-text">
                            Enter the official department name or description.
                        </small>
                    </div>

                </form>
            </div>

            {{-- Modal Footer --}}
            <div class="modal-footer fm-modal-footer">
                <button type="button" class="btn fm-btn-cancel"
                        data-bs-dismiss="modal">
                    Cancel
                </button>

                <button id="add-form-submit" type="button" class="btn fm-btn-primary"
                    {{ $branches->isEmpty() ? 'disabled' : '' }}>
                    <i class="lni lni-plus"></i>
                    Create Department
                </button>
            </div>

        </div>
    </div>
</div>
