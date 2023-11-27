<!-- Modal -->
<div class="modal fade create-task-modal" id="createdTaskProjectModal" tabindex="-1" aria-labelledby="createdTaskProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-block text-center w-100" id="createdTaskProjectModalLabel">Create Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form method="POST" id="create_project_task" onsubmit="onSubmitCreateTask(event)">
                        @csrf
                        <input type="hidden" name="grid_id" id="create_task_grid_id" />
                        <input type="hidden" name="project_id" id="create_task_project_id" />
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <input required type="text" name="title" class="form-control mb-3" placeholder="Title" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <textarea id="create_task_description" name="description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <input type="file" name="files[]" class="form-control mb-3" multiple />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <select required class="form-control mb-3" name="user_id">
                                        <option value="">Select User</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}} ({{$user->email}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="date" required name="due_date" class="form-control mb-3" placeholder="Due Date" />
                                </div>
                                <div class="col-md-6">
                                    <input type="time" required name="due_time" class="form-control mb-3" placeholder="Due Time" />
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
@push('js')
<script>
var create_task_project_id = 0, create_task_grid_id = 0, create_task_callback, create_task_editor;
async function openTaskModalProject(project_id, grid_id, callback){
    create_task_grid_id = grid_id
    create_task_project_id = project_id
    create_task_callback = callback
    $('#create_task_grid_id').val(create_task_grid_id)
    $('#create_task_project_id').val(create_task_project_id)
    $('#createdTaskProjectModal').modal('show');
}
async function onSubmitCreateTask(event){
    event.preventDefault()
    $('#create_task_description').val(create_task_editor.getData())
    var formData = new FormData(document.getElementById('create_project_task'))
    await axios.post('/projects/'+create_task_project_id+'/tasks/otherproject', formData).then(e=>e.data).then(e=>{
        if(e.status){
            location.reload()
        }
    })
    // $('#create_project_task').
    return false
}
ClassicEditor
.create( document.querySelector( '#create_task_description' ) ).then(e=>{
    create_task_editor = e
})
.catch( error => {
    console.error( error );
});
</script>
@endpush