<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/classic/ckeditor.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="https://kit.fontawesome.com/8ec810e844.js" crossorigin="anonymous"></script>
<script src="{{asset('js/slick.min.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>
<script src="{{asset('js/jwtdecode.js')}}"></script>
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script>
const { createApp } = Vue
const instance = axios.create({
    baseURL: '{{url('/')}}'
});

// Alter defaults after instance has been created
instance.defaults.headers.common['X-CSRF-Token'] = '{{ csrf_token() }}';
// instance.defaults.headers.common['Content-type'] = 'application/x-www-form-urlencoded';
// $('.collapse').collapse()
var seconds = 0;
setInterval(() => {
    seconds++;
    $('.task-timer-running').each(function(){
        var startTime = $(this).data('timer')
        var serverTime = $(this).data('servertime')
        var today = new Date(startTime);
        var Christmas = new Date(serverTime);
        Christmas = new Date(Christmas.getTime()+(seconds*1000))
        var diffMs = (Christmas - today); // milliseconds between now & Christmas
        var diffDays = Math.floor(diffMs / 86400000); // days
        var diffHrs = Math.floor((diffMs % 86400000) / 3600000); // hours
        var diffMins = Math.round(((diffMs % 86400000) % 3600000) / 60000); // minutes
        var _html = ((diffDays>0?(diffDays+' D '): ''))+diffHrs+' H '+diffMins+' M'
        $(this).html(_html)
        // console.log(diffDays + " days, " + diffHrs + " hours, " + diffMins + " minutes until Christmas =)");
    })
}, 1000);
setInterval(() => {
    if (Notification.permission !== 'granted'){
        Notification.requestPermission();
    }
    else {
        @auth
        @if($isTimerRunning===true)
        var notification = new Notification('Workforce Management', {
            icon: '{{asset('images/logo.png')}}',
            body: 'There is a Timer Running',
        });
        notification.onclick = function() {
            window.open('<?php print route('dashboard', ['opentaskmodal'=>true, 'project_id'=>$runningTimerTask->project_id, 'task_id'=>$runningTimerTask->project_task_id]); ?>')
        };
        @endif
        @endauth
    }
}, 60000);
document.addEventListener('DOMContentLoaded', function() {
    if (!Notification) {
        return;
    }
    if (Notification.permission !== 'granted'){
        Notification.requestPermission();
    }
    @if(isset($_GET['opentaskmodal']))
    var project_id = <?=$_GET['project_id']?>;
    var task_id = <?=$_GET['task_id']?>;
    openTaskModal(task_id, project_id);
    @endif
});
function searchProject(){
    $('#project-search-form')[0].submit()
}
function UpdateTitleProject(){
    $('#changeProjectTitleModal').modal('toggle')
}
function openUpdateCardModal(gid, pid){
    $('#update-card-name-form').find('[name="project_id"]').eq(0).val(pid)
    $('#update-card-name-form').find('[name="grid_id"]').eq(0).val(gid)
    $('#update-card-name-form').find('[name="grid_name"]').eq(0).val('')
    $('#updateCardModal').modal('toggle')
}
$(document).ready(function(){
    $('#update-card-name-form').submit(function(e){
        e.preventDefault()
        var pid = $('#update-card-name-form').find('[name="project_id"]').eq(0).val()
        var gid = $('#update-card-name-form').find('[name="grid_id"]').eq(0).val()
        var grid_name = $('#update-card-name-form').find('[name="grid_name"]').eq(0).val()
        if(grid_name){
            axios.post('/projects/'+pid+'/grid/edit/'+gid, {
                grid_name: grid_name
            }).then(e=>{
                $('#updateCardModal').modal('toggle')
                swal({
                    title: "Grid Name Updated",
                    icon: "success",
                    // buttons: false,
                    timer: 3000,
                });
                setTimeout(()=>{
                    window.location.reload()
                },2000)
            })
        }
        return false
    })
})
</script>