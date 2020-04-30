/**************************
	Extention class type
**************************/
class Canvas{

    /**************************
            Constructor
    **************************/
    constructor(app, viewport) {
        this.resolution                 // html5 canvas display resolution
        this.viewport = viewport;       // html5 canvas DOM
        this.app = app;                 // App reference
        this.Start();                   // Initialization
    }

    // First time setup
    Start(){
        // Gather initial resolution details
        this.resolution = {
            "height" : window.innerHeight,
            "width" : window.innerWidth,
        }

        // hardcode height and with in the event user resized the page
        this.viewport.height(this.resolution.height);
        this.viewport.width(this.resolution.height);

        // Bind event listeners
        this.EventListeners();

        // Update frame
        this.Update();
    }

    // Frame update
    Update(){
        this.DrawFloor(this.app.floor);
    }

    DrawFloor(id){
        // Variable declarations
        var ctx = this.viewport[0].getContext('2d');
        var img = new Image;

        // acquire image
        img.src = this.app.battleplan.floors[id].background;

        // Fill background color
        ctx.fillStyle = 'black';
        ctx.fillRect(0, 0, this.resolution.width, this.resolution.height);

        // Load the image in memory
        img.onload = function () {
            // Draw the image
            ctx.drawImage(img, 0, 0, img.width, img.height);
        }.bind(this);
    }

    DrawObjects(id){
        // Variable declarations
        var ctx = this.viewport[0].getContext('2d');
        var img = new Image;

        // acquire image
        img.src = this.app.battleplan.floors[id].background;

        // Fill background color
        ctx.fillStyle = 'black';
        ctx.fillRect(0, 0, this.resolution.width, this.resolution.height);

        // Load the image in memory
        img.onload = function () {
            // Draw the image
            ctx.drawImage(img, 0, 0, img.width, img.height);
        }.bind(this);
    }

    /**
     * EventListeners
     */
    // EventListeners(){
    //     // Mouse Down
    //     this.viewport[0].addEventListener('mousedown', function(event) {
    //         lastX = event.offsetX || (event.pageX - canvas.offsetLeft);
    //         lastY = event.offsetY || (event.pageY - canvas.offsetTop);
    //         dragged = true;
    //         if (dragStart){
    //           var pt = ctx.transformedPoint(lastX,lastY);
    //           ctx.translate(pt.x-dragStart.x,pt.y-dragStart.y);
    //           redraw();
    //               }
    //     },false);
    // }

    /**************************
        Canvas Methods
    **************************/
    // @here
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
}
export {
    Canvas as
        default
}