<div class="modal fade" id="upload-files-modal" tabindex="-1" aria-labelledby="updateFilesModalHelp" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <div>
            <h1 class="modal-title fs-5" id="updateFilesModalTitle">Upload File</h1>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="upload-files-form">
                <div class="w-100">
                    <label for="upload-file">Upload file</label>
                    <input class="form-control" type="file" name="file[]" id="file" multiple>
                    <span id="file_error" class="text-error text-danger d-none" role="alert"></span>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button id="upload-file-submit" class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </div>
  </div>
