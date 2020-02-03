var keysPressed = [];
var keyEvents = [];
keyEvents.push({ "keys": [38], "event": floorUp }); // up arrow
keyEvents.push({ "keys": [40], "event": floorDown }); // down arrow

function init() {
    $(document).on('keydown', function (event) {
        setKey(event.which || event.keyCode);

        // Prevent ctrl + s default behavior
        if (keysPressed.includes(17) && keysPressed.includes(83)) {
            event.preventDefault();
        }

        // Prevent ctrl + d default behavior
        if (keysPressed.includes(17) && keysPressed.includes(68)) {
            event.preventDefault();
        }

        // Do events
        events();

        // console.log(keysPressed);
    })

    $(document).on('keyup', function (event) {
        unsetKey(event.which || event.keyCode);
    })

} export {
    init as
        init
}

function setKey(code) {
    if (!keysPressed.includes(code)) {
        keysPressed.push(code)
    }
}

function unsetKey(code) {
    keysPressed = keysPressed.filter(function (value, index, arr) {
        return value != code;
    });
}

function events() {
    keyEvents.forEach(function (element) {
        var flag = true;
        for (let index = 0; index < element["keys"].length && flag; index++) {
            const aKey = element["keys"][index]
            if (!keysPressed.includes(aKey)) {
                flag = false;
            }
        }
        if (flag) {
            element["event"]();
        }
    });
}

function floorDown() {
    app.engine.changeFloor(-1);
}
function floorUp() {
    app.engine.changeFloor(1);
}