@extends('layouts.main')

@push('js')

{{-- init --}}
<script type="text/javascript">
    const BATTLEPLAN_ID = {{ $battleplan->id}};
</script>

<script src="{{asset("js/battleplan/edit.bundle.js")}}"></script>
@endpush

@push('css')
<!-- <link rel="stylesheet" href="{{asset("css/battleplan/edit.css")}}"> -->

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
@include('battleplan.left-sidebar')
<div class="wrapper">
    <canvas id="viewport"></canvas>
</div>
@endsection

@push('modals')

@endpush
