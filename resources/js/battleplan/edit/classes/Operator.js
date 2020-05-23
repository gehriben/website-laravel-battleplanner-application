/**************************
	Extention class type
**************************/
var Databaseable = require('./Databaseable.js').default;

class Operator extends Databaseable{

    /**************************
            Constructor
    **************************/
    constructor(id,src) {
        super(id);
        this.src = src;
    }

    ToJson(){
        return {
            'id' : this.id,
            'localId' : this.localId,
            'src' : this.src
        }
    }
}
export {
    Operator as
    default
}
