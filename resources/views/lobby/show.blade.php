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
    app.requestBattleplanJson();
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
    .message-screen{
        display: none;
        position: absolute;
        height:100%;
        width:100%;
        color: white;
        z-index: 10;
        size: 40px;
        text-shadow: 1px 0 0 #000, 0 -1px 0 #000, 0 1px 0 #000, -1px 0 0 #000;
    }
    #host-left-lobby{
        background-color: rgba(255, 0, 0, 0.3);
    }
    #saving-screen{
        background-color: rgba(0, 255, 0, 0.3);
    }

</style>
@endpush

@section('content')
<div id="host-left-lobby" class="message-screen">
    <div class="container h-100">
        <div class="row h-100 justify-content-center text-center align-items-center">
                <p>
                    Uh Oh! Looks like the host has left! <br>
                    Please wait!
                </p>
        </div>
    </div>
</div>

<div id="saving-screen" class="message-screen">
    <div class="container h-100">
        <div class="row h-100 justify-content-center text-center align-items-center">
                <p>
                    Saving! <br>
                    Please Wait
                </p>
        </div>
    </div>
</div>

@include('battleplan.left-sidebar', ["gadgets" => $gadgets])
@include('battleplan.right-sidebar')
<div class="wrapper">
    <canvas id="viewport"></canvas>
</div>

@endsection

@push('modals')

@endpush
