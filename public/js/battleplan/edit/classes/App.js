var Battleplan = require('./Battleplan.js').default;
var Canvas = require('./Canvas.js').default;
var Keybinds = require('./Keybinds.js').default;
// var ToolLine = require('./ToolLine.js').default;
// var ToolSquare = require('./ToolSquare.js').default;
// var ToolMoveCanvas = require('./ToolMoveCanvas.js').default;
// var ToolZoom = require('./ToolZoom.js').default;
// var ToolIcon = require('./ToolIcon.js').default;
// var ToolErase = require('./ToolErase.js').default;

class App {

    /**************************
            Constructor
    **************************/

    constructor(id, viewport) {
        // Properties
        this.canvas;                    // Canvas data and logic
        this.map;                       // Saved Map Data (map & floors)
        this.battleplan;                // Saved battleplan instance
        this.keybinds;                  // Definition of keybind actions
        this.viewport = viewport        // active canvas

        // Drawing settings
        this.lineSize = 3;
        this.iconSize = 25;

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

        this.Start(id, viewport);
    }

    /**
     * Setup the battleplan data:
     * - Initialize key eventlisteners
     * - Get Map data
     * - Initialize new battleplan
     */
    Start(id,viewport){
        this.keybinds = new Keybinds(this);

        // Initialize Battleplan hierarchy
        this.battleplan = new Battleplan(id, function(){
            this.canvas = new Canvas(this,viewport);       // Initialize canvas
        }.bind(this));
    }

    ChangeTool(tool){
        this.keybinds.mousePressed.lmb.tool = tool;
    }
}
export {
    App as
        default
}
