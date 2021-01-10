@extends('layouts.main-bootstrap')

@push('js')
  <script src="{{asset("js/user/index.js")}}"></script>
  <script>
    var page = {{$pageNum}};
    function ChangePage(diff){
      page += diff;
      window.location.href = `/user?page=${page}`
    }

    function vote(planId,vote){
      $(`.vote-${planId}`).removeClass('active');
      var tmp = `#vote-${planId}_${vote}`;
      $(tmp).addClass('active');
      $.ajax({
            method: "POST",
            url: `/vote`,
            data: {
              'user_id' : planId,
              'value' : vote
            },
            success: function (result) {

            }

        });
    }
  </script>
@endpush

@push('css')
  <link rel="stylesheet" href="{{asset("css/user/index.css")}}">
@endpush

@section('content')
<div class="container">

  <div class="row mt-3">
    <div class="col-12 text-center">
      <h1>Users</h1>
    </div>
  </div>


  <div class="row mt-2 justify-content-between mx-1">
    <button type="button" class="col-4 col-xl-2 btn btn-success list-button" onclick="ChangePage(-1)" {{($pageNum <= 1) ? 'disabled' : '' }}>Previous</button>
    <button type="button" class="col-4 col-xl-2 btn btn-success list-button" onclick="ChangePage(1)" {{($pageNum >= $totalPages) ? 'disabled' : '' }}>Next</button>
  </div>
  <hr>

  <div class="row">

    <div id="public-list" class="list-group col-12">

      @foreach($users as $user)

      <div class='row'>

        <div class='col-12'>
          <a href="/users/{{$user->id}}" class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
              <h5 id="plan-title" class="mb-1">{{$user->username}}</h5>
              <small id="plan-title" class="mb-1">{{$user->email}}</small>
            </div>
            <div class="d-flex w-100 justify-content-between">
              <p id="plan-description" class="mb-1"></p>
              
              <small id="plan-map">
                Verified at: <strong>{{$user->email_verified_at}}</strong>
              </small>
            </div>
          </a>
        </div>

      </div>
      @endforeach

    </div>
  </div>

  @endsection

  @push('modals')
  <div class="modal" id="copy" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Copy User</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="copy-id">
                  <h2>Save user as</h2>
                  <input class="col-4 form-control inline col-12" id="user_name" value="" type="text">

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" name="button" class="btn btn-success" onclick="copy()">Copy</button>
              </div>
          </div>
      </div>
  </div>
</div>
@endpush
