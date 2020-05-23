import { v4 as uuidv4 } from 'uuid';
// var uuid = require('uuid');

class Databaseable{

    /**************************
            Constructor
    **************************/

    constructor(id) {
        this.id = id;
        this.localId = this.GenerateLocalId();
    }
    
    ToJson(){
        return {
            'id' : this.id,
            'localId' : this.localId,
        }
    }

    GenerateLocalId(){
        return uuidv4();
    }

}
export {
    Databaseable as
    default
}