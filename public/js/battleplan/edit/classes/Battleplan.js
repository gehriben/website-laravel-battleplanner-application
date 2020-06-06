var Floor = require('./Floor.js').default;
var Databaseable = require('./Databaseable.js').default;
var Operator = require('./Operator.js').default;

class Battleplan extends Databaseable{

    /**************************
            Constructor
    **************************/

    constructor(id, slots) {
        // Properties
        super(id);
        this.slots = slots;
        this.floors = [];        // Floors of the battleplan
        this.floor;              // Current Active Floor
        this.finishedCallback;
        this.operators = []             // Operators
        this.operator;                  // Operator slot being edited
    }
    
    initializeByApi(slots,callback){
        this.finishedCallback = callback;

        this.Get(this.id,function(result){

            // Create floors
            for(var i = 0; i < result.battlefloors.length; i++){
                var floor = new Floor(result.battlefloors[i]['id']);
                floor.initializeByApi(result.battlefloors[i], this.ReadyCheck.bind(this));
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

    initializeByJson(Json,slots,callback){
        this.finishedCallback = callback;
        
        for (let i = 0; i < Json.floors.length; i++) {
            const floorData = Json.floors[i];
            var floor = new Floor(floorData['id']);
            floor.initializeByJson(floorData, this.ReadyCheck.bind(this));
            floor.localId = floorData['localId'];
            this.floors.push(floor);

            // First floor, set as default
            if(i == 0){
                this.floor = floor;
            }
        }

        // Create operator slots object
        for (let i = 0; i < Json.operators.length; i++) {
            var operatorData = Json.operators[i];
            var operator = new Operator(operatorData.id,operatorData.operator_id,operatorData.src);
            operator.localId = operatorData['localId'];
            this.operators.push({
                "operator" : operator,
                "slot" : slots[i]
            });
        }

    }

    ChangeFloor(increment){
        var current = this.floors.findIndex(floor => floor.id === this.floor.id);
        var next = current + increment;

        if(
            next >=0 &&                         // lowest
            next <= this.floors.length  -1      // highest
        ){
            this.floor = this.floors[next]
        }
        return this.floor;
    }

    getFloorByLocalId(localId){
        for (let i = 0; i < this.floors.length; i++) {
            const floor = this.floors[i];
            if(floor.localId == localId){
                return floor;
            }
        }
    }

    getOperatorByLocalId(localId){
        for (let i = 0; i < this.operators.length; i++) {
            const operator = this.operators[i];
            if(operator.operator.localId == localId){
                return operator;
            }
        }
    }

    getDrawLocalId(localId){
        for (let i = 0; i < this.floors.length; i++) {
            const floor = this.floors[i];
            var found = floor.getDrawLocalId(localId);
            if(found){
                return found;
            }
        }
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

    deleteDrawByLocalId(localId){
        this.floors.forEach(floor => {
            floor.deleteDrawByLocalId(localId)
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
