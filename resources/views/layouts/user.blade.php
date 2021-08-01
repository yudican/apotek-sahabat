<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
  <link rel="icon" href="{{asset('assets/img/icon.ico')}}" type="image/x-icon" />

  <!-- Fonts and icons -->
  <script src="{{asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
  <script>
    WebFont.load({
        			google: {"families":["Lato:300,400,700,900"]},
        			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: [`{{asset('assets/css/fonts.min.css')}}`]},
        			active: function() {
        				sessionStorage.fonts = true;
        			}
        		});
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/atlantis2.css')}}">

  <!-- Styles -->
  {{-- <link rel="stylesheet" href="{{ mix('css/app.css') }}"> --}}
  @stack('styles')
  @livewireStyles
  <style>
    .cursor-pointer {
      cursor: pointer;
    }

    .cursor-default {
      cursor: default;
    }

    .absolute {
      position: absolute;
      bottom: 5px;
      left: 5px;
    }

    .table td,
    .table th {
      font-size: 14px;
      border-top-width: 0px;
      border-bottom: 1px solid;
      border-color: #ebedf2 !important;
      padding: 0 10px !important;
      height: 60px;
      vertical-align: middle !important;
    }
  </style>
  <!-- Scripts -->
  {{-- <script src="{{ mix('js/app.js') }}" defer></script> --}}
</head>

<body class="font-sans antialiased">
  <div class="wrapper">

    <div class="main-header" data-background-color="purple">
      <div class="nav-top">
        <div class="container d-flex flex-row">
          <!-- Logo Header -->
          <a id="notifDropdown" class="topbar-toggler more" title="Login" href="{{ route('login') }}">
            Login
          </a>
          <a href="index.html" class="d-flex align-items-center">
            <img src="{{asset('assets/img/logo.jpeg')}}" height="50" alt="navbar brand" class="navbar-brand">
          </a>
          <!-- End Logo Header -->

          <!-- Navbar Header -->
          <nav class="navbar navbar-header p-0">

            <div class="container-fluid p-0">
              <ul class="navbar-nav topbar-nav ml-auto align-items-center">
                <li class="nav-item ">
                  <a class="nav-link" id="notifDropdown" title="Login" href="{{ route('login') }}">
                    Login
                  </a>
                </li>


              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>
      </div>
    </div>

    <div class="main-panel">
      <div class="container">{{$slot}}</div>
    </div>
    <footer class="footer">
      <div class="container">
        <nav class="pull-left">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" target="_blank"
                href="https://www.google.com/maps/place/Jl.+Buncis,+Malawele,+Aimas,+Sorong,+Papua+Bar./@-0.956981,131.3068123,21z/data=!4m5!3m4!1s0x2d5bff238f14afc9:0xce220f686c9065a!8m2!3d-0.9569693!4d131.3069642">
                Kunjungi Apotek Sahabat
              </a>
            </li>
          </ul>
        </nav>
        <div class="copyright ml-auto">
          {{date('Y')}}, made with <i class="fa fa-heart heart text-danger"></i> by <a
            href="http://www.themekita.com">ThemeKita</a>
        </div>
      </div>
    </footer>
  </div>


  <script src="{{ asset('assets/js/core/jquery.3.2.1.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

  <!-- jQuery UI -->
  <script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>


  <!-- jQuery Scrollbar -->
  <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/atlantis2.min.js') }}"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  @stack('scripts')
  <script>
    document.addEventListener('livewire:load', function(e) {
                    window.livewire.on('showAlert', (data) => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.msg,
                            timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: false
                        })
                    });
                    
                    window.livewire.on('showAlertError', (data) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.msg,
                            timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: false
                        })
                    });
                })
  </script>
  @livewireScripts
</body>

</html>