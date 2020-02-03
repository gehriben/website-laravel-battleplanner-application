/**
 * Main appication class, includes all ui functionality and application flow of the various parts
 *
 * @version 0.1
 * @author Erik Smith
 */
class App {

    /**************************
            Constructor
    **************************/

    constructor(conn_string, viewports, user_id) {
        // Instantiatable class types
        this.Battleplan = require('./Battleplan.js').default;
        this.Battlefloor = require('./Battlefloor.js').default;
        this.ToolLine = require('./ToolLine.js').default; // useable tool
        this.ToolSquare = require('./ToolSquare.js').default; // useable tool
        this.ToolMove = require('./ToolMove.js').default; // useable tool
        this.ToolZoom = require('./ToolZoom.js').default; // useable tool
        this.ToolIcon = require('./ToolIcon.js').default; // useable tool
        this.ToolErase = require('./ToolErase.js').default; // useable tool
        this.Ui = require('./Ui.js').default;

        // Settings
        this.acquisitionTime = 200; // ms oc collection before sending new draws to the server (forced ping to avoid DOS)

        // Varable declarations
        this.acquisitionLockCreate = false;
        this.acquisitionLockDelete = false;
        this.color = "#e66465"; //draw color
        this.lineSize = 3;
        this.iconSize = 25;
        this.conn_string = conn_string
        this.viewports = viewports
        this.user_id = user_id;

        this.toolLine; // useable tool
        this.toolSquare; // useable tool
        this.toolMove; // useable tool
        this.toolZoom; // useable tool
        this.toolImage; // useable tool

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

        this.init();

    }

    /**************************
            App Methods
    **************************/
    init() {
        // Set curent tool type
        this.toolLine = new this.ToolLine(this);
        this.toolSquare = new this.ToolSquare(this);
        this.toolMove = new this.ToolMove(this);
        this.toolZoom = new this.ToolZoom(this);
        this.toolIcon = new this.ToolIcon(this);
        this.toolErase = new this.ToolErase(this);

        // Set defaults
        this.buttonEvents.lmb.tool = this.toolLine
        this.buttonEvents.rmb.tool = this.toolMove

        // hide them until a map is chosen
        for (var property in this.viewports) {
            $("#" + this.viewports[property]).hide();
        }

        // load battleplan if already set
        this.getRoomsBattleplan(
            this.load.bind(this)
        );
    }

    changeColor(newColor) {
        this.color = newColor
    }

    /**************************
        Battleplan Methods
    **************************/

    createBattleplan(mapId) {
        var self = this;
        $.ajax({
            method: "POST",
            url: "/battleplan/create",
            data: {
                map: mapId,
                room: this.conn_string
            },
            success: function (battleplan) {
                self.setRoomsBattleplan(battleplan.id);
            },
            error: function (result) {
                console.log(result);
            }
        });
    }

    getRoomsBattleplan(callback) {
        $.ajax({
            method: "GET",
            url: `${this.conn_string}/getBattleplan`,
            success: function (result) {
                if (callback) {
                    callback(result);
                }
            },
            error: function (result) {
                console.log(result);
            }
        });
    }

    deleteBattlePlan(battleplanId) {
        var r = confirm("Are you sure you want to delete? There is no going back!");
        if (r == true) {
            $.ajax({
                method: "POST",
                url: "/battleplan/delete",
                data: {
                    "battleplanId": battleplanId
                },
                success: function () {
                    alert("Successfully deleted! Refresh page to refresh the list");
                },
                error: function (result) {
                    console.log(result);
                }
            });
        }
    }

    // Loading a saved battleplan
    loadBattlePlan(battleplanId) {
        var self = this;
        this.setRoomsBattleplan(battleplanId, function () {
            // Reset
            self.getRoomsBattleplan(function (result) {
                if (result != null) {
                    self.load(result.battleplan, result.battlefloors);
                }
            })
        });
    }

