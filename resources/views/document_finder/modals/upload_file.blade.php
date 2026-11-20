
<div
    class="modal fade fm-modal"
    id="upload-files-modal"
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
                        Upload File
                    </h5>
                    <p class="fm-modal-subtitle">
                        Attach one or more files to this document.
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
                    <i class="lni lni-cloud-upload" aria-hidden="true"></i>
                </div>

                <form id="upload-files-form" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="file" class="fm-label">
                            Select Files
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            class="form-control fm-input"
                            type="file"
                            name="file[]"
                            id="file"
                            multiple
                            required
                            aria-describedby="file-help file_error"
                        >

                        <p class="fm-help-text" id="file-help">
                            You can select multiple files. Make sure each file
                            meets the system's allowed file type and size limits.
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
                        Selected files will be attached to the current document
                        when you save.
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
                    id="upload-file-submit"
                    class="fm-btn-primary"
                >
                    <i class="lni lni-upload" aria-hidden="true"></i>
                    Upload Files
                </button>
            </div>

        </div>
    </div>
</div>
