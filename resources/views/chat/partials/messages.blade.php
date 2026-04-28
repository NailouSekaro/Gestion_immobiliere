@foreach($messages as $message)
    @include('chat.partials.message', ['message' => $message])
@endforeach
