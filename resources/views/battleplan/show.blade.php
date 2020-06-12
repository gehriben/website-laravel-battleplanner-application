@extends('layouts.main')

@push('js')

{{-- init --}}
<script type="text/javascript">
    const BATTLEPLAN_ID = {{ $battleplan->id}};
</script>

<script src="{{asset("js/battleplan/show.bundle.js")}}"></script>
@endpush

@push('css')
<style>

.wrapper{
    height: 100%;
    width:  100%;
}
#viewport{
    /* margin-top: 60px; */
    z-index: -1;
    top: 0px;
    bottom: 0px;
    position: fixed;
}
.operator-icon{
    height: 80px;
    height: 80px;
}
.operator-listing{
    position:fixed;
    bottom:0px;
}
</style>
@endpush

@section('content')
<div class='col-12'>

    @if(Auth::user() && $battleplan->owner_id == Auth::user()->id)
        <div class='row'>
            <p class='col-12 align-content-center text-center'>

                <a class="btn btn btn-success col-2" data-toggle="collapse" href="#information-collapse" role="button" aria-expanded="false" aria-controls="information-collapse">
                    Info
                </a>

                <button type="button" id="FloorUpTool" class="col-2 tool btn btn-success" onclick="app.ChangeFloor(1)">
                    <svg class="bi bi-arrow-up-circle-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-10.646.354a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 6.207V11a.5.5 0 0 1-1 0V6.207L5.354 8.354z"/>
                    </svg>
                </button>
                

                <button type="button" id="FloorDownTool" class="col-2 tool btn btn-success" onclick="app.ChangeFloor(-1)">
                    <svg class="bi bi-arrow-down-circle-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 5a.5.5 0 0 0-1 0v4.793L5.354 7.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 9.793V5z"/>
                    </svg>
                </button>
                
                <a href='/battleplan/{{$battleplan->id}}/edit' type="button" class="col-2 btn btn-info">Edit</a>
            </p>
        </div>
    @else
        <div class='row '>
            <p class='col-12 align-content-center text-center'>
                <a class="btn btn btn-success col-3" data-toggle="collapse" href="#information-collapse" role="button" aria-expanded="false" aria-controls="information-collapse">
                    Info
                </a>

                <button type="button" id="FloorUpTool" class="col-3 tool btn btn-success" onclick="app.ChangeFloor(1)">
                    <svg class="bi bi-arrow-up-circle-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-10.646.354a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 6.207V11a.5.5 0 0 1-1 0V6.207L5.354 8.354z"/>
                    </svg>
                </button>

                <button type="button" id="FloorDownTool" class="col-3 tool btn btn-success" onclick="app.ChangeFloor(-1)">
                    <svg class="bi bi-arrow-down-circle-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 5a.5.5 0 0 0-1 0v4.793L5.354 7.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 9.793V5z"/>
                    </svg>
                </button>
            </p>
        </div>
    @endif

    


    <div class='row'>
        <div class='col-12'>
            <div class="collapse" id="information-collapse">
                <div class="card card-body">
                    <div class='col-12'>
                        <div class='row'>
                            Name: {{$battleplan->name}}
                        </div>
                        
                        <div class='row'>
                            Creator: {{$battleplan->owner->username}}
                        </div>
                        
                        <div class='row'>
                            Description: {{$battleplan->description}}
                        </div>

                        <div class='row'>
                            notes: {{$battleplan->notes}}
                        </div>
                        
                        <div class='row'>
                            map: {{$battleplan->map->name}}
                        </div>
 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="col-12 operator-listing">
    <div class='row justify-content-center'>
        <img type="image" id="operator-0" class="operator-icon m-1">
        <img type="image" id="operator-1" class="operator-icon m-1">
        <img type="image" id="operator-2" class="operator-icon m-1">
        <img type="image" id="operator-3" class="operator-icon m-1">
        <img type="image" id="operator-4" class="operator-icon m-1">
    </div>
</div>

 <div class="wrapper">
    <canvas id="viewport"></canvas>
  </div>

<!-- 
<div class="col-12">
    <div class='row'>
    </div>
</div> -->


    
@endsection

@push('modals')

@endpush
