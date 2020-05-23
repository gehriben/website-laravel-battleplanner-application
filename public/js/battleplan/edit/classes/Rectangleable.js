const Draw = require('./Draw.js').default;

class Rectangleable extends Draw {

    /**************************
            Constructor
    **************************/

    constructor(id, origin, destination) {
        super(id);
        this.origin = origin;
        this.destination = destination;
    }
    
    static checkSides(origin,destination){
        var tmp;

        if(parseInt(origin.x) > parseInt(destination.x)){
            tmp = origin.x;
            origin.x = destination.x
            destination.x = tmp;
        }

        if(parseInt(origin.y) > parseInt(destination.y)){
            tmp = origin.y;
            origin.y = destination.y
            destination.y = tmp;
        }
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
        Rectangleable.checkSides(offsetOrigin,offsetDestination);

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
        Rectangleable.checkSides(offsetOrigin,offsetDestination);

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
    
    Move(dX,dY){
        
        this.origin.x += dX;
        this.origin.y += dY;

        this.destination.x += dX;
        this.destination.y += dY;
    }

    ToJson(){
        return {
            'id' : this.id,
            'localId' : this.localId,
            'origin' : this.origin,
            'destination' : this.destination,
        }
    }

}
export {
    Rectangleable as
    default
}