@extends('layouts.main')

@push('css')
<link rel="stylesheet" href="{{asset("css/room/show.css")}}">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

@endpush

@push ('js')
{{-- requisits --}}
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js" charset="utf-8"></script>


{{-- init --}}
<script type="text/javascript">
    const ROOM_CONN_STRING = "{{$room->connection_string}}";
    const LISTEN_SOCKET = io('{{$listenSocket}}');
    const USER_ID = {{Auth::User()->id}}
</script>

{{-- Main app --}}
<script src="{{asset("js/room/show.bundle.js")}}"></script>
<script src="{{asset('js/room/sidebar.js')}}"></script>

{{-- post init --}}
@if (Auth::User()->id == $room->Owner->id && !$room->battleplan)
<script type="text/javascript">
    $("#mapModal").modal("show")
</script>
@endif

<script type="text/javascript">

    // init elements
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        $('#battleplan_load_table').DataTable();
    });

    // Toggle operator modal + copy color
    function setEditingSlot(id, event, dom) {
        if( event.which == 2 ) {
            event.preventDefault();
            if(dom.src.indexOf("/media/ops/empty.png") == -1){
                var hex = "#" + fullColorHex(dom.style.borderColor);
                $("#colorPicker").val(hex);
                app.engine.changeColor(hex);
                toast("Operator Color Copied",1000);
            }
        } else{
            $("#EditingOperatorSlot").val(id);
        }
    }

    // Helper function
    function fullColorHex(str) {
        var array = str.replace("rgb(",'').replace(")",'').replace(" ",'').split(",");
        var red = rgbToHex(array[0]);
        var green = rgbToHex(array[1]);
        var blue = rgbToHex(array[2]);
        return red+green+blue;
    };

    function rgbToHex(rgb){
        var hex = Number(rgb).toString(16);
        if (hex.length < 2) {
            hex = "0" + hex;
        }
        return hex;
    }

    // Public switch
    var switchStatus = false;
    $("#battleplan_public").on('change', function() {
        if ($(this).is(':checked')) {
            switchStatus = $(this).is(':checked');
        }
        else {
            switchStatus = $(this).is(':checked');
        }
        app.engine.togglePublic(switchStatus);
    });

    // Toast the snackbar
    function toast(message,time){
        // Get the snackbar DIV
        var x = document.getElementById("snackbar");
        $(x).html(message);
        // Add the "show" class to DIV
        x.className = "show";

        // After 3 seconds, remove the show class from DIV
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, time);
    }

</script>
@endpush

@section ('content')
{{-- @include('room.collapse-topbar') --}}
{{-- Engine --}}
<div class="row bg-dark" id="EngineContainer">
    <div id="viewport">
        <canvas id="background" class="fixed"></canvas>
        <canvas id="overlay" class="fixed" onmouseleave="app.engine.canvasLeave(event)" onmouseenter="app.engine.canvasEnter(event)" onmousemove="app.engine.canvasMove(event)" onmousedown="app.engine.canvasDown(event)" onmouseup="app.engine.canvasUp(event)"
          onmousedown="app.engine.canvasDown(event)" ondrop="app.engine.canvasDrop(event)" ondragover="app.engine.allowDrop(event)">
        </canvas>
    </div>
    <div id="snackbar"></div>
</div>

{{-- Sidebar --}}
<div class="toggletag toggled"><i class="fas fa-arrow-left fa-lg"></i></div>
<div class="nav-side-menu toggled">
    <div class="brand">Options</div>

    <div class="menu-list">

        <ul id="menu-content" class="menu-content collapse out">

            <div class="row no-margin">
                {{-- Information --}}
                <li data-toggle="collapse" data-target="#info" class="active collapsed col-6" aria-expanded="false">
                    <a href="#"><i class="fas fa-info-circle"></i> Info </a>
                </li>

                {{-- Help --}}
                <li data-toggle="collapse" class="collapsed active col-6">
                    <div style="height:100%;width:100%;" data-toggle="modal" data-target="#helpModal">
                        <a href="#"><i class="fas fa-question"></i> Help</a>
                    </div>
                </li>

                <ul class="sub-menu collapse" id="info">
                  @include('room.sidebar-info')
                </ul>
            </div>

            <div class="row no-margin">
                {{-- Notes --}}
                <li data-toggle="collapse" data-target="#notes" class="active collapsed col-6" aria-expanded="false">
                    <a href="#"><i class="fas fa-edit"></i> Notes</a>
                </li>

                {{-- Controls --}}
                <li data-toggle="collapse" data-target="#controls" class="active col-6 collapsed" aria-expanded="false">
                    <a href="#"> <i class="fas fa-sliders-h"></i> Controls</a>
                </li>

                <ul class="sub-menu collapse" id="notes">
                    @include('room.sidebar-notes')
                </ul>
                <ul class="sub-menu collapse" id="controls">
                    @include('room.sidebar-controls')
                </ul>
            </div>

            <div class="row no-margin">
                {{-- Tools --}}
                <li data-toggle="collapse" data-target="#tools" class="active collapsed col-6" aria-expanded="false">
                    <a href="#"> <i class="fas fa-wrench"></i> Tools</a>
                </li>

                {{-- Icons --}}
                <li data-toggle="collapse" data-target="#icons" class="active col-6 collapsed" aria-expanded="false">
                    <a href="#"><i class="far fa-image"></i> Icons</a>
                </li>

                <ul class="sub-menu collapse" id="tools">
                    @include('room.sidebar-tools')
                </ul>

                <ul class="sub-menu col-12 collapse" id="icons">
                    @include('room.sidebar-icons')
                </ul>
            </div>

            <div class="row no-margin">
                {{-- Operator Icons --}}
                <li data-toggle="collapse" data-target="#operatorIcons" class="active col-12 text-center collapsed" aria-expanded="false">
                    <a href="#"><i class="far fa-user"></i> Operator Icons</a>
                </li>

                <ul class="sub-menu col-12 collapse" id="operatorIcons">
                    @include('room.sidebar-op-icons')
                </ul>
            </div>

        </ul>
    </div>
