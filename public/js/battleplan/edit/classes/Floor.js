class Floor {

    /**************************
            Constructor
    **************************/
    constructor(data) {
        // Properties
        this.draws = [];
        this.background;

        this.Initialize(data);
    }
    
    Initialize(data){
        this.background = data.floor.media.url;
        for (var i = 0; i < this.draws.length; i++) {
			this.draws[i] = Object.assign(new this.Draw, this.draws[i]);
            this.draws[i].init();
		}
    }
}

export {
    Floor as
        default
}
    