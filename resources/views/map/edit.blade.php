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
          <div class="form-group">
              <label for="exampleInputEmail1">Name</label>
              <input type="text" class="form-control" id="exampleInputEmail1" name="name" value="{{$map->name}}" required>
          </div>

          <div class="form-group">
              <label for="exampleInputEmail1">Thumbnail</label>
              <input type="file" class="col-sm form-control" name="thumbnail">
              @if($map->media)
                <img src="{{$map->media->url()}}"></img>
              @endif
          </div>

          <div class="custom-control custom-switch">
            @if($map->is_competitive)
            <input type="checkbox" checked class="custom-control-input" name="is_competitive" id="exampleCheck1">
            <label class="custom-control-label" for="exampleCheck1">Competitive Playlist</label>
            @else
            <input type="checkbox" class="custom-control-input" name="is_competitive" id="exampleCheck1">
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
                $preview = ($floor->media) ? $floor->media->url() : "https://via.placeholder.com/150";
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
  <div class="row justify-content-center mt-3 mb-3">
    <a type="button" href="/map/{{$map->id}}" method="DELETE" class="col-3 btn btn-secondary">Delete Map</a>
  </div>
</div>
@endsection
