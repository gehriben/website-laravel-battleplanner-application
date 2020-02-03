@if ($room->Owner == Auth::User())
    <div class="row margin10">
        <div class="col-6" data-toggle="tooltip" data-placement="top" title="Keybind: Ctrl + D">
                <button type="button" id="loadModalToggle" name="button" class="btn btn-info sidebar-btn" data-toggle="modal"
                    data-target="#mapModal">Load/New</button>
        </div>
        <div class="col-6" data-toggle="tooltip" data-placement="top" title="Keybind: Ctrl + S">
                <button type="button" name="button" class="btn btn-success sidebar-btn" id="saveModalToggle" data-toggle="modal" data-target="#save">Save</button>
        </div>
    </div>
@endif
<div class="row margin10">
    <div class="col-6">
            <button type="button" name="button" class="btn btn-primary sidebar-btn" onclick="app.engine.changeFloor(-1)" data-toggle="tooltip" data-placement="top" title="Keybind: Down arrow">Floor
                &darr;</button>
    </div>
    <div class="col-6">
            <button type="button" name="button" class="btn btn-primary sidebar-btn" onclick="app.engine.changeFloor(1)" data-toggle="tooltip" data-placement="top" title="Keybind: Up arrow">Floor
                &uarr;</button>
    </div>
</div>
