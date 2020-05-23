/**************************
	Extention class type
**************************/
const Rectangleable = require('./Rectangleable.js').default;

class Icon extends Rectangleable {

    /**************************
            Constructor
    **************************/

    constructor(id, origin, size, src) {
        super(id,origin,origin);
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

    /**************************
        Helper functions
    **************************/

   ToJson(){
        return {
            'localId' : this.localId,
            'type': 'Icon',
            'id' : this.id,
            'origin' : this.origin,
            'src' : this.src,
            'size' : this.size,
            'destination' : this.destination
        }
    }
}
export {
    Icon as
    default
}