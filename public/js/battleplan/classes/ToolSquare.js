/**************************
	Extention class type
**************************/
const Tool = require('./Tool.js').default;

class ToolSquare extends Tool {

    /**************************
            Constructor
    **************************/

    constructor(app) {
        // Super Class constructor call
        super(app);
        this.Square = require('./Square.js').default;
        this.activeSquare;
    }
    
    actionDown(coordinates){
        
        if(this.activeSquare){
            this.sendBroadcast(this.activeSquare);
        }
        
        this.activeSquare = new this.Square(
            null,
            this.AddOffsetCoordinates(coordinates),
            this.AddOffsetCoordinates(coordinates),
            this.app.color,
            this.app.opacity
        );
        
        this.app.battleplan.floor.AddDraw(this.activeSquare);
    }

    actionUp(coordinates){
        
        if(this.activeSquare){
            this.sendBroadcast(this.activeSquare);
        }
        this.activeSquare = null;
        this.app.canvas.Update();
    }

    actionLeave(coordinates){
        
        if(this.activeSquare){
            this.sendBroadcast(this.activeSquare);
        }
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
    ToolSquare as
    default
}
