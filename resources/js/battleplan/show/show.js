/**************************
    Imports
**************************/
var App = require('../edit/classes/App.js').default;

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
var app = new App(
    null,
    null,
    null,
    $('#viewport'),
    [
        $('#operator-0'),
        $('#operator-1'),
        $('#operator-2'),
        $('#operator-3'),
        $('#operator-4')
    ],
    $('#lobbyList'),
    null,
    null
);
app.initializeByApi(BATTLEPLAN_ID);
app.keybinds.mousePressed['lmb']['tool'] = app.keybinds.toolMove;

app.canvas.resolution ={
    "x" : window.innerWidth,
    "y" : window.innerHeight,
};

$( window ).resize(function() {
    app.canvas.resolution = {
        "x" : window.innerWidth,
        "y" : window.innerHeight,
    };
    app.canvas.Initialize();
});

/**************************
   Give access to app object in main windows
**************************/
window.app = app;