@extends('layouts.main-bootstrap')

@push('js')
@endpush

@push('css')
  <link rel="stylesheet" href="{{asset("css/admin/admin.css")}}">
@endpush

@section('content')
<div class="container">
  <div class="row mt-3">
    <div class="card mt-3 col-12">
      <div class="col-12 mt-3 text-center">
        <h1>{{$op->name}}</h1>
      </div>

      <div class="row mt-3 text-center justify-content-center">
        <div class="col-12 col-xl-4">
          <h5 class="labeling">Icon&nbsp;</h5>
          <img class="icon" src="{{($op->icon) ? $op->icon->url() : 'https://via.placeholder.com/150'}}"></img>
        </div>
        <div class="col-4">
          <h5 class="labeling">Colour&nbsp;</h5>
          <div class="color" style="background-color: {{$op->colour}};"></div>
        </div>
        <div class="col-4">
          <h5 class="labeling">Attacker&nbsp;</h5>
          @if ($op->attacker)
          <i class="fa fa-check"></i>
          @else
          <i class="fas fa-times"></i>
          @endif
        </div>
      </div>

      @if(count($gadgets) != 0)
      <div class="row mt-3 text-center">
        <div class="col-12">
          <h5 class="labeling">Gadgets</h5>
        </div>
      </div>
      @endif

      <div class="row mb-3 justify-content-center">
        <div class="list-group col-8">
            @foreach ($gadgets as $gadget)
            <a href="/gadgets/{{$gadget->id}}" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{$gadget->name}}</h5>
                </div>
                <p class="mb-1">Click to view in detail</p>
            </a>
            @endforeach
        </div>
      </div>

    </div>
  </div>
  <div class="row mt-3 justify-content-center">
    <a type="button" href="/operators/{{$op->id}}/edit" class="btn btn-success">Edit Operator</a>
  </div>
</div>
@endsection
