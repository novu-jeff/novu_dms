
<div class="modal fade fm-modal" id="addModal" tabindex="-1"
     aria-labelledby="addSectionModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content fm-modal-content">

            <div class="modal-header fm-modal-header">
                <div>
                    <span class="fm-modal-eyebrow">LOCATION MANAGEMENT</span>
                    <h5 class="modal-title fm-modal-title" id="addSectionModalTitle">
                        Add Section
                    </h5>
                    <p class="fm-modal-subtitle">
                        Register a section and assign it to a department and division.
                    </p>
                </div>

                <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body fm-modal-body">
                <form id="add-form">
                    <div class="fm-branch-form-icon">
                        <i class="lni lni-grid-alt"></i>
                    </div>

                    <div class="mb-4">
                        <label for="department_add" class="form-label fm-label">
                            Department <span class="text-danger">*</span>
                        </label>

                        <select class="form-select fm-input"
                                name="department"
                                id="department_add"
                                required>
                            <option value="" disabled selected>
                                Choose department
                            </option>
                            @forelse($departments as $department)
                                <option value="{{ $department->id }}">
                                    {{ $department->description }}
                                </option>
                            @empty
                                <option value="" disabled>
                                    No departments available
                                </option>
                            @endforelse
                        </select>

                        <small class="fm-help-text">
                            Select the department responsible for this section.
                        </small>
                    </div>

                    <div class="mb-4">
                        <label for="division_add" class="form-label fm-label">
                            Division <span class="text-danger">*</span>
                        </label>

                        <select class="form-select fm-input"
                                name="division"
                                id="division_add"
                                required>
                            <option value="" disabled selected>
                                Choose division
                            </option>
                            @forelse($divisions as $division)
                                <option value="{{ $division->id }}">
                                    {{ $division->description }}
                                </option>
                            @empty
                                <option value="" disabled>
                                    No divisions available
                                </option>
                            @endforelse
                        </select>

                        <small class="fm-help-text">
                            Available divisions should correspond to the selected department.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="add-section-description"
                               class="form-label fm-label">
                            Section Name / Description
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               id="add-section-description"
                               name="description"
                               class="form-control fm-input"
                               placeholder="e.g., Records Section"
                               maxlength="255"
                               required>

                        <small class="fm-help-text">
                            Enter the official section name or description.
                        </small>
                    </div>
                </form>
            </div>

            <div class="modal-footer fm-modal-footer">
                <button type="button"
                        class="btn fm-btn-cancel"
                        data-bs-dismiss="modal">
                    Cancel
                </button>

                <button id="add-form-submit"
                        type="button"
                        class="btn fm-btn-primary"
                        {{ $departments->isEmpty() ? 'disabled' : '' }}>
                    <i class="lni lni-plus"></i>
                    Create Section
                </button>
            </div>

        </div>
    </div>
</div>
