@extends('layouts.app')

@section('title')
    <title> {{$resource->name}} - szczegóły </title>
@endsection

@section('logged_user')
    <div id="user_greet">
        Zalogowany: {{Auth::user()->name}}
    </div>
@endsection

@section('logout_btn')
    <ul class="nav navbar-nav navbar-right">
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
@endsection

@section('content')
    <div class='container ap_table_container'>
        <div class='ap_action_bar'>
            <a href='/resourcesManager' class="btn_styled">Wróć</a>
        </div>
        <div class="resource_description_container">
            <h1>{{$resource->name}}</h1>
            <h3>Obecny stan magazynowy: {{$resource->quantity}}</h3>
            <h3>Minimalna wymagana ilość: {{$resource->critical_quantity}}</h3>
            @if($resource->capacity != "")
                <h3>Pojemność opakowania: {{$resource->capacity}}</h3>
            @endif
            @if($resource->proportions != "")
            <h3>Proporcje [preparat:woda]: {{$resource->proportions}}</h3>
            @endif
            <p class="resource_description">{{$resource->description}}</p>
        </div>

        <canvas id="resource_description_usage_chart">
          <script>
            var ctx = document.getElementById("resource_description_usage_chart").getContext('2d');
            var myLineChart = new Chart(document.getElementById("resource_description_usage_chart"), {
              type: 'line',
              data: {
                labels: [
                  @foreach($warehouseOperations as $wO)
                      "{{$wO->created_at}}",
                  @endforeach
                ],
                datasets: [{
                    data: [
                      @foreach($warehouseOperations as $wO)
                          {{$wO->new_val}},
                      @endforeach
                    ],
                    label: "{{$resource->name}}",
                    borderColor: "#3e95cd",
                    fill: true
                  }
                ]
              },
              options: {
                title: {
                  display: true,
                  text: 'Zmiany ilości w ciągu ostatnich 30 dni'
                },
                scales: {
                    xAxes: [{
                      time: {
                          unit: 'day',
                          displayFormats: {
                              day: 'MMM DD'
                          }
                      }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                            stepSize: 1
                        }
                    }]
                }
              }
            });
          </script>
        </canvas>
    </div>

@endsection
