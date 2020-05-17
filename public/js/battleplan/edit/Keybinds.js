// ToolLine = require('./classes/ToolLine.js').default; // useable tool
// ToolSquare = require('./classes/ToolSquare.js').default; // useable tool
ToolMove = require('./classes/ToolMove.js').default; // useable tool
// ToolZoom = require('./classes/ToolZoom.js').default; // useable tool
// ToolIcon = require('./classes/ToolIcon.js').default; // useable tool
// ToolErase = require('./classes/ToolErase.js').default; // useable tool

class Keybinds {

    /**************************
            Constructor
    **************************/
    constructor(app) {

        this.keysPressed = [];
        this.keyEvents = [];
        this.mousePressed = {
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

        // Define Possible Mouse
        // Defining possible key Combinations & actions
        this.keyEvents.push({ "keys": [38], "event": this.floorUp }); // up arrow
        this.keyEvents.push({ "keys": [40], "event": this.floorDown }); // down arrow
        this.keyEvents.push({ "keys": [17,83], "event": this.save }); // down arrow
        this.keyEvents.push({ "keys": [17,68], "event": this.load }); // down arrow
        this.keyEvents.push({ "keys": [81], "event": this.toolPencil }); // down arrow
        this.keyEvents.push({ "keys": [87], "event": this.toolSquare }); // down arrow
        this.keyEvents.push({ "keys": [90], "event": this.toolEraser }); // down arrow

        // Keypress
        $(document).on('keydown', this.pressKey);

        // KeyPressed
        $(document).on('keyup',this.pressKey);
        
    }

    pressKey(event){
        setKey(event.which || event.keyCode);
        this.preventDefaultBrowserActions();
        events();
    }

    unpressKey(event){
        unsetKey(event.which || event.keyCode);
    }
    
    /**
     * Private Helpers
     */

    preventDefaultBrowserActions(){
         if (
             this.keysPressed.includes(17) && this.keysPressed.includes(83) ||    // Prevent ctrl + s default behavior
             this.keysPressed.includes(17) && this.keysPressed.includes(68)       // Prevent ctrl + d default behavior
             ) {
            event.preventDefault();
        }
    }
    
    // Set a key pressed
    setKey(code) {
        if (!this.keysPressed.includes(code)) {
            this.keysPressed.push(code)
        }
    }

    // Unset a key pressed
    unsetKey(code) {
        this.keysPressed = this.keysPressed.filter(function (value, index, arr) {
            return value != code;
        });
    }

    /**
     * Key Actions
     */
    floorDown() {
        app.engine.changeFloor(-1);
    }
    floorUp() {
        app.engine.changeFloor(1);
    }
    save() {
        $("#saveModalToggle").click();
    }
    load() {
        $("#loadModalToggle").click();
    }
    toolPencil(){
        toast("Pencil Selected", 2000);
        $("#pencil").click();
    }
    toolSquare(){
        toast("Square Selected", 2000);
        $("#square").click();
    }
    toolEraser(){
        toast("Eraser Selected", 2000);
        $("#eraser").click();
    }
}
export {
    Keybinds as
        default
}