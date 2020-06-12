@extends('layouts.main-bootstrap')

@push('js')
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endpush

@push('css')
  <link rel="stylesheet" href="{{asset("css/admin/admin.css")}}">
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

  <form action="/gadgets" method="post"  enctype="multipart/form-data">
    @csrf
    <div class="row mt-3">
      <div class="col-12 text-center">
        <h1>New Gadget</h1>
      </div>
    </div>

    <div class="row">
      <div class="card mt-3 col-12">
        <div class="properties container">
          <h2>Properties</h2>
          <div class="form-group row justify-content-center" style="padding-left: 15px;">
            <div class="col-12 align-self-center col-xl-4 mt-3">
              <label for="exampleInputEmail1">Name</label>
              <input type="text" class="form-control file-input" id="exampleInputEmail1" name="name" placeholder="Gadget Name" required>
            </div>
            <div class="col-12 align-self-center col-xl-4 mt-3">
              <label for="exampleInputEmail1">Icon</label>
              <input type="file" class="col-sm form-control file-input" name="icon" required>
            </div>
            <div class="col-12 col-xl-4 mt-3">
              <label class="" for="exampleCheck1">Operator(s)</label>
              <select class="custom-select" name="operators[]" id="exampleCheck1" multiple>
                <option value="">None</option>
                @foreach($ops as $op)
                <option value="{{$op->id}}">{{$op->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <div class="row justify-content-center my-3">
          <button type="submit" class="col-3 btn btn-success">Save</button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection
