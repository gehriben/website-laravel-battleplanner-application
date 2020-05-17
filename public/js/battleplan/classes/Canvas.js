/**************************
	Extention class type
**************************/
class Canvas{

    /**************************
            Constructor
    **************************/
    constructor(app, viewport) {
        this.resolution                                 // html5 canvas display resolution
        this.viewport = viewport;                       // html5 canvas DOM
        this.app = app;                                 // App reference

        this.scale = 1;                                 // canvas zoom scale
        this.scaleStep = 0.05;                          // canvas zoom scale increments
        this.scaleMax = 5;                              // maximum scale
        this.scaleMin = 0.5                             // minimum scale

        this.ctx = this.viewport[0].getContext('2d');   // canvas context

        // canvas drawing offset
        this.offset = {
            x:0,
            y:0
        }

        // last known coordinates
        this.coordinates = {
            x:0,
            y:0
        }

        this.Start();                                   // Initialization
    }

    // First time setup
    Start(){
        // Gather initial resolution details
        this.resolution = {
            "x" : window.innerWidth,
            "y" : window.innerHeight,
        }

        // hardcode height and with in the event user resized the page
        $(this.viewport).attr( "width", this.resolution.x);
        $(this.viewport).attr( "height", this.resolution.y);

        // Update frame
        this.Update();
    }

    // Frame update
    Update(){
        this.cls();
        this.UpdateFloor(this.app.battleplan.floor);           // Draw map
        this.UpdateDraws(this.app.battleplan.floor.draws)      // Draw drawings
        
        // debug Line
        // var center = {
        //     'x' : (this.resolution.x  / this.scale) /2,
        //     'y' : (this.resolution.y / this.scale) /2
        // }
        // this.debugLine({"x":center.x,"y":0}, {"x":center.x,"y":center.y});
        // this.debugLine({"x":0,"y":center.y}, {"x":center.x,"y":center.y});

    }

    UpdateFloor(floor){
        var img = new Image;

        // acquire image
        img.src = floor.background;

        // Fill background color
        this.ctx.fillStyle = 'black';
        this.ctx.fillRect(0, 0, this.resolution.x / this.scale, this.resolution.y  / this.scale);

        // unsure what this does
        this.ctx.imageSmoothingEnabled = true;

        // translate offset
        this.ctx.translate(this.offset.x,this.offset.y);
        
        this.ctx.drawImage(
            floor.load,
            0,0,
            floor.load.width,
            floor.load.height

        );
        
        // Translate Back
        this.ctx.translate(-this.offset.x,-this.offset.y);
    }

    UpdateDraws(draws){
        draws.forEach(draw => {
            draw.draw(this);
        });
    }

    /**
     * Public Methods
     */
    move(dX,dY){
        this.offset.x += dX;
        this.offset.y += dY;

        this.Update();
    }

    zoom(clicks, coordinates){
        // properties for calculations
        var originCenter = {
            'x' : (this.resolution.x  / this.scale) /2,
            'y' : (this.resolution.y / this.scale) /2
        }

        var sign = Math.sign(clicks);
        var step = this.scaleStep * clicks;

        // reset scale matrix
        this.ctx.setTransform(1, 0, 0, 1, 0, 0);

        this.scale += step;
        if(sign >=1 ){
            this.scale = (this.scale + step > this.scaleMax) ? this.scaleMax : this.scale + step;
        } else{
            this.scale = (this.scale + step < this.scaleMin) ? this.scaleMin: this.scale + step;
        }

        this.ctx.scale(
            this.scale,
            this.scale
        );

        var newCenter = {
            'x' : (this.resolution.x  / this.scale) /2,
            'y' : (this.resolution.y / this.scale) /2
        }
        
        this.move( 
            newCenter.x - originCenter.x,
            newCenter.y - originCenter.y,
        );

        this.Update();
    }

    cls(){
        this.ctx.clearRect(0, 0, this.resolution.x / this.scale, this.resolution.y  / this.scale);
    }

    debugLine(c1,c2){
        this.ctx.lineWidth = 5;
        this.ctx.fillStyle = 'orange';
        this.ctx.beginPath();
        this.ctx.moveTo(c1.x, c1.y);
        this.ctx.lineTo(c2.x, c2.y);
        this.ctx.stroke();
    }

