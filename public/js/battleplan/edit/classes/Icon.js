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
        this.src = src;
        this.img = null;
        this.size = size;
    }

    init(){
        
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
               
                this.origin.x - this.size/2,
                this.origin.y - this.size/2,

                this.size,
                this.size
            );    
            
            // Translate Back
            canvas.ctx.translate(-canvas.offset.x,-canvas.offset.y);
        }
    }
    
    /**************************
        Helper functions
    **************************/

}
export {
    Icon as
    default
}