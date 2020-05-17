/**************************
	Extention class type
**************************/
const Draw = require('./Draw.js').default;

class Line extends Draw {

    /**************************
            Constructor
    **************************/

    constructor(origin, color, size) {
        super(origin);
        this.color = color;
        this.size = size;
        this.points = [];
    }

    init(){

    }

    draw(canvas){
        
        // Settings
        canvas.ctx.lineWidth = this.size;
        canvas.ctx.fillStyle = 'orange';
        canvas.ctx.lineCap = 'round';
        
        canvas.ctx.beginPath();
        
        canvas.ctx.moveTo(
            this.origin.x + canvas.offset.x,
            this.origin.y + canvas.offset.y
        );

        // Itterate each point
        for (let i = 0; i < this.points.length; i++) {
            
            canvas.ctx.lineTo(
                this.points[i].x + canvas.offset.x,
                this.points[i].y + canvas.offset.y
            );
            
        }
        canvas.ctx.stroke();
    }
    /**************************
        Helper functions
    **************************/

}
export {
    Line as
    default
}