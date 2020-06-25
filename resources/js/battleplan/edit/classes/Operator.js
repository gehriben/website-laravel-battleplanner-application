/**************************
	Extention class type
**************************/
var Databaseable = require('./Databaseable.js').default;

class Operator extends Databaseable{

    /**************************
            Constructor
    **************************/
    constructor(id,operator_id,src, color) {
        super(id);
        this.src = src;
        this.color = color;
        this.operatorId = operator_id;
    }

    ToJson(){
        return {
            'id' : this.id,
            'localId' : this.localId,
            'src' : this.src,
            'color' : this.color,
            'operator_id' : this.operatorId
        }
    }
}
export {
    Operator as
    default
}
