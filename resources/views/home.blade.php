@extends('layouts.app')

@section('content')
    <div class="h-20"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('widgets.sidebar')
            </div>
            <div class="col-xs-12 col-md-3 pull-right">
                <div class="hidden-sm hidden-xs">
                    @include('widgets.suggested_people')
                </div>
            </div>
            <div class="col-md-6">
                @include('widgets.wall')
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script type="text/javascript">
        WALL_ACTIVE = true;
        fetchPost(0,0,0,10,-1,-1,'initialize');
    </script>
@endsection