    // Tell the server to save its current state
    save() {
        $.ajax({
            method: "POST",
            url: "/battleplan/save",
            data: {
                conn_string: this.conn_string,
                name: $("#battleplan_name").val(),
                notes: $("#battleplan_notes").val(),
                public: this.battleplan.public
            },
            success: function () {
                alert("Saved!");
                location.reload();
            },
            error: function (result) {
                console.log(result);
            }
        });
    }

    // Load a battle plan into the app
    load(battleplan) {
        if (battleplan) {

            // Init battleplan
            this.battleplan = Object.assign(new this.Battleplan, battleplan);
            this.battleplan.init();

            // Init UI class
            this.ui = new this.Ui(this);
        }
    }

    // Set the rooms to a battleplan
    setRoomsBattleplan(battleplanId, callback = null) {
        $.ajax({
            method: "POST",
            url: "/room/setBattleplan",
            data: {
                battleplanId: battleplanId,
                conn_string: this.conn_string
            },
            success: function (result) {
                if (callback) {
                    callback(result)
                }
            },
            error: function (result) {
                console.log(result);
            }
        });
    }

    // Push changes to the server to propagate to others on the socket + add them to the DB
    pushServerCreate() {

        // Var declarations
        this.acquisitionLockCreate = false;
        this.battleplan.draws_transit = [];
        this.battleplan.draws_transit = this.battleplan.acquireUnsavedDraws();
        // this.battleplan.draws_limbo = this.battleplan.draws_limbo.concat(this.battleplan.draws_transit);

        // Don't waste API call if empty
        if (this.battleplan.draws_transit.length > 0) {
            // Push to server API
            $.ajax({
                method: "POST",
                url: "/battlefloor/draw",
                data: {
                    conn_string: this.conn_string,
                    userId: this.user_id,
                    "draws": JSON.parse(JSON.stringify(this.battleplan.draws_transit))
                },
                success: function (result) {
                    this.battleplan.draws_transit = [];

                    // for (let index = 0; index < result.length; index++) {
                    //     const element = result[index];
                    //     // remove limbos
                    //     this.battleplan.draws_limbo = this.battleplan.draws_limbo.filter(function(draw){
                    //         var found = draw.originX == element.originX && draw.originY == element.originY;
                    //         if(found){
                    //             var battlefloor = this.battleplan.getBattlefloor(element.battlefloor_id);
                    //             battlefloor.serverDraw(element);
                    //         }
                    //     }.bind(this))
                    // }
                    
                    this.ui.overlayUpdate = true;
                    this.ui.update();
                }.bind(this),
                error: function (result) {
                    this.acquisitionLockCreate = false;
                    console.log(result);
                }
            });
        } else{
            this.acquisitionLockCreate = false;
        }

    }

    pushServerDelete() {

        // Var declarations
        this.acquisitionLockDelete = false;
        this.battleplan.deletes_transit = [];
        this.battleplan.deletes_transit = this.battleplan.acquireUnsavedDeletes();

        // Don't waste API call is empty
        if (this.battleplan.deletes_transit.length > 0) {
            // Push to server API
            $.ajax({
                method: "POST",
                url: "/battlefloor/deleteDraw",
                data: {
                    conn_string: this.conn_string,
                    userId: this.user_id,
                    "draws": JSON.parse(JSON.stringify(this.battleplan.deletes_transit))
                },
                success: function () {
                    this.battleplan.deletes_transit = [];
                    this.ui.overlayUpdate = true;
                    this.ui.update();
                }.bind(this),
                error: function (result) {
                    this.acquisitionLockDelete = false;
                    console.log(result);
                }
            });
        } else{
            this.acquisitionLockDelete = false;
        }
    }

    // Tell the server to start the push timer
    logPush() {
        // Push new lines to server
        if (!this.acquisitionLockCreate) {
            this.acquisitionLockCreate = true;
            setTimeout(this.pushServerCreate.bind(this), this.acquisitionTime);
        }
    }

    logDelete() {
        // Push new lines to server
        if (!this.acquisitionLockDelete) {
            this.acquisitionLockDelete = true;
            setTimeout(this.pushServerDelete.bind(this), this.acquisitionTime);
        }
    }

