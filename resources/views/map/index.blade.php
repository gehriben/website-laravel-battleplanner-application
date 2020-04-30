@extends('layouts.main')

@push('js')

@endpush

@push('css')

@endpush

@section('content')

<h1 class="text-center">Maps</h1>
<a type="button" href="/map/new" class="col-12 btn btn-primary m-1">Create</a>

<div class="list-group">

    @foreach ($maps as $map)
    <a href="/map/{{$map->id}}" class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">{{$map->name}}</h5>
            <small>{{count($map->battleplans)}} battleplans using</small>
        </div>
        <p class="mb-1">Click to edit</p>
        <!-- <small>Donec id elit non mi porta.</small> -->
    </a>
    @endforeach

</div>


@endsection
