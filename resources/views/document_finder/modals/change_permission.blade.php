<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Update Permission</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="col-12">
                <div class="input-style-1">
                    <div class="select-style-1">
                        <label for="branch">{{ __('Document Permission') }}</label>
                        <div class="select-position">
                            <select name="permission" id="permission" required>
                                <option id="default" value="" selected>Choose Permission</option>
                                <option value="1">Public</option>
                                <option value="2">Private</option>
                                <option value="3">Confidential</option>
                            </select>
                        </div>
                        @error('branch')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button id="permission-submit" type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
