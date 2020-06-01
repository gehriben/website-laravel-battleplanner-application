/**************************
	Extention class type
**************************/
const Draw = require('./Draw.js').default;

class Line extends Draw {

    /**************************
            Constructor
    **************************/

    constructor(id, color, opacity, size) {
        super(id);
        this.SelectBox = require('./SelectBox.js').default;
        this.color = color;
        this.opacity = opacity;
        this.size = size;
        this.points = [];
    }

    init(){

    }

    draw(canvas){
        
        var defaultColor = canvas.ctx.strokeStyle;

        if(this.highlighted){
            canvas.ctx.strokeStyle = "blue";
        } else{
            canvas.ctx.strokeStyle = this.hexToRgbA(this.color, this.opacity);
        }

        // Settings
        canvas.ctx.lineWidth = this.size;
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
            'opacity' : this.opacity,
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

    hexToRgbA(hex, opacity){
        var c;
        if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
            c= hex.substring(1).split('');
            if(c.length== 3){
                c= [c[0], c[0], c[1], c[1], c[2], c[2]];
            }
            c= '0x'+c.join('');
            return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+','+opacity+')';
        }
        throw new Error('Bad Hex');
    }
}
export {
    Line as
    default
}