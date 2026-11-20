
<div class="modal fade fm-modal" id="addModal" tabindex="-1"
     aria-labelledby="addBranchModalTitle" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content fm-modal-content">

            <div class="modal-header fm-modal-header">
                <div>
                    <span class="fm-modal-eyebrow">LOCATION MANAGEMENT</span>
                    <h5 class="modal-title fm-modal-title" id="addBranchModalTitle">
                        Add Branch
                    </h5>
                    <p class="fm-modal-subtitle">
                        Register a new branch in your organization.
                    </p>
                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>

            <div class="modal-body fm-modal-body">
                <form id="add-form">
                    <div class="fm-branch-form-icon">
                        <i class="lni lni-apartment"></i>
                    </div>

                    <div class="mb-3">
                        <label for="branch-description" class="form-label fm-label">
                            Branch Description / Name
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            name="description"
                            type="text"
                            class="form-control fm-input"
                            id="branch-description"
                            placeholder="e.g., Main Office"
                            maxlength="255"
                            autocomplete="organization"
                            required
                        >

                        <small class="fm-help-text">
                            Enter the official name or description of the branch.
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
                        class="btn fm-btn-primary">
                    <i class="lni lni-plus"></i>
                    Create Branch
                </button>
            </div>

        </div>
    </div>
</div>
