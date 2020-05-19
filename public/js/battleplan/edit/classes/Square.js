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
        this.SelectBox = require('./SelectBox.js').default;
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

        if(this.highlighted){
            this.Highlight(canvas);
        }

    }

    /**
     * Parent overrides
     */
    inBox(canvas,box){
        
        // square inside box
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

        if(
            this.SelectBox.PointInBox(canvas,offsetOrigin,box) ||
            this.SelectBox.PointInBox(canvas,{"x": offsetOrigin.x, "y" : offsetDestination.y},box) ||
            this.SelectBox.PointInBox(canvas,offsetDestination,box) ||
            this.SelectBox.PointInBox(canvas,{"x": offsetDestination.x, "y" : offsetOrigin.y},box)
        ){
            return true;
        }

        // square inside box
        offsetOrigin = {
            "x": box.origin.x + canvas.offset.x,
            "y": box.origin.y + canvas.offset.y
        };

        offsetDestination = {
            "x": box.destination.x + canvas.offset.x,
            "y": box.destination.y + canvas.offset.y
        }

        // origin must always be bigger the destination for drawing on canvas
        Square.checkSides(offsetOrigin,offsetDestination);

        if(
            this.SelectBox.PointInBox(canvas,offsetOrigin,this) ||
            this.SelectBox.PointInBox(canvas,{"x": offsetOrigin.x, "y" : offsetDestination.y},this) ||
            this.SelectBox.PointInBox(canvas,offsetDestination,this) ||
            this.SelectBox.PointInBox(canvas,{"x": offsetDestination.x, "y" : offsetOrigin.y},this)
        ){
            return true;
        }

        return false;
    }

    // Highlights object
    Highlight(canvas){
        var defaultColor = canvas.ctx.strokeStyle;
        canvas.ctx.strokeStyle = "blue";

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

        canvas.ctx.beginPath();
        canvas.ctx.rect(
            offsetOrigin.x,
            offsetOrigin.y,
            offsetDestination.x - offsetOrigin.x,
            offsetDestination.y - offsetOrigin.y,
        );
        canvas.ctx.stroke();

        canvas.ctx.strokeStyle = defaultColor;
    }

    /**
     * Private Helpers
     */
    static checkSides(c1,c2){

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
    
    Move(dX,dY){
        super.Move(dX,dY);
        this.destination.x += dX;
        this.destination.y += dY;
    }

    
}
export {
    Square as
        default
}