@extends('layouts.main-bootstrap')

@push('js')

{{-- init --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>

<script type="text/javascript">
    const SOCKET = io('{{$listenSocket}}');
    const LOBBY = {!! json_encode($lobby->toArray(), JSON_HEX_TAG) !!}
    const USER = {!! json_encode(Auth::user()->toArray(), JSON_HEX_TAG) !!}
</script>

<script src="{{asset("js/lobby/show.bundle.js")}}"></script>


@endpush

@section('content')
@include('battleplan.message-screen')
@include('battleplan.left-sidebar', ["gadgets" => $gadgets])
@include('battleplan.right-sidebar')
<div class="wrapper">
    <canvas id="viewport"></canvas>
</div>

@endsection

@push('modals')

@endpush
