/**************************
	Extention class type
**************************/
const Tool = require('./Tool.js').default;

class ToolDelete extends Tool {

    /**************************
            Constructor
    **************************/

    constructor(app) {
        // Super Class constructor call
        super(app);
        this.Square = require('./Square.js').default;
        this.activeSquare;
        this.size = 1;
    }
    
    actionDown(coordinates){
        this.activeSquare = new this.Square(
            this.AddOffsetCoordinates(coordinates),
            this.AddOffsetCoordinates(coordinates),
            "ffffff",
            this.size 
        );
        
        this.app.battleplan.floor.AddDraw(this.activeSquare);
    }

    actionUp(coordinates){
        this.activeSquare = null;
        this.app.canvas.Update();
    }

    actionLeave(coordinates){
        this.activeSquare = null;
    }

    actionMove(coordinates){
        if(this.activeSquare){
            this.activeSquare.destination = this.AddOffsetCoordinates(coordinates);
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
    ToolSquare as
    default
}
