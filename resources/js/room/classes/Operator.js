/**************************
	Extention class type
**************************/
const Helpers = require('./Helpers.js').default;

class Operator extends Helpers {

    /**************************
            Constructor
    **************************/

    constructor(operator, gadgets) {
        // Super Class constructor call
        super();

        // Instantiatable class types
        this.Gadget = require('./Gadget.js').default;
		//
        // // Identifiers
        // this.id = operator.id;
        // this.type = "Operator"; // Json identifier
		//
        // // Variables
        // this.gadgetPrime = null;
        // this.gadgetsSecond = [];
        // this.atk = operator.atk;
        // this.name = operator.name;
		//
        // this.initialization(gadgets);
    }

    // initialization(gadgetSources) {
    //     // Initialize the gadgets
    //     this.loadGadgets(gadgetSources);
    // }
	//
    // loadGadgets(gadgetSources) {
    //     for (var i = 0; i < gadgetSources.length; i++) {
    //         if (gadgetSources[i].prime) {
    //             this.gadgetPrime = gadgetSources[i];
    //         } else {
    //             this.gadgetsSecond.push(new this.Gadget(gadgetSources[i]));
    //         }
    //     }
    // }


}
export {
    Operator as
    default
}
