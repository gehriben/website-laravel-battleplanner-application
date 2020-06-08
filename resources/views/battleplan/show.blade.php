@extends('layouts.main')

@push('js')

{{-- init --}}
<script type="text/javascript">
    const BATTLEPLAN_ID = {{ $battleplan->id}};
    const USER = {!! json_encode(Auth::user()->toArray(), JSON_HEX_TAG) !!}
</script>

<script src="{{asset("js/battleplan/show.bundle.js")}}"></script>
@endpush

@push('css')
<link rel="stylesheet" href="{{asset("css/battleplan/edit.css")}}">

<style>

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
        font-size: 40px;
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

<div class="wrapper">
    <canvas id="viewport"></canvas>
</div>

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

        <div class='col-12'>
            <div class="spinner-border" role="status"></div>
        </div>

        <p class='col-12'>
            Saving... Please Wait
        </p>
        </div>
    </div>
</div>
@endsection

@push('modals')

@endpush
