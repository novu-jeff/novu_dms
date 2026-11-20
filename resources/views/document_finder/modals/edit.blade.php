
<div class="modal fade fm-modal" id="editModal" tabindex="-1"
     aria-labelledby="editDocumentModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content fm-modal-content">

            {{-- Modal Header --}}
            <div class="modal-header fm-modal-header">
                <div>
                    <span class="fm-modal-eyebrow">DOCUMENT MANAGEMENT</span>
                    <h5 class="modal-title fm-modal-title"
                        id="editDocumentModalTitle">
                        Update Document
                    </h5>
                    <p class="fm-modal-subtitle">
                        Edit the document details and classification.
                    </p>
                </div>

                <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Modal Body --}}
            <div class="modal-body fm-modal-body">
                <form id="edit-document-form">
                    <div class="fm-branch-form-icon">
                        <i class="lni lni-files"></i>
                    </div>

                    <div class="row">
                        {{-- Document Title --}}
                        <div class="col-12 mb-4">
                            <label for="title" class="form-label fm-label">
                                Document Title
                                <span class="text-danger">*</span>
                            </label>

                            <input id="title"
                                   name="title"
                                   type="text"
                                   class="form-control fm-input"
                                   placeholder="Enter document title"
                                   required>

                            <small class="fm-help-text">
                                Provide the official title of the document.
                            </small>
                        </div>

                        {{-- Author --}}
                        <div class="col-md-6 mb-4">
                            <label for="author" class="form-label fm-label">
                                Author
                                <span class="text-danger">*</span>
                            </label>

                            <input id="author"
                                   name="author"
                                   type="text"
                                   class="form-control fm-input"
                                   placeholder="Enter author name"
                                   required>

                            <small class="fm-help-text">
                                Enter the document's author or originating person.
                            </small>
                        </div>

                        {{-- Tags --}}
                        <div class="col-md-6 mb-4">
                            <label for="tags" class="form-label fm-label">
                                {{ __('Tags') }}
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   class="form-control fm-input"
                                   name="tags"
                                   id="tags"
                                   placeholder="e.g., finance, resolution, 2026"
                                   required>

                            <small class="fm-help-text">
                                Separate multiple tags with commas.
                            </small>
                        </div>

                        {{-- Description --}}
                        <div class="col-12 mb-4">
                            <label for="description" class="form-label fm-label">
                                Description
                            </label>

                            <textarea id="description"
                                      name="description"
                                      class="form-control fm-input"
                                      placeholder="Enter a brief document description"
                                      rows="4"></textarea>

                            <small class="fm-help-text">
                                Add relevant information to help identify the document.
                            </small>
                        </div>

                        {{-- Document Type --}}
                        <div class="col-12">
                            <label class="form-label fm-label d-block">
                                Document Type
                                <span class="text-danger">*</span>
                            </label>

                            <div class="fm-document-type-grid">

                                <label class="fm-document-type-option"
                                       for="edit-type-1">
                                    <input class="form-check-input"
                                           name="type"
                                           type="radio"
                                           value="1"
                                           id="edit-type-1"
                                           required>
                                    <span class="fm-document-type-icon">
                                        <i class="lni lni-files"></i>
                                    </span>
                                    <span class="fm-document-type-text">
                                        Committee Report
                                    </span>
                                </label>

                                <label class="fm-document-type-option"
                                       for="edit-type-2">
                                    <input class="form-check-input"
                                           name="type"
                                           type="radio"
                                           value="2"
                                           id="edit-type-2"
                                           required>
                                    <span class="fm-document-type-icon">
                                        <i class="lni lni-agenda"></i>
                                    </span>
                                    <span class="fm-document-type-text">
                                        Resolution
                                    </span>
                                </label>

                                <label class="fm-document-type-option"
                                       for="edit-type-3">
                                    <input class="form-check-input"
                                           name="type"
                                           type="radio"
                                           value="3"
                                           id="edit-type-3"
                                           required>
                                    <span class="fm-document-type-icon">
                                        <i class="lni lni-book"></i>
                                    </span>
                                    <span class="fm-document-type-text">
                                        Ordinance
                                    </span>
                                </label>

                                <label class="fm-document-type-option"
                                       for="edit-type-4">
                                    <input class="form-check-input"
                                           name="type"
                                           type="radio"
                                           value="4"
                                           id="edit-type-4"
                                           required>
                                    <span class="fm-document-type-icon">
                                        <i class="lni lni-calendar"></i>
                                    </span>
                                    <span class="fm-document-type-text">
                                        Session Meeting
                                    </span>
                                </label>

                                <label class="fm-document-type-option"
                                       for="edit-type-5">
                                    <input class="form-check-input"
                                           name="type"
                                           type="radio"
                                           value="5"
                                           id="edit-type-5"
                                           required>
                                    <span class="fm-document-type-icon">
                                        <i class="lni lni-briefcase"></i>
                                    </span>
                                    <span class="fm-document-type-text">
                                        Executive Order
                                    </span>
                                </label>

                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Modal Footer --}}
            <div class="modal-footer fm-modal-footer">
                <button type="button"
                        class="btn fm-btn-cancel"
                        data-bs-dismiss="modal">
                    Cancel
                </button>

                <button id="update-document-submit"
                        type="button"
                        class="btn fm-btn-primary">
                    <i class="lni lni-save"></i>
                    Save Changes
                </button>
            </div>

        </div>
    </div>
</div>
