/**************************
	Extention class type
**************************/
const Helpers = require('./Helpers.js').default;

class Battlefloor extends Helpers {

    /**************************
            Constructor
    **************************/

    constructor() {
        // Super Class constructor call
        super();
        this.Draw = require('./Draw.js').default;
        this.draws = []
        this.draws_unpushed = [];
        this.draws_deleted = [];
        this.draws_transit = [];
        this.transit_deleted = [];
        this.drawStack = [];
    }

	init(){
		this.initDraws()
	}

	initDraws(){
		for (var i = 0; i < this.draws.length; i++) {
			this.draws[i] = Object.assign(new this.Draw, this.draws[i]);
            this.draws[i].init();
		}
	}

    /**************************
             Public methods
    **************************/
    drawById(stack,id){
        return stack.filter(draw => this._objectIdEquals(draw,id))[0];
    }

	addDraw(draw){
		this.draws_unpushed.push(draw);
    }
    
    addDelete(draw){
        // Draw on server
        var index = this.draws.indexOf(draw);
        if(index >= 0){
            this.draws.splice(index, 1);
            this.draws_deleted.push(draw);
        } else if(this.draws_unpushed.indexOf(draw) >= 0){
            index = this.draws_unpushed.indexOf(draw);
            this.draws_unpushed.splice(index, 1);
        } else if(this.draws_transit.indexOf(draw) >= 0){
            index = this.draws_transit.indexOf(draw);
            this.draws_transit.splice(index, 1);
            this.draws_deleted.push(draw);
        }
	}

    serverDraw(draw){
      draw = Object.assign(new this.Draw, draw);
      draw.init();
      this.draws.push(draw);
    }

    serverDelete(draw){
        var actualDraw = this.drawById(this.draws,draw.id);
        var index = this.draws.indexOf(actualDraw);
        if(index >= 0){
            this.draws.splice(index, 1);
        }
        return index;
    }

    /**************************
        Helper functions
    **************************/

}
export {
    Battlefloor as
    default
}
