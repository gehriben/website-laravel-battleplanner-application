/**************************
	Extention class type
**************************/
const Tool = require('./Tool.js').default;

class ToolLine extends Tool {

    /**************************
            Constructor
    **************************/

    constructor(app) {
        // Super Class constructor call
        super(app);
        this.Line = require('./Line.js').default;
        this.activeLine;
    }
    
    actionDown(coordinates){
        this.activeLine = new this.Line(
            null,
            this.app.color,
            this.app.opacity,
            this.app.lineSize
        );

        this.activeLine.points.push(
            this.AddOffsetCoordinates(coordinates)
        );

        this.app.battleplan.floor.AddDraw(this.activeLine);
    }

    actionUp(coordinates){
        this.activeLine = null;
        this.app.canvas.Update();
    }

    actionLeave(coordinates){
        this.activeLine = null;
    }

    actionMove(coordinates){
        if(this.activeLine){

            this.activeLine.points.push(
                this.AddOffsetCoordinates(coordinates)
            );
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
    ToolLine as
    default
}
