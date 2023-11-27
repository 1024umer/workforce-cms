<!-- Modal -->
<div class="modal fade create-task-modal" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-block text-center w-100" id="createProjectModalLabel">Create Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form method="POST" action="{{route('projects.store')}}">
                    @csrf
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" name="title" class="form-control mb-3" placeholder="Project Title" />
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