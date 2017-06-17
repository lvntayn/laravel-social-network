<div class="message @if($message->sender_user_id == $user->id){{ 'message-right' }}@endif" id="chat-message-{{ $message->id }}">
    <div class="text">
        {{ $message->message }}
    </div>
    <a href="javascript:;" class="delete" onclick="deleteMessage({{ $message->id }})">Delete</a>
    <small>{{ $message->created_at->format('d/m/Y H:i') }}</small>
</div>
<div class="clearfix"></div>