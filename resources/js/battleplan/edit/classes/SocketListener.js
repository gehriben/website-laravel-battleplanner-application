
class SocketListener {
    /**************************
            Constructor
    **************************/
   constructor(LISTEN_SOCKET,app) {
        LISTEN_SOCKET.on(`RequestBattleplan.${app.lobby.connection_string}:App\\Events\\Lobby\\RequestBattleplan`, function(message){
            alert('Request Received!');
        });

        LISTEN_SOCKET.on(`ResponseBattleplan.${app.lobby.connection_string}:App\\Events\\Lobby\\ResponseBattleplan`, function(message){
            alert('Response Received!');
        });
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