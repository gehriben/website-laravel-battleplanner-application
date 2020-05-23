/**************************
	Extention class type
**************************/
const Rectangleable = require('./Rectangleable.js').default;

class SelectBox extends Rectangleable {

    /**************************
            Constructor
    **************************/

    constructor(origin, color, size) {
        super(null,origin,origin);
        this.color = color;
        this.size = size;
    }

    draw(canvas) {
        
        canvas.ctx.fillStyle = this.color;

        var offsetOrigin = {
            "x": this.origin.x + canvas.offset.x,
            "y": this.origin.y + canvas.offset.y
        };

        var offsetDestination = {
            "x": this.destination.x + canvas.offset.x,
            "y": this.destination.y + canvas.offset.y
        }

        // origin must always be bigger the destination for drawing on canvas
        SelectBox.checkSides(offsetOrigin,offsetDestination);

        canvas.ctx.beginPath();
        canvas.ctx.rect(
            offsetOrigin.x,
            offsetOrigin.y,
            offsetDestination.x - offsetOrigin.x,
            offsetDestination.y - offsetOrigin.y,
        );
        canvas.ctx.stroke();
    }

    // Determine if a given point is inside box coordinates
    // Assumption, box is Axis alignes with both x and y (AABB)
    // point is searched point (2d)
    static PointInBox(canvas, point, box){
        
        var offsetOrigin = {
            "x": box.origin.x + canvas.offset.x,
            "y": box.origin.y + canvas.offset.y
        };

        var offsetDestination = {
            "x": box.destination.x + canvas.offset.x,
            "y": box.destination.y + canvas.offset.y
        }

        // origin must always be bigger the destination for drawing on canvas
        SelectBox.checkSides(offsetOrigin,offsetDestination);
        
        return (point.x >= offsetOrigin.x && point.x <= offsetDestination.x) &&  // x coordinate check
            (point.y >= offsetOrigin.y && point.y <= offsetDestination.y);       // y coordinate check
    }

    Select(canvas,draws){
        draws.forEach(draw => {
            draw.highlighted = draw.inBox(canvas,this);
        });
    }
    
    

}
export {
    SelectBox as
        default
}