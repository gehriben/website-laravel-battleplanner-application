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
        this.scaleMax = 10;                              // maximum scale
        this.scaleMin = 0.1                             // minimum scale
        
        this.resolution = {
            'x': 0,
            'y': 0    
        };

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
    }

    // First time setup
    Initialize(){
        this.scale = 1;
        this.SetResolution(this.resolution)
        // Update frame
        this.Update();
    }

    SetResolution(resolution){
        this.resolution = resolution;

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

    zoom(clicks){

        var sign = Math.sign(clicks);
        var step = this.scaleStep * this.scale * clicks;

        this.setScale(this.scale + step);
    }

    setScale(value){
        // reset scale matrix
        this.ctx.setTransform(1, 0, 0, 1, 0, 0);

        // properties for calculations
        var originCenter = {
            'x' : (this.resolution.x  / this.scale) /2,
            'y' : (this.resolution.y / this.scale) /2
        }

        this.scale = value;
        
        this.scale = (this.scale > this.scaleMax) ? this.scaleMax : this.scale;
        this.scale = (this.scale < this.scaleMin) ? this.scaleMin : this.scale;

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
}
export {
    Canvas as
        default
}