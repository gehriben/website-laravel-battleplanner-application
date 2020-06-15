@extends('layouts.main')

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

@push('css')
<style>
  #viewport {
    position: fixed;
    z-index: -1;
  }
</style>
@endpush

@section('content')
@include('battleplan.left-sidebar', ["gadgets" => $gadgets])
@include('battleplan.right-sidebar')
@include('battleplan.message-screen')
<div class="wrapper">
    <canvas id="viewport"></canvas>
</div>

@endsection

@push('modals')

@endpush
