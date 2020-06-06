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
        
        if(this.activeLine){
            this.sendBroadcast(this.activeLine);
        }
        
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
        if(this.activeLine){
            this.sendBroadcast(this.activeLine);
        }
        this.activeLine = null;
        this.app.canvas.Update();
    }

    actionLeave(coordinates){
        
        if(this.activeLine){
            this.sendBroadcast(this.activeLine);
        }

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

    sendBroadcast(draw){
        $.ajax({
            method: "POST",
            url: `/lobby/${LOBBY["connection_string"]}/request-draw-create`,
            data: {
                'drawData' : draw.ToJson(),
                'floorData' : this.app.battleplan.floor.ToJson(),
            },
            success: function (result) {
                console.log(result);
            }.bind(this),
            
            error: function (result) {
                console.log(result);
            }
    
        });
    }
}
export {
    ToolLine as
    default
}
