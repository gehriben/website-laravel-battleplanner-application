/**************************
	Extention class type
**************************/
const Draw = require('./Draw.js').default;

class Line extends Draw {

    /**************************
            Constructor
    **************************/

    constructor(origin,destination,color, battlefloorId) {
        super();
    }

    init(){

    }

    draw(draw,ctx,ui){
        ctx.lineWidth=this.lineSize;
        ctx.beginPath();
        ctx.moveTo(draw.originX * ui.ratio - ui.offsetX, draw.originY * ui.ratio - ui.offsetY);
        ctx.lineTo(draw.destinationX * ui.ratio - ui.offsetX + 1, draw.destinationY * ui.ratio - ui.offsetY + 1);
        ctx.strokeStyle = draw.drawable.color;
        ctx.closePath();
        ctx.stroke();
    }
    /**************************
        Helper functions
    **************************/

}
export {
    Line as
    default
}
