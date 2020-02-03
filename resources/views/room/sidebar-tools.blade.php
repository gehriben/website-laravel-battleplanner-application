<div class="row margin10">
    <div class="col-6">
        <button type="button" name="button" id="pencil" class="toolSelector btn btn-info col-12 active" onclick="app.engine.changeTool(app.engine.toolLine,this)" data-toggle="tooltip" data-placement="top" title="Keybind: q"><i class="fas fa-paint-brush"></i></button>
    </div>

    <div class="col-6">
        <button type="button" name="button" id="square" class="toolSelector btn btn-info col-4 col-12" onclick="app.engine.changeTool(app.engine.toolSquare,this)" data-toggle="tooltip" data-placement="top" title="Keybind: w"><i class="fas fa-square"></i></button>
    </div>
  </div>

<div class="row margin10">
    <div class="col-6">
        <button type="button" name="button" id="eraser" class="toolSelector btn btn-info col-4 col-12" onclick="app.engine.changeTool(app.engine.toolErase,this)" data-toggle="tooltip" data-placement="top" title="Keybind: z"><i class="fas fa-eraser"></i></button>
    </div>

    <div class="col-6">
        <input type="color" class="col-12" id='colorPicker' name="color" value="#e66465" onChange="app.engine.changeColor(this.value)" />
    </div>
</div>

<div class="row margin10">
    <div class="col-12">
        <div class="row">
            <div class="col-4">Pen size</div>
            <input type="number" id='lineSizePicker'  class="col-8" name="size" onChange="app.engine.changeLineSize(this.value)" />
        </div>
        <div class="row">
                <div class="col-4">Icon size</div>
                <input type="number" id='iconSizePicker'  class="col-8" name="size" onChange="app.engine.changeIconSize(this.value)" />
        </div>
    </div>
</div>
