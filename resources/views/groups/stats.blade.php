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
                    {{ $group->hobby->name }}
                </div>






                <div class="row">
                    <div class="col-xs-12 col-md-3 pull-right">
                        <div class="hidden-sm hidden-xs">
                            @include('groups.widgets.people_in_my')
                        </div>
                    </div>
                    <div class="col-md-9">

                        <a href="{{ url('/group/'.$group->id.'') }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back to group page</a>



                        <div class="group-stats">


                            <div class="row">

                                <div class="col-md-4">
                                    <div class="box">
                                        <span class="count"> {{ $group->countPeople($city->id) }}</span>
                                        <span class="title">{{ $city->name }}</span>

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="box dark">
                                        <span class="count"> {{ $group->countPeople($country->id, true) }}</span>
                                        <span class="title">{{ $country->name }}</span>

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="box hard-dark">
                                        <span class="count"> {{ $group->countPeople() }}</span>
                                        <span class="title">Total</span>

                                    </div>
                                </div>

                            </div>


                        </div>


                        <table class="table table-bordered table-striped table-hover" style="background: #fff">
                            <thead>
                                <tr>
                                    <th>Country Name</th>
                                    <th>Country Code</th>
                                    <th>Number of Users</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($all_countries as $country)
                                    <tr>
                                        <td>{{ $country->name }}</td>
                                        <td>{{ $country->shortname }}</td>
                                        <td>{{ $country->count }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>


                    </div>
                </div>






            </div>
        </div>
    </div>



@endsection

@section('footer')
@endsection