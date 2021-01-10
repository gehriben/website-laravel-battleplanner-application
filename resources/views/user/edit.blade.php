@extends('layouts.main-bootstrap')

@push('js')
  <script>
  function emailVerifiedTimeNow(){
    let date = new Date(Date.now()).toISOString().slice(0, 10).replace('T', ' ');
    $('#input_email_verified_at').val(date)
  }
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
    
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div>{{$error}}</div>
        @endforeach
    @endif
  
    <form class="col-12" action="/users/{{$user->id}}" method="post">
      @csrf
      <table class="table table-striped">
        <tbody>
          <tr>
            <th scope="row">Username</th>
            <td><input type="text" class="form-control" placeholder="Username" name="username" aria-label="Username" value="{{$user->username}}" aria-describedby="basic-addon1"></td>
          </tr>
          <tr>
            <th scope="row">Email</th>
            <td><input type="text" class="form-control" placeholder="Username" name="email" aria-label="Username" value="{{$user->email}}" aria-describedby="basic-addon1"></td>
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
            <td>
              <div class="row">
                <input type="text" class="form-control col-6" id="input_email_verified_at" name="email_verified_at" placeholder="Username" aria-label="Username" value="{{$user->email_verified_at}}" aria-describedby="basic-addon1">
                <a onClick="emailVerifiedTimeNow()" class="btn btn-primary">now</a>
              </div>
            
            </td>
          </tr>
          <tr>
            <th scope="row">Battleplan count:</th>
            <td>{{($user->battleplans->count())}}</td>
          </tr>
        </tbody>
      </table>
      
      <div class="row">
        <div class="col-12">
          <button type="submit" class="btn btn-primary">submit</button>
        </div>
      </div>
    </form>
    

    
  </div>



@endsection

@push('modals')
@endpush
