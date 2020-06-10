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
<style>

#viewport{
    width:100%;
    height:70%;
    position: absolute;
    bottom: 0px;
    z-index: -1;
}
.operator-icon{
    height: 100px;
    height: 100px;
}
</style>
@endpush

@section('content')

<div class='col-12'>
    <div class='row'>
        Name: {{$battleplan->name}}
    </div>
    
    <div class='row'>
        Creator: {{$battleplan->owner->username}}
    </div>
    
    <div class='row'>
        Description: {{$battleplan->description}}
    </div>

    <div class='row'>
        notes: {{$battleplan->notes}}
    </div>
    
    <div class='row'>
        map: {{$battleplan->map->name}}
    </div>

    @if($battleplan->owner_id == Auth::user()->id)
    <div class='row'>
        <a href='/battleplan/{{$battleplan->id}}/edit' type="button" class="btn btn-primary">Edit</a>
    </div>
    @endif
</div>

<div class="col-12">
    <div class='row justify-content-center'>
        <img type="image" id="operator-0" class="operator-icon m-1">
        <img type="image" id="operator-1" class="operator-icon m-1">
        <img type="image" id="operator-2" class="operator-icon m-1">
        <img type="image" id="operator-3" class="operator-icon m-1">
        <img type="image" id="operator-4" class="operator-icon m-1">
    </div>
</div>

<canvas id="viewport"></canvas>

<!-- 
<div class="col-12">
    <div class='row'>
    </div>
</div> -->


    
@endsection

@push('modals')

@endpush
