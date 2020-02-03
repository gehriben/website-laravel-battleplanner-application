/**************************
	Extention class type
**************************/
const Draw = require('./Draw.js').default;

class Square extends Draw {

    /**************************
            Constructor
    **************************/

    constructor() {
        super();
    }

    init() {
        
    }

    draw(draw, ctx, ui) {
        var tmp = this;
        ctx.fillStyle = draw.drawable.color;
        ctx.globalAlpha = 0.35;

        var oX = draw.originX * ui.ratio - ui.offsetX;
        var oY = draw.originY * ui.ratio - ui.offsetY;
        var dX = draw.destinationX * ui.ratio - ui.offsetX;
        var dY = draw.destinationY * ui.ratio - ui.offsetY;

        ctx.fillRect(
            oX,
            oY,
            dX - oX,
            dY - oY
        );

        ctx.globalAlpha = 1.0;

    }
    /**************************
        Helper functions
    **************************/
}
export {
    Square as
        default
}
