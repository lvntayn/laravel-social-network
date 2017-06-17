@extends('layouts.app')

@section('content')

    <div class="profile">

        @include('profile.widgets.header')


        @if ($can_see)
            <div class="container profile-main">
                <div class="row">
                    <div class="col-xs-12 col-md-3 pull-right">
                        @include('profile.widgets.user_follow_counts')
                        <div class="hidden-sm hidden-xs">
                            @include('widgets.suggested_people')
                        </div>
                    </div>
                    <div class="col-md-9">


                        <div class="content-page-title">
                            Following ({{ $list->count() }})
                        </div>


                        @if($list->count() == 0)
                            <div class="alert-message alert-message-danger">
                                <h4>Following are not found.</h4>
                            </div>
                        @else
                            <div class="row">

                                @foreach($list as $relation)


                                    <div class="col-sm-6 col-md-4">
                                        <div class="card-container">
                                            <div class="card">
                                                <div class="front">
                                                    <div class="cover" style="background-image: url('{{ $relation->following->getCover() }}')"></div>
                                                    <div class="user">
                                                        <a href="{{ url('/'.$relation->following->username) }}">
                                                            <img class="img-circle @if($relation->following->sex == 1){{ 'female' }}@endif" src="{{ $relation->following->getPhoto(130, 130) }}"/>
                                                        </a>
                                                    </div>
                                                    <div class="content">
                                                        <div class="main">
                                                            <a href="{{ url('/'.$relation->following->username) }}">
                                                                <h3 class="name">{{ $relation->following->name }}</h3>
                                                                <p class="profession">
                                                                    {{ '@'.$relation->following->username }}
                                                                    @if($relation->following->canSeeProfile(Auth::id()))
                                                                        <small>{{ Auth::user()->distance($relation->following) }}</small>
                                                                    @else
                                                                        <small>(Private)</small>
                                                                    @endif
                                                                </p>
                                                            </a>
                                                        </div>
                                                        <div class="bottom" id="following-button-{{ $relation->following->id }}">
                                                            {!! sHelper::followButton($relation->following->id, Auth::id(), '#following-button-'.$relation->following->id, '.btn-no-refresh') !!}
                                                            {!! sHelper::deniedButton(Auth::id(), $relation->following->id, '.denied-button-'.$relation->following->id, 'denied-button-'.$relation->following->id) !!}
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
        @else
            <div class="container">
                <div class="alert-message alert-message-default">
                    <h4>{{ '@'.$user->username."'s" }} profile is private.</h4>
                    <p>Please follow to see {{ '@'.$user->username."'s" }} profile.</p>
                </div>
            </div>
        @endif

    </div>

@endsection

@section('footer')
    <script src="{{ asset('js/profile.js') }}"></script>

@endsection