</div>
</div>

<div class="operatorContainer float-right">
    <div class="col-md-12 col-sm-12" id="operatorSlotList">
        @if ($room->battleplan != null)
        @foreach ($room->battleplan->slots as $key => $slot)
        <div class="row">
            @if ($room->Owner == Auth::User())
            @if (!$slot->operator || !$slot->operator->exists)
            <input type="image" id="operatorSlot-{{$slot->id}}" data-id="{{$slot->id}}" src="/media/ops/empty.png" class="op-icon operator-slot operator-border" data-toggle="modal" data-target="#opModal" onclick="setEditingOperatorSlot($(this).data('id'))"
              style="border-color: black" />
            @else
            <input type="image" id="operatorSlot-{{$slot->id}}" data-id="{{$slot->id}}" src="{{$slot->operator->icon}}" class="op-icon operator-slot operator-border" data-toggle="modal" data-target="#opModal" onclick="setEditingOperatorSlot($(this).data('id'))"
              style="border-color: #{{$slot->operator->colour}}" />
            @endif
            @else
            @if (!$slot->operator || !$slot->operator->exists)
            <input type="image" id="operatorSlot-{{$slot->id}}" data-id="{{$slot->id}}" src="/media/ops/empty.png" class="op-icon operator-slot operator-border" style="border-color: black" />
            @else
            <input type="image" id="operatorSlot-{{$slot->id}}" data-id="{{$slot->id}}" src="{{$slot->operator->icon}}" class="op-icon operator-slot operator-border" style="border-color: #{{$slot->operator->colour}}" />
            @endif
            @endif
        </div>
        @endforeach
        @endif
    </div>
</div>
@endsection

@push('modals')

{{-- only load this modal if room owner --}}
@if (Auth::User()->id == $room->Owner->id)
<div class="modal" id="mapModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Load Map</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                {{-- Pillbox --}}
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="new-tab" data-toggle="tab" href="#new" role="tab" aria-controls="new" aria-selected="true">New Map</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="load-tab" data-toggle="tab" href="#load" role="tab" aria-controls="load" aria-selected="false">Load Saved</a>
                    </li>
                </ul>

                {{-- Pill content --}}
                <div class="tab-content" id="myTabContent">
                    <input type="hidden" id="EditingOperatorSlot" name="" value="">
                    <div class="tab-pane fade show active" id="new" role="tabpanel" aria-labelledby="home-tab">
                        @include('room.new')
                    </div>
                    <div class="tab-pane fade" id="load" role="tabpanel" aria-labelledby="profile-tab">
                        @include('room.load')
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif


<!-- OPERATOR MODAL -->
<div class="modal" id="opModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Operator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- Pillbox --}}
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="atk-tab" data-toggle="tab" href="#atk" role="tab" aria-controls="atk" aria-selected="true">Attackers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="def-tab" data-toggle="tab" href="#def" role="tab" aria-controls="def" aria-selected="false">Defenders</a>
                    </li>
                </ul>

                {{-- Pill content --}}
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="atk" role="tabpanel" aria-labelledby="home-tab">
                        @include('room.atkOp')
                    </div>
                    <div class="tab-pane fade" id="def" role="tabpanel" aria-labelledby="profile-tab">
                        @include('room.defOp')
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Help MODAL -->
<div class="modal" id="helpModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Help! how does this work?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- Pillbox --}}
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="atk-tab" data-toggle="tab" href="#help_general" role="tab" aria-controls="atk" aria-selected="true">General</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="def-tab" data-toggle="tab" href="#help_functions" role="tab" aria-controls="def" aria-selected="false">Functions</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="def-tab" data-toggle="tab" href="#help_about" role="tab" aria-controls="def" aria-selected="false">About Us</a>
                    </li>
                </ul>

                {{-- Pill content --}}
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="help_general" role="tabpanel" aria-labelledby="home-tab">
                        @include('room.help-general')
                    </div>
                    <div class="tab-pane fade" id="help_functions" role="tabpanel" aria-labelledby="profile-tab">
                        @include('room.help-functions')
                    </div>

                    <div class="tab-pane fade" id="help_about" role="tabpanel" aria-labelledby="profile-tab">
                        @include('room.help-about')
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="save" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Save</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <h2>Battleplan name</h2>
                    <input class="col-4 form-control inline col-12" id="battleplan_name" value="" type="text">

                    <hr>

                    <!-- Rectangular switch -->
                    <h2>Show public?</h2>
                    {{-- <strong>Show public?</strong>( --}}
                    <small>(This will list your battleplan in the "Public Plans" page)</small> <br>
                    <label class="switch">
                        <input type="checkbox" value="public" id="battleplan_public">
                        <span class="slider"></span>
                    </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" name="button" class="btn btn-success" onclick="app.engine.save()">Save</button>
            </div>
        </div>
    </div>
</div>
@endpush
