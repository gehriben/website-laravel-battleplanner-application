/**************************
	Extention class type
**************************/
const Tool = require('./Tool.js').default;

class ToolMove extends Tool {

    /**************************
            Constructor
    **************************/

    constructor(app) {
        // Super Class constructor call
        super(app);
        this.origin = { "x": 0, "y": 0 };
    }

    actionDown(coordinates) {
        this.origin.x = coordinates.x
        this.origin.y = coordinates.y
    }

    actionMove(coordinates) {
        // this.app.ui.move(this.origin.x - coordinates.x, this.origin.y - coordinates.y);
        var mx = this.origin.x - coordinates.x
        var my = this.origin.y - coordinates.y
        this.app.ui.move(mx, my);
        this.app.ui.backgroundUpdate = true;
    }

}
export {
    ToolMove as
        default
}
