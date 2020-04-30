var Floor = require('./Floor.js').default;

class Battleplan {

    /**************************
            Constructor
    **************************/

    constructor(id, callback) {
        // Properties
        this.floors = [];        // Floors of the battleplan

        this.Initialize(id,callback);
    }
    
    Initialize(id,callback){
        this.Get(id,function(result){

            for(var i = 0; i < result.battlefloors.length; i++){
                this.floors.push(new Floor(result.battlefloors[i]))
            }
            
            // Initialization complete callback
            callback();

        }.bind(this));
    }
    
    // Get Map
    Get(id,callback) {
        $.ajax({
            method: "GET",
            contentType: "application/json",
            url: `/battleplan/${id}`,
            dataType: "json",

            success: function (result) {
                callback(result);
            },
            
            error: function (result) {
                console.log(result);
            }

        });
    }

}
export {
    Battleplan as
        default
}
