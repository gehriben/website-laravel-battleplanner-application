@extends('layouts.main')

@push('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  var map = {!! json_encode($map->toArray(), JSON_HEX_TAG) !!}
  var floorNum = map["floors"].length > 0 ? map["floors"][map["floors"].length - 1].order + 1 : 0;

  function del(button){
    $(button).parent("li").addClass("d-none");
    $(button).parent("li").remove();
  }

  function addFloor(){
      var dom = $("#sample-floor-form").clone();
      dom.removeClass("d-none");
      dom.attr("id",floorNum);
      dom.children("#floor-number").attr("value", floorNum);
      floorNum++;
      $("#floor-list").append(dom);
  }
</script>
@endpush

@push('css')
  <link rel="stylesheet" href="{{asset("css/admin/admin.css")}}">
@endpush

@section('content')
@include('map.floor-form', ["floorPreview" => "", "floorName" => "", "floorOrder" => -1, "floorId" => ""])

<div class="container">

  @if ($errors->any())
    @foreach ($errors->all() as $error)
      <div class="row mt-3 justify-content-center">
        <div class="col-12 alert alert-danger" role="alert">
          {{ $error }}
        </div>
      </div>
    @endforeach
  @endif

  <form action="/map/{{$map->id}}" method="post"  enctype="multipart/form-data">
    @csrf
    <div class="row mt-3">
      <div class="col-12 text-center">
        <h1>Edit Map</h1>
      </div>
    </div>

    <div class="row">
      <div class="card mt-3 col-12">
        <div class="properties container">
          <h2>Properties</h2>
          <div class="row justify-content-center form-group">
              <label class="col-auto align-self-center mt-3" for="exampleInputEmail1">Name</label>
              <input type="text" class="mt-3 file-input align-self-center col-12 col-xl-4 form-control" id="exampleInputEmail1" name="name" value="{{$map->name}}" required>
              <img class="mt-3 thumb d-none d-xl-block col-xl-2" src="{{($map->thumbnail) ? $map->thumbnail->url() : 'https://via.placeholder.com/150'}}"></img>
              <label class="mt-3 col-auto align-self-center" for="exampleInputEmail1">Thumbnail</label>
              <input type="file" class="mt-3 file-input align-self-center col-12 col-xl-4 form-control" name="thumbnail">
          </div>

          <div class="row mt-3 custom-control custom-switch">
            @if($map->competitive)
            <input type="checkbox" checked class="col-2 custom-control-input" name="competitive" id="exampleCheck1">
            <label class="col-2 custom-control-label" for="exampleCheck1">Competitive Playlist</label>
            @else
            <input type="checkbox" class="custom-control-input" name="competitive" id="exampleCheck1">
            <label class="custom-control-label" for="exampleCheck1">Competitive Playlist</label>
            @endif
          </div>
        </div>

        <div class="floors container">
          <h2>Floors</h2>
          <button type="button" class="col-12 btn btn-success m-1" onclick="addFloor()">Add floor</button>
          <ul class="list-group" id="floor-list">
            @foreach ($map->floors as $floor)
              @php
                $preview = ($floor->source) ? $floor->source->url() : "https://via.placeholder.com/150";
              @endphp
              @include('map.floor-form', ["floorPreview" => $preview, "floorName" => $floor->name, "floorOrder" => $floor->order, "floorId" => $floor->id])
            @endforeach
          </ul>
        </div>
        <div class="row justify-content-center mt-3 mb-3">
          <button type="submit" class="col-3 btn btn-success">Save</button>
        </div>
      </div>
    </div>
  </form>
  <form class="row mt-3 justify-content-center" action="/map/{{$map->id}}/delete" method="post">
    @csrf
    <button type="submit" class="col-3 btn btn-secondary">Delete Map</a>
  </form>
</div>
@endsection
