<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="add-form">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="branch" class="form-label">Branch</label>
                            <select class="form-select form-control" name="branch">
                                @forelse($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->description }}</option>
                                @empty
                                    <option value="">No results</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Department description/name</label>
                            <input name="description" type="text" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="add-form-submit" type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
