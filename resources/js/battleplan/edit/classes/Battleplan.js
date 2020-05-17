var Floor = require('./Floor.js').default;

class Battleplan {

    /**************************
            Constructor
    **************************/

    constructor(id, callback) {
        // Properties
        this.floors = [];        // Floors of the battleplan
        this.floor;              // Current Active Floor
        this.finishedCallback = callback;
        this.Initialize(id,callback);
    }
    
    Initialize(id,callback){
        this.Get(id,function(result){

            for(var i = 0; i < result.battlefloors.length; i++){
                var floor = new Floor(result.battlefloors[i], this.ReadyCheck.bind(this))
                this.floors.push(floor);

                // First floor, set as default
                if(i == 0){
                    this.floor = floor;
                }
            }

        }.bind(this));
    }
    
    // Check that all sub assets have loaded
    ReadyCheck(){

        // are all the floors loaded?
        for (let i = 0; i < this.floors.length; i++) {
            const floor = this.floors[i];
            if(!floor.load){
                return false;
            }
        }
        
        // all sub elements loaded correctly, signal finished callback
        this.finishedCallback();
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
