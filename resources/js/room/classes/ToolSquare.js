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
        this.Draw = require('./Draw.js').default;
        this.origin;
        this.creating = null;
    }

    draw(ctx, ui) {
        
        if (this.creating) {
            this.creating.draw(ctx, ui);
        }
    }

    actionDown(coordinates) {
        this.origin = coordinates;
    }

    actionUp(coordinates) {
        this.app.battleplan.battlefloor.addDraw(this.square(this.origin, coordinates, this.app.color));
        this.creating = null;
        this.app.ui.overlayUpdate = true;
        this.app.logPush();
    }

    actionLeave(coordinates) {
        this.origin = coordinates;
        this.creating = null;
    }

    actionMove(coordinates) {
        this.creating = this.square(this.origin, coordinates, this.app.color);
        this.app.ui.overlayUpdate = true;
    }

    square(origin, destination, color) {
        var draw = {
            "battlefloor_id": this.app.battleplan.battlefloor.id,
            "destinationX": destination.x,
            "destinationY": destination.y,
            "drawable_type": "Square",
            "originX": origin.x,
            "originY": origin.y,
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
    ToolSquare as
    default
}
