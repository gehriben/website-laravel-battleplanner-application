/**************************
	Extention class type
**************************/
const Tool = require('./Tool.js').default;

class ToolEraser extends Tool {

    /**************************
            Constructor
    **************************/

    constructor(app) {
        // Super Class constructor call
        super(app);
        this.origin = { "x": 0, "y": 0 };
        this.size = 30;
    }

    actionDown(coordinates) {
        this.origin = coordinates;
        this.app.battleplan.floor.draws.forEach(draw => {
            if(draw.inBox(app.canvas,this.getBox())){
                this.app.battleplan.floor.RemoveDraw(draw);
                this.sendBroadcast(draw.localId);
            }
        });
        this.app.canvas.Update();
        this.getBox();
    }

    actionMove(coordinates) {
        this.origin = coordinates;
        this.app.battleplan.floor.draws.forEach(draw => {
            if(draw.inBox(app.canvas,this.getBox())){
                this.app.battleplan.floor.RemoveDraw(draw);
                this.sendBroadcast(draw.localId);
            }
        });
        this.app.canvas.Update();
        this.getBox();
    }
    
    sendBroadcast(drawLocalId){
        $.ajax({
            method: "POST",
            url: `/lobby/${LOBBY["connection_string"]}/request-draw-delete`,
            data: {
                'localId' : drawLocalId
            },
            success: function (result) {
                console.log(result);
            }.bind(this),
            
            error: function (result) {
                console.log(result);
            }
    
        });
    }
    /**
     * Private Helpers
     */
    getBox(){

        var x = {
            "origin": {
                "x" : (this.origin.x) / this.app.canvas.scale - this.app.canvas.offset.x - (this.size/2),
                "y" : (this.origin.y) / this.app.canvas.scale - this.app.canvas.offset.y - (this.size/2)
            },
            "destination": {
                "x" : (this.origin.x) / this.app.canvas.scale - this.app.canvas.offset.x + (this.size/2),
                "y" : (this.origin.y) / this.app.canvas.scale - this.app.canvas.offset.y + (this.size/2)
            }
        }

        return x;
    }

}
export {
    ToolEraser as
        default
}