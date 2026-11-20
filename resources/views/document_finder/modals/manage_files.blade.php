
<div class="modal fade fm-modal" id="manage-files-modal" tabindex="-1"
     aria-labelledby="manageFilesModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content fm-modal-content">

            {{-- Header --}}
            <div class="modal-header fm-modal-header">
                <div>
                    <span class="fm-modal-eyebrow">DOCUMENT MANAGEMENT</span>
                    <h5 class="modal-title fm-modal-title" id="manageFilesModalTitle">
                        Manage Files
                    </h5>
                    <p class="fm-modal-subtitle">
                        View, upload, download, and manage document attachments.
                    </p>
                </div>

                <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body fm-modal-body">

                <div class="fm-files-toolbar">
                    <div class="fm-files-toolbar-info">
                        <div class="fm-files-toolbar-icon">
                            <i class="lni lni-files"></i>
                        </div>
                        <div>
                            <h6 class="fm-files-toolbar-title">Document Attachments</h6>
                            <p class="fm-files-toolbar-subtitle">
                                Files associated with this document.
                            </p>
                        </div>
                    </div>

                    <button type="button"
                            id="upload-file-button-modal"
                            class="btn fm-create-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#upload-files-modal">
                        <i class="lni lni-upload"></i>
                        Upload File
                    </button>
                </div>

                <div class="fm-files-table-wrapper">
                    <table class="table fm-table align-middle w-100">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Size</th>
                                <th>Date Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody id="manage-files-tbody">
                            {{-- Populate this tbody using your existing JavaScript. --}}
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="fm-files-empty">
                                        <div class="fm-files-empty-icon">
                                            <i class="lni lni-files"></i>
                                        </div>
                                        <h6>No files to display</h6>
                                        <p>
                                            Uploaded attachments will appear here.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="fm-files-note">
                    <i class="lni lni-information"></i>
                    <span>
                        Ensure that uploaded files are correct before sharing or downloading them.
                    </span>
                </div>
            </div>

            {{-- Footer --}}
            <div class="modal-footer fm-modal-footer">
                <button type="button"
                        class="btn fm-btn-cancel"
                        data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>
