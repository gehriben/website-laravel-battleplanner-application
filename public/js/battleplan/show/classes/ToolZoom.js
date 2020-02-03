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
        this.step = .1;
    }

    actionScroll(direction, coordinates) {
        this.app.ui.zoomCanvases(this.step * direction, coordinates.x, coordinates.y);
        this.app.ui.backgroundUpdate = true;
        this.app.ui.overlayUpdate = true;
    }

}
export {
    ToolZoom as
        default
}
