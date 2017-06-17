@extends('layouts.app')

@section('content')
    <div class="h-20"></div>
    <div class="container">

        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                @include('widgets.post_detail.single_post')
            </div>
        </div>

    </div>

    <div class="modal fade " id="likeListModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title">Likes</h5>
                </div>

                <div class="user_list">

                </div>
            </div>
        </div>
    </div>
@endsection
