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
                    <i class="fa fa-users"></i> Groups
                </div>



                @if($groups->count() == 0)

                    <div class="alert-message alert-message-default">
                        <h4>You are not in any group.</h4>
                    </div>

                @else

                    <div class="row">

                    @foreach($groups->get() as $group)

                            <div class="col-sm-6 col-md-4">
                                <a class="bs-box" href="{{ url('/group/'.$group->id) }}">
                                    <h3>{{ $group->hobby->name }}</h3>
                                    <p>People in {{ $city->name }}: {{ $group->countPeople($city->id) }}</p>
                                </a>
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