import 'bootstrap';

class Keybinds {

    /**************************
            Constructor
    **************************/
    constructor(app) {
        this.app = app;

        this.ToolMove = new (require('./ToolMove.js').default)(app); 
        this.toolZoom = new (require('./ToolZoom.js').default)(app); 
        this.toolLine = new (require('./ToolLine.js').default)(app); 
        this.toolSquare = new (require('./ToolSquare.js').default)(app); 
        this.toolIcon = new (require('./ToolIcon.js').default)(app);
        this.toolSelect = new (require('./ToolSelect.js').default)(app);
        this.toolEraser = new (require('./ToolEraser.js').default)(app);

        this.keysPressed = [];              // keys actively pressed
        this.keyEvents = [];                // Key binding to events

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
                "tool": this.ToolMove
            },
        }

        // Save
        this.keyEvents.push({ "keys": [17,83], "event": function(ev){
            $('#test-modal').modal();
            ev.preventDefault();
        } });

        // Arrow Up
        this.keyEvents.push({ "keys": [38], "event": function(ev){
            app.ChangeFloor(1);
            ev.preventDefault();
        } });
        
        // Arrow down
        this.keyEvents.push({ "keys": [40], "event": function(ev){
            app.ChangeFloor(-1);
            ev.preventDefault();
        }});
        
        // Delete key
        this.keyEvents.push({ "keys": [46], "event": function(ev){
            
            app.battleplan.floor.SelectedDraws().forEach(draw => {
                app.battleplan.floor.RemoveDraw(draw);

                $.ajax({
                    method: "POST",
                    url: `/lobby/${LOBBY["connection_string"]}/request-draw-delete`,
                    data: {
                        'localId' : draw.localId
                    },

                    success: function (result) {
                        console.log(result);
                    }.bind(this),
                    
                    error: function (result) {
                        console.log(result);
                    }
            
                });

            });

            

            this.app.canvas.Update();
            ev.preventDefault();
        }.bind(this)});

        /**
         * Event listeners
         */

        // Keyboard Listeners
        $(document).on('keydown', this.pressKey.bind(this));
        $(document).on('keyup',this.unpressKey.bind(this));

        // Canvas Listeners
        app.viewport[0].addEventListener("mouseup", function(ev){
            this.canvasUp(ev);
            this.unpressMouse(ev);
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

    }

    // fire events id button combination pressed
    listen(ev) {
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
                element["event"](ev);
                return true;
            }

        }.bind(this));
        return false;
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
        // this.preventDefaultBrowserActions();
        if(this.listen(event)){
            event.preventDefault();
        };
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
}
export {
    Keybinds as
        default
}