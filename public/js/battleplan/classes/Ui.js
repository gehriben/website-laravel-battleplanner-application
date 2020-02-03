import {
    throws
} from "assert";

class Ui {

    /**************************
            Constructor
    **************************/

    constructor(app) {

        // Save the app for access later
        this.app = app;

        // reload variables
        this.backgroundImage = null;

        // Zoom variables
        this.ratio = 1;
        this.offsetX = 0;
        this.offsetY = 0;

        // info vars
        this.imgHeight = 0;
        this.imgWidth = 0;
        // updateFlags
        this.floorChange = true;
        this.overlayUpdate = false;
        this.backgroundUpdate = false;
        this.slotUpdate = false;

        this.init();
    }

    /**************************
        Initialisation methods
    **************************/
    init() {
        this.initViewports();
        this.initBackground();
        this.updateSlots();
        this.update();
    }

    showViewports() {
        for (var property in this.app.viewports) {
            $("#" + this.app.viewports[property]).show();
        }
    }

    // Set the size of the viewports
    initViewports() {

        // show the viewport now that we have a battleplan
        this.showViewports()

        // Acquire DOMS
        var background = document.getElementById(this.app.viewports.CANVAS_BACKGROUND_ID);
        var overlay = document.getElementById(this.app.viewports.CANVAS_OVERLAY_ID);
        var viewport = document.getElementById(this.app.viewports.VIEWPORT_ID);

        // Set Heights
        background.height = $(viewport).height();
        background.width = $(viewport).width();
        overlay.height = $(viewport).height();
        overlay.width = $(viewport).width();

        // show Battleplan name
        $("#battleplan_name").val(this.app.battleplan.name);
        $("#battleplan_name_display").val(this.app.battleplan.name);

        if(this.app.battleplan.public == 1 && !$("#battleplan_public").is(':checked')){
            $("#battleplan_public").click();
        } else if(this.app.battleplan.public == 0 && $("#battleplan_public").is(':checked')){
            $("#battleplan_public").click();
        }

        $("#battleplan_notes").val(this.app.battleplan.notes);
        $("#lineSizePicker").val(this.app.lineSize);
        $("#iconSizePicker").val(this.app.iconSize);
    }

    initBackground() {
        // Fresh slate
        this.clearAllScreen();

        // Variable declarations
        var background = document.getElementById(this.app.viewports.CANVAS_BACKGROUND_ID);
        var ctx = background.getContext('2d');
        var img = new Image;

        // acquire image
        img.src = this.app.battleplan.battlefloor.floor.src;

        // Fill background color
        ctx.fillStyle = 'black';
        ctx.fillRect(0, 0, background.width, background.height);

        // Load the image in memory
        img.onload = function () {
            // Draw the image
            ctx.drawImage(img, -this.offsetX, -this.offsetY, img.width * this.ratio, img.height * this.ratio);
            this.backgroundImage = img;
            this.overlayUpdate = true;
            this.floorChange = false;
            this.update();
        }.bind(this);
    }

    /**************************
        Clear methods
    **************************/
    clearAllScreen() {
        this.clearBackground()
        this.clearOverlay()
    }

    clearBackground() {
        var myCanvas = document.getElementById(this.app.viewports.CANVAS_BACKGROUND_ID);
        var ctx = myCanvas.getContext('2d');
        ctx.clearRect(0, 0, myCanvas.width, myCanvas.height);
    }

    clearOverlay() {
        var myCanvas = document.getElementById(this.app.viewports.CANVAS_OVERLAY_ID);
        var ctx = myCanvas.getContext('2d');
        ctx.clearRect(0, 0, myCanvas.width, myCanvas.height);
    }

    /**************************
        Update methods
    **************************/

    // Master update call to all other updaters
    update() {

        // floor needs to be initialized
        if (this.floorChange) {
            this.initBackground();
        }

        // floor needs to be initialized
        if (this.backgroundUpdate) {
            this.updateBackground();
        }

        // floor needs to be updated
        if (this.overlayUpdate) {
            this.updateOverlay();
        }

        if (this.slotUpdate) {
            this.updateSlots();
        }
    }

    updateOverlay() {

        // variable declaration
        var myCanvas = document.getElementById(this.app.viewports.CANVAS_OVERLAY_ID);
        var ctx = myCanvas.getContext('2d');

        // Clear all
        this.clearOverlay()

        // draw saved
        for (var i = 0; i < this.app.battleplan.battlefloor.draws.length; i++) {
            var myDraw = this.app.battleplan.battlefloor.draws[i];
            myDraw.draw(ctx, this);
        }

        // Redraw unpushed ones
        for (var i = 0; i < this.app.battleplan.battlefloor.draws_unpushed.length; i++) {
            var myDraw = this.app.battleplan.battlefloor.draws_unpushed[i];
            myDraw.draw(ctx, this);
        }

        // Redraw transit ones
        for (var i = 0; i < this.app.battleplan.draws_transit.length; i++) {
            var myDraw = this.app.battleplan.draws_transit[i];
            // Transit objects are not associated to a floor, so we must manually check if we are on the correct one
            if (this.app.battleplan.battlefloor.id == myDraw.battlefloor_id) {
                myDraw.draw(ctx, this);
            }
        }

        // Redraw limbo ones
        // for (var i = 0; i < this.app.battleplan.draws_limbo.length; i++) {
        //     var myDraw = this.app.battleplan.draws_limbo[i];
        //     // Transit objects are not associated to a floor, so we must manually check if we are on the correct one
        //     if (this.app.battleplan.battlefloor.id == myDraw.battlefloor_id) {
        //         myDraw.draw(ctx, this);
        //     }
        // }

        // Draw temporaried of tools
        for (const key in this.app.buttonEvents) {
            if (this.app.buttonEvents[key].tool) this.app.buttonEvents[key].tool.draw(ctx, this);
        }

        // Update flag to finished
        this.overlayUpdate = false;
    }

    updateSlots() {
        var newDom = "";
        for (var i = 0; i < this.app.battleplan.slots.length; i++) {
            newDom += "<div class=\"row\">";
            newDom += this.app.battleplan.slots[i].generateDom(this.app.user_id == this.app.battleplan.owner);
            newDom += "</div>";
        }
        $("#operatorSlotList").html(newDom);
    }

    updateBackground() {
        this.clearBackground();
        var canvas = document.getElementById(this.app.viewports.CANVAS_BACKGROUND_ID);
        var ctx = canvas.getContext('2d');

        // Fill background color
        ctx.fillStyle = 'black';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        this.imgWidth = this.backgroundImage.width * this.ratio;
        this.imgHeight = this.backgroundImage.height * this.ratio;

        ctx.drawImage(this.backgroundImage, -this.offsetX, -this.offsetY, this.imgWidth, this.imgHeight);
        this.overlayUpdate = true;
    }

    /**************************
        Action Methods
    **************************/

    zoomCanvases(step, x, y) {
        // update ratio and dimentions
        this.ratio = this.ratio + step;
    }

    move(distanceX, distanceY) {
        this.offsetX += distanceX * this.ratio;
        this.offsetY += distanceY * this.ratio;
    }
}
export {
    Ui as
        default
}
