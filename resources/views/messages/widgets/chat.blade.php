<input type="hidden" name="chat_friend_id" value="{{ $friend->id }}">
<div class="chat-info">
    <a href="{{ url('/'.$friend->username) }}" class="user-profile">
        <img class="img-circle" src="{{ $friend->getPhoto(50, 50) }}">
        <div class="detail">
            <strong>{{ $friend->name }}</strong>
            {{ '@'.$friend->username }}
        </div>
    </a>
    <a class="btn btn-default btn-xs btn-remove" onclick="deleteChat({{ $friend->id }})" data-toggle="tooltip" data-placement="bottom" title="Delete Chat">
        <i class="fa fa-times"></i>
    </a>
    <div class="clearfix"></div>
</div>

<div class="message-list">
    @php($first_message_id = 0)
    @if($message_list->count() == 0)
        <div class="alert alert-info">
            No messages
        </div>
    @else
        @php($i=0)
        @foreach($message_list->get()->reverse() as $message)

            @include('messages.widgets.single_message')

            @if($i == 0)
                @php($first_message_id = $message->id)
            @endif
            @php($i++)
        @endforeach
    @endif
    <div class="first_message_div">
        <input type="hidden" name="first_message_id" value="{{ $first_message_id }}">
    </div>
</div>
<div class="message-write">
    <form id="form-message-write">
        <input type="hidden" name="user_id" value="{{ $friend->id }}">
        @if ($can_send_message)
            <textarea class="form-control" rows="1" placeholder="Your message.." onkeyup="sendMessage(event)"></textarea>
        @else
            <div class="alert alert-danter">You can't send new message anymore.</div>
        @endif
    </form>
</div>