    // Draw the object that the server has propagated to you
    serverDraw(result) {
        // if(result.creator != this.user_id){
            // Draw new draws from server if you did not create them
            for (var i = 0; i < result.draws.length; i++) {
                var battlefloor = this.battleplan.getFloor(result.draws[i].battlefloor_id);
                battlefloor.serverDraw(result.draws[i]);
            }
        // }
        
        // check your deleted transit draws and delete them from server
        for (var i = 0; i < this.battleplan.battlefloors.length; i++) {
            var battlefloor = this.battleplan.battlefloors[i];

            for (let index = 0; index < battlefloor.draws_deleted.length; index++) {
                const draw = battlefloor.draws_deleted[index];
                var potentialIndex = battlefloor.draws.indexOf(draw);
                if(potentialIndex >= 0){
                    battlefloor.addDelete(draw)
                }
            }
            
        }

        this.ui.overlayUpdate = true;
        this.ui.update();
    }

    serverDelete(result){
        for (var i = 0; i < result.draws.length; i++) {
            var battlefloor = this.battleplan.getFloor(result.draws[i].battlefloor_id);
            battlefloor.serverDelete(result.draws[i]);
        }
        this.ui.overlayUpdate = true;
        this.ui.update();
    }

    // Tell the server to change the operator in a given slot
    changeOperatorSlot(slotId, operatorId) {

        $.ajax({
            method: "POST",
            url: "/operatorSlot/update",
            data: {
                conn_string: this.conn_string,
                userId: this.user_id,
                operatorSlotId: slotId,
                operatorId: operatorId
            },
            success: function (result) {
                this.changeOperatorSlotDom(result.operatorSlot.id, result.operator)
            }.bind(this),
            error: function (result) {
                console.log(result);
            }
        });
    }

    // Update the DOM to reflect an operator change
    changeOperatorSlotDom(operatorSlotId, operator) {
        var slot = this.battleplan.getSlot(operatorSlotId);
        slot.setOperator(operator);
        this.ui.slotUpdate = true;
        this.ui.update();
    }

    changeLineSize(newSize) {
        this.lineSize = newSize;
    }

    changeIconSize(newSize) {
        this.iconSize = newSize;
    }

    togglePublic(toggleTo){
        if(toggleTo){
            this.battleplan.public = 1;
        } else{
            this.battleplan.public = 0;
        }
    }
    /**************************
          Floor Methods
    **************************/

    changeFloor(amount) {
        this.battleplan.changeFloor(amount);
        this.ui.floorChange = true;
        this.ui.update();
    }

    changeFloorById(floorId) {
        this.battleplan.changeFloorById(floorId);
        this.ui.floorChange = true;
        this.ui.update();
    }

    /**************************
          Floor Methods
    **************************/

    changeTool(tool, seletor) {
        $(".toolSelector").removeClass("active");
        $(seletor).addClass("active");
        this.buttonEvents.lmb.tool = tool;
    }

    /**************************
        Canvas Methods
    **************************/

    canvasUp(ev) {
        var coordinates = this._calculateOffset(ev.offsetX, ev.offsetY);
        for (const key in this.buttonEvents) {
            if (this.buttonEvents[key].active && this.buttonEvents[key].tool) this.buttonEvents[key].tool.actionUp(coordinates);
        }
        this._clickDeactivateEventListen(ev);
        this.ui.update();
    }

    canvasDown(ev) {
        var coordinates = this._calculateOffset(ev.offsetX, ev.offsetY);
        this._clickActivateEventListen(ev)
        for (const key in this.buttonEvents) {
            if (this.buttonEvents[key].active && this.buttonEvents[key].tool) this.buttonEvents[key].tool.actionDown(coordinates);
        }
        this.ui.update();
    }

    canvasMove(ev) {
        var coordinates = this._calculateOffset(ev.offsetX, ev.offsetY);
        for (const key in this.buttonEvents) {
            if (this.buttonEvents[key].active && this.buttonEvents[key].tool) this.buttonEvents[key].tool.actionMove(coordinates);
        }
        this.ui.update();
    }

