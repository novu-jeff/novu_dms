<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editModalLabel">Update Document</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="edit-document-form">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="title" class="form-label">Document Title</label>
                        <input id="title" name="title" type="text" class="form-control" aria-describedby="titleHelp">
                    </div>
                    <div class="col-12 mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input id="author" name="author" type="text" class="form-control" aria-describedby="authorHelp">
                    </div>
                    <div class="col-12 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" type="text" class="form-control" aria-describedby="descriptionHelp" rows="3"></textarea>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="tags" class="form-label">{{ __('Tags') }}</label>
                        <input type="text"class="form-control" name="tags"
                               id="tags"
                               value="" required>
                        <div id="tagsHelpBlock" class="form-text">
                            Indicate multiple tags by comma seperated values e.g. (tag1, tag2, tag3)
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="type" class="form-label">{{ __('Document Type') }}</label>
                        <div class="col-12 d-flex flex-column">
                            <div class="form-check radio-style mb-20 me-3">
                                <input class="form-check-input"
                                       name="type"
                                       type="radio" value="1" id="radio-4" required>
                                <label class="form-check-label" for="radio-4">
                                    Committee Report</label>
                            </div>

                            <div class="form-check radio-style mb-20 me-3">
                                <input class="form-check-input"
                                       name="type" type="radio" value="2" id="radio-5" required>
                                <label class="form-check-label" for="radio-5">
                                    Resolution</label>
                            </div>

                            <div class="form-check radio-style mb-20 me-3">
                                <input class="form-check-input"
                                       name="type" type="radio" value="3" id="radio-6" required>
                                <label class="form-check-label" for="radio-6">
                                    Ordinance</label>
                            </div>

                            <div class="form-check radio-style mb-20 me-3">
                                <input class="form-check-input"
                                       name="type" type="radio" value="4" id="radio-6" required>
                                <label class="form-check-label" for="radio-6">
                                    Session Meeting</label>
                            </div>

                            <div class="form-check radio-style mb-20 me-3">
                                <input class="form-check-input"
                                       name="type" type="radio" value="5" id="radio-6" required>
                                <label class="form-check-label" for="radio-6">
                                    Executive Order</label>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button id="update-document-submit" type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
