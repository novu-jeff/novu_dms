
<div class="modal fade fm-modal" id="updateModal" tabindex="-1"
     aria-labelledby="updateDepartmentModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content fm-modal-content">

            {{-- Modal Header --}}
            <div class="modal-header fm-modal-header">
                <div>
                    <span class="fm-modal-eyebrow">LOCATION MANAGEMENT</span>
                    <h5 class="modal-title fm-modal-title" id="updateDepartmentModalTitle">
                        Edit Department
                    </h5>
                    <p class="fm-modal-subtitle">
                        Update the department details and assigned branch.
                    </p>
                </div>

                <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Modal Body --}}
            <div class="modal-body fm-modal-body">
                <form id="update-form">

                    <div class="fm-branch-form-icon">
                        <i class="lni lni-pencil"></i>
                    </div>

                    {{-- Branch --}}
                    <div class="mb-4">
                        <label for="branch" class="form-label fm-label">
                            Branch <span class="text-danger">*</span>
                        </label>

                        <select
                            id="branch"
                            class="form-select fm-input"
                            name="branch"
                            required
                        >
                            <option value="" disabled>
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
                            Choose the branch to which this department belongs.
                        </small>
                    </div>

                    {{-- Department Name --}}
                    <div class="mb-3">
                        <label for="description" class="form-label fm-label">
                            Department Name / Description
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            id="description"
                            name="description"
                            type="text"
                            class="form-control fm-input"
                            placeholder="Enter department name"
                            maxlength="255"
                            autocomplete="organization-title"
                            required
                        >

                        <small class="fm-help-text">
                            Ensure the department name is accurate before saving.
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

                <button id="update-form-submit" type="button" class="btn fm-btn-primary">
                    <i class="lni lni-checkmark"></i>
                    Save Changes
                </button>
            </div>

        </div>
    </div>
</div>