    canvasEnter(ev) {
        var coordinates = this._calculateOffset(ev.offsetX, ev.offsetY);
        for (const key in this.buttonEvents) {
            if (this.buttonEvents[key].active && this.buttonEvents[key].tool) this.buttonEvents[key].tool.actionEnter(coordinates);
        }
        this._deactivateClickEventListen();
        // Update UI
        this.ui.update();
    }

    canvasLeave(ev) {
        this._deactivateClickEventListen();
        var coordinates = this._calculateOffset(ev.offsetX, ev.offsetY);
        for (const key in this.buttonEvents) {
            if (this.buttonEvents[key].active && this.buttonEvents[key].tool && this.buttonEvents[key].tool) this.buttonEvents[key].tool.actionLeave(coordinates);
        }
        // Update UI
        this.ui.update();
    }

    canvasScroll(ev) {
        var coordinates = this._calculateOffset(ev.offsetX, ev.offsetY);

        var direction = 1;
        // if (ev.originalEvent.wheelDelta / 120 < 0) {
        if (ev.originalEvent.deltaY) {
            direction = -direction * Math.sign(ev.originalEvent.deltaY);
        }

        this.toolZoom.actionScroll(direction, coordinates);

        for (const key in this.buttonEvents) {
            if (this.buttonEvents[key].active && this.buttonEvents[key].tool) this.buttonEvents[key].tool.actionScroll();
        }

        // Update UI
        this.ui.update();
    }

    canvasDrop(ev) {
        var coordinates = this._calculateOffset(ev.offsetX, ev.offsetY);

        ev.preventDefault();
        var src = ev.dataTransfer.getData("src");

        this.toolIcon.actionDrop(coordinates, src);

        for (const key in this.buttonEvents) {
            if (this.buttonEvents[key].active && this.buttonEvents[key].tool) this.buttonEvents[key].tool.actionDrop();
        }

        // Update UI
        this.ui.update();
    }

    canvasDrag(ev) {
        var coordinates = this._calculateOffset(ev.offsetX, ev.offsetY);

        // Update UI
        this.ui.update();
    }

    allowDrop(ev) {
        ev.preventDefault();
    }

    drag(ev) {
        ev.dataTransfer.setData("src", ev.target.src);
    }

    /**************************
        Event detection
    **************************/

    /**
     * @description activates button press that triggered the event
     * @method _clickActivateEventListen
     * @param  {event} event that trigger this method
     * @return {undefined}
     */
    _clickActivateEventListen(ev) {
        if (ev.button == 0) this.buttonEvents.lmb.active = true;
        if (ev.button == 1) this.buttonEvents.mmb.active = true;
        if (ev.button == 2) this.buttonEvents.rmb.active = true;
    }

    /**
     * @description unsets event provided it was pressed/released
     * @method _clickDeactivateEventListen
     * @param  {event} event that trigger this method
     * @return {undefined}
     */
    _clickDeactivateEventListen(ev) {
        if (ev.button == 0) this.buttonEvents.lmb.active = false;
        if (ev.button == 1) this.buttonEvents.mmb.active = false;
        if (ev.button == 2) this.buttonEvents.rmb.active = false;
    }

    /**
     * @description removes any event handlers for a mouse
     * @method _deactivateClickEventListen
     * @return {undefined}
     */
    _deactivateClickEventListen() {
        this.buttonEvents.lmb.active = false;
        this.buttonEvents.mmb.active = false;
        this.buttonEvents.rmb.active = false;
    }

    /**************************
        Helper Methods
    **************************/
    _calculateOffset(evx, evy) {
        var jsonResponse = {}
        jsonResponse.x = (evx / this.ui.ratio) + (this.ui.offsetX / this.ui.ratio);
        jsonResponse.y = (evy / this.ui.ratio) + (this.ui.offsetY / this.ui.ratio);
        return jsonResponse;
    }

}
export {
    App as
        default
}
