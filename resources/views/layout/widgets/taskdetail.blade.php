<!-- Modal -->
<div id="taskDetailDiv">
  <div class="modal right fade task-detail-modal" id="taskDetailModal" tabindex="-1" aria-labelledby="taskDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <a v-if="taskDetail.is_completed==0" href="javascript:void(0)" @click="completeToggle" class="btn"><i class="fa fa-check-circle-o"></i> Mark Complete</a>
          <a v-else href="javascript:void(0)" @click="completeToggle" class="btn"> Open Task</a>
          <ul class="opt-main">
            <!-- <li><a href="#"><i class="fas fa-thumbs-up"></i></a></li>
            <li><a href="#"><i class="fas fa-link"></i></a></li>
            <li><a href="#"><i class="fas fa-window-restore"></i></a></li>
            <li><a href="#"><i class="fas fa-expand"></i></a></li>
            <li> <a href="javascript:void(0);" type="button" class="dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis" aria-hidden="true"></i></a>
              <ul class="dropdown-menu"><a href="javascript:void(0);" type="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                </a>
                <li><a href="javascript:void(0);" type="button" class="dropdown-toggle" data-bs-toggle="dropdown"></a><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
              </ul>
            </li> -->
          </ul>
        </div>
        <div class="modal-body">
          <h3 v-if="!showTaskTitleInput">@{{taskDetail.title}} <a @click="updateTaskTitle" href="javascript:void(0)"><i class="fas fa-pen"></i></a></h3>
          <input v-else type="text" :value="taskDetail.title" @blur="saveTaskTitle" class="form-control" placeholder="Update Task Title" />
          <div class="row divi">
            <div class="col-md-3">
              <h4>Assignee:</h4>
            </div>
            <div class="col-md-9">
              <span class="db"><img :src="taskDetail?.assigned?.image_url" alt="profile picture" class="img-avatar"> @{{taskDetail?.assigned?.name}} <a href="javascript:void(0);"><i class="fas fa-times-circle"></i></a></span>
              <a href="javascript:void(0);" type="button" class="dropdown-toggle" data-bs-toggle="dropdown">@{{taskDetail?.grid?.grid_name}} </a>
              <ul class="dropdown-menu">
                <li v-for="grid in projectDetail.grids"><a class="dropdown-item" href="javascript:void(0)" @click="gridUpdate(grid.id)">@{{grid.grid_name}}</a></li>
              </ul>
              <a href="javascript:void(0);" type="button" class="dropdown-toggle priority-dropdown-btn" data-bs-toggle="dropdown">
                <span v-show="(taskDetail.is_priority==priorityk?true:false)" :class="'badge bg-'+priority.label" v-for="(priority, priorityk) in priorities">@{{priority.name}}</span>
              </a>
              <ul class="dropdown-menu priority-dropdown">
                <li v-for="(priority, priorityk) in priorities">
                  <a class="dropdown-item" href="javascript:void(0)" @click="priorityUpdate(priorityk)">
                    <span :class="'badge bg-'+priority.label">@{{priority.name}}</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="row divi">
            <div class="col-md-3">
              <h4>Due Date:</h4>
            </div>
            <div class="col-md-9">
              <span v-if="showPicker==false" @click="showPicker=true" class="db"><span class="calen"><i class="far fa-calendar-alt"></i></span> 
                @{{taskDetail.due_date}} 
              </span>
              <span v-else class="db"><span class="calen"><i class="far fa-calendar-alt"></i></span> 
                <input @change="updateDueDate" type="datetime-local" :value="taskDetail.due_date" />
              </span>
            </div>
          </div>
          <div class="row divi">
            <div class="col-md-3">
              <h4>Timer:</h4>
            </div>
            <div class="col-md-9">
              <span class="db">
                <span class="calen">
                  <i class="far fa-clock" :class="(taskDetail.is_timer_running==1?'fa-spin':'')"></i>
                </span>
                @{{hoursSpent>0?(parseFloat(hoursSpent).toFixed(2)):0}} Hours
              </span>
              <button class="btn btn-dark" @click="toggleTimer">
                @{{taskDetail.is_timer_running==1?'Stop':'Start'}}
              </button>
            </div>
          </div>
          <div class="row divi" v-if="taskDetail.project_id!=1">
            <div class="col-md-3">
              <h4>Projects:</h4>
            </div>
            <div class="col-md-9"><a :href="`/projects/${projectDetail.id}/board`" class="link">@{{projectDetail.title}}</a></div>
          </div>
          <div class="row divi">
            <div class="col-md-3">
              <h4>Description:</h4>
            </div>
            <div class="col-md-9" v-html="taskDetail.description"></div>
          </div>
          <hr>
          <div class="desc-box">
            <p class="subtask-div" v-for="(subtask, subtaskk) in subtasks" :key="subtask.id">
              <button @click="updateSubTask(subtask.id, subtaskk)" class="btn btn-sm btn-lis" :class="(subtask.is_completed==1?'text-success':'')" type="button">
                <i class="fa fa-sharp fa-solid" :class="subtask.is_completed==0?'fa-check':'fa-check'" aria-hidden="true"></i>
              </button>
              <button @click="deleteSubTask(subtask.id, subtaskk)" class="btn btn-sm text-danger" type="button">
                <i class="fa fa-sharp fa-solid fa-times" aria-hidden="true"></i>
              </button>
              <span @blur="updateSubTaskDescription(subtask.id, subtaskk)" :id="'subtaskdescription'+subtask.id" contenteditable="true" v-html="subtask.description"></span>
            </p>
            <button @click="addSubtask" type="button" class="btn subbtn"><i class="fas fa-plus-circle" aria-hidden="true"></i> Add Subtask</button>

            <section class="comment-section">
              <div class="comment">
                <div v-for="comment in taskDetail.comments" class="d-flex">
                  <div class="flex-shrink-0">
                    <img :src="comment?.user?.image_url" alt="profile picture" class="img-avatar">
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <a :href="'/users/'+comment?.user_id" target="_blank"> <span class="name">@{{comment?.user?.name}}</span></a>
                    <div class="dip" :class="comment.comment_type==1?'othercomment':''" v-html="comment.comment">
                    </div>
                    <ul class="list-group list-group-horizontal p-0 pt-2" v-if="comment.files.length>0">
                      <a v-for="file in comment.files" :key="file.id" class="list-group-item list-group-item-action" :href="file.full_url" target="_blank">@{{file.original_name}}</a>
                    </ul>
                    <span class="date">@{{comment.created_at_formatted}}</span>
                  </div>
                </div>
              </div>
            </section>
            <div class="d-flex media">
              <div class="flex-grow-1 ms-3">
                <textarea class="form-control" id="task-comment" rows="5" placeholder="Ask a question or post an update..."></textarea>
                <div class="row">
                  <div class="col-md-12 mt-3">
                    <input class="form-control" multiple id="task-files" type="file" id="formFile">
                  </div>
                  <div class="col-md-3">
                    <button type="button" @click="postTaskComment" class="btn">Send</button>
                  </div>
                  <div class="col-md-9 ddes">
                    <a :href="`/projects/${projectDetail.id}/tasks/${taskDetail.id}/collaborators`">
                      <div class="added-pep">
                        <ul>
                          <li v-for="collaborator in taskDetail.collaborators"><img class="" :src="collaborator.user.image_url" alt=""></li>
                        </ul>
                        </div><i class="fas fa-plus-circle"></i> Collaborators
                      </a>
                      <!-- <a href="javascript:void(0);" class="leave"><i class="fas fa-bell"></i> Leave task</a> -->
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@push('js')
<script>
  const taskDetailApp = createApp({
    data() {
      return {
        taskDetail: {},
        projectDetail: {},
        hoursSpent: 0,
        priorities: JSON.parse('<?php print json_encode($taskPriorities); ?>'),
        subtasks: [],
        showPicker: false,
        showTaskTitleInput: false,
      }
    },
    methods:{
      updateTaskTitle(){
        this.showTaskTitleInput = true
      },
      saveTaskTitle(e){
        const formData = new FormData();
        formData.append('title', e.target.value)
        axios.post('/projects/'+this.projectDetail.id+'/tasks/'+this.taskDetail.id+'/updateTaskTitle', formData).then(e=>{
          openTaskModal(this.taskDetail.id, this.projectDetail.id)
          this.showTaskTitleInput = false
        });
      },
      async deleteSubTask(id, key){
        await axios.delete('/projects/'+this.projectDetail.id+'/tasks/'+this.taskDetail.id+'/subtasks/'+id)
        this.subtasks.splice(key, 1);
      },
      async updateSubTask(id, key){
        const formData = new FormData();
        var is_completed = 0;
        if(this.subtasks[key].is_completed==1){
          is_completed = 0
        }else if(this.subtasks[key].is_completed==0){
          is_completed = 1
        }
        formData.append('is_completed', is_completed)
        const {subtask}  = await axios.post('/projects/'+this.projectDetail.id+'/tasks/'+this.taskDetail.id+'/subtasks/update/'+id, formData).then(e=>e.data)
        this.subtasks[key] = (subtask)
      },
      async updateSubTaskDescription(id, key){
        const formData = new FormData();
        formData.append('description', document.getElementById('subtaskdescription'+id).innerHTML)
        const {subtask}  = await axios.post('/projects/'+this.projectDetail.id+'/tasks/'+this.taskDetail.id+'/subtasks/update/'+id, formData).then(e=>e.data)
        this.subtasks[key] = (subtask)
      },
      async addSubtask(){
        const {subtask}  = await axios.post('/projects/'+this.projectDetail.id+'/tasks/'+this.taskDetail.id+'/subtasks/store').then(e=>e.data)
        this.subtasks.push(subtask)
      },
      async toggleTimer(){
        await axios.get('/projects/'+this.projectDetail.id+'/tasks/'+this.taskDetail.id+'/timers?ajax=true')
        openTaskModal(this.taskDetail.id, this.projectDetail.id)
      },
      postTaskComment(){
        const comment = postComment.getData()
        if(comment){
          const formData = new FormData()
          formData.append('comment', comment);
          var ins = document.getElementById('task-files').files.length;
          for (var x = 0; x < ins; x++) {
            formData.append("files["+x+"]", document.getElementById('task-files').files[x]);
          }
          axios.post('/projects/'+this.projectDetail.id+'/tasks/'+this.taskDetail.id+'/comments', formData).then(e=>{
            openTaskModal(this.taskDetail.id, this.projectDetail.id)
            postComment.setData('')
            document.getElementById('task-files').value = '';
          });
        }
      },
      gridUpdate(grid_id){
        axios.post('/projects/'+this.projectDetail.id+'/tasks/'+this.taskDetail.id+'/gridUpdate', {
          grid_id: grid_id
        }).then(e=>{
          openTaskModal(this.taskDetail.id, this.projectDetail.id)
        });
      },
      priorityUpdate(priorityId){
        axios.post('/projects/'+this.projectDetail.id+'/tasks/'+this.taskDetail.id+'/priorityUpdate', {
          priority: priorityId
        }).then(e=>{
          openTaskModal(this.taskDetail.id, this.projectDetail.id)
        });
      },
      async updateDueDate(event){
        axios.post('/projects/'+this.projectDetail.id+'/tasks/'+this.taskDetail.id+'/dueDateUpdate', {
          due_date: event.target.value
        }).then(e=>{
          this.showPicker = false
          openTaskModal(this.taskDetail.id, this.projectDetail.id)
        });
      },
      async completeToggle(){
        axios.get('/projects/'+this.projectDetail.id+'/tasks/'+this.taskDetail.id+'/completeToggle').then(e=>{
          openTaskModal(this.taskDetail.id, this.projectDetail.id)
        });
      }
    }
  }).mount('#taskDetailDiv')
</script>
<script>
  var postComment; 
  ClassicEditor
  .create(document.querySelector('#task-comment')).then(e=>{
    postComment = e
  })
  .catch(error => {
    console.error(error);
  });
</script>
@endpush