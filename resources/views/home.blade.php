@extends('layouts.app')

@section('title')
<title> Aplikacja wspomagająca zarządzanie DSU AP </title>
@endsection

@section('nav')
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav_links" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">
                <div id="user_greet">
                    Witaj {{Auth::user()->name}}!
                </div>
            </a>
          </div>

          <div class="collapse navbar-collapse" id="nav_links">
            <ul class="nav navbar-nav pull-left">
                <li><a href="#consumable_manager">Moduł środków nietrwałych</a></li>
                <li><a href="#tire_manager">Moduł opon</a></li>
                <li><a href="#user_manager">Moduł użytkowników</a></li>
            </ul>
            <ul class="nav navbar-nav pull-right">
                <li><a href="{{ url('/logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Wyloguj
                    </a>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
          </div>
        </div>
      </nav>
@endsection
