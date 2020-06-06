
@push('js')

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">

    $(function() {
        // Initialize slider
        $("#slider").slider({
            max: 1,
            min: 0,
            step: 0.01,
            value: 1,
            slide: function( event, ui ) {
                $('#opacity-value').val($("#slider").slider('value'))
            },
            change: function( event, ui ) {
                app.ChangeOpacity($("#slider").slider('value'));
            }
        });

        // Default App values
        $('#opacity-value').val($("#slider").slider('value'));
        app.ChangeOpacity($("#slider").slider('value'));
        app.ChangeColor($("#color-picker").val());
    });

    function selectTool(selected){
        $('.tool').removeClass("active");
        $(selected).addClass("active");
    }

    function search(dom,query){
        // Declare variables
        query = query.toUpperCase();
        dom = $('#' + dom);

        // Loop through all list items, and hide those who don't match the search query
        dom.find('div').each(function(){
            var nameDom = $(this).find('input')[0];

            if (nameDom.value.toUpperCase().indexOf(query) > -1) {
                $(this)[0].style.display = "";
            } else {
                $(this)[0].style.display = "none";
            }
        });

    }

    function toggleLeftNav() {
        if($("#sidebar-left").hasClass("sidebar-left-open")){
            $("#sidebar-left").removeClass("sidebar-left-open");
            $("#toggletag-left").removeClass("toggletag-left-open");
        }
        else{
            $("#sidebar-left").addClass("sidebar-left-open");
            $("#toggletag-left").addClass("toggletag-left-open");
        }
    }
</script>
@endpush

@push('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
    /**
        General Sidebar
     */
    #sidebar-left {
        height: 100%;
        width:500px;
        left:-500px;
        position: fixed;
        z-index: 1;
        background-color: grey;
        overflow-x: hidden;
        transition: 0.5s;
    }

    .sidebar-left-open{
        left:0px !important;
    }

    #toggletag-left {
        cursor: pointer;
        position: absolute;
        top: 100px;
        left:0px;
        background-color: grey;
        padding: 10px;
        transition: 0.5s;

        writing-mode: vertical-rl;
        text-orientation: mixed;
    }

    .toggletag-left-open {
        left:500px !important;
    }

    .close-button{
        position: absolute;
        right: 30px;
    }

    .sidebar-title{
        
    }

    #icon-searchbox{
        /* margin: 10px; */
    }

    /**
        Toolbox
     */
     #tool-box, #tool-options,#icon-box,#tool-lobby{
        background-color: white;
        /* margin: 10px;
        padding: 10px; */
     }

    /**
        Icons
     */
    #icon-box{
         max-height: 400px;
         overflow: auto;
     }
     
</style>
<link rel="stylesheet" href="{{asset("css/battleplan/sidebars.css")}}">
@endpush

<div id="toggletag-left" class="" onclick="toggleLeftNav()">Tools</div>

