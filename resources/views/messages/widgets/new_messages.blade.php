@foreach($message_list->get()->reverse() as $message)

    @include('messages.widgets.single_message')

@endforeach

