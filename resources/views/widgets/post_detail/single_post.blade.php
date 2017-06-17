<div class="panel panel-default panel-post" id="panel-post-{{ $post->id }}">
    <div class="panel-body">
        <div class="pull-left">
            <a href="#">
                <img class="media-object img-circle post-profile-photo" src="{{ $post->user->getPhoto(60,60) }}">
            </a>
        </div>
        <div class="pull-left info">
            <a href="{{ url('/'.$post->user->username) }}" class="name">{{ $post->user->name }}</a>
            <a href="{{ url('/'.$post->user->username) }}" class="username">{{ '@'.$post->user->username }}</a>
            <a href="{{ url('/post/'.$post->id) }}" class="date"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $post->created_at->diffForHumans() }}</a>
        </div>
        <div class="pull-right like-box">
            <a href="javascript:;" onclick="likePost({{ $post->id }})" class="like-text">
                @if($post->checkLike($user->id))
                    <i class="fa fa-heart"></i> <span>Unlike!</span>
                @else
                    <i class="fa fa-heart-o"></i> <span>Like!</span>
                @endif
            </a>
            <div class="clearfix"></div>
            <a href="javascript:;" class="all_likes" onclick="showLikes({{ $post->id }})"><span>{{ $post->getLikeCount() }} @if($post->getLikeCount() > 1){{ 'likes' }}@else{{ 'like' }}@endif</span></a>
        </div>
        <div class="clearfix"></div>
        <span>
            @if($post->checkOwner($user->id))
                <div class="navbar-right">
                    <div class="dropdown">
                        <button class="btn btn-link btn-xs dropdown-toggle" type="button" id="dd1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="fa fa-cog" aria-hidden="true"></i>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dd1" style="float: right;">
                            <li><a href="javascript:;" onclick="deletePost({{ $post->id }})"><i class="fa fa-fw fa-trash" aria-hidden="true"></i> Delete</a></li>
                        </ul>
                    </div>
                </div>
            @endif
        </span>
        <hr class="fix-hr">
        <div class="post-content post-content-s">
            {{ $post->content }}
            @if($post->hasImage())
                @foreach($post->images()->get() as $image)
                    <a data-fancybox="gallery" href="{{ $image->getURL() }}" data-caption="{{ $post->content }}"><img class="img-responsive post-image" src="{{ $image->getURL() }}"></a>
                @endforeach
            @endif
        </div>
        <hr class="fix-hr">
        <div class="comments-title">
            @include('widgets.post_detail.comments_title')
        </div>
        <div class="post-comments">

            @foreach($post->comments()->limit($comment_count)->orderBY('id', 'DESC')->with('user')->get()->reverse() as $comment)

                @include('widgets.post_detail.single_comment')


            @endforeach

        </div>

        <div class="clearfix"></div>
        <div class="media post-write-comment">
            <form id="form-new-comment">
                <div class="pull-left">
                    <a href="{{ url('/'.$user->username) }}">
                        <img class="media-object img-circle" src="{{ $user->getPhoto(60,60) }}">
                    </a>
                </div>
                <div class="media-body">
                    <textarea class="form-control" rows="1" placeholder="Comment"></textarea>
                </div>
                <button type="button" class="btn btn-default btn-xs pull-right" onclick="submitComment({{ $post->id }})">
                    Submit!
                </button>
            </form>
        </div>
    </div>
</div>