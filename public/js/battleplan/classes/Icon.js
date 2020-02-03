/**************************
	Extention class type
**************************/
const Draw = require('./Draw.js').default;

class Icon extends Draw {

    /**************************
            Constructor
    **************************/

    constructor() {
        super();
        this.img = null;
    }

    init(){
        
    }

    draw(draw,ctx,ui){
        if(!this.img){
            this.img = new Image;
            this.img.src = this.src;

            // Load the image in memory
            this.img.onload = function() {
                // this.img = img;
                this.draw(draw,ctx,ui);
            }.bind(this);
        } else{
            ctx.drawImage(
                this.img,
                draw.originX * ui.ratio - ui.offsetX,
                draw.originY * ui.ratio - ui.offsetY,
                (draw.destinationX -draw.originX) * ui.ratio,
                (draw.destinationY - draw.originY)  * ui.ratio);
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
