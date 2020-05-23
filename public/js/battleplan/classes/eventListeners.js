function init(VIEWPORTS, app){

    /**************************
     Remove Default Html Events
    **************************/
    $("#" + VIEWPORTS.CANVAS_BACKGROUND_ID + ', #' + VIEWPORTS.CANVAS_OVERLAY_ID).on("contextmenu", function(e) {
        return false;
    });

    /**************************
     Resize needs to reasjust the canvas sizes
    **************************/
    $( window ).resize(function() {
      app.init()
    });

    /**************************
        Scroll event listener
    **************************/
    $("#" + VIEWPORTS.VIEWPORT_ID).on('wheel', function (ev) {
        ev.preventDefault();
        app.canvasScroll(ev);
    });

} export {
    init as
    init
}
