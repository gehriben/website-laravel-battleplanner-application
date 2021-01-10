@extends('layouts.main-bootstrap')

@push('js')
<script>

    $( function() {
        $("#search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#map-list .container-image").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    } );

function selectMap(dom, mapId){
    $('#map_id').val(mapId);
    $(".container-image").removeClass("selected");
    $(dom).addClass("selected");
}

</script>
@endpush

@push('css')
  <link rel="stylesheet" href="{{asset("css/battleplan/new.css")}}">
@endpush

@section('content')
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

  <form action="/battleplan" method="post">
    @csrf
    @if($connection_string)
      <input type="hidden" name="connection_string" value='{{$connection_string}}' required>
    @endif

    <div class="row mt-3">
      <div class="col-12 text-center">
        <h1>Create Battleplan</h1>
      </div>
    </div>

    <div class="row">
      <div class="card mt-3 col-12">
        <div class="properties container">
          <div class="form-group row justify-content-center" style="padding-left: 15px;">
            <div class="col-12 col-xl-4 mt-3">
              <div class="row">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="name" aria-describedby="emailHelp" placeholder="Battleplan Name" required>
              </div>
              <div class="row mt-2 custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="public" id="exampleCheck1">
                <label class="custom-control-label" for="exampleCheck1">Public Plan</label>
              </div>
            </div>
            <div class="col-12 col-xl-4 mt-3 text-field">
              <label for="exampleInputEmail1">Description</label>
              <textarea type="text" class="form-control" id="exampleInputEmail1" name="description" aria-describedby="emailHelp" placeholder="Battleplan Description"></textarea>
            </div>
            <div class="col-12 col-xl-4 mt-3 text-field">
              <label for="exampleInputEmail1">Notes</label>
              <textarea type="text" class="form-control" id="exampleInputEmail1" name="notes" aria-describedby="emailHelp" placeholder="Notes about the plan"></textarea>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <div class="col-12 text-center">
              <h2>Map</h2>
              
              <!-- <div class="alert alert-info" role="alert">
                  Due to a copyright claim, we can no longer host the Athena/R6Tactics maps. We apologize for the inconvenience.
              </div> -->
              
              <input id="search" type="text" class="col-12" placeholder="Search..">
              <input type="hidden" name="map_id" id="map_id" required>
              <div id="map-list" class="overflow-auto mt-2 col-12  ">

                <div class="row">
                  @foreach($maps as $map)
                  <div class="col-3 container-image p-1 cursor-pointer" onclick="selectMap(this, {{$map->id}})">
                    <img src="{{($map->thumbnail) ? $map->thumbnail->url() : 'https://via.placeholder.com/150'}}" class="card-img-top map-thumbnail" alt="...">
                    <div class="centered map-text">{{$map->name}}</div>
                  </div>
                  @endforeach
                </div>
                

              </div>
            </div>
          </div>
        </div>
        <div class="row justify-content-center my-3">
          <button type="submit" class="col-3 btn btn-success">Create</button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection
