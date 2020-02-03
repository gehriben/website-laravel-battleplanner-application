/**************************
	Extention class type
**************************/
const Tool = require('./Tool.js').default;

class ToolErase extends Tool {

    /**************************
            Constructor
    **************************/

    constructor(app) {
        // Super Class constructor call
        super(app);
        this.acceptedDeviance = 10;
    }
    
    actionDown(coordinates){
        this.attemptDeletes(coordinates);
    }
    
    lineIntersect(point,draw){
        // distance between draw
        var drawDistance = this.pointDistance(draw.originX,draw.destinationX,draw.originY,draw.destinationY)

        var pointDistA = this.pointDistance(point.x,draw.originX,point.y,draw.originY);
        var pointDistB = this.pointDistance(point.x,draw.destinationX,point.y,draw.destinationY);

        var difference = (pointDistA + pointDistB) - drawDistance;
        return  difference <= this.acceptedDeviance;
    }

    rectangleInstersect(point,draw){
        return ( draw.originX <= point.x && point.x <= draw.destinationX && draw.originY <= point.y && point.y <= draw.destinationY );
    }
    
    delete(draw){
        var index = this.app.battleplan.battlefloor.draws.indexOf(draw);
        this.app.battleplan.battlefloor.draws.splice(index, 1);
        this.app.ui.overlayUpdate = true;
        return index;
    }
    
    pointDistance(x1,x2,y1,y2){
        var a = x1 - x2;
        var b = y1 - y2;
        return Math.sqrt( a*a + b*b );
    }


    actionMove(coordinates){
        this.attemptDeletes(coordinates);
    }

    attemptDeletes(coordinates){
        var draws = this.app.battleplan.battlefloor.draws;
        var drawsToDelete = [];
        for (let index = 0; index < draws.length; index++) {
            const draw = draws[index];
            
            switch (draw.drawable.constructor.name) {
                case "Line":
                    if (this.lineIntersect(coordinates,draw)) {
                        drawsToDelete.push(draw);
                        // this.app.battleplan.battlefloor.addDelete(draw);
                    }
                    break;
                case "Icon":
                    if (this.rectangleInstersect(coordinates,draw)) {
                        drawsToDelete.push(draw);
                        // this.app.battleplan.battlefloor.addDelete(draw);
                    }
                    break;
                case "Square":
                    if (this.rectangleInstersect(coordinates,draw)) { 
                        drawsToDelete.push(draw);
                        // this.app.battleplan.battlefloor.addDelete(draw);
                    }
                    break;
            
                default:
                    break;
            }
        }
        for (let index = 0; index < drawsToDelete.length; index++) {
            const element = drawsToDelete[index];
            this.app.battleplan.battlefloor.addDelete(element);
        }
        this.app.ui.overlayUpdate = true;
        this.app.logDelete();
    }
    
}
export {
    ToolErase as
    default
}
