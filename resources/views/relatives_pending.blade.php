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
                    Relative Requests ({{ $list->count() }})
                </div>


                @if($list->count() == 0)
                    <div class="alert-message alert-message-danger">
                        <h4>Relative requests are not found.</h4>
                    </div>
                @else
                    <div class="row">

                        @foreach($list as $relation)


                            <div class="col-sm-6 col-md-4">
                                <div class="card-container">
                                    <div class="card">
                                        <div class="front">
                                            <div class="cover" style="background-image: url('{{ $relation->relative->getCover() }}')"></div>
                                            <div class="user">
                                                <a href="{{ url('/'.$relation->relative->username) }}">
                                                    <img class="img-circle @if($relation->relative->sex == 1){{ 'female' }}@endif" src="{{ $relation->relative->getPhoto(130, 130) }}"/>
                                                </a>
                                            </div>
                                            <div class="content">
                                                <div class="main">
                                                    <a href="{{ url('/'.$relation->relative->username) }}">
                                                        <h3 class="name">{{ $relation->relative->name }}</h3>
                                                        <p class="profession">
                                                            {{ '@'.$relation->relative->username }}
                                                        </p>
                                                    </a>
                                                    <p style="padding: 10px; text-align: center">Is {{ $relation->relative->name }} your {{ $relation->getType() }}?</p>
                                                </div>
                                                <div class="bottom" id="approve-buttons-{{ $relation->id }}">
                                                    <div class="text-success approved" style="display: none"><i class="fa fa-check"></i> Successfully Approved</div>
                                                    <div class="text-danger denied" style="display: none"><i class="fa fa-times"></i> Denied</div>
                                                    <a href="javascript:;" class="btn btn-success approve-button btn-sm" onclick="relativeRequest(1, {{ $relation->id }})"><i class="fa fa-check"></i> Approve</a>
                                                    <a href="javascript:;" class="btn btn-danger approve-button btn-sm" onclick="relativeRequest(2, {{ $relation->id }})"><i class="fa fa-times"></i> Deny</a>
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

@endsection