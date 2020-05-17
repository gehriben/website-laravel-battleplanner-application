
// ToolErase = require('./classes/ToolErase.js').default; // useable tool

class Keybinds {

    /**************************
            Constructor
    **************************/
    constructor(app) {
        // Class inclusions
        this.ToolMove = require('./ToolMove.js').default; // useable tool
        this.ToolZoom = require('./ToolZoom.js').default; // useable tool
        this.ToolLine = require('./ToolLine.js').default; // useable tool
        this.ToolSquare = require('./ToolSquare.js').default; // useable tool
        this.ToolIcon = require('./ToolIcon.js').default; // useable tool

        this.keysPressed = [];              // keys actively pressed
        this.keyEvents = [];                // Key binding to events

        this.tools(app);

        this.mousePressed = {               // keys pressed on mouse       
            "lmb": {
                "active": false,
                "tool": this.toolLine
            },
            "rmb": {
                "active": false,
                "tool": null
            },
            "mmb": {
                "active": false,
                "tool": this.toolMove
            },
        }

        // Define Possible Mouse
        // Defining possible key Combinations & actions
        // this.keyEvents.push({ "keys": [38], "event": this.floorUp }); // up arrow
        // this.keyEvents.push({ "keys": [40], "event": this.floorDown }); // down arrow
        // this.keyEvents.push({ "keys": [17,83], "event": this.save }); // down arrow
        // this.keyEvents.push({ "keys": [17,68], "event": this.load }); // down arrow
        // this.keyEvents.push({ "keys": [81], "event": this.toolPencil }); // down arrow
        // this.keyEvents.push({ "keys": [87], "event": this.toolSquare }); // down arrow
        // this.keyEvents.push({ "keys": [90], "event": this.toolEraser }); // down arrow

        /**
         * Event listeners
         */

        // Keyboard Listeners
        $(document).on('keydown', this.pressKey.bind(this));
        $(document).on('keyup',this.pressKey.bind(this));

        // Canvas Listeners
        app.viewport[0].addEventListener("mouseup", function(ev){
            this.unpressMouse(ev);
            this.canvasUp(ev);
        }.bind(this));

        app.viewport[0].addEventListener("mousedown", function(ev){
            this.pressMouse(ev);
            this.canvasDown(ev);
        }.bind(this));

        app.viewport[0].addEventListener("mousemove", function(ev){
            this.canvasMove(ev);
        }.bind(this));

        
        app.viewport[0].addEventListener("mousewheel", function(ev){
            this.canvasScroll(ev);
        }.bind(this));

        app.viewport[0].addEventListener("dragover", function(ev){
            this.allowDrop(ev);
        }.bind(this));

        
        app.viewport[0].addEventListener("drop", function(ev){
            this.canvasDrop(ev);
        }.bind(this));

        // app.viewport.addEventListener("mousedown", this.canvasDown);
        // app.viewport.addEventListener("mousewheel", this.canvasScroll);
        // viewport.addEventListener("mousemove", this.canvasMove);
        // app.viewport.addEventListener("mouseout", this.canvasLeave);
        
        
        /**
         * Button Binds
         */
        // $("#lineTool").click(function(){
        //     this.mousePressed.lmb.tool = this.toolLine;
        // }.bind(this));
        
        // $("#squareTool").click(function(){
        //     this.mousePressed.lmb.tool = this.toolSquare;
        // }.bind(this));
    }

    tools(app){
        this.toolZoom = new this.ToolZoom(app);
        this.toolMove = new this.ToolMove(app);
        this.toolLine = new this.ToolLine(app);
        this.toolSquare = new this.ToolSquare(app);
        this.toolIcon = new this.ToolIcon(app);
    }

    // fire events id button combination pressed
    listen() {
        // keyboard check
        this.keyEvents.forEach(function (element) {
            var flag = true;
            for (let index = 0; index < element["keys"].length && flag; index++) {
                const aKey = element["keys"][index]
                if (!this.keysPressed.includes(aKey)) {
                    flag = false;
                }
            }
            if (flag) {
                element["event"]();
            }
        }.bind(this));
    }

