/**************************
	Extention class type
**************************/
var Databaseable = require('./Databaseable.js').default;

class Operator extends Databaseable{

    /**************************
            Constructor
    **************************/
    constructor(id,operator_id,src) {
        super(id);
        this.src = src;
        this.operatorId = operator_id;
    }

    ToJson(){
        return {
            'id' : this.id,
            'localId' : this.localId,
            'src' : this.src,
            'operator_id' : this.operatorId
        }
    }
}
export {
    Operator as
    default
}
