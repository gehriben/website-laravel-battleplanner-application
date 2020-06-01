
var Databaseable = require('./Databaseable.js').default;
class Floor extends Databaseable{

    /**************************
            Constructor
    **************************/
    constructor(data,callback) {
        // Properties
        super(data.id);
        this.draws = [];
        this.background;
        this.image = new Image();
        this.load;
        this.finishedCallback = callback;

        // map the possible classes for draws
        this.Line = require('./Line.js').default,
        this.Square = require('./Square.js').default,
        this.Icon = require('./Icon.js').default,

        this.Initialize(data);
    }
    
    Initialize(data){
        this.background = data.floor.source.url;

        for (var i = 0; i < data.draws.length; i++) {
            var typeArray = data.draws[i]['drawable_type'].split('\\');
            var type = typeArray[typeArray.length - 1];

            switch (type) {
                case 'Line':
                    this.draws[i] = new this.Line(
                        data.draws[i].id,
                        data.draws[i].drawable.color,
                        data.draws[i].drawable.opacity,
                        data.draws[i].drawable.size,
                    );
                    
                    data.draws[i].drawable.points.forEach(coordinate => {
                        this.draws[i].points.push({
                            'x' : coordinate['x'],
                            'y' : coordinate['y']
                        });
                    });

                    break;

                case 'Square':
                    
                    this.draws[i] = new this.Square(
                        data.draws[i].id,
                        data.draws[i].drawable.origin,
                        data.draws[i].drawable.destination,
                        data.draws[i].drawable.color,
                        data.draws[i].drawable.opacity,
                    );

                    break;

                case 'Icon':
                    
                    this.draws[i] = new this.Icon(
                        data.draws[i].id,
                        {'x': data.draws[i].drawable.origin.x,'y': data.draws[i].drawable.origin.y},
                        data.draws[i].drawable.size,
                        data.draws[i].drawable.opacity,
                        data.draws[i].drawable.source,
                    );
                    
                    break;
            
                // Do default
                default:
                    console.error(' Invalid Draw Type');
                    break;
            }
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

    ToJson(){
        var drawsJson = [];

        for (let i = 0; i < this.draws.length; i++) {
            const draw = this.draws[i];
            drawsJson.push(draw.ToJson());
        }

        return {
            'id' : this.id,
            'localId' : this.localId,
            'draws' : drawsJson
        }
    }

}

export {
    Floor as
        default
}
    