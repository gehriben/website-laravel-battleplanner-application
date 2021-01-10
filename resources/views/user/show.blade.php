@extends('layouts.main-bootstrap')

@push('js')
  <script>
  </script>
@endpush

@push('css')
@endpush

@section('content')
<div class="container">

  <div class="row mt-3">
    <div class="col-12 text-center">
      <h1>Users Show</h1>
    </div>

    <table class="table table-striped">
      <tbody>
        <tr>
          <th scope="row">Username</th>
          <td>{{$user->username}}</td>
        </tr>
        <tr>
          <th scope="row">Email</th>
          <td>{{$user->email}}</td>
        </tr>
        <tr>
          <th scope="row">Created at</th>
          <td>{{$user->created_at}}</td>
        </tr>
        <tr>
          <th scope="row">Last updated at</th>
          <td>{{$user->updated_at}}</td>
        </tr>
        <tr>
          <th scope="row">Email verified at</th>
          <td>{{$user->email_verified_at}}</td>
        </tr>
        <tr>
          <th scope="row">Battleplan count:</th>
          <td>{{($user->battleplans->count())}}</td>
        </tr>
      </tbody>
    </table>


    <div class="row">
      <div class="col-12">
        <a href="/users/{{$user->id}}/edit" type="button" class="btn btn-primary">edit</a>
      </div>
    </div>
  </div>



@endsection

@push('modals')
@endpush
