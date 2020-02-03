class Helpers {

    /**************************
            Constructor
    **************************/

    constructor() {

    }

    /**************************
        Filter Functions
    **************************/

    _objectNotDeleted(object){
        if(!object.deleted){
            return object;
        }
    }

    _objectIdEquals(object,id){
        if(object.id == id){
            return object;
        }
    }

    _objectDbIdEquals(object,id){
        if(object.dbId == id){
            return object;
        }
    }

    _objectInside(object,x,y){
        if(object.inside(x,y)){
            return object;
        }
    }

    _objectSelected(object){
        if(object.selected){
            return object;
        }
    }

    /**************************
        Id Generation Methods
    **************************/

    /**
     * @description makes a unique id
     * @method _makeId
     * @return {string}
     */
    _makeId(relevantIds) {
        var id = this._guid();
        while (relevantIds.includes(id)) {
            id = this._guid();
        }
        return id;
    }

    // Helper for _makeId
    _guid() {
        return this._s4() + this._s4() + '-' + this._s4() + '-' + this._s4() + '-' +
            this._s4() + '-' + this._s4() + this._s4() + this._s4();
    }

    // Helper for _guid
    _s4() {
        return Math.floor((1 + Math.random()) * 0x10000)
            .toString(16)
            .substring(1);
    }

    // Makes array of id from the objects
    _getIds(arrayObjects){
        var results = []
        for (var i = 0; i < arrayObjects.length; i++) {
            results.push(arrayObjects[i].id);
        }
        return results;
    }
}
export {
    Helpers as
    default
}
