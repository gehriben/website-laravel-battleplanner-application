/**************************
    Extention class type
**************************/
const CanvasElement = require('./CanvasElement.js').default;

class SelectorBox extends CanvasElement {

    /**************************
            Constructor
    **************************/

    constructor(x, y, height, width) {
        // Super Class constructor call
        super('selector', x, y, height, width, "gray")

        // Identifiers
        this.type = "SelectorBox"; // Json identifier
    }

    /**************************
          Public Methods
    **************************/

    /**
     * @description recalculates the correct coordinates for the placeholder such that it is always positive values (height, with, x, y)
     * @method move
     * @param  {int} x coordinate of the cursor
     * @param  {int} y coordinate of the cursor
     * @return {undefined}
     */
    move(actX, actY) {
        this.width = actX - this.origins["x"];
        this.height = actY - this.origins["y"];
    }

    /**
     * @description checks if the placeholder is within the selector box
     * @method isElementInsideSelector
     * @param  {Placeholder}
     * @return {bool}
     */
    isElementInsideSelector(canvasElement) {
        var thisLeftOfcanvasElement = this.coordinates["x"] + this.width < canvasElement.coordinates["x"];
        var thisRightOfcanvasElement = this.coordinates["x"] > canvasElement.coordinates["x"] + canvasElement.width;
        var thisAbovecanvasElement = this.coordinates["y"] > canvasElement.coordinates["y"] + canvasElement.height;
        var thisBelowcanvasElement = this.coordinates["y"] + this.height < canvasElement.coordinates["y"];
        return !(thisLeftOfcanvasElement || thisRightOfcanvasElement || thisAbovecanvasElement || thisBelowcanvasElement);
    }
}
export {
    SelectorBox as
    default
}
