/**************************
	Extention class type
**************************/
const Helpers = require('./Helpers.js').default;

class Gadget extends Helpers {

    /**************************
            Constructor
    **************************/

    constructor(gadget) {
        // Super Class constructor call
        super();

        // Identifiers
        this.id = gadget.id;
        this.type = "Gadget"; // Json identifier

        // Variables
        this.prime = null;
    }


}
export {
    Gadget as
    default
}