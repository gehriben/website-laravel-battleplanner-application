/**************************
    Imports
**************************/ 
var App = require('../battleplan/edit/classes/App.js').default;

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
    USER,
    LOBBY,
    SOCKET,
    $('#viewport'),
    [
        $('#operator-0'),
        $('#operator-1'),
        $('#operator-2'),
        $('#operator-3'),
        $('#operator-4')
    ],
    $('#lobbyList'),
    $('#host-left-lobby'),
    $('#saving-screen')
);

// app.initializeByJson();

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

app.requestBattleplanJson();