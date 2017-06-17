<div class="panel panel-default suggested-people">
    <div class="panel-heading">All in {{ $city->name }}</div>
    <ul class="list-group" style="overflow-x: auto; max-height: 500px;">
        @php($i = 0)
        @foreach(Auth::user()->suggestedPeople(100000, $city->id, $group->hobby->id, true) as $user)
            <li class="list-group-item">
                <div class="col-xs-12 col-sm-3">
                    <a href="{{ url('/'.$user->username) }}">
                        <img src="{{ $user->getPhoto(50, 50) }}" alt="{{ $user->name }}" class="img-circle" />
                    </a>
                </div>
                <div class="col-xs-12 col-sm-9">
                    <a href="{{ url('/'.$user->username) }}">
                        <span class="name">{{ $user->name }}</span><small>{{ '@'.$user->username }}</small><br />
                    </a>
                    <div id="people-listed-{{ $user->id }}">
                        {!! sHelper::followButton($user->id, Auth::id(), '#people-listed-'.$user->id, 'btn-sm') !!}
                    </div>
                </div>
                <div class="clearfix"></div>
            </li>
            @php($i++)
        @endforeach
        @if($i == 0)
            <li class="list-group-item">
                There is only you in {{ $city->name }}
            </li>
        @endif
    </ul>
</div>