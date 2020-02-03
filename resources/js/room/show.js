/**************************
    Imports
**************************/
var App = require('./classes/App.js').default;
var EventListeners = require('./eventListeners.js');
var SocketListeners = require('./socketListeners.js');
var Keybinds = require('./Keybinds.js');

/**************************
    Constant declarations
**************************/
const VIEWPORTS = {
    "CANVAS_BACKGROUND_ID": "background",
    "CANVAS_OVERLAY_ID": "overlay",
    "VIEWPORT_ID": "viewport",
};

/**************************
    Variables that must be defined in html view due to blade limitations
**************************/
// const ROOM_CONN_STRING;
// const LISTEN_SOCKET;
// const USER_ID;

/**************************
    Setup Ajax CSRF
**************************/
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/**************************
    Variable Declaration
**************************/
var app = new App(ROOM_CONN_STRING, VIEWPORTS, USER_ID);

/**************************
    Event Listeners
**************************/
EventListeners.init(VIEWPORTS, app);

/**************************
    Socket Listeners
**************************/
SocketListeners.init(LISTEN_SOCKET, ROOM_CONN_STRING, app);

/**************************
    Socket Listeners
**************************/
Keybinds.init(LISTEN_SOCKET, ROOM_CONN_STRING, app);

/**************************
    Windows Event Assignment
**************************/
if (typeof window.app === "undefined") {
    window.app = {}
}
window.app.engine = app;
