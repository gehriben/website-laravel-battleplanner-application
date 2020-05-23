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

/**************************
    Constant declarations
**************************/
var app = new App(BATTLEPLAN_ID,
    $('#viewport'),
    [
        $('#operator-0'),
        $('#operator-1'),
        $('#operator-2'),
        $('#operator-3'),
        $('#operator-4')
    ]);

/**************************
   Give access to app object in main windows
**************************/
window.app = app;