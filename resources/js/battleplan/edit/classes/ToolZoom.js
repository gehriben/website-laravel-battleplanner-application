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
        
        // var sign = Math.sign(clicks);
        var step = this.app.canvas.scaleStep * this.app.canvas.scale * clicks;
        this.app.ChangeZoom(this.app.canvas.scale + step)
    }

}
export {
    ToolZoom as
        default
}
