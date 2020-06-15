
@push('js')
<script type="text/javascript">

    function setOperator(operatorSlot) {
        app.battleplan.operator = app.battleplan.operators[operatorSlot];
    }

    function ChangeOperator(id,src){
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
<link rel="stylesheet" href="{{asset("css/battleplan/sidebars.css")}}">
@endpush


<div id="toggletag-right" class="text-center" onclick="togglerightNav()">Operators</div>

<div id="sidebar-right" class="sidebar-right">

  <div class="row">
    <div class="col-12">
      <div id="operator-box" class="row mt-3 align-center">
        <div class="col-12 text-center" id="operatorSlotList">
          <img type="image" id="operator-0" data-id="882110" class="cursor-click op-icon operator-slot operator-border" data-toggle="modal" data-target="#operator-modal" onclick="setOperator(0)" style="border-color: #black" draggable="true" ondragstart="app.keybinds.drag(event)"><br>
          <img type="image" id="operator-1" data-id="882110" class="cursor-click op-icon operator-slot operator-border" data-toggle="modal" data-target="#operator-modal" onclick="setOperator(1)" style="border-color: #black" draggable="true" ondragstart="app.keybinds.drag(event)"><br>
          <img type="image" id="operator-2" data-id="882110" class="cursor-click op-icon operator-slot operator-border" data-toggle="modal" data-target="#operator-modal" onclick="setOperator(2)" style="border-color: #black" draggable="true" ondragstart="app.keybinds.drag(event)"><br>
          <img type="image" id="operator-3" data-id="882110" class="cursor-click op-icon operator-slot operator-border" data-toggle="modal" data-target="#operator-modal" onclick="setOperator(3)" style="border-color: #black" draggable="true" ondragstart="app.keybinds.drag(event)"><br>
          <img type="image" id="operator-4" data-id="882110" class="cursor-click op-icon operator-slot operator-border" data-toggle="modal" data-target="#operator-modal" onclick="setOperator(4)" style="border-color: #black" draggable="true" ondragstart="app.keybinds.drag(event)"><br>
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
              <div class="col-3 text-center operator-list-item cursor-click" onclick="ChangeOperator( {{$operator->id}},'{{$operator->icon->url()}}' )" data-dismiss="modal">
                <img src="{{$operator->icon->url()}}" class="op-icon"> <br>
                <div> {{$operator->name}} </div>
              </div>
              @endforeach
            </div>
          </div>

          <!-- Attackers -->
          <div class="tab-pane fade" id="attackers" role="tabpanel" aria-labelledby="attacker-tab">
            <div class="row">
              <!-- Populate icons -->
              @foreach($attackers as $operator)
              <div class="col-3 text-center operator-list-item cursor-click" onclick="ChangeOperator( {{$operator->id}},'{{$operator->icon->url()}}' ) " data-dismiss="modal">
                <img src="{{$operator->icon->url()}}" class="op-icon"> <br>
                <div> {{$operator->name}} </div>
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
