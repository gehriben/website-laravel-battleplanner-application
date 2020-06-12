/**************************
	Extention class type
**************************/
const Draw = require('./Draw.js').default;

class Square extends Draw {

    /**************************
            Constructor
    **************************/

    constructor(id, origin, destination, color, opacity) {
        super(id);
        this.SelectBox = require('./SelectBox.js').default;
        this.color = color;
        this.opacity = opacity;
        this.origin = {'x':parseFloat(origin.x),'y':parseFloat(origin.y)};
        this.destination = {'x':parseFloat(destination.x),'y':parseFloat(destination.y)};
        this.type = 'Square';
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
    
    Move(dX,dY){
        super.Move(dX,dY);
        this.origin.x += dX;
        this.origin.y += dY;

        this.destination.x += dX;
        this.destination.y += dY;
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

    UpdateFromJson(json){
        this.origin = {'x':parseFloat(json.origin.x),'y':parseFloat(json.origin.y)};
        this.destination = {'x':parseFloat(json.destination.x),'y':parseFloat(json.destination.y)};
        this.updated = true;
    }

   ToJson(){
        return {
            'localId' : this.localId,
            'type': 'Square',
            'id' : this.id,
            'origin' : this.origin,
            'color' : this.color,
            'destination' : this.destination,
            'opacity' : this.opacity,
            'updated' : this.updated,
            'type' : this.type,
        }
    }
}
export {
    Square as
        default
}