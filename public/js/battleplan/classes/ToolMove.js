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
        this.origin = coordinates;
    }

    actionMove(coordinates) {
        var mx = this.origin.x - coordinates.x
        var my = this.origin.y - coordinates.y
        this.app.canvas.move(-mx / this.app.canvas.scale, -my / this.app.canvas.scale);
        this.origin = coordinates;
    }

}
export {
    ToolMove as
        default
}