@extends('layouts.main')

@push('js')

{{-- init --}}
<script type="text/javascript">
    const BATTLEPLAN_ID = {{ $battleplan->id}};

</script>

<script src="{{asset("js/battleplan/show.bundle.js")}}"></script>

<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    
    /*
    *
    * Direct JS functions
    */

    function vote(value,battleplanId,dom){

    var tmp = dom;

    if (value > 0) {
        $("#vote-up-" + battleplanId ).addClass("vote-green")
        $("#vote-down-" + battleplanId ).removeClass("vote-red")
    } else{
        $("#vote-down-" + battleplanId ).addClass("vote-red")
        $("#vote-up-" + battleplanId ).removeClass("vote-green")
    }

    $.ajax({
        method: "POST",
        url: "/battleplan/vote",
        data: {
            value: value,
            battleplanId: battleplanId
        },

        success: function (result) {
            console.log(result);
            $("#vote-value-" + battleplanId ).html(result);
        },

        error: function (result) {
            console.log(result);
        }
    });
    }

    function copyModal($id){
        $('#copy-id').val($id);
        $('#copy').modal('toggle');
    }

    function copy(){
    $.ajax({
        method: "POST",
        url: "/battleplan/copy",
        data: {
            battleplanId: $('#copy-id').val(),
            name: $('#battleplan_name').val()
        },

        success: function (result) {
            alert("Successfully copied to account!");
            $('#copy').modal('hide');
        },

        error: function (result) {
            console.log(result);
        }
    });
    }


  </script>
@endpush

@push('css')
<link rel="stylesheet" href="{{asset("css/battleplan/show.css")}}">
@endpush

@section('content')

