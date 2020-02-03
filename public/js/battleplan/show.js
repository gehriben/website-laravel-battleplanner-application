
/**************************
    Imports
**************************/
var App = require('./classes/App.js').default;
var EventListeners = require('./eventListeners.js');
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
var app = new App(VIEWPORTS,BATTLEPLAN_ID);

/**************************
    Event Listeners
**************************/
EventListeners.init(VIEWPORTS, app);

/**************************
    Socket Listeners
**************************/
Keybinds.init(app);

/**************************
    Windows Event Assignment
**************************/
if (typeof window.app === "undefined") {
    window.app = {}
}
window.app.engine = app;


/*
*
* Direct JS functions
*/

function vote(value,battleplanId,dom){

    var tmp = dom;

    if (value > 0) {
        $("#vote-up-" + battleplanId ).addClass("vote-green")
        $("#vote-down-" + battleplanId ).removeClass("vote-red")
    } else{
        $("#vote-down-" + battleplanId ).addClass("vote-red")
        $("#vote-up-" + battleplanId ).removeClass("vote-green")
    }

    $.ajax({
        method: "POST",
        url: "/battleplan/vote",
        data: {
            value: value,
            battleplanId: battleplanId
        },

        success: function (result) {
            console.log(result);
            $("#vote-value-" + battleplanId ).html("Points: " + result);
        },

        error: function (result) {
            console.log(result);
        }
    });
}

function copyModal($id){
    $('#copy-id').val($id);
    $('#copy').modal('toggle');
}

function copy(){
    $.ajax({
        method: "POST",
        url: "/battleplan/copy",
        data: {
            battleplanId: $('#copy-id').val(),
            name: $('#battleplan_name').val()
        },

        success: function (result) {
            alert("Successfully copied to account!");
            $('#copy').modal('hide');
        },

        error: function (result) {
            console.log(result);
        }
    });
}

