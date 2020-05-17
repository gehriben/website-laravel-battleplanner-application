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
        this.scaleFactor = 1.1;
    }

    actionScroll(clicks, coordinates) {
        this.app.canvas.zoom(coordinates,clicks,this.scaleFactor)
    }

}
export {
    ToolZoom as
        default
}
