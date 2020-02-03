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
        this.Draw = require('./Draw.js').default;
        this.origin;
    }
    
    actionDown(coordinates){
		this.origin = coordinates;
    }

    actionUp(coordinates){
        this.app.battleplan.battlefloor.addDraw(this.line(this.origin, coordinates, this.app.color));
        this.app.ui.overlayUpdate = true;
        this.app.logPush();
    }

    actionLeave(coordinates){
        this.origin = coordinates;
    }

    actionMove(coordinates){
        this.app.battleplan.battlefloor.addDraw(this.line(this.origin, coordinates, this.app.color));
        this.origin = coordinates;
        this.app.ui.overlayUpdate = true;
        this.app.logPush();
    }
    
    line(originCoordinates,destinationCoordinates, color){
        var draw = {
          "battlefloor_id": this.app.battleplan.battlefloor.id,
          "destinationX": destinationCoordinates.x,
          "destinationY": destinationCoordinates.y,
          "drawable_type": "Line",
          "originX": originCoordinates.x,
          "originY": originCoordinates.y,
        };
  
        draw.drawable = {
            "lineSize": this.app.lineSize,
            "color": this.app.color,
        }
  
        draw = Object.assign(new this.Draw, draw);
        draw.init();
        return draw;
      }
}
export {
    ToolLine as
    default
}
