/**************************
	Extention class type
**************************/
const Draw = require('./Draw.js').default;

class Square extends Draw {

    /**************************
            Constructor
    **************************/

    constructor(origin, destination, color, size) {
        super(origin);
        this.destination = destination;
        this.color = color;
        this.size = size;
    }

    draw(canvas) {
        
        canvas.ctx.fillStyle = this.color;
        canvas.ctx.globalAlpha = 0.35;

        var offsetOrigin = {
            "x": this.origin.x + canvas.offset.x,
            "y": this.origin.y + canvas.offset.y
        };

        var offsetDestination = {
            "x": this.destination.x + canvas.offset.x,
            "y": this.destination.y + canvas.offset.y
        }

        // origin must always be bigger the destination for drawing on canvas
        this.checkSides(offsetOrigin,offsetDestination);


        canvas.ctx.fillRect(
            offsetOrigin.x,
            offsetOrigin.y,
            offsetDestination.x - offsetOrigin.x,
            offsetDestination.y - offsetOrigin.y,
        );

        // reset alpha
        canvas.ctx.globalAlpha = 1.0;

    }

    /**
     * Private Helpers
     */
    checkSides(c1,c2){

        if(parseInt(c1.x) > parseInt(c2.x)){ 
            var swap = c1.x;
            c1.x = c2.x
            c2.x = swap;
        }

        if(parseInt(c1.y) > parseInt(c2.y)){
            var swap = c1.y;
            c1.y = c2.y
            c2.y = swap;
        }

    }
    
}
export {
    Square as
        default
}