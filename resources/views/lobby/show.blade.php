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

<script>
    app.socketListener.waitingForJson = true;
    

    $.ajax({
        method: "POST",
        url: `/lobby/${LOBBY["connection_string"]}/request-battleplan`,
        data: {},

        success: function (result) {
            console.log('awaiting json');
        }.bind(this),
        
        error: function (result) {
            console.log(result);
        }

    });

</script>


@endpush

@push('css')
<style>
    .wrapper{
        height: 100%;
        width:  100%;
    }
    canvas{
        margin-top: 60px;
        z-index: -1;
        top: 0px;
        bottom: 0px;
        position: fixed;
    }
</style>
@endpush

@section('content')

@include('battleplan.left-sidebar', ["gadgets" => $gadgets])
@include('battleplan.right-sidebar')
<div class="wrapper">
    <canvas id="viewport"></canvas>
</div>

@endsection

@push('modals')

@endpush
