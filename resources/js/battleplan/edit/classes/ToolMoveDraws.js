/**************************
	Extention class type
**************************/
const Tool = require('./Tool.js').default;

class ToolMoveCanvas extends Tool {

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
        var mx = (this.origin.x - coordinates.x) / this.app.canvas.scale
        var my = (this.origin.y - coordinates.y) / this.app.canvas.scale
        
        this.app.battleplan.floor.SelectedDraws().forEach(draw => {
            draw.Move(-mx,-my);
        });

        this.origin = coordinates;
        this.app.canvas.Update();
    }

}
export {
    ToolMoveCanvas as
        default
}