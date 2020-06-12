/**************************
	Extention class type
**************************/

const Draw = require('./Draw.js').default;
class Icon extends Draw {

    /**************************
            Constructor
    **************************/

    constructor(id, origin, size, opacity, src) {
        super(id,origin);
        this.SelectBox = require('./SelectBox.js').default;
        this.size = size;
        this.opacity = opacity;
        this.origin = {'x':parseFloat(origin.x),'y':parseFloat(origin.y)};
        this.src = src;
        this.img = null;
        this.type = 'Icon';
    }

    draw(canvas){

        if(!this.img){
            this.img = new Image;
            this.img.src = this.src;

            // Load the image in memory
            this.img.onload = function() {
                this.width = this.img.width;
                this.height = this.img.height;
                this.draw(canvas);
            }.bind(this);

        } else{
            
            // translate offset
            canvas.ctx.translate(canvas.offset.x,canvas.offset.y);
            canvas.ctx.globalAlpha = this.opacity;
            
            canvas.ctx.drawImage(
                this.img,
               
                this.origin.x - ((this.height * this.size)/2) ,
                this.origin.y - ((this.width * this.size)/2) ,
                (this.width * this.size),
                (this.height * this.size)
            );    
            
            canvas.ctx.globalAlpha = 1;

            if(this.highlighted){
                this.Highlight(canvas);
            }
            
            // Translate Back
            canvas.ctx.translate(-canvas.offset.x,-canvas.offset.y);
            
        }
    }

    
    // Highlights object
    Highlight(canvas){
        var defaultColor = canvas.ctx.strokeStyle;
        canvas.ctx.strokeStyle = "blue";
        
        canvas.ctx.beginPath();
        canvas.ctx.rect(
            this.origin.x - ((this.height * this.size)/2) ,
            this.origin.y - ((this.width * this.size)/2) ,
            (this.width * this.size),
            (this.height * this.size)
        );
        canvas.ctx.stroke();

        canvas.ctx.strokeStyle = defaultColor;
    }

    inBox(canvas,box){
        
        // square inside box
        var offsetOrigin = {
            'x': this.origin.x - ((this.width * this.size)/2) + canvas.offset.x,
            'y': this.origin.y - ((this.height * this.size)/2) + canvas.offset.y,
        };

        var offsetDestination = {
            'x': this.origin.x + ((this.width * this.size)/2) + canvas.offset.x,
            'y': this.origin.y + ((this.height * this.size)/2) + canvas.offset.y,
        }

        if(
            this.SelectBox.PointInBox(canvas,offsetOrigin,box) ||
            this.SelectBox.PointInBox(canvas,{"x": offsetOrigin.x, "y" : offsetDestination.y},box) ||
            this.SelectBox.PointInBox(canvas,offsetDestination,box) ||
            this.SelectBox.PointInBox(canvas,{"x": offsetDestination.x, "y" : offsetOrigin.y},box)
        ){
            return true;
        }

        // box inside square
        offsetOrigin = {
            "x": box.origin.x + canvas.offset.x,
            "y": box.origin.y + canvas.offset.y
        };

        offsetDestination = {
            "x": box.destination.x + canvas.offset.x,
            "y": box.destination.y + canvas.offset.y
        }

        box = {
            origin : {
                'x': this.origin.x - ((this.width * this.size)/2),
                'y': this.origin.y - ((this.height * this.size)/2),
            },

            destination : {
                'x': this.origin.x + ((this.width * this.size)/2),
                'y': this.origin.y + ((this.height * this.size)/2),
            },
        }
        if(
            this.SelectBox.PointInBox(canvas,offsetOrigin,box) ||
            this.SelectBox.PointInBox(canvas,{"x": offsetOrigin.x, "y" : offsetDestination.y},box) ||
            this.SelectBox.PointInBox(canvas,offsetDestination,box) ||
            this.SelectBox.PointInBox(canvas,{"x": offsetDestination.x, "y" : offsetOrigin.y},box)
        ){
            return true;
        }

        return false;
    }
    
    Move(dX,dY){
        super.Move(dX,dY);
        this.origin.x += dX;
        this.origin.y += dY;
    }
    /**************************
        Helper functions
    **************************/

    UpdateFromJson(json){
        this.origin = {'x':parseFloat(json.origin.x),'y':parseFloat(json.origin.y)};
        this.updated = true;
    }

   ToJson(){
        return {
            'localId' : this.localId,
            'type': 'Icon',
            'id' : this.id,
            'origin' : this.origin,
            'source' : this.src,
            'size' : this.size,
            'opacity': this.opacity,
            'updated' : this.updated,
            'type' : this.type,
        }
    }
}
export {
    Icon as
    default
}