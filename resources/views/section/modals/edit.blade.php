
<div class="modal fade fm-modal" id="updateModal" tabindex="-1"
     aria-labelledby="updateSectionModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content fm-modal-content">

            <div class="modal-header fm-modal-header">
                <div>
                    <span class="fm-modal-eyebrow">LOCATION MANAGEMENT</span>
                    <h5 class="modal-title fm-modal-title"
                        id="updateSectionModalTitle">
                        Update Section
                    </h5>
                    <p class="fm-modal-subtitle">
                        Update the section name or its assigned department and division.
                    </p>
                </div>

                <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body fm-modal-body">
                <form id="update-form">
                    <div class="fm-branch-form-icon">
                        <i class="lni lni-grid-alt"></i>
                    </div>

                    <div class="mb-4">
                        <label for="department_update"
                               class="form-label fm-label">
                            Department <span class="text-danger">*</span>
                        </label>

                        <select id="department_update"
                                class="form-select fm-input"
                                name="department"
                                required>
                            <option value="" disabled>
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
                        <label for="division_update"
                               class="form-label fm-label">
                            Division <span class="text-danger">*</span>
                        </label>

                        <select id="division_update"
                                class="form-select fm-input"
                                name="division"
                                required>
                            <option value="" disabled selected>
                                Choose division
                            </option>
                        </select>

                        <small class="fm-help-text">
                            Select a division belonging to the chosen department.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fm-label">
                            Section Name / Description
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               id="description"
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

                <button id="update-form-submit"
                        type="button"
                        class="btn fm-btn-primary">
                    <i class="lni lni-save"></i>
                    Save Changes
                </button>
            </div>

        </div>
    </div>
</div>