{{-- New --}}
<div class="row">
    <div class="accordion col-12" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-info col-12 text-center" type="button" data-toggle="collapse" data-target="#collapseOne"
                        aria-expanded="true" aria-controls="collapseOne">
                        Information
                    </button>
                </h5>
            </div>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample"
                style="">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-xl-6 text-center">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Battle Plan</td>
                                        <td><strong>{{$battleplan->name}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Creator</td>
                                        <td>{{$battleplan->Owner->username}}</td>
                                    </tr>
                                    <tr>
                                        <td>Points</td>
                                        <td id="vote-value-{{$battleplan->id}}">{{$battleplan->voteSum()}}</td>
                                    </tr>
                                    <tr>
                                        <td>Functions</td>
                                        <td>
                                                @if(Auth::user())
                                                @if ($battleplan->voted(1))
                                                <i class="fas fa-arrow-circle-up cursor-click vote-green" id="vote-up-{{$battleplan->id}}" onclick="vote(1,{{$battleplan->id}}, this)"
                                                    data-toggle="tooltip" data-placement="top" title="Up Vote"></i>
                                                @else
                                                <i class="fas fa-arrow-circle-up cursor-click" id="vote-up-{{$battleplan->id}}" onclick="vote(1,{{$battleplan->id}}, this)"
                                                    data-toggle="tooltip" data-placement="top" title="Up Vote"></i>
                                                @endif
                                        
                                                |
                                        
                                                @if ($battleplan->voted(-1))
                                                <i class="fas fa-arrow-circle-down cursor-click vote-red" id="vote-down-{{$battleplan->id}}" onclick="vote(-1,{{$battleplan->id}}, this)"
                                                    data-toggle="tooltip" data-placement="top" title="Down Vote"></i>
                                                @else
                                                <i class="fas fa-arrow-circle-down cursor-click" id="vote-down-{{$battleplan->id}}" onclick="vote(-1,{{$battleplan->id}}, this)"
                                                    data-toggle="tooltip" data-placement="top" title="Down Vote"></i>
                                                @endif
                                        
                                                |
                                        
                                                <i class="fas fa-clone cursor-click" id="copy-{{$battleplan->id}}" data-toggle="tooltip" data-placement="top"
                                                    title="Copy to my account" onclick="copyModal({{$battleplan->id}})"></i>
                                        
                                                @else
                                                <small style="color:red">Please sign in to unlock more features</small>
                                                @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-12 col-xl-6 text-center">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Status</td>

                                        @if ($battleplan->public)
                                            <td  style="color:green">
                                                Public
                                            </td>
                                        @else
                                            <td style="color:red">
                                                Private <br>
                                                <small>This battleplan is private and is only visible to the owner</small>
                                            </td>
                                        @endif
                                    </tr>
                                    
                                    <tr>
                                        <td>Created</td>
                                        <td>{{$battleplan->created_at}}</td>
                                    </tr>
        
                                    <tr>
                                        <td>Notes</td>
                                        <td>
                                            <textarea disabled="" style="width: 100%">{{$battleplan->notes}}</textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
</div>

{{--
@if (!$battleplan->public)
<div class="row">
    <div class="col-12 text-center">
        <small style="color:red">This battleplan is private and is only visible to the owner</small>
    </div>
</div>
@endif --}}

{{--
<div class="row">
    <div class="col-12 text-center">

        @if(Auth::user())
        @if ($battleplan->voted(1))
        <i class="fas fa-arrow-circle-up cursor-click vote-green" id="vote-up-{{$battleplan->id}}" onclick="vote(1,{{$battleplan->id}}, this)"
            data-toggle="tooltip" data-placement="top" title="Up Vote"></i>
        @else
        <i class="fas fa-arrow-circle-up cursor-click" id="vote-up-{{$battleplan->id}}" onclick="vote(1,{{$battleplan->id}}, this)"
            data-toggle="tooltip" data-placement="top" title="Up Vote"></i>
        @endif

        |

        @if ($battleplan->voted(-1))
        <i class="fas fa-arrow-circle-down cursor-click vote-red" id="vote-down-{{$battleplan->id}}" onclick="vote(-1,{{$battleplan->id}}, this)"
            data-toggle="tooltip" data-placement="top" title="Down Vote"></i>
        @else
        <i class="fas fa-arrow-circle-down cursor-click" id="vote-down-{{$battleplan->id}}" onclick="vote(-1,{{$battleplan->id}}, this)"
            data-toggle="tooltip" data-placement="top" title="Down Vote"></i>
        @endif

        |

        <i class="fas fa-clone cursor-click" id="copy-{{$battleplan->id}}" data-toggle="tooltip" data-placement="top"
            title="Copy to my account" onclick="copyModal({{$battleplan->id}})"></i>

        @else
        <small style="color:red">Please sign in to unlock more features</small>
        @endif


    </div>
</div> --}}

<div class="row text-center">
    <div class="col-12 floorChanger">
        <button type="button" name="button" class="btn btn-primary sidebar-btn" onclick="app.engine.changeFloor(-1)"
            data-toggle="tooltip" data-placement="top" title="Keybind: Down arrow">Floor
            &darr;</button>
        <button type="button" name="button" class="btn btn-primary sidebar-btn" onclick="app.engine.changeFloor(1)"
            data-toggle="tooltip" data-placement="top" title="Keybind: Up arrow">Floor
            &uarr;</button>
    </div>
</div>
<div class="row">
    {{-- Engine --}}
    <div class="row bg-dark" id="EngineContainer">
        <div id="viewport">
            <canvas id="background" class="fixed"></canvas>
            <canvas id="overlay" class="fixed" onmouseleave="app.engine.canvasLeave(event)" onmouseenter="app.engine.canvasEnter(event)"
                onmousemove="app.engine.canvasMove(event)" onmousedown="app.engine.canvasDown(event)" onmouseup="app.engine.canvasUp(event)"
                onmousedown="app.engine.canvasDown(event)" ondrop="app.engine.canvasDrop(event)" ondragover="app.engine.allowDrop(event)">
            </canvas>
        </div>
        <div id="snackbar"></div>
    </div>
</div>

<div class="operatorContainer float-right">
    <div class="col-md-12 col-sm-12" id="operatorSlotList">
        @foreach ($battleplan->slots as $key => $slot)
        <div class="row">
            @if (!$slot->operator || !$slot->operator->exists)
            <input type="image" id="operatorSlot-{{$slot->id}}" src="/media/ops/empty.png" class="op-icon operator-slot operator-border"
                style="border-color: black" />
            @else
            <input type="image" id="operatorSlot-{{$slot->id}}" src="{{$slot->operator->icon}}" class="op-icon operator-slot operator-border"
                style="border-color: #{{$slot->operator->colour}}" />
            @endif
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
                <h5 class="modal-title">Copy Battleplan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="copy-id">
                <h2>Save battleplan as</h2>
                <input class="col-4 form-control inline col-12" id="battleplan_name" value="" type="text">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" name="button" class="btn btn-success" onclick="copy()">Copy</button>
            </div>
        </div>
    </div>
</div>

@endpush
