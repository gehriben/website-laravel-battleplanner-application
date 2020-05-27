var Databaseable = require('./Databaseable.js').default;

class Draw extends Databaseable{

    /**************************
            Constructor
    **************************/
    constructor(id) {
        // Properties
        super(id);
    }

    draw(canvas){
        // Should be overriden in child
    }

    /**************************
        Helper functions
    **************************/
   
    

    // getType(draw){
    //     var exploded = draw.drawable_type.split("\\");
    //     return exploded[exploded.length -1];
    // }

    // Method to see if object is inside a given bounding box.
    // Used for the selection tool
    InBox(canvas,box){
        // Should be overriden in child
        return false;
    }

    // Highlights object
    Highlight(canvas){
        // Should be overriden in child
    }

    Move(dX,dY){
        this.updated = true;
        // Should be overriden in child
    }

}
export {
    Draw as
    default
}