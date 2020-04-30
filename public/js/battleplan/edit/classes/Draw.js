Line = require('./Line.js').default;
Square = require('./Square.js').default;
Icon = require('./Icon.js').default;
        
class Draw {

    /**************************
            Constructor
    **************************/
    constructor() {
        
    }

    init(){
        // var type = this.getType(this);
        this.drawable = Object.assign(new this[this.getType(this)], this.drawable);

        if (this.drawable instanceof this.Square) {
            this.checkSides()
        }
        
        this.drawable.init();
    }

    draw(ctx,ui){
        
        if (this.drawable instanceof this.Square) {
            this.checkSides()
        }

        this.drawable.draw(this,ctx,ui);//.bind(this.drawable);
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