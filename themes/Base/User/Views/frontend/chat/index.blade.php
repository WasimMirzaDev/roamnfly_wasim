@extends('Layout::user')
@section('content')
    <iframe
            width="100%"
            style="height: calc(100vh - 30px)"
            src="{{route(config('chatify.path'),['id'=>request('user_id')])}}"
            frameborder="0"
    ></iframe>
@endsection
