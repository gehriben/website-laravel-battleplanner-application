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
        this.SelectBox = require('./SelectBox.js').default;
        this.color = color;
        this.size = size;
        this.points = [];
    }

    init(){

    }

    draw(canvas){
        
        var defaultColor = canvas.ctx.strokeStyle;
        if(this.highlighted){
            canvas.ctx.strokeStyle = "blue";
        }

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

        canvas.ctx.strokeStyle = defaultColor;
    }

    /**
     * Parent overrides
     */
    inBox(canvas,box){
        // merge origin into point list
        var points = [this.origin].concat(this.points);

        for (let i = 0; i < points.length; i++) {
            const point = points[i];
            
            var coors = {
                "x": point.x + canvas.offset.x,
                "y": point.y + canvas.offset.y
            }

            if(
                this.SelectBox.PointInBox(canvas,coors,box)
            ){
                return true;
            }
        }

        return false;
    }

    Move(dX,dY){
        super.Move(dX,dY);
        // Itterate each point
        for (let i = 0; i < this.points.length; i++) {
            this.points[i].x += dX;
            this.points[i].y += dY;
        }
    }
    
    /**************************
        Helper functions
    **************************/

}
export {
    Line as
    default
}