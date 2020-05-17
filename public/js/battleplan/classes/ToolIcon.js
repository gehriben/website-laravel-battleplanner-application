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
        this.size = 100;
    }

    actionDrop(coordinates,src) {
        if(src){

            var icon = new this.Icon(
                this.AddOffsetCoordinates(coordinates),
                this.size,
                src
            );

            this.app.battleplan.floor.Draw(icon);

            this.app.canvas.Update();
        }
    }

    // icon(coordinates, src) {
    //     var start = JSON.parse(JSON.stringify(coordinates));
    //     var end = JSON.parse(JSON.stringify(coordinates));

    //     start.x = coordinates.x - (this.app.iconSize/2);
    //     start.y = coordinates.y - (this.app.iconSize/2);

    //     end.x = coordinates.x + (this.app.iconSize/2);
    //     end.y = coordinates.y + (this.app.iconSize/2);

    //     var draw = {
    //         "battlefloor_id": this.app.battleplan.battlefloor.id,
    //         "destinationX": end.x,
    //         "destinationY": end.y,
    //         "drawable_type": "Icon",
    //         "originX": start.x,
    //         "originY": start.y,
    //     };

    //     draw.drawable = {
    //         "src": src,
    //     }

    //     draw = Object.assign(new this.Draw, draw);
    //     draw.init();
    //     return draw;
    // }
    
    AddOffsetCoordinates(coor){
        return {
            "x" : (coor.x) / this.app.canvas.scale - this.app.canvas.offset.x,
            "y" : (coor.y) / this.app.canvas.scale - this.app.canvas.offset.y
        }
    }
    
}
export {
    ToolIcon as
    default
}
