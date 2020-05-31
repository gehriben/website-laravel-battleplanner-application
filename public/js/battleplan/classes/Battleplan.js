var Floor = require('./Floor.js').default;
var Databaseable = require('./Databaseable.js').default;
var Operator = require('./Operator.js').default;

class Battleplan extends Databaseable{

    /**************************
            Constructor
    **************************/

    constructor(id, slots, callback) {
        // Properties
        super(id);
        this.floors = [];        // Floors of the battleplan
        this.floor;              // Current Active Floor
        this.finishedCallback = callback;
        this.operators = []             // Operators
        this.operator;                  // Operator slot being edited
        this.Initialize(id,slots,callback);
    }
    
    Initialize(id,slots,callback){
        this.Get(id,function(result){

            // Create floors
            for(var i = 0; i < result.battlefloors.length; i++){
                var floor = new Floor(result.battlefloors[i], this.ReadyCheck.bind(this))
                this.floors.push(floor);

                // First floor, set as default
                if(i == 0){
                    this.floor = floor;
                }
            }

            // Create operator slots object
            for (let i = 0; i < slots.length; i++) {
                var operator_src = (result['operator_slots'][i]['operator']) ? result['operator_slots'][i]['operator']["icon"]["url"] : "https://via.placeholder.com/50";
                this.operators.push({
                    "operator" : new Operator(result['operator_slots'][i]['id'],result['operator_slots'][i]['operator_id'],operator_src),
                    "slot" : slots[i]
                });
            }

        }.bind(this));
    }

    ChangeFloor(increment){
        var current = this.floors.findIndex(floor => floor.id === this.floor.id);
        var next = current + increment;

        if(
            next >=0 &&                     // lowest
            next <= this.floors.length  -1    // highest
        ){
            this.floor = this.floors[next]
        }
        return this.floor;
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

    ToJson(){
        
        var operatorsJson = [];
        for (let i = 0; i < this.operators.length; i++) {
            const operator = this.operators[i].operator;
            operatorsJson.push(operator.ToJson());
        }

        var floorsJson = [];
        for (let i = 0; i < this.floors.length; i++) {
            const floor = this.floors[i];
            floorsJson.push(floor.ToJson());
        }

        return {
            'id' : this.id,
            'operators' : operatorsJson,
            'localId' : this.localId,
            'floors' : floorsJson
        }
    }
}
export {
    Battleplan as
        default
}
