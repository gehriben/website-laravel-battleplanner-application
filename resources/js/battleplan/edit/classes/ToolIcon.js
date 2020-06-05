/**************************
	Extention class type
**************************/
const Tool = require('./Tool.js').default;

class ToolIcon extends Tool {

    /**************************
            Constructor
    **************************/

    constructor(app) {
        // Super Class constructor call
        super(app);
        this.Icon = require('./Icon.js').default;
    }

    actionDrop(coordinates,src) {
        if(src){

            var icon = new this.Icon(
                null,
                this.AddOffsetCoordinates(coordinates),
                this.app.iconSizeModifier,
                this.app.opacity,
                src
            );
            this.sendBroadcast(icon);
            this.app.battleplan.floor.AddDraw(icon);
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
    ToolIcon as
    default
}
