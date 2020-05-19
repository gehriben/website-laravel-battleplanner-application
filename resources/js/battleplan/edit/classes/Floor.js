class Floor {

    /**************************
            Constructor
    **************************/
    constructor(data,callback) {
        // Properties
        this.draws = [];
        this.background;
        this.image = new Image();
        this.load;
        this.finishedCallback = callback;

        this.Initialize(data);
    }
    
    Initialize(data){
        this.background = data.floor.media.url;
        for (var i = 0; i < this.draws.length; i++) {
			this.draws[i] = Object.assign(new this.Draw, this.draws[i]);
            this.draws[i].init();
        }
        
        // acquire image
        this.image.src = this.background;

        // Load the image in memory
        this.image.onload = function () {
            this.load = this.image;
            this.finishedCallback(this);
        }.bind(this);
    }

    AddDraw(draw){
		this.draws.push(draw);
    }

    RemoveDraw(draw){
		this.draws = this.draws.filter(item => item !== draw);
    }

    SelectedDraws(){
        return this.draws.filter(draw => draw.highlighted);
    }
}

export {
    Floor as
        default
}
    