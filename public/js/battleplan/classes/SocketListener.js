
class SocketListener {
    /**************************
            Constructor
    **************************/
   constructor(LISTEN_SOCKET, app) {
       this.waitingForJson = false;
       this.app = app;
       
        LISTEN_SOCKET.on(`RequestBattleplan.${app.lobby.connection_string}:App\\Events\\Lobby\\RequestBattleplan`, function(message){
            if(app.lobby.owner['id'] == app.user['id']){
                $.ajax({
                    method: "POST",
                    url: `/lobby/${LOBBY["connection_string"]}/response-battleplan`,
                    data: {
                        'appJson' : app.ToJson()
                    },
                    success: function (result) {
                        console.log(result);
                    }.bind(this),
                    
                    error: function (result) {
                        console.log(result);
                    }
                });
            }
        });

        LISTEN_SOCKET.on(`ResponseBattleplan.${app.lobby.connection_string}:App\\Events\\Lobby\\ResponseBattleplan`, function(message){
            if(this.waitingForJson){
                app.initializeByJson(message);
            }
        }.bind(this));
        
        LISTEN_SOCKET.on(`ReceiveDrawCreate.${app.lobby.connection_string}:App\\Events\\Lobby\\ReceiveDrawCreate`, function(message){
            if(this.app.user['id'] != message['requester']['id']){
                var floor = app.battleplan.getFloorByLocalId(message['floorData']['localId'])
                floor.AddDraw(floor.createDrawFromJson(message['drawData']));
                app.canvas.Update();
            }
        }.bind(this));

        LISTEN_SOCKET.on(`ReceiveDrawDelete.${app.lobby.connection_string}:App\\Events\\Lobby\\ReceiveDrawDelete`, function(message){
            if(this.app.user['id'] != message['requester']['id']){
                app.battleplan.deleteDrawByLocalId(message['localId']);
                app.canvas.Update();
            }
        }.bind(this));

        LISTEN_SOCKET.on(`ReceiveDrawDelete.${app.lobby.connection_string}:App\\Events\\Lobby\\ReceiveDrawDelete`, function(message){
            if(this.app.user['id'] != message['requester']['id']){
                app.battleplan.deleteDrawByLocalId(message['localId']);
                app.canvas.Update();
            }
        }.bind(this));

        LISTEN_SOCKET.on(`ReceiveOperatorSlotChange.${app.lobby.connection_string}:App\\Events\\Lobby\\ReceiveOperatorSlotChange`, function(message){
            if(this.app.user['id'] != message['requester']['id']){
                var operator = app.battleplan.getOperatorByLocalId(message['operatorSlotData']['localId']);
                operator.operator.id = message['operatorSlotData']["operator_id"]
                operator.operator.src = message['operatorSlotData']["src"];
                app.DisplayOperators();
            }
        }.bind(this));

        LISTEN_SOCKET.on(`ReceiveDrawUpdate.${app.lobby.connection_string}:App\\Events\\Lobby\\ReceiveDrawUpdate`, function(message){
            if(this.app.user['id'] != message['requester']['id']){
                var found = this.app.battleplan.getDrawLocalId(message['drawData']['localId']);
                found.UpdateFromJson(message['drawData']);
                // if(this.app.user['id'] != message['requester']['id']){
                //     var operator = app.battleplan.getOperatorByLocalId(message['operatorSlotData']['localId']);
                //     operator.operator.id = message['operatorSlotData']["operator_id"]
                //     operator.operator.src = message['operatorSlotData']["src"];
                //     app.DisplayOperators();
                // }
                app.canvas.Update();
            }
        }.bind(this));

        
   }

} export {
    SocketListener as
        default
}

// function init(LISTEN_SOCKET, ROOM_CONN_STRING ,app){

//     LISTEN_SOCKET.on(`RequestBattleplan.${ROOM_CONN_STRING}:App\\Events\\Lobby\\RequestBattleplan`, function(message){
//         alert('Request Received!');
//     });

//     LISTEN_SOCKET.on(`ResponseBattleplan.${ROOM_CONN_STRING}:App\\Events\\Lobby\\ResponseBattleplan`, function(message){
//         alert('Response Received!');
//     });
//     // //listen for someone elses draws
//     // LISTEN_SOCKET.on(`BattlefloorDraw.${ROOM_CONN_STRING}:App\\Events\\Battlefloor\\CreateDraws`, function(message){
//     //     app.serverDraw(message);
//     // });

//     // //listen for someone elses draws
//     // LISTEN_SOCKET.on(`BattlefloorDelete.${ROOM_CONN_STRING}:App\\Events\\Battlefloor\\DeleteDraws`, function(message){
//     //     app.serverDelete(message);
//     // });

//     // //listen for someone elses draws
//     // LISTEN_SOCKET.on(`ChangeOperatorSlot.${ROOM_CONN_STRING}:App\\Events\\Battleplan\\ChangeOperatorSlot`, function(message){
//     //     app.changeOperatorSlotDom(message.operatorSlot.id,message.operator);
//     // }); 
// }