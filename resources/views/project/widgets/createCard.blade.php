<!-- Modal -->
<div class="modal fade create-task-modal" id="createCardModal" tabindex="-1" aria-labelledby="createCardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-block text-center w-100" id="createCardModalLabel">Create Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form method="POST" action="{{route('projects.grids.store', $project)}}">
                    @csrf
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" name="grid_name" class="form-control mb-3" placeholder="Card Name" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn task-next w-25 mt-4">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade create-task-modal" id="updateCardModal" tabindex="-1" aria-labelledby="updateCardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-block text-center w-100" id="updateCardModalLabel">Update Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form method="POST" id="update-card-name-form">
                    @csrf
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="project_id" />
                                    <input type="hidden" name="grid_id" />
                                    <input type="text" name="grid_name" class="form-control mb-3" placeholder="Card Name" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn task-next w-25 mt-4">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>