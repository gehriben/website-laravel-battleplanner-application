/**************************
	Extention class type
**************************/
const Tool = require('./Tool.js').default;

class ToolSelect extends Tool {

    /**************************
            Constructor
    **************************/

    constructor(app) {
        // Super Class constructor call
        super(app);
        this.SelectBox = require('./SelectBox.js').default;
        this.activeSelect;
        this.size = 1;
    }
    
    actionDown(coordinates){
        
        this.activeSelect = new this.SelectBox(
            this.AddOffsetCoordinates(coordinates),
            "ffffff",
            this.size 
        );
        
        this.app.battleplan.floor.AddDraw(this.activeSelect);
    }

    actionUp(coordinates){
        this.app.battleplan.floor.RemoveDraw(this.activeSelect);
        this.activeSelect.Select(this.app.canvas,this.app.battleplan.floor.draws);
        this.activeSelect = null;
        this.app.canvas.Update();
    }

    actionMove(coordinates){
        if(this.activeSelect){
            this.activeSelect.destination = this.AddOffsetCoordinates(coordinates);
            this.app.canvas.Update();
        }
    }
    
    AddOffsetCoordinates(coor){
        return {
            "x" : (coor.x) / this.app.canvas.scale - this.app.canvas.offset.x,
            "y" : (coor.y) / this.app.canvas.scale - this.app.canvas.offset.y
        }
    }
}
export {
    ToolSelect as
    default
}
