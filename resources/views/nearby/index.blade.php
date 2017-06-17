@extends('layouts.app')

@section('content')
    <div class="h-20"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('widgets.sidebar')
            </div>
            <div class="col-md-9">

                <div class="content-page-title">
                    <i class="fa fa-map-marker"></i> Find people nearby
                </div>

                <div id="map-render" style="width: 100%; height: 500px">

                </div>

                <h5 class="text-muted">{{ $user->location->address }}</h5>

                <div class="content-page-blue-title">
                    Found {{ $nearby->count() }} people in 50 km range!
                </div>

                @if($nearby->count() == 0)
                    <div class="alert-message alert-message-danger">
                        <h4>People are not found.</h4>
                    </div>
                @else
                    <div class="row">

                        @foreach($nearby as $location)


                            <div class="col-sm-6 col-md-4">
                                <div class="card-container">
                                    <div class="card">
                                        <div class="front">
                                            <div class="cover" style="background-image: url('{{ $location->user->getCover() }}')"></div>
                                            <div class="user">
                                                <a href="{{ url('/'.$location->user->username) }}">
                                                    <img class="img-circle @if($location->user->sex == 1){{ 'female' }}@endif" src="{{ $location->user->getPhoto(130, 130) }}"/>
                                                </a>
                                            </div>
                                            <div class="content">
                                                <div class="main">
                                                    <a href="{{ url('/'.$location->user->username) }}">
                                                        <h3 class="name">{{ $location->user->name }}</h3>
                                                        <p class="profession">
                                                            {{ '@'.$location->user->username }}
                                                            <small>{{ Auth::user()->distance($location->user) }}</small>
                                                        </p>
                                                    </a>
                                                </div>
                                                <div class="bottom" id="following-button-{{ $location->user->id }}">
                                                    {!! sHelper::followButton($location->user->id, Auth::id(), '#following-button-'.$location->user->id, '.btn-no-refresh') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach

                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script type="text/javascript">
        var map = new GMaps({
            el: '#map-render',
            lat: {{ $user->location->latitud }},
            lng: {{ $user->location->longitud }},
            zoom: 14
        });
        map.addMarker({
            lat: {{ $user->location->latitud }},
            lng: {{ $user->location->longitud }},
            title: 'You',
            icon: '{{ asset('/images/home_marker.png') }}',
            infoWindow: {
                content: 'You'
            }
        });
        @foreach($nearby as $location)
            map.addMarker({
                lat: {{ $location->latitud }},
                lng: {{ $location->longitud }},
                title: '{{ $location->user->name }}',
                @if(($location->user->sex == 0))
                    icon: '{{ asset('/images/male_marker.png') }}',
                @else
                    icon: '{{ asset('/images/female_marker.png') }}',
                @endif
                infoWindow: {
                    content: '{{ $location->user->name }}'
                },
                click: function(e) {
                  //  alert('You clicked in this marker');
                }
            });
        @endforeach
    </script>
@endsection