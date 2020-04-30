
/**************************
    Imports
**************************/
var App = require('./classes/App.js').default;

/**************************
    Setup Ajax CSRF
**************************/
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
});

const VIEWPORTS = {
    "CANVAS_BACKGROUND_ID": "background",
    "CANVAS_OVERLAY_ID": "interractible"
};

/**************************
    Constant declarations
**************************/
var app = new App(BATTLEPLAN_ID,VIEWPORTS);
