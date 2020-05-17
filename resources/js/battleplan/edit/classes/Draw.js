
        
class Draw {

    /**************************
            Constructor
    **************************/
    constructor(origin) {
        // this.Line = require('./Line.js').default;
        // this.Square = require('./Square.js').default;
        // this.Icon = require('./Icon.js').default;

        this.origin = origin;
        // this.destination = destination;

    }

    draw(canvas){
        
        if (this.drawable instanceof this.Square) {
            this.checkSides()
        }

        this.drawable.draw(canvas);
    }

    /**************************
        Helper functions
    **************************/
    getType(draw){
        var exploded = draw.drawable_type.split("\\");
        return exploded[exploded.length -1];
    }

    checkSides(){
        var tmp;

        if(parseInt(this.originX) > parseInt(this.destinationX)){
            tmp = this.originX;
            this.originX = this.destinationX
            this.destinationX = tmp;
        }

        if(parseInt(this.originY) > parseInt(this.destinationY)){
            tmp = this.originY;
            this.originY = this.destinationY
            this.destinationY = tmp;
        }

    }
}
export {
    Draw as
    default
}