    /**
     * Button press listeners
     */
    pressMouse(ev){
        this.mousePressed.lmb.active = (ev.button == 0) ? true : this.mousePressed.lmb.active;
        this.mousePressed.mmb.active = (ev.button == 1) ? true : this.mousePressed.mmb.active;
        this.mousePressed.rmb.active = (ev.button == 2) ? true : this.mousePressed.rmb.active;
    }

    unpressMouse(ev){
        this.mousePressed.lmb.active = (ev.button == 0) ? false : this.mousePressed.lmb.active;
        this.mousePressed.mmb.active = (ev.button == 1) ? false : this.mousePressed.mmb.active;
        this.mousePressed.rmb.active = (ev.button == 2) ? false : this.mousePressed.rmb.active;
    }

    // Button pressed - add to list
    pressKey(event){
        this.setKey(event.which || event.keyCode);
        this.preventDefaultBrowserActions();
        this.listen();
    }

    // Button unpressed - remove from list
    unpressKey(event){
        this.unsetKey(event.which || event.keyCode);
    }
    
    /**
     * Private Helpers
     */

    // Prevent default browser actions on specific key combinations
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
     * Canvas Actions
     */

    canvasUp(ev) {
        // Get current coordinates
        var coordinates = {x:ev.offsetX, y:ev.offsetY};

        for (const key in this.mousePressed)
            (this.mousePressed[key].active && this.mousePressed[key].tool) ? this.mousePressed[key].tool.actionUp(coordinates) : null;
    }

    canvasDown(ev) {
        // Get current coordinates
        var coordinates = {x:ev.offsetX, y:ev.offsetY};

        // this._clickActivateEventListen(ev)
        for (const key in this.mousePressed)
            if (this.mousePressed[key].active && this.mousePressed[key].tool) this.mousePressed[key].tool.actionDown(coordinates);
    }
    
    canvasMove(ev) {
        // Get current coordinates
        var coordinates = {x:ev.offsetX, y:ev.offsetY};

        // this._clickActivateEventListen(ev)
        for (const key in this.mousePressed) {
            if (this.mousePressed[key].active && this.mousePressed[key].tool) this.mousePressed[key].tool.actionMove(coordinates);
        }
    }

    canvasScroll(ev) {

        // Get current coordinates
        var coordinates = {x:ev.offsetX, y:ev.offsetY};

        var delta = ev.wheelDelta ? ev.wheelDelta/40 : ev.detail ? -ev.detail : 0;

        if (delta){
            this.toolZoom.actionScroll(delta,coordinates);
        }

        return ev.preventDefault() && false;
    }

    canvasDrop(ev) {
        // Get current coordinates
        var coordinates = {x:ev.offsetX, y:ev.offsetY};

        var src = ev.dataTransfer.getData("src");

        this.toolIcon.actionDrop(coordinates, src);

        for (const key in this.buttonEvents) {
            if (this.buttonEvents[key].active && this.buttonEvents[key].tool) this.buttonEvents[key].tool.actionDrop();
        }

        return ev.preventDefault();
    }

    allowDrop(ev) {
        ev.preventDefault();
    }

    drag(ev) {
        ev.dataTransfer.setData("src", ev.target.src);
    }

    /**
     * Key Actions
     */

    ChangeTool(tool){
        this.mousePressed.lmb.tool = tool;
    }

    // floorDown() {
    //     app.engine.changeFloor(-1);
    // }
    // floorUp() {
    //     app.engine.changeFloor(1);
    // }
    // save() {
    //     $("#saveModalToggle").click();
    // }
    // load() {
    //     $("#loadModalToggle").click();
    // }
    // toolPencil(){
    //     toast("Pencil Selected", 2000);
    //     $("#pencil").click();
    // }
    // toolSquare(){
    //     toast("Square Selected", 2000);
    //     $("#square").click();
    // }
    // toolEraser(){
    //     toast("Eraser Selected", 2000);
    //     $("#eraser").click();
    // }
}
export {
    Keybinds as
        default
}