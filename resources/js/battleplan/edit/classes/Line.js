/**************************
	Extention class type
**************************/
const Draw = require('./Draw.js').default;

class Line extends Draw {

    /**************************
            Constructor
    **************************/

    constructor(id, color, size) {
        super(id);
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
        canvas.ctx.fillStyle = this.color;
        canvas.ctx.lineCap = 'round';
        
        canvas.ctx.beginPath();
        
        canvas.ctx.moveTo(
            this.points[0].x + canvas.offset.x,
            this.points[0].y + canvas.offset.y
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
        for (let i = 0; i < this.points.length; i++) {
            const point = this.points[i];
            
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
   ToJson(){
        return {
            'localId' : this.localId,
            'type': 'Line',
            'id' : this.id,
            'color' : this.color,
            'size' : this.size,
            'updated' : this.updated,

            // we need to optimize the compressions of objects or else we go over the alloted php POST size limit.
            // Serialization is a 2n array where all 1n are x and 2n are y coordinates
            'points' : this.CompressPoints(this.points)

            // This is too unoptimized
            // 'points' : this.points
        }
    }

    CompressPoints(points){
        var compressed = "";
        points.forEach(point => {
            compressed += `${point.x},${point.y},`;
        });
        
        // remove trailling ','
        compressed = compressed.substring(0, compressed.length - 1);
        return compressed;
    }
}
export {
    Line as
    default
}