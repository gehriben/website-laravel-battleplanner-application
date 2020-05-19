/**************************
	Extention class type
**************************/
const Draw = require('./Draw.js').default;

class Icon extends Draw {

    /**************************
            Constructor
    **************************/

    constructor(origin, size, src) {
        super(origin);

        this.size = size;

        this.origin.x = this.origin.x - this.size/2;
        this.origin.y = this.origin.y - this.size/2;

        this.destination = {
            "x": this.origin.x  + this.size,
            "y": this.origin.y  + this.size
        }

        this.SelectBox = require('./SelectBox.js').default;
        this.src = src;
        this.img = null;
    }

    draw(canvas){

        if(!this.img){
            this.img = new Image;
            this.img.src = this.src;

            // Load the image in memory
            this.img.onload = function() {
                this.draw(canvas);
            }.bind(this);

        } else{
            
            // translate offset
            canvas.ctx.translate(canvas.offset.x,canvas.offset.y);
            
            canvas.ctx.drawImage(
                this.img,
               
                this.origin.x,
                this.origin.y,

                this.size,
                this.size
            );    
            
            if(this.highlighted){
                this.Highlight(canvas);
            }

            // Translate Back
            canvas.ctx.translate(-canvas.offset.x,-canvas.offset.y);
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
        this.SelectBox.checkSides(offsetOrigin,offsetDestination);

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
        this.SelectBox.checkSides(offsetOrigin,offsetDestination);

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
            "x": this.origin.x,
            "y": this.origin.y,
        };

        var offsetDestination = {
            "x": this.destination.x,
            "y": this.destination.y
        }

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
    
    Move(dX,dY){
        super.Move(dX,dY);
        this.destination.x += dX;
        this.destination.y += dY;
    }
    
    /**************************
        Helper functions
    **************************/

}
export {
    Icon as
    default
}