<div id="sidebar-left" class="sidebar-left">
    <div class="sidebar-title col-12 text-center">Lobby</div>
    
        <div id="tool-lobby" class="col-12 align-center">

            <div class="row">
                <div class="col-4">Invite Link</div>
                <input type="text" class="col-8" value="{{env('APP_URL')}}lobby/{{$lobby->connection_string}}"/>
            </div>

            
            <div class="row">
                <div class="col-4">
                    In Lobby:
                </div>
                <ul id="lobbyList" class="list-group col-8 ">
                    <li class="list-group-item" id="lobby-user-{{Auth::user()->id}}">{{Auth::user()->username}}</li>
                </ul>
            </div>
        </div>

        <div class="sidebar-title col-12 text-center">Options</div>
    
        <div id="tool-options" class="col-12 align-center">

            <div class="row">
                <div class="col-4">Color</div>
                <input type="color" id='color-picker' onchange="app.ChangeColor(this.value);">
            </div>
        
            <div class="row">
                <div class="col-4">
                    <div class='row'>
                        
                        <p class= col-8>Opacity</p> 
                        <p class='col-2' id="opacity-value">
                            1
                        </p>
                    </div>
                </div>
                <div class="col-6" id="slider"></div>
            </div>

            <div class="row">
                <div class="col-4">Line size</div>
                <input type="number" id='line-size-value' value='1' onchange="app.ChangeLineSize(this.value);"\>
            </div>
            
            <div class="row">
                <div class="col-4">Icon Size Modifier</div>
                <input type="number" id='icon-size-value' value='1' min="0" step="0.25" onchange="app.ChangeIconSizeModifier(this.value);"\>
            </div>

        </div>
    
        <div class="sidebar-title col-12 text-center">Tools</div>

        <div id="tool-box" class="col-12 align-center">
  <h4 class="sidebar-title mt-3 col-12 text-center">Drawing Options</h4>

  <div id="tool-options">

    <div class="row mt-3 mx-1">
      <div class="col-6 col-xl-4 standard-text">Color</div>
      <input type="color" class="col-5 col-xl-2" id='color-picker' onchange="app.ChangeColor(this.value);">
    </div>

    <div class="row mt-2 mx-1">
      <div class="col-12 col-xl-4 standard-text">Line size</div>
      <input type="number" id='line-size-value' class="col-12 col-xl-8" value='1' onchange="app.ChangeLineSize(this.value);"\>
    </div>

    <div class="row mt-2 mx-1">
      <div class="col-xl-4 col-12 standard-text">Icon Size</div>
      <input type="number" id='icon-size-value' class="col-12 col-xl-8" value='1' min="0" step="0.25" onchange="app.ChangeIconSizeModifier(this.value);"\>
    </div>

    <div class="row mx-1">
      <p class="col-6 col-xl-4 mt-2 standard-text align-self-center">Opacity</p>
      <input disabled class="col-6 col-xl-3 mt-2" value="1" id="opacity-value"></input>
      <div class="col-11 col-xl-4 mt-2 align-self-center" id="slider"></div>
    </div>

  </div>

  <h4 class="sidebar-title mt-3 col-12 text-center">Tools</h4>

  <div id="tool-box" class="col-12 mt-3 align-center">

    <!-- Populate tools -->
    <div class="row justify-content-center mx-1">
      <button type="button" id="FloorUpTool" class="tool col-12 col-xl-6 btn btn-success" onclick="app.ChangeFloor(1)">Floor Up</button>
      <button type="button" id="FloorDownTool" class="tool col-12 col-xl-6 btn btn-success" onclick="app.ChangeFloor(-1)">Floor Down</button>
    </div>
    <hr>
    <div class="row justify-content-center mx-1">
      <button type="button" id="selectTool" class="tool col-12 col-xl-3 btn btn-success" onclick="selectTool(this);app.keybinds.ChangeTool(app.keybinds.toolSelect)">Select</button>
      <button type="button" id="lineTool" class="tool col-12 col-xl-3 btn btn-success" onclick="selectTool(this);app.keybinds.ChangeTool(app.keybinds.toolLine)">Line</button>
      <button type="button" id="squareTool" class="tool col-12 col-xl-3 btn btn-success" onclick="selectTool(this);app.keybinds.ChangeTool(app.keybinds.toolSquare)">Square</button>
      <button type="button" id="EraserTool" class="tool col-12 col-xl-3 btn btn-success" onclick="selectTool(this);app.keybinds.ChangeTool(app.keybinds.toolEraser)">Eraser</button>
    </div>
  </div>

  <h4 class="sidebar-title mt-3 col-12 text-center">Icons (drag & drop onto map)</h4>

  <div class="row justify-content-center" id="icon-searchbox">
    <input type="text" class="col-10" onkeyup="search('icon-box', this.value)" placeholder="Search">
  </div>

  <div id="icon-box" class="row justify-content-center">
    <!-- Populate icons -->
    @foreach($gadgets as $gadget)
    <div class="col-xl-2 col-6 p-1 text-center">
      <input type="hidden" class="name" id="" value="{{$gadget->name}}">
      <img src="{{$gadget->icon->url()}}" alt="" draggable="true" ondragstart="app.keybinds.drag(event)" height="50" width="50">
    </div>
    @endforeach
  </div>
</div>
