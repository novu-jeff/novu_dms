
<div class="modal fade fm-modal" id="updateModal" tabindex="-1"
     aria-labelledby="updateBranchModalTitle" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content fm-modal-content">

            <div class="modal-header fm-modal-header">
                <div>
                    <span class="fm-modal-eyebrow">LOCATION MANAGEMENT</span>
                    <h5 class="modal-title fm-modal-title" id="updateBranchModalTitle">
                        Edit Branch
                    </h5>
                    <p class="fm-modal-subtitle">
                        Update the name or description of this branch.
                    </p>
                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>

            <div class="modal-body fm-modal-body">
                <form id="update-form">
                    <div class="fm-branch-form-icon">
                        <i class="lni lni-pencil"></i>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fm-label">
                            Branch Description / Name
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            id="description"
                            name="description"
                            type="text"
                            class="form-control fm-input"
                            placeholder="Enter branch name"
                            maxlength="255"
                            autocomplete="organization"
                            required
                        >

                        <small class="fm-help-text">
                            Make sure the branch name is accurate before saving.
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
                    <i class="lni lni-checkmark"></i>
                    Save Changes
                </button>
            </div>

        </div>
    </div>
</div>
