var Battleplan = require('./Battleplan.js').default;
var Canvas = require('./Canvas.js').default;
var Keybinds = require('./Keybinds.js').default;

class App {

    /**************************
            Constructor
    **************************/

    constructor(id, viewport, slots) {
        this.id = id;
        this.viewport = viewport
        this.slots = slots;

        // Properties
        this.canvas;                    // Canvas data and logic
        this.map;                       // Saved Map Data (map & floors)
        this.battleplan;                // Saved battleplan instance
        this.keybinds;                  // Definition of keybind actions

        //Drawing settings
        this.color = '#ffffff';
        this.opacity = 1;
        this.lineSize = 1;
        this.iconSizeModifier = 1

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
        this.battleplan = new Battleplan(id,slots, function(){
            this.canvas = new Canvas(this,viewport);       // Initialize canvas
            this.DisplayOperators();
        }.bind(this));

    }

    ChangeFloor(increment){
        this.battleplan.ChangeFloor(increment);
        this.canvas.Update();
    }

    ChangeTool(tool){
        this.keybinds.mousePressed.lmb.tool = tool;
    }

    ChangeColor(color){
        this.color = color;
    }

    ChangeOpacity(opacity){
        this.opacity = opacity;
    }

    ChangeLineSize(lineSize){
        this.lineSize = lineSize;
    }

    ChangeIconSizeModifier(size){
        this.iconSizeModifier = size;
    }

    /**
     * Operator Logic
     */
    DisplayOperators(){
        this.battleplan.operators.forEach(operator => {
            operator.slot.attr( "src", operator.operator.src );
        });
    }

    ChangeOperator(operatorId,src){
        this.battleplan.operator.operator.operatorId = operatorId;
        this.battleplan.operator.operator.src = src;
        this.DisplayOperators();
    }

    /**
     * Save
     */
    SaveAs(name,description,notes,ispublic){

        var json = {
            'battleplan' : this.battleplan.ToJson(),
            'name' : name,
            'description' : description,
            'notes' : notes,
            'public' : ispublic,
        }

        $.ajax({
            method: "POST",
            url: `/battleplan/${this.battleplan.id}`,
            data: json,
            success: function (result) {
                // alert("success");

                // Initialize Battleplan hierarchy
                this.battleplan = new Battleplan(this.id,this.slots, function(){
                    this.canvas = new Canvas(this,this.viewport);       // Initialize canvas
                    this.DisplayOperators();
                }.bind(this));
            }.bind(this),
            
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
