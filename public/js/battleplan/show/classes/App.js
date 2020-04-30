
class App {

    /**************************
            Constructor
    **************************/

    constructor(id, viewports) {
        this.battleplan;
        this.viewports = viewports;
        this.getBattleplan(id,function(result){
            this.battleplan = result;
            this.drawFloor();
        }.bind(this));
    }

    getBattleplan(id,callback) {
        $.ajax({
            method: "GET",
            contentType: "application/json",
            url: `/battleplan/${id}`,
            dataType: "json",
            success: function (result) {
                callback(result);
            },
            error: function (result) {
                console.log(result);
            }
        });
    }

    drawFloor(){
        // Variable declarations
        var background = document.getElementById(this.viewports.CANVAS_BACKGROUND_ID);
        var ctx = background.getContext('2d');
        var img = new Image;

        // acquire image
        img.src = this.battleplan.battlefloors[0].floor.media.url;

        // Fill background color
        ctx.fillStyle = 'black';
        ctx.fillRect(0, 0, background.width, background.height);

        // Load the image in memory
        img.onload = function () {
            // Draw the image
            ctx.drawImage(img, 0, 0, img.width, img.height);
        }.bind(this);
    }
}
export {
    App as
        default
}
