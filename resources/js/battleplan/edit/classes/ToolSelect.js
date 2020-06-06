/**************************
	Extention class type
**************************/
const Tool = require('./Tool.js').default;

class ToolSelect extends Tool {

    /**************************
            Constructor
    **************************/

    constructor(app) {
        // Super Class constructor call
        super(app);
        this.SelectBox = require('./SelectBox.js').default;
        this.activeSelect;
        this.origin = { "x": 0, "y": 0 };
        this.size = 10;
    }
    
    actionDown(coordinates){
        this.origin = coordinates;

        if(this.activeSelect){
            this.app.battleplan.floor.RemoveDraw(this.activeSelect);
        }

        // clicked on draw
        if(this.drawsInCoordinates(coordinates).length > 0){

            // Already had draws selected
            if(this.app.battleplan.floor.SelectedDraws().length > 0){

                // not on a selected draw
                if(!this.drawsContainASelected(this.drawsInCoordinates(coordinates))){
                    
                    // unselect all draws
                    this.toggleSelectDraws(this.app.battleplan.floor.SelectedDraws(), false)

                    // select draw
                    this.toggleSelectDraws(this.drawsInCoordinates(coordinates), true)
                }

            }

            // No draws selected already
            else{
                // unselect all draws
                this.toggleSelectDraws(this.app.battleplan.floor.SelectedDraws(), false)

                // select draw
                this.toggleSelectDraws(this.drawsInCoordinates(coordinates), true)
                // move all 
            }
        }

        // not clicked on draw
        else{
            // make a select box
            this.activeSelect = new this.SelectBox(
                this.AddOffsetCoordinates(coordinates),
                this.AddOffsetCoordinates(coordinates),
                "ffffff",
                1
            );
            
            this.app.battleplan.floor.AddDraw(this.activeSelect);
        }
        this.app.canvas.Update();
    }

    actionUp(coordinates){
        if(this.activeSelect){
            this.app.battleplan.floor.RemoveDraw(this.activeSelect);
            this.activeSelect.Select(this.app.canvas,this.app.battleplan.floor.draws);
            this.activeSelect = null;
        } else{
            this.broadcast();
        }
        this.app.canvas.Update();
    }

    actionMove(coordinates){

        var mx = (this.origin.x - coordinates.x) / this.app.canvas.scale;
        var my = (this.origin.y - coordinates.y) / this.app.canvas.scale;

        
        // not clicked on draw
        if(this.activeSelect){
            this.activeSelect.destination = this.AddOffsetCoordinates(coordinates);
            this.app.canvas.Update();
        }

        else{
            this.app.battleplan.floor.SelectedDraws().forEach(draw => {
                draw.Move(-mx,-my);
            });
        }


        this.origin = coordinates;
        this.app.canvas.Update();
            
    }
    
    AddOffsetCoordinates(coor){
        return {
            "x" : (coor.x) / this.app.canvas.scale - this.app.canvas.offset.x,
            "y" : (coor.y) / this.app.canvas.scale - this.app.canvas.offset.y
        }
    }

    /**
     * Private Helpers
     */
    // Get a small size box around an origin
    // Used to determine if the origin is on a draw object
    getBox(coordinates){

        var x = {
            "origin": {
                "x" : (coordinates.x) / this.app.canvas.scale - this.app.canvas.offset.x - (this.size/2),
                "y" : (coordinates.y) / this.app.canvas.scale - this.app.canvas.offset.y - (this.size/2)
            },
            "destination": {
                "x" : (coordinates.x) / this.app.canvas.scale - this.app.canvas.offset.x + (this.size/2),
                "y" : (coordinates.y) / this.app.canvas.scale - this.app.canvas.offset.y + (this.size/2)
            }
        }

        return x;
    }

    drawsInCoordinates(coordinates){
        var inOrigin = [];
        var draws = this.app.battleplan.floor.draws;
        for (let i = 0; i < draws.length; i++) {
            const draw = draws[i];
            if(draw.inBox(app.canvas, this.getBox(coordinates))){
                inOrigin.push(draw);
            }
        }
        return inOrigin;
    }

    drawsContainASelected(draws){
        for (let i = 0; i < draws.length; i++) {
            const draw = draws[i];
            if(draw.highlighted){
                return true
            }
        }
        return false;
    }

    toggleSelectDraws(draws, toggle = false){
        draws.forEach(draw => {
            draw.highlighted = toggle;
        });
    }
    
    broadcast() {
        this.app.battleplan.floor.SelectedDraws().forEach(draw => {
            $.ajax({
                method: "POST",
                url: `/lobby/${LOBBY["connection_string"]}/request-draw-update`,
                data: {
                    'drawData' : draw.ToJson()
                },
                success: function (result) {
                    console.log(result);
                }.bind(this),
                
                error: function (result) {
                    console.log(result);
                }
            });
        });
        
    }

}
export {
    ToolSelect as
    default
}
