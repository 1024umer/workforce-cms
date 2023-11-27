<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--Any config settings you want to fetch you will get in $config array, -->
  <?php //echo $config['COMPANY']; 
  ?>
  <title>{{isset($title)?$title:''}}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @include('layout.css')
  @stack('css')
</head>

<body class="crm-isloading">
  <input type="hidden" id="web_base_url" value="{{url('/')}}" />
  <div class="crm-loader">
    <svg version="1.1" id="L7" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
      <path fill="#fff" d="M31.6,3.5C5.9,13.6-6.6,42.7,3.5,68.4c10.1,25.7,39.2,38.3,64.9,28.1l-3.1-7.9c-21.3,8.4-45.4-2-53.8-23.3
        c-8.4-21.3,2-45.4,23.3-53.8L31.6,3.5z">
            <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="2s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
      </path>
      <path fill="#fff" d="M42.3,39.6c5.7-4.3,13.9-3.1,18.1,2.7c4.3,5.7,3.1,13.9-2.7,18.1l4.1,5.5c8.8-6.5,10.6-19,4.1-27.7
        c-6.5-8.8-19-10.6-27.7-4.1L42.3,39.6z">
            <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="-360 50 50" repeatCount="indefinite"></animateTransform>
      </path>
      <path fill="#fff" d="M82,35.7C74.1,18,53.4,10.1,35.7,18S10.1,46.6,18,64.3l7.6-3.4c-6-13.5,0-29.3,13.5-35.3s29.3,0,35.3,13.5
        L82,35.7z">
          <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="2s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
      </path>
    </svg>
  </div>
  @guest
  @yield('content')
  @endguest
  @auth
    @if(!isset($invitePage))
      <div class="mainContent">
        <!-- HEADER -->
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3">
              @include('layout.sidebar')
            </div>
            <div class="col-md-9">
              @include('layout.breadcrumb')
              @if (session('redirect_success'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success</strong> 
                    @php
                    $redirect_success_data = session('redirect_success');
                    echo $redirect_success_data;
                    @endphp
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
              @endif
              @if (session('redirect_errors'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error</strong> 
                    @php
                    $redirect_errors_data = session('redirect_errors');
                    echo $redirect_errors_data;
                    @endphp
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
              @endif
              @yield('content')
            </div>
            @include('layout.widgets.createtask')
            @include('layout.widgets.createproject')
            @include('layout.widgets.projectinvite')
            @include('layout.widgets.taskdetail')
          </div>
        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="wfmManagementModal" tabindex="-1" aria-labelledby="wfmManagementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Organization Chart</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <img class="img-fluid" src="{{asset('images/orgchart.jpg')}}" />
            </div>
          </div>
        </div>
      </div>
    @else
      @yield('content')
    @endif
  @endauth
  @include('layout.scripts')
  @stack('js')
  <script>
    $(document).ready(function(){
      setTimeout(function(){
        $('body').removeClass('crm-isloading')
        $('.crm-loader').hide();
      },2000)
    })
  </script>
</body>

</html>