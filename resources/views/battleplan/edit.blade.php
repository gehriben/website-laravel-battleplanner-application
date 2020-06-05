@extends('layouts.main')

@push('js')

{{-- init --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
<script type="text/javascript">
    const BATTLEPLAN_ID = {{ $battleplan->id}};
    const SOCKET = io('{{$listenSocket}}');
    const LOBBY = {!! json_encode($lobby->toArray(), JSON_HEX_TAG) !!}
    const USER = {!! json_encode(Auth::user()->toArray(), JSON_HEX_TAG) !!}
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
@include('battleplan.left-sidebar', ["gadgets" => $gadgets])
@include('battleplan.right-sidebar')
<div class="wrapper">
    <canvas id="viewport"></canvas>
</div>
@endsection

@push('modals')



<div class="modal" id="test-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" id="bName" name="name" aria-describedby="emailHelp" placeholder="Battleplan Name" value="{{$battleplan->name}}">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Description</label>
            <textarea type="text" class="form-control" id="bDescription" name="description" aria-describedby="emailHelp" placeholder="Battleplan Description">{{$battleplan->description}}</textarea>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Notes</label>
            <textarea type="text" class="form-control" id="bNotes" name="notes" aria-describedby="emailHelp" placeholder="Notes about the plan">{{$battleplan->notes}}</textarea>
        </div>

        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" name="public" id="bPublic" {{ ($battleplan->public) ?"checked" : ""}}>
            <label class="custom-control-label" for="bPublic">Public</label>
        </div>
      </div>



      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="app.SaveAs()" data-dismiss="modal">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>

  </div>
</div>



@endpush
