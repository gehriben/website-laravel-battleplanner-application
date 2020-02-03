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

    constructor(viewports, battleplanId) {
        // Instantiatable class types
        this.Battleplan = require('./Battleplan.js').default;
        this.Battlefloor = require('./Battlefloor.js').default;
        this.ToolMove = require('./ToolMove.js').default; // useable tool
        this.ToolZoom = require('./ToolZoom.js').default; // useable tool
        this.Ui = require('./Ui.js').default;
        this.battleplanId = battleplanId;
        this.viewports = viewports
        this.toolMove; // useable tool
        this.toolZoom; // useable tool

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
    init(battleplanId) {
        this.toolMove = new this.ToolMove(this);
        this.toolZoom = new this.ToolZoom(this);

        // Set defaults
        this.buttonEvents.lmb.tool = this.toolMove
        this.buttonEvents.rmb.tool = this.toolMove

        // hide them until a map is chosen
        for (var property in this.viewports) {
            $("#" + this.viewports[property]).hide();
        }

        // load battleplan if already set
        this.getBattleplan(
            this.load.bind(this)
        );
    }

    changeColor(newColor) {
        this.color = newColor
    }

    getBattleplan(callback) {
        $.ajax({
            method: "GET",
            url: `/battleplan/${this.battleplanId}/getBattleplan`,
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
