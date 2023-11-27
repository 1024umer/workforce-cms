<!-- Modal -->
<div class="modal fade create-task-modal" id="projectInviteModal" tabindex="-1" aria-labelledby="projectInviteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title d-block text-center w-100" id="projectInviteModalLabel">Invite to Project</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <i class="fa fa-close"></i>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <nav>
              <div class="nav nav-tabs" id="invite-tab" role="tablist">
                <button class="nav-link active" id="nav-invite-email-tab" data-bs-toggle="tab" data-bs-target="#nav-invite-email" type="button" role="tab" aria-controls="nav-invite-email" aria-selected="true">Share</button>
                <button class="nav-link" id="nav-invite-member-tab" data-bs-toggle="tab" data-bs-target="#nav-invite-member" type="button" role="tab" aria-controls="nav-invite-member" aria-selected="false">Members</button>
              </div>
            </nav>
          </div>
          <div class="col-md-12">
            <div class="tab-content" id="nav-tabContentInvite">
              <div class="tab-pane fade show active" id="nav-invite-email" role="tabpanel" aria-labelledby="nav-invite-email-tab" tabindex="0">
                  <form method="POST" id="invite-email-form" action="">
                    @csrf
                    <div class="row">
                      <label>Invite With Email</label>
                      <input type="email" name="email" class="form-control" placeholder="Add Project Members By Email" />
                    </div>
                    <div class="row">
                      <div class="col-md-12 text-center">
                        <button type="submit" class="btn task-next w-25 mt-4">Invite Member</button>
                      </div>
                    </div>
                  </form>
              </div>
              <div class="tab-pane fade" id="nav-invite-member" role="tabpanel" aria-labelledby="nav-invite-member-tab" tabindex="0">
                  <div class="row mt-4">
                    <input type="hidden" id="invite-project-id-hdn" />
                    <h4>Select Member to Invite</h4>
                    <input type="text" class="form-control mb-3" id="user-invite-search" placeholder="Search User by Email/Name" />
                    <ul class="birthdays-ul" id="invite-tbody">

                    </ul>
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
var userTyping;
function getUsers(){
  if($('#user-invite-search').val()){
    clearInterval(userTyping)
    userTyping = setInterval(() => {
      clearInterval(userTyping)
      $('#invite-tbody').html('')
      let project_id = $('#invite-project-id-hdn').val()
      axios.get('{{route('users.index')}}?search='+$('#user-invite-search').val()+'&project_id='+project_id).then(e=>e.data.data).then(e=>{
        for(let i = 0; i < e.length; i++){
          $('#invite-tbody').append(`
          <a class="list-group-item list-group-item-action" href="/projects/${project_id}/invite/${e[i].id}">
            <img class="img-avatar" src="${e[i].image_url}" />${e[i].name}</a>
          `);
        }
      })
    }, 500);
  }
}
$(document).ready(function(){
  $('#user-invite-search').keyup(function(){
    getUsers()
  });
})
</script>
@endpush