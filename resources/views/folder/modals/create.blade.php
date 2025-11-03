<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Add Folder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="add-form">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="exampleInputEmail1" class="form-label">Folder name</label>
                            <input name="name" type="text" class="form-control" aria-describedby="emailHelp">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="branch" class="form-label">Branch</label>
                            <select class="form-select form-control" name="branch" id="branch">
                                <option value="" disabled selected>Choose branch</option>
                                @forelse($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->description }}</option>
                                @empty
                                    <option value="">No results</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="department" class="form-label">Department</label>
                            <select class="form-select form-control" name="department" id="department">
                                <option value="" disabled selected>Choose department</option>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="division" class="form-label">Division</label>
                            <select class="form-select form-control" name="division" id="division">
                                <option value="" disabled selected>Choose division</option>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="section" class="form-label">Section</label>
                            <select class="form-select form-control" name="section" id="section">
                                <option value="" disabled selected>Choose section</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="add-form-submit" type="button" class="btn btn-primary">Save changes</button>
                <button id="update-form-submit" type="button" class="btn btn-primary">Update changes</button>
            </div>
        </div>
    </div>
</div>
