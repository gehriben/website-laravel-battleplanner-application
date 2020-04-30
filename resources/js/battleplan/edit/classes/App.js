var Battleplan = require('./Battleplan.js').default;
var Canvas = require('./Canvas.js').default;
// var ToolLine = require('./ToolLine.js').default;
// var ToolSquare = require('./ToolSquare.js').default;
var ToolMove = require('./ToolMove.js').default;
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
        this.floor = 0;                 // Active floor on canvas
        
        // Drawing settings
        this.lineSize = 3;
        this.iconSize = 25;

        // Tools
        // this.toolLine;
        // this.toolSquare;
        this.toolMove;
        // this.toolZoom;
        // this.toolImage;

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
     * - Get Map data
     * - Initialize new battleplan
     */
    Start(id,viewport){
        // Initialize Battleplan hierarchy
        this.battleplan = new Battleplan(id, function(){
            this.canvas = new Canvas(this,viewport);       // Initialize canvas
        }.bind(this));
    }

}
export {
    App as
        default
}
