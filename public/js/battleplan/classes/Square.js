/**************************
	Extention class type
**************************/
const Rectangleable = require('./Rectangleable.js').default;

class Square extends Rectangleable {

    /**************************
            Constructor
    **************************/

    constructor(id, origin, color, size, opacity) {
        super(id, origin, origin);
        this.SelectBox = require('./SelectBox.js').default;
        this.color = color;
        this.size = size;
        this.opacity = opacity;
    }

    draw(canvas) {
        
        canvas.ctx.fillStyle = this.color;
        canvas.ctx.globalAlpha = this.opacity;

        var offsetOrigin = {
            "x": this.origin.x + canvas.offset.x,
            "y": this.origin.y + canvas.offset.y
        };

        var offsetDestination = {
            "x": this.destination.x + canvas.offset.x,
            "y": this.destination.y + canvas.offset.y
        }

        // origin must always be bigger the destination for drawing on canvas
        Square.checkSides(offsetOrigin,offsetDestination);

        canvas.ctx.fillRect(
            offsetOrigin.x,
            offsetOrigin.y,
            offsetDestination.x - offsetOrigin.x,
            offsetDestination.y - offsetOrigin.y,
        );

        // reset alpha
        canvas.ctx.globalAlpha = 1.0;

        // translate offset
        canvas.ctx.translate(canvas.offset.x,canvas.offset.y);
            
        if(this.highlighted){
            this.Highlight(canvas);
        }

        // Translate Back
        canvas.ctx.translate(-canvas.offset.x,-canvas.offset.y);
        
    }
    
   ToJson(){
        return {
            'localId' : this.localId,
            'type': 'Square',
            'id' : this.id,
            'origin' : this.origin,
            'color' : this.color,
            'size' : this.size,
            'destination' : this.destination,
            'opacity' : this.opacity
        }
    }
}
export {
    Square as
        default
}