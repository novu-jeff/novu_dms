<div class="modal fade" id="update-files-modal" tabindex="-1" aria-labelledby="updateFilesModalHelp" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <div>
            <h1 class="modal-title fs-5" id="updateFilesModalTitle">Update File</h1>
            <small class="text-muted">File to update:
                <span id="file-name-to-update" class="text-uppercase"></span>
            </small>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="update-files-form">
                <div class="w-100">
                    <label for="upload-file">Upload file</label>
                    <input class="form-control" type="file" name="file" id="file">
                    <span id="file_error" class="text-error text-danger d-none" role="alert"></span>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button id="update-file-submit" class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </div>
  </div>
