
<div class="modal fade fm-modal" id="addModal" tabindex="-1"
     aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content fm-modal-content">

            <div class="modal-header fm-modal-header">
                <div>
                    <span class="fm-modal-eyebrow">FOLDER MANAGEMENT</span>
                    <h5 class="modal-title fm-modal-title" id="modal-title">
                        Add Folder
                    </h5>
                    <p class="fm-modal-subtitle">
                        Create a folder and assign its organizational location.
                    </p>
                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>

            <div class="modal-body fm-modal-body">
                <form id="add-form">
                    <div class="mb-4">
                        <label for="folder-name" class="form-label fm-label">
                            Folder Name <span class="text-danger">*</span>
                        </label>
                        <input
                            id="folder-name"
                            name="name"
                            type="text"
                            class="form-control fm-input"
                            placeholder="Enter folder name"
                            maxlength="255"
                            required
                        >
                        <small class="fm-help-text">
                            Use a clear name that identifies the folder's contents.
                        </small>
                    </div>

                    <div class="fm-section-heading">
                        <span class="fm-section-icon">
                            <i class="lni lni-map-marker"></i>
                        </span>
                        <div>
                            <h6>Organizational Location</h6>
                            <p>Select the branch and its corresponding units.</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="branch" class="form-label fm-label">
                            Branch <span class="text-danger">*</span>
                        </label>
                        <select
                            class="form-select fm-input"
                            name="branch"
                            id="branch"
                            required
                        >
                            <option value="" disabled selected>
                                Choose branch
                            </option>
                            @forelse($branches as $branch)
                                <option value="{{ $branch->id }}">
                                    {{ $branch->description }}
                                </option>
                            @empty
                                <option value="" disabled>No branches available</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="department" class="form-label fm-label">
                            Department <span class="text-danger">*</span>
                        </label>
                        <select
                            class="form-select fm-input"
                            name="department"
                            id="department"
                            required
                        >
                            <option value="" disabled selected>
                                Choose department
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="division" class="form-label fm-label">
                            Division <span class="text-danger">*</span>
                        </label>
                        <select
                            class="form-select fm-input"
                            name="division"
                            id="division"
                            required
                        >
                            <option value="" disabled selected>
                                Choose division
                            </option>
                        </select>
                    </div>

                    <div class="mb-1">
                        <label for="section" class="form-label fm-label">
                            Section <span class="text-danger">*</span>
                        </label>
                        <select
                            class="form-select fm-input"
                            name="section"
                            id="section"
                            required
                        >
                            <option value="" disabled selected>
                                Choose section
                            </option>
                        </select>
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
                        class="btn fm-btn-primary">
                    <i class="lni lni-plus"></i>
                    Create Folder
                </button>

                <button id="update-form-submit"
                        type="button"
                        class="btn fm-btn-primary">
                    <i class="lni lni-checkmark"></i>
                    Save Changes
                </button>
            </div>

        </div>
    </div>
</div>
