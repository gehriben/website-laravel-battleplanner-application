/**************************
	Extention class type
**************************/
const Helpers = require('./Helpers.js').default;

class Tool extends Helpers {

    /**************************
            Constructor
    **************************/

    constructor(app) {
        // Super Class constructor call
        super();
        this.app = app
    }

    draw(ctx, ui) {
        // Action to be overriten in child
    }

    actionUp() {
        // Action to be overriten in child
    }

    actionDown() {
        // Action to be overriten in child
    }

    actionLeave() {
        // Action to be overriten in child
    }

    actionEnter() {
        // Action to be overriten in child
    }

    actionMove() {
        // Action to be overriten in child
    }
    
    actionScroll(){
        // Action to be overriten in child
    }
    actionDrop(){
        // Action to be overriten in child
    }

}
export {
    Tool as
    default
}
