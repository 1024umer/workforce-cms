function getDashboardTasks(){
    axios.get('/dashboard/get-tasks').then(e=>e.data).then(e=>{
        $('#dashboard-today-tasks').html('')
        $('#dashboard-upcomming-tasks').html('')
        $('#dashboard-completedstop-tasks').html('')
        $('#dashboard-overdue-tasks').html('')
        $('#dashboard-completedtoday-tasks').html('')
        for(let i = 0; i < e.today.length; i++){
            const todayTask = e.today[i]
            $('#dashboard-today-tasks').append(`<li>
                <div class="row">
                    <div onclick="openTaskModal(${todayTask.id}, ${todayTask.project_id})" class="col-md-12">
                        <p><i class="fa fa-sharp fa-solid ${todayTask.is_completed==0?'fa-check-circle-o':'fa-check-circle'}"></i> ${todayTask.title}
                        <span>${(todayTask.project_id==1?todayTask.grid.grid_name:todayTask.project.title)}</span>
                        </p>
                    </div>
                </div>
            </li>`);
        }
        for(let i = 0; i < e.upcomming.length; i++){
            const upcommingTask = e.upcomming[i]
            $('#dashboard-upcomming-tasks').append(`<li>
                <div class="row">
                    <div onclick="openTaskModal(${upcommingTask.id}, ${upcommingTask.project_id})" class="col-md-12">
                        <p><i class="fa fa-sharp fa-solid ${upcommingTask.is_completed==0?'fa-check-circle-o':'fa-check-circle'}"></i> ${upcommingTask.title}
                        <span>${(upcommingTask.project_id==1?upcommingTask.grid.grid_name:upcommingTask.project.title)}</span>
                        </p>
                    </div>
                </div>
            </li>`);
        }
        for(let i = 0; i < e.overdue.length; i++){
            const overdueTask = e.overdue[i]
            $('#dashboard-overdue-tasks').append(`<li>
                <div class="row">
                    <div onclick="openTaskModal(${overdueTask.id}, ${overdueTask.project_id})" class="col-md-12">
                        <p><i class="fa fa-sharp fa-solid ${overdueTask.is_completed==0?'fa-check-circle-o':'fa-check-circle'}"></i> ${overdueTask.title}
                        <span>${(overdueTask.project_id==1?overdueTask.grid.grid_name:overdueTask.project.title)}</span>
                        </p>
                    </div>
                </div>
            </li>`);
        }
        for(let i = 0; i < e.stopped.length; i++){
            const overdueTask = e.stopped[i]
            $('#dashboard-completedstop-tasks').append(`<li>
                <div class="row">
                    <div onclick="openTaskModal(${overdueTask.id}, ${overdueTask.project_id})" class="col-md-12">
                        <p><i class="fa fa-sharp fa-solid ${overdueTask.is_completed==0?'fa-check-circle-o':'fa-check-circle'}"></i> ${overdueTask.title}
                        <span>${(overdueTask.project_id==1?overdueTask.grid.grid_name:overdueTask.project.title)}</span>
                        </p>
                    </div>
                </div>
            </li>`);
        }
        for(let i = 0; i < e.completedToday.length; i++){
            const overdueTask = e.completedToday[i]
            $('#dashboard-completedtoday-tasks').append(`<li>
                <div class="row">
                    <div onclick="openTaskModal(${overdueTask.id}, ${overdueTask.project_id})" class="col-md-8">
                        <p>${overdueTask.title}
                        <span>${(overdueTask.project_id==1?overdueTask.grid.grid_name:overdueTask.project.title)}</span>
                        </p>
                    </div>
                </div>
            </li>`);
        }
    });
}
function getProjects(){
    axios.get('/dashboard/projects').then(e=>e.data).then(e=>{
        $('#dashboard-myprojects').html('')
        $('.recent-projects-dashboard').html('')
        for(let i = 0; i < e.recentProjects.length; i++){
            const project = e.recentProjects[i]
            var collaboratorsHtml = '';
            for(let q = 0; q < project.collaborators.length; q++){
                const collaborator = project.collaborators[q]
                collaboratorsHtml+=`<li><a href="/users/${collaborator.user.id}"><img class="" src="${collaborator.user.image_url}" alt="" /></a></li>`
            }
            $('.recent-projects-dashboard').append(`
            <div class="accordion-item">
                <h2 class="accordion-header" id="sideProject${project.id}">
                    <button class="accordion-button ${(i==0?'':'collapsed')}" type="button" data-bs-toggle="collapse" data-bs-target="#sideCollapse${project.id}" aria-expanded="true" aria-controls="sideCollapse${project.id}">
                        ${project.title}
                    </button>
                </h2>
                <div id="sideCollapse${project.id}" class="accordion-collapse collapse ${(i==0?'show':'')}" aria-labelledby="sideProject${project.id}" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="added-pep">
                            <ul>
                                ${collaboratorsHtml}
                            </ul>
                        </div>
                        <a href="javascript:void(0)" onclick="inviteToProject(${project.id})" class="invite">+ Invite</a>
                        <a href="/projects/${project.id}/board" class="boardbtnpro"><i class="fas fa-list-check" aria-hidden="true"></i> Board</a>
                    </div>
                </div>
            </div>
            `)
        }
        for(let i = 0; i < e.projects.length; i++){
            const project = e.projects[i]
            var collaboratorsHtml = '';
            for(let q = 0; q < project.collaborators.length; q++){
                const collaborator = project.collaborators[q]
                collaboratorsHtml+=`<li><a href="/users/${collaborator.user.id}"><img class="" src="${collaborator.user.image_url}" alt="" /></a></li>`
            }
            $('#dashboard-myprojects').append(`<div class="col-md-6">
                <a href="/projects/${project.id}/board">
                    <div class="pjt-box">
                        <div class="pjt-box-header project-color-${project.id}">
                            <h4>${project.title}</h4>
                        </div>
                        <div class="added-pep">
                            <ul>
                                ${collaboratorsHtml}
                            </ul>
                        </div>
                    </div>
                </a>
            </div>`)
            $('#project-color-styles').append(`
                .project-list .pjt-box-header.project-color-${project.id}:before {
                    background: ${project.color_code};
                }
            `)
        }
    })
}
function inviteToProject(project_id){
    $('#invite-project-id-hdn').val(project_id)
    $('#invite-email-form').attr('action', '/projects/'+project_id+'/invite');
    $('#projectInviteModal').modal('show');
}
function openTaskModal(task_id, project_id){
    axios.get('/projects/'+project_id+'/tasks/'+task_id).then(e=>e.data).then(e=>{
        taskDetailApp.taskDetail = e.task
        taskDetailApp.projectDetail = e.project
        taskDetailApp.hoursSpent = e.hoursSpent
        taskDetailApp.subtasks = e.task.subtasks
        $('#taskDetailModal').modal('show')
    })
}
$(document).ready(function(){
    getDashboardTasks()
    getProjects()
})