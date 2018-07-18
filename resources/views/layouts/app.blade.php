<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @yield('robots')
        @yield('title')
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/jquery-ui.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
        <script src="{{ URL::asset('js/jquery-3.2.1.min.js')}}"></script>
        <script src="{{ URL::asset('js/bootstrap.min.js')}}"></script>
        <script src="{{ URL::asset('js/jquery-ui.min.js')}}"></script>
        <script src="{{ URL::asset('js/app.js')}}"></script>
        <script src="/node_modules/moment/min/moment.min.js"></script>
        <script src="/node_modules/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
        <link rel="stylesheet" href="/node_modules/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
    </head>
    <body>
        @if (count($errors) > 0 || Session::has('message'))
                <div class="alert_box">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                </div>
        @endif
        <nav class="navbar navbar-static-top">
            <div class="container-fluid">
              @if (Auth::user())
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav_links" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <span class="navbar-brand">
                      @yield('logged_user')
                  </span>
                </div>
                <ul class="nav navbar-nav navbar-left">
                    <li><a class="nav_href" href="/resourcesManager">Moduł zasobów magazynowych</a></li>
                    <li><a class="nav_href" href="/supplierManager">Moduł dostawców</a></li>
                    <li><a class="nav_href" href="/carManager">Moduł samochodów</a></li>
                    <li><a class="nav_href" href="/carTaskManager">Moduł zleceń</a></li>
                    <li><a class="nav_href" href="/userManager">Moduł użytkowników</a></li>
                </ul>
                @yield('logout_btn')
              @endif
              @if (!Auth::user())
                <div class="navbar-header">
                  <span class="navbar-brand">
                      System wspomagania zarządzania procesem przygotowania samochodów
                  </span>
                </div>
              @endif
            </div>
        </nav>

        @yield('content')

        <footer>
                <div class='author'>Designed and developed by MW5</div>
        </footer>
    </body>
</html>
