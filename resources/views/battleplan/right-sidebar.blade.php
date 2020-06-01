
@push('js')
<script type="text/javascript">

    function openOperatorModal(operatorSlot) {
        $('#operator-modal').modal();
        app.battleplan.operator = app.battleplan.operators[operatorSlot];
    }
    function ChangeOperator(id,src){
        $('#operator-modal').hide();
        app.ChangeOperator(id,src);
    }

    function togglerightNav() {
        if($("#sidebar-right").hasClass("sidebar-right-open")){
            $("#sidebar-right").removeClass("sidebar-right-open");
            $("#toggletag-right").removeClass("toggletag-right-open");
        }
        else{
            $("#sidebar-right").addClass("sidebar-right-open");
            $("#toggletag-right").addClass("toggletag-right-open");
        }
    }
</script>
@endpush

@push('css')
<style>
    /**
        General Sidebar
     */
    #sidebar-right {
        height: 100%;
        width: 300px;
        right: -300px;
        position: fixed;
        z-index: 1;
        background-color: grey;
        overflow-x: hidden;
        transition: 0.5s;
    }

    .sidebar-right-open{
        right:0px !important;
    }

    #toggletag-right {
        cursor: pointer;
        position: absolute;
        top: 100px;
        right:0px;
        background-color: grey;
        padding: 10px;
        transition: 0.5s;

        writing-mode: vertical-rl;
        text-orientation: mixed;
    }

    .toggletag-right-open {
        right:300px !important;
    }


    /**
        Toolbox
     */
    .op-icon {
        height:30px;
        width:30px;
    }

    .operator-border {
        border-style: solid;
        border-width: 10px;
        height: 150px;
        width: 150px;
    }

</style>
@endpush


<div id="toggletag-right" class="" onclick="togglerightNav()">
    Operators
</div>

<div id="sidebar-right" class="sidebar-right">

    <div class="row">
        <div class="sidebar-title col-12 text-center">Operators</div>
    </div>

    <div class="row">
        <div class="col-12">
            <div id="operator-box" class="row align-center">

                <div class="col-xl-12 col-sm-12 text-center" id="operatorSlotList">
                    <img type="image" id="operator-0" data-id="882110" class="cursor-click op-icon operator-slot operator-border" onclick="openOperatorModal(0)" style="border-color: #black" draggable="true" ondragstart="app.keybinds.drag(event)"><br>
                    <img type="image" id="operator-1" data-id="882110" class="cursor-click op-icon operator-slot operator-border" onclick="openOperatorModal(1)" style="border-color: #black" draggable="true" ondragstart="app.keybinds.drag(event)"><br>
                    <img type="image" id="operator-2" data-id="882110" class="cursor-click op-icon operator-slot operator-border" onclick="openOperatorModal(2)" style="border-color: #black" draggable="true" ondragstart="app.keybinds.drag(event)"><br>
                    <img type="image" id="operator-3" data-id="882110" class="cursor-click op-icon operator-slot operator-border" onclick="openOperatorModal(3)" style="border-color: #black" draggable="true" ondragstart="app.keybinds.drag(event)"><br>
                    <img type="image" id="operator-4" data-id="882110" class="cursor-click op-icon operator-slot operator-border" onclick="openOperatorModal(4)" style="border-color: #black" draggable="true" ondragstart="app.keybinds.drag(event)"><br>
                </div>

            </div>
        </div>
    </div>

</div>


@push('modals')
<div class="modal" id="operator-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">


        <!-- Tab -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="defenders-tab" data-toggle="tab" href="#defenders" role="tab" aria-controls="defenders" aria-selected="false">Defenders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="attackers-tab" data-toggle="tab" href="#attackers" role="tab" aria-controls="attackers" aria-selected="false">Attackers</a>
            </li>
        </ul>

        <!-- Content -->
        <div class="tab-content mt-2">

            <!-- Defenders -->
            <div class="tab-pane fade show active" id="defenders" role="tabpanel" aria-labelledby="defender-tab">
                <div class="row">
                    <!-- Populate icons -->
                    @foreach($defenders as $operator)
                        <div class="col-3 text-center" onclick="ChangeOperator( {{$operator->id}},'{{$operator->icon->url()}}' )" data-dismiss="modal">
                            <img src="{{$operator->icon->url()}}" class="op-icon map-thumb"> <br>
                            <div class="map-name stroke-text">
                                {{$operator->name}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Attackers -->
            <div class="tab-pane fade" id="attackers" role="tabpanel" aria-labelledby="attacker-tab">
                <div class="row">
                    <!-- Populate icons -->
                    @foreach($attackers as $operator)
                        <div class="col-3 text-center" onclick="ChangeOperator( {{$operator->id}},'{{$operator->icon->url()}}' ) " data-dismiss="modal">
                            <img src="{{$operator->icon->url()}}" class="op-icon map-thumb"> <br>
                            <div class="map-name stroke-text">
                                {{$operator->name}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>

  </div>
</div>

@endpush