    /**
     * EventListeners
     */
    // EventListeners(){
        // viewport.addEventListener("mouseup", this.canvasUp);
        // viewport.addEventListener("mousedown", this.canvasDown);
        // viewport.addEventListener("mousewheel", this.canvasScroll);
        // viewport.addEventListener("mousemove", this.canvasMove);
        // viewport.addEventListener("mouseout", this.canvasLeave);

        // Needs work
        // viewport.addEventListener("dragenter", canvasEnter);
        // viewport.addEventListener("dragover", canvasDrag);
        // viewport.addEventListener("dragleave", canvasEnter);
        // viewport.addEventListener("drop", canvasDrop);

    // }

    /**************************
        Canvas Methods
    **************************/
//    canvasUp(ev) {
//         // var coordinates = this._calculateOffset(ev.offsetX, ev.offsetY);
//         for (const key in this.buttonEvents) {
//             if (this.buttonEvents[key].active && this.buttonEvents[key].tool) this.buttonEvents[key].tool.actionUp(coordinates);
//         }
//         // this._clickDeactivateEventListen(ev);
//         // this.ui.update();
//     }

//     canvasDown(ev) {
        
//         // Get current coordinates
//         var coordinates = {x:ev.offsetX, y:ev.offsetY};

//         // this._clickActivateEventListen(ev)
//         for (const key in this.buttonEvents) {
//             if (this.buttonEvents[key].active && this.buttonEvents[key].tool) this.buttonEvents[key].tool.actionDown(coordinates);
//         }
//         // this.ui.update();
//     }

//     canvasMove(ev) {
//         // var coordinates = this._calculateOffset(ev.offsetX, ev.offsetY);
//         for (const key in this.buttonEvents) {
//             if (this.buttonEvents[key].active && this.buttonEvents[key].tool) this.buttonEvents[key].tool.actionMove(coordinates);
//         }
//         // this.ui.update();
//     }

//     canvasEnter(ev) {
//         // var coordinates = this._calculateOffset(ev.offsetX, ev.offsetY);
//         for (const key in this.buttonEvents) {
//             if (this.buttonEvents[key].active && this.buttonEvents[key].tool) this.buttonEvents[key].tool.actionEnter(coordinates);
//         }
//         // this._clickDeactivateEventListen(ev);
//         // Update UI
//         // this.ui.update();
//     }

//     canvasLeave(ev) {
//         // this._clickDeactivateEventListen(ev);
//         // var coordinates = this._calculateOffset(ev.offsetX, ev.offsetY);
//         for (const key in this.buttonEvents) {
//             if (this.buttonEvents[key].active && this.buttonEvents[key].tool && this.buttonEvents[key].tool) this.buttonEvents[key].tool.actionLeave(coordinates);
//         }
//         // Update UI
//         // this.ui.update();
//     }

//     canvasScroll(ev) {
//         // var coordinates = this._calculateOffset(ev.offsetX, ev.offsetY);

//         var direction = 1;
//         // if (ev.originalEvent.wheelDelta / 120 < 0) {
//         if (ev.originalEvent.deltaY) {
//             direction = -direction * Math.sign(ev.originalEvent.deltaY);
//         }

//         this.toolZoom.actionScroll(direction, coordinates);

//         for (const key in this.buttonEvents) {
//             if (this.buttonEvents[key].active && this.buttonEvents[key].tool) this.buttonEvents[key].tool.actionScroll();
//         }

//         // Update UI
//         // this.ui.update();
//     }

//     canvasDrop(ev) {
//         // var coordinates = this._calculateOffset(ev.offsetX, ev.offsetY);

//         ev.preventDefault();
//         var src = ev.dataTransfer.getData("src");

//         this.toolIcon.actionDrop(coordinates, src);

//         for (const key in this.buttonEvents) {
//             if (this.buttonEvents[key].active && this.buttonEvents[key].tool) this.buttonEvents[key].tool.actionDrop();
//         }

//         // Update UI
//         // this.ui.update();
//     }

//     canvasDrag(ev) {
//         var coordinates = this._calculateOffset(ev.offsetX, ev.offsetY);

//         // Update UI
//         // this.ui.update();
//     }

//     allowDrop(ev) {
//         ev.preventDefault();
//     }

//     drag(ev) {
//         ev.dataTransfer.setData("src", ev.target.src);
//     }

}
export {
    Canvas as
        default
}