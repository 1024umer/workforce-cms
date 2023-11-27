<!-- Modal -->
<div class="modal fade create-task-modal" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title d-block text-center w-100" id="createTaskModalLabel">Create Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <i class="fa fa-close"></i>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <label>Select Task Type</label>
            <select class="form-control" name="task_type" id="createTaskTaskType">
              <option value="0">Select Task Type</option>
              @foreach($taskTypes as $taskTypek=>$taskType)
                <option value="{{$taskTypek}}">{{$taskType}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-12 text-center">
            <button onclick="createTaskNext1()" type="button" class="btn task-next w-25 mt-4">Next</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade create-task-modal" id="createTaskModal2" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title d-block text-center w-100" id="createTaskModalLabel">Create Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <i class="fa fa-close"></i>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <label>Enter Details</label>
            <input type="text" id="createTask2Title" class="form-control mb-3" placeholder="Title" />
          </div>
          <div class="col-md-12">
            <textarea placeholder="Description" name="description" id="createTask2Description"></textarea>
          </div>
          <div class="col-md-12 text-center">
            <button onclick="createTaskNext()" type="button" class="btn task-next w-25 mt-4">Start Now</button>
            <button onclick="createTaskNextWithDue()" type="button" class="btn task-next task-next-rev w-25 mt-4">Create</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade create-task-modal" id="createTaskModal3" tabindex="-1" aria-labelledby="createTaskModal3Label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title d-block text-center w-100" id="createTaskModal3Label">Set Due Date</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <i class="fa fa-close"></i>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <label>Due Date</label>
            <input type="datetime-local" id="createTask3DueDate" class="form-control mb-3" placeholder="Due Date" />
          </div>
          <div class="col-md-12 text-center">
            <button onclick="createTaskWithDue()" type="button" class="btn task-next task-next-rev w-25 mt-4">Create</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@push('js')
<script>
var myEditor;
ClassicEditor
.create( document.querySelector( '#createTask2Description' ) ).then(editor=>{
  myEditor = editor
})
.catch( error => {
    console.error( error );
});
function createTaskNext1(){
  $('#createTaskModal').modal('hide');
  setTimeout(function(){
    $('#createTaskModal2').modal('show');
  }, 400)
}
function createTaskNext(){
  const formData = new FormData();
  formData.append('description', myEditor.getData())
  formData.append('title', $('#createTask2Title').val())
  formData.append('grid', $('#createTaskTaskType').val())
  axios.post('/projects/1/tasks', formData).then(e=>e.data).then(e=>{
    if(e.status){
      $('#createTaskModal2').modal('hide');
      swal({
        title: "Task Created",
        icon: "success",
      });
      getDashboardTasks();
      window.location.href = '{{url('/')}}/projects/1/tasks/'+e.task.id+'/timers'
    }
  });
}
function createTaskNextWithDue(){
  $('#createTaskModal2').modal('hide');
  setTimeout(function(){
    $('#createTaskModal3').modal('show');
  }, 400)
}
function createTaskWithDue(){
  const formData = new FormData();
  formData.append('description', myEditor.getData())
  formData.append('title', $('#createTask2Title').val())
  formData.append('grid', $('#createTaskTaskType').val())
  formData.append('due_date', $('#createTask3DueDate').val())
  axios.post('/projects/1/tasks', formData).then(e=>e.data).then(e=>{
    if(e.status){
      $('#createTaskModal3').modal('hide');
      swal({
        title: "Task Created",
        icon: "success",
      });
      getDashboardTasks();
    }
  });
}
</script>
@endpush