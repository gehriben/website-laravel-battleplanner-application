import 'bootstrap';

class Keybinds {

    /**************************
            Constructor
    **************************/
    constructor(app) {
        this.app = app;

        this.toolMove = new (require('./ToolMove.js').default)(app); 
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
                "tool": this.toolMove
            },
            "rmb": {
                "active": false,
                "tool": this.toolMove
            },
            "mmb": {
                "active": false,
                "tool": this.toolMove
            },
        }

        // Save
        this.keyEvents.push({ "keys": [17,83], "event": function(ev){
            $('#save-modal').modal();
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
        
        // alt + q
        this.keyEvents.push({ "keys": [18,81], "event": function(ev){
            this.mousePressed.lmb.tool = this.toolMove;
            $('#selectMove').click();
            ev.preventDefault();
        }.bind(this)});

        // alt + w
        this.keyEvents.push({ "keys": [18,87], "event": function(ev){
            this.mousePressed.lmb.tool = this.toolSelect;
            $('#selectTool').click();
            ev.preventDefault();
        }.bind(this)});

        // alt + e
        this.keyEvents.push({ "keys": [18,69], "event": function(ev){
            this.mousePressed.lmb.tool = this.toolLine;
            $('#lineTool').click();
            ev.preventDefault();
        }.bind(this)});

        // alt + r
        this.keyEvents.push({ "keys": [18,82], "event": function(ev){
            this.mousePressed.lmb.tool = this.toolSquare;
            $('#squareTool').click();
            ev.preventDefault();
        }.bind(this)});

        // alt + t
        this.keyEvents.push({ "keys": [18,84], "event": function(ev){
            this.mousePressed.lmb.tool = this.toolEraser;
            $('#eraserTool').click();
            ev.preventDefault();
        }.bind(this)});

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
        
        /**
         * Mobile
         */
        app.viewport[0].addEventListener("touchstart", function(ev){
            this.pressMobile(ev);
        }.bind(this));

        app.viewport[0].addEventListener("touchend", function(ev){
            this.unpressMobile(ev);
        }.bind(this));
        app.viewport[0].addEventListener("touchmove", function(ev){
            this.dragMobile(ev);
        }.bind(this));

        app.viewport[0].addEventListener('gesturechange', function(ev) {
            if (ev.scale < 1.0) {
                this.toolZoom.actionScroll(3);
            } else if (ev.scale > 1.0) {
                this.toolZoom.actionScroll(-3);
            }
            ev.preventDefault()
        }, false);

        app.viewport[0].addEventListener('gestureend', function(ev) {
            if (ev.scale < 1.0) {
                this.toolZoom.actionScroll(3);
            } else if (ev.scale > 1.0) {
                this.toolZoom.actionScroll(-3);
            }
            ev.preventDefault()
        }, false);

        /**
         * Specific DOM binds
         */
        $('.operator-slot').mousedown(function(event) {

            // right or middle click
            switch (event.which) {
                case 2:
                case 3:
                    var color = $(event.target).css("color");
                    this.app.ChangeColor(this.rgb2hex(color));
                    break;
            }
        }.bind(this));

        // Remove context menue
        $(document).contextmenu(function() {
            return false;
        });

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
     * Mobile press listeners
     */
    pressMobile(ev){
        this.mousePressed.lmb.active = true;

        var coordinates = {
            'x': ev.touches[0].clientX,
            'y': ev.touches[0].clientY
        };

        this.mousePressed.lmb.tool.actionDown(coordinates);
        ev.preventDefault()
    }

    dragMobile(ev){
        // Get current coordinates
        var coordinates = {
            'x': ev.touches[0].clientX,
            'y': ev.touches[0].clientY
        };

        if (this.mousePressed.lmb.active) {
            this.mousePressed.lmb.tool.actionMove(coordinates);
        }
        ev.preventDefault()
    }

    unpressMobile(ev){
        this.mousePressed.lmb.tool.actionUp(this.mousePressed.lmb.tool.origin);
        this.mousePressed.lmb.active = false;
        ev.preventDefault()
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
        
        ev.preventDefault();
    }

    canvasDown(ev) {
        // Get current coordinates
        var coordinates = {x:ev.offsetX, y:ev.offsetY};

        // this._clickActivateEventListen(ev)
        for (const key in this.mousePressed)
            if (this.mousePressed[key].active && this.mousePressed[key].tool) this.mousePressed[key].tool.actionDown(coordinates);
        
        // ev.preventDefault();
    }
    
    canvasMove(ev) {
        // Get current coordinates
        var coordinates = {x:ev.offsetX, y:ev.offsetY};

        // this._clickActivateEventListen(ev)
        for (const key in this.mousePressed) {
            if (this.mousePressed[key].active && this.mousePressed[key].tool) this.mousePressed[key].tool.actionMove(coordinates);
        }
        
        ev.preventDefault();
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

    /**
     * Helper functions
     */

    // Convert RBG to hex  
    rgb2hex(rgb) {
        rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
        return "#" + this.hex(rgb[1]) + this.hex(rgb[2]) + this.hex(rgb[3]);
    }

    hex(x) {
        var hexDigits = new Array
           ("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f"); 
        return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
    }
}
export {
    Keybinds as
        default
}