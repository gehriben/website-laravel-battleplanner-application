var Battleplan = require('./Battleplan.js').default;
var Canvas = require('./Canvas.js').default;
var Keybinds = require('./Keybinds.js').default;
var Operator = require('./Operator.js').default;

class App {

    /**************************
            Constructor
    **************************/

    constructor(id, viewport, slots) {
        // Properties
        this.canvas;                    // Canvas data and logic
        this.map;                       // Saved Map Data (map & floors)
        this.battleplan;                // Saved battleplan instance
        this.keybinds;                  // Definition of keybind actions
        this.viewport = viewport        // Active canvas
        this.operators = []             // Operators
        this.operator;                  // Operator slot being edited

        // Button statuses
        this.buttonEvents = {
            "lmb": {
                "active": false,
                "tool": null
            },
            "rmb": {
                "active": false,
                "tool": null
            },
            "mmb": {
                "active": false,
                "tool": null
            },
        }

        this.Start(id, viewport, slots);
    }

    /**
     * Setup the battleplan data:
     * - Initialize key eventlisteners
     * - Get Map data
     * - Initialize new battleplan
     */
    Start(id,viewport, slots){
        // Make Keybind Listener class
        this.keybinds = new Keybinds(this);

        // Initialize Battleplan hierarchy
        this.battleplan = new Battleplan(id, function(){
            this.canvas = new Canvas(this,viewport);       // Initialize canvas
        }.bind(this));

        // Create operator slots object
        for (let i = 0; i < slots.length; i++) {
            this.operators.push({
                "operator" : new Operator(null,"https://via.placeholder.com/50"),
                "slot" : slots[i]
            });
        }

        this.DisplayOperators();
    }

    ChangeTool(tool){
        this.keybinds.mousePressed.lmb.tool = tool;
    }

    /**
     * Operator Logic
     */
    DisplayOperators(){
        this.operators.forEach(operator => {
            operator.slot.attr( "src", operator.operator.src );
        });
    }

    ChangeOperator(operatorId,src){
        this.operator.operator.operatorId = operatorId;
        this.operator.operator.src = src;
        this.DisplayOperators();
    }

    /**
     * Save
     */
    SaveAs(name,description,notes,ispublic){
        var operatorsJson = [];
        
        for (let i = 0; i < this.operators.length; i++) {
            const operator = this.operators[i].operator;
            operatorsJson.push(operator.ToJson());
        }

        var json = {
            'battleplan' : this.battleplan.ToJson(),
            'operators' : operatorsJson,
            'name' : name,
            'description' : description,
            'notes' : notes,
            'public' : ispublic
        }

        $.ajax({
            method: "POST",
            url: `/battleplan/${this.battleplan.id}`,
            data: json,
            success: function (result) {
                alert("success");
            },
            
            error: function (result) {
                console.log(result);
            }

        });
    }
}
export {
    App as
        default
}
