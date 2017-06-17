<a href="#" class="dropdown-toggle parent" data-toggle="dropdown" role="button" aria-expanded="false">
    @if (count($user_list) > 0)
        <span class="badge badge-notify">{{ count($user_list) }}</span>
    @endif
    <i class="fa fa-commenting"></i>
</a>
<ul class="dropdown-menu" role="menu">
    @if(count($user_list) == 0)
       <li style="padding: 10px"><a href="{{ url('/direct-messages') }}">See all messages</a></li>
    @else
        @foreach($user_list as $friend)
            <li>
                <a href="{{ url('/direct-messages/show/'. $friend['user']->id) }}" class="friend">
                    <div class="image">
                        <img class="img-circle" src="{{ $friend['user']->getPhoto(40, 40) }}">
                    </div>
                    <div class="detail">
                        <strong>{{ $friend['user']->name }}</strong>
                        <span>{{ str_limit($friend['message']->message, 20) }}</span>
                        <small>{{ $friend['message']->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
        @endforeach
    @endif
</ul>