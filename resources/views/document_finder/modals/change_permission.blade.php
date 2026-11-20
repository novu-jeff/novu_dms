
<div class="modal fade fm-modal" id="exampleModal" tabindex="-1"
     aria-labelledby="updatePermissionModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content fm-modal-content">

            <div class="modal-header fm-modal-header">
                <div>
                    <span class="fm-modal-eyebrow">DOCUMENT MANAGEMENT</span>
                    <h5 class="modal-title fm-modal-title"
                        id="updatePermissionModalTitle">
                        Update Permission
                    </h5>
                    <p class="fm-modal-subtitle">
                        Control who can access this document.
                    </p>
                </div>

                <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body fm-modal-body">
                <div class="fm-branch-form-icon">
                    <i class="lni lni-lock"></i>
                </div>

                <div class="mb-3">
                    <label for="permission" class="form-label fm-label">
                        Document Permission
                        <span class="text-danger">*</span>
                    </label>

                    <select name="permission"
                            id="permission"
                            class="form-select fm-input"
                            required>
                        <option id="default" value="" selected disabled>
                            Choose permission
                        </option>
                        <option value="1">Public</option>
                        <option value="2">Private</option>
                        <option value="3">Confidential</option>
                    </select>

                    <small class="fm-help-text">
                        <strong>Public:</strong> Accessible to users according to your application's public-access rules.
                        <br>
                        <strong>Private:</strong> Restricted to authorized users.
                        <br>
                        <strong>Confidential:</strong> Intended for users with specific authorization.
                    </small>
                </div>
            </div>

            <div class="modal-footer fm-modal-footer">
                <button type="button"
                        class="btn fm-btn-cancel"
                        data-bs-dismiss="modal">
                    Cancel
                </button>

                <button id="permission-submit"
                        type="button"
                        class="btn fm-btn-primary">
                    <i class="lni lni-save"></i>
                    Save Changes
                </button>
            </div>

        </div>
    </div>
</div>
