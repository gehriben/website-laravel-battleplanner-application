/**************************
	Extention class type
**************************/
const Tool = require('./Tool.js').default;

class ToolZoom extends Tool {

    /**************************
            Constructor
    **************************/

    constructor(app) {
        // Super Class constructor call
        super(app);
        this.origin;
    }

    actionScroll(clicks, coordinates) {
        this.app.canvas.zoom(clicks, coordinates)
    }

}
export {
    ToolZoom as
        default
}
