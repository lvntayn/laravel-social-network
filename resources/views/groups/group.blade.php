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
                            @include('groups.widgets.count')
                            @include('groups.widgets.people_in')
                        </div>
                    </div>
                    <div class="col-md-9">
                        @include('widgets.wall')
                    </div>
                </div>



            </div>
        </div>
    </div>



@endsection

@section('footer')
    <script type="text/javascript">
        WALL_ACTIVE = true;
        fetchPost(2,0,{{ $group->id }},10,-1,-1,'initialize');
    </script>
@endsection