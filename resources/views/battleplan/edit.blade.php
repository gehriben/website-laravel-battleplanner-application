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
            <input type="text" class="form-control" id="battleplanName" name="battleplanName" placeholder="Battleplan Name">
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
