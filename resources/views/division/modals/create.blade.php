
<div class="modal fade fm-modal" id="addModal" tabindex="-1"
     aria-labelledby="addDivisionModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content fm-modal-content">

            {{-- Modal Header --}}
            <div class="modal-header fm-modal-header">
                <div>
                    <span class="fm-modal-eyebrow">LOCATION MANAGEMENT</span>
                    <h5 class="modal-title fm-modal-title" id="addDivisionModalTitle">
                        Add Division
                    </h5>
                    <p class="fm-modal-subtitle">
                        Register a division and assign it to a department.
                    </p>
                </div>

                <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Modal Body --}}
            <div class="modal-body fm-modal-body">
                <form id="add-form">

                    <div class="fm-branch-form-icon">
                        <i class="lni lni-layers"></i>
                    </div>

                    {{-- Department --}}
                    <div class="mb-4">
                        <label for="add-department" class="form-label fm-label">
                            Department <span class="text-danger">*</span>
                        </label>

                        <select
                            id="add-department"
                            class="form-select fm-input"
                            name="department"
                            required
                        >
                            <option value="" disabled selected>
                                Select a department
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
                            Choose the department this division belongs to.
                        </small>
                    </div>

                    {{-- Division Name --}}
                    <div class="mb-3">
                        <label for="add-division-description" class="form-label fm-label">
                            Division Name / Description
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            id="add-division-description"
                            name="description"
                            type="text"
                            class="form-control fm-input"
                            placeholder="e.g., Administrative Division"
                            maxlength="255"
                            required
                        >

                        <small class="fm-help-text">
                            Enter the official division name or description.
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

                <button
                    id="add-form-submit"
                    type="button"
                    class="btn fm-btn-primary"
                    {{ $departments->isEmpty() ? 'disabled' : '' }}
                >
                    <i class="lni lni-plus"></i>
                    Create Division
                </button>
            </div>

        </div>
    </div>
</div>
