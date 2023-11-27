<div class="col-md-12">
    <hr>
    <div class="d-grid gap-2" id="google_btn">
        <button id="loginbtnggl" onclick="logintoGoogle()" class="btn btn-block btn-danger"><i class="fa fa-google"></i> Login with Google</button>
        <button id="logoutbtnggl" onclick="logoutGoogle()" class="btn btn-block btn-danger"><i class="fa fa-google"></i> Logout Google</button>
    </div>
    <hr>
    <div id="gcalendar"></div>
</div>
@push('js')
@php
$clientId = '854782184217-0dlq84m7su85a5mgo5afo8sj99sccrdt.apps.googleusercontent.com';
$apiKey = 'AIzaSyCEZ-WUQaPFP42PNZfT5cUtCtypmd-r_9E';
$email = strtolower(auth()->user()->email);
if (str_contains($email, 'empireonegs.com')) { 
  $apiKey = 'AIzaSyAH9M25bBe9hVsazZlaKRUvde3Bf3OA1nA';
  $clientId = '267913962202-hshno0lpga3g4qv32sdnq1ga2a85034i.apps.googleusercontent.com';
}
if (str_contains($email, 'empireonecredit.com')) { 
  $apiKey = 'AIzaSyCP3EUOwZ1lEDZMfwwFwnrwbxAhTecZ_zI';
  $clientId = '73891987953-rn1o3vr4cr8mulfga6g803eng5920eo7.apps.googleusercontent.com';
}

if (str_contains($email, 'empireonetravel.com')) { 
  $apiKey = 'AIzaSyDQnNFZX0t9wlq5W7JHLIyHYTfwoQDMdGc';
  $clientId = '402316506489-dgloaa70a6a7scv348k2ah00jcefv6ja.apps.googleusercontent.com';
}
@endphp
<script src="https://apis.google.com/js/api.js"></script>
<script src="https://accounts.google.com/gsi/client"></script>
<script type="text/javascript">
const CLIENT_ID = '{{$clientId}}';
const API_KEY = '{{$apiKey}}';
const DISCOVERY_DOC = 'https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest';
const SCOPES = 'https://www.googleapis.com/auth/calendar.readonly';
var googleToken = undefined
var calendar;
const client = google.accounts.oauth2.initTokenClient({
  client_id: CLIENT_ID,
  scope: SCOPES,
  callback: function(response){
    console.log(response)
    axios.post('{{route('google.setToken')}}', {
      token: JSON.stringify(response)
    })
    initializingGoogle()
  },
});
function logoutGoogle(){
  google.accounts.oauth2.revoke(googleToken.access_token)
  axios.get('{{route('google.forgetToken')}}')
  try{
    calendar.destroy()
  }catch(ex){}
  $('#logoutbtnggl').hide();
  $('#loginbtnggl').show();
}
function logintoGoogle(){
  client.requestAccessToken();
}
async function initializingGoogle(){
  await gapi.client.init({
    apiKey: API_KEY,
    discoveryDocs: [DISCOVERY_DOC],
  });
  axios.get('{{route('google.checkToken')}}').then(e=>e.data).then(e=>{
    if(e.status){
      $('#logoutbtnggl').show();
      $('#loginbtnggl').hide();
      gapi.auth.setToken({
        access_token: e.token.access_token,
        expires_in: e.token.expires_in,
        scope: SCOPES,
        token_type: 'Bearer',
      })
      googleToken = e.token
      var calendarEl = document.getElementById('gcalendar');
      calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          events: function(info, successCallback, failureCallback) {
              getEvents((new Date(info.startStr)).toISOString(), (new Date(info.endStr)).toISOString()).then(e=>{
                  if(e){
                    successCallback(e.map(event=>{
                        return {
                            title: event.summary,
                            start: (event.start.dateTime?event.start.dateTime:event.start.date),
                            end: (event.end.dateTime?event.end.dateTime:event.end.date),
                            url: event.htmlLink
                        }
                    }))
                  }
              })
          },
          eventClick: function(info) {
              info.jsEvent.preventDefault();
              if (info.event.url) {
                  let url = new URL(info.event.url)
                  const urlParams = new URLSearchParams(url.search)
                  const eid = urlParams.get('eid')
                  const authUser = googleToken.authuser//gapi.client.getToken().authuser
                  const goURL = 'https://www.google.com/calendar/u/'+authUser+'/event?eid='+eid
                  window.open(info.event.url, '_blank');
                  // window.open(goURL, '_blank');
              }
          }
      });
      calendar.render();
    }else{
      $('#logoutbtnggl').hide();
      $('#loginbtnggl').show();
    }
  })
}
$(document).ready(function(){
  $('#logoutbtnggl').hide();
  gapi.load('client', initializingGoogle)
})
async function getEvents(startTime, endTime, token='', events = []){
  try {
    const request = {
        'calendarId': 'primary',
        'timeMin': startTime,//(new Date()).toISOString(),
        'timeMax': endTime,
        'showDeleted': false,
        'singleEvents': true,
        'maxResults': 10,
        'orderBy': 'startTime',
        'pageToken': token
    };
    response = await gapi.client.calendar.events.list(request);
  } catch (err) {
    $('#logoutbtnggl').show();
    $('#loginbtnggl').hide();
    logoutGoogle()
    // document.getElementById('content').innerText = err.message;
    return [];
  }
  if(response.result.nextPageToken){
    events = [...events, ...response.result.items]
    const result = await getEvents(startTime, endTime, response.result.nextPageToken, events)
    return result
  }else{
    events = [...events, ...response.result.items]
  }
  return events;
}
</script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.0.1/index.global.min.js'></script>
@endpush