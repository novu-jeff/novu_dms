
<div
    class="modal fade fm-modal"
    id="update-files-modal"
    tabindex="-1"
    aria-labelledby="updateFilesModalTitle"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content fm-modal-content">

            <!-- Header -->
            <div class="modal-header fm-modal-header">
                <div class="fm-modal-heading">
                    <span class="fm-modal-eyebrow">DOCUMENT MANAGEMENT</span>

                    <h5 class="fm-modal-title" id="updateFilesModalTitle">
                        Update File
                    </h5>

                    <p class="fm-modal-subtitle">
                        Replace the existing attachment with a new file.
                    </p>
                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>

            <!-- Body -->
            <div class="modal-body fm-modal-body">
                <div class="fm-branch-form-icon">
                    <i class="lni lni-files" aria-hidden="true"></i>
                </div>

                <div class="mb-4">
                    <label class="fm-label">File to Update</label>

                    <div class="fm-file-current">
                        <div class="fm-file-current-icon">
                            <i class="lni lni-file" aria-hidden="true"></i>
                        </div>

                        <div class="fm-file-current-info">
                            <span class="fm-file-current-label">
                                CURRENT ATTACHMENT
                            </span>

                            <span
                                id="file-name-to-update"
                                class="fm-file-current-name text-uppercase"
                            ></span>
                        </div>
                    </div>
                </div>

                <form id="update-files-form" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="file" class="fm-label">
                            Select Replacement File
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            class="form-control fm-input"
                            type="file"
                            name="file"
                            id="file"
                            required
                            aria-describedby="update-file-help file_error"
                        >

                        <p class="fm-help-text" id="update-file-help">
                            Choose the new file that will replace the current
                            attachment.
                        </p>

                        <span
                            id="file_error"
                            class="text-error text-danger d-none"
                            role="alert"
                        ></span>
                    </div>
                </form>

                <div class="fm-files-note">
                    <i class="lni lni-information" aria-hidden="true"></i>
                    <span>
                        Ensure the replacement file is correct before saving.
                        The system's existing file replacement behavior will apply.
                    </span>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer fm-modal-footer">
                <button
                    type="button"
                    class="fm-btn-cancel"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    id="update-file-submit"
                    class="fm-btn-primary"
                >
                    <i class="lni lni-save" aria-hidden="true"></i>
                    Update File
                </button>
            </div>

        </div>
    </div>
</div>
