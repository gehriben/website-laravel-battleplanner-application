
class SocketListener {
    /**************************
            Constructor
    **************************/
   constructor(LISTEN_SOCKET, app, hostLeftSceen) {
        this.waitingForJson = false;
        this.app = app;
        this.hostLeftSceen=hostLeftSceen;

        /**
         * Alert clients you're connected
         */
        LISTEN_SOCKET.on('connect', function onConnect(socket){
            console.log(LISTEN_SOCKET.id);
            
            $.ajax({
                method: "POST",
                url: `/lobby/${app.lobby.connectionString}/connected`,
                data: {
                    'socketId' : LISTEN_SOCKET.id
                },
                success: function (result) {
                    console.log(result);
                }.bind(this),
                
                error: function (result) {
                    console.log(result);
                }
            });

        }.bind(this));
        

        /**
         * Request Json State of current Battleplan from host
         */
        LISTEN_SOCKET.on(`RequestBattleplan.${app.lobby.connectionString}:App\\Events\\Lobby\\RequestBattleplan`, function(message){
            if(app.lobby.owner['id'] == app.user['id']){
                var tmp = app.ToJson();
                $.ajax({
                    method: "POST",
                    url: `/lobby/${app.lobby.connectionString}/response-battleplan`,
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
        }.bind(this));

        /**
         * Listeners
         */
        LISTEN_SOCKET.on(`ResponseBattleplan.${app.lobby.connectionString}:App\\Events\\Lobby\\ResponseBattleplan`, function(message){
            if(this.waitingForJson){
                app.initializeByJson(message);
            }
        }.bind(this));
        
        LISTEN_SOCKET.on(`ReceiveDrawCreate.${app.lobby.connectionString}:App\\Events\\Lobby\\ReceiveDrawCreate`, function(message){
            if(this.app.user['id'] != message['requester']['id']){
                var floor = app.battleplan.getFloorByLocalId(message['floorData']['localId'])
                floor.AddDraw(floor.createDrawFromJson(message['drawData']));
                app.canvas.Update();
            }
        }.bind(this));

        LISTEN_SOCKET.on(`ReceiveDrawDelete.${app.lobby.connectionString}:App\\Events\\Lobby\\ReceiveDrawDelete`, function(message){
            if(this.app.user['id'] != message['requester']['id']){
                app.battleplan.deleteDrawByLocalId(message['localId']);
                app.canvas.Update();
            }
        }.bind(this));

        LISTEN_SOCKET.on(`ReceiveDrawDelete.${app.lobby.connectionString}:App\\Events\\Lobby\\ReceiveDrawDelete`, function(message){
            if(this.app.user['id'] != message['requester']['id']){
                app.battleplan.deleteDrawByLocalId(message['localId']);
                app.canvas.Update();
            }
        }.bind(this));

        LISTEN_SOCKET.on(`ReceiveOperatorSlotChange.${app.lobby.connectionString}:App\\Events\\Lobby\\ReceiveOperatorSlotChange`, function(message){
            if(this.app.user['id'] != message['requester']['id']){
                var operator = app.battleplan.getOperatorByLocalId(message['operatorSlotData']['localId']);
                operator.operator.operatorId = message['operatorSlotData']["operator_id"]
                operator.operator.src = message['operatorSlotData']["src"];
                operator.operator.color = message['operatorSlotData']["color"];
                app.DisplayOperators();
            }
        }.bind(this));

        LISTEN_SOCKET.on(`ReceiveDrawUpdate.${app.lobby.connectionString}:App\\Events\\Lobby\\ReceiveDrawUpdate`, function(message){
            if(this.app.user['id'] != message['requester']['id']){
                var found = this.app.battleplan.getDrawLocalId(message['drawData']['localId']);
                found.UpdateFromJson(message['drawData']);
                app.canvas.Update();
            }
        }.bind(this));


        LISTEN_SOCKET.on(`ReceiveReload.${app.lobby.connectionString}:App\\Events\\Lobby\\ReceiveReload`, function(message){
            if(this.app.user['id'] != message['requester']['id']){
                window.location.reload();
            }
        }.bind(this));
        
        /**
         * User (dis)connections
         */
        
        LISTEN_SOCKET.on(`ReceiveConnected.${app.lobby.connectionString}:App\\Events\\Lobby\\ReceiveConnected`, function(message){
            // lobby owner rejoined and am not owner, reload Battleplan
            if(message.user.id == this.app.lobby.owner.id && this.app.user.id != this.app.lobby.owner.id){
                window.location.reload();
            }

            // random user join, add to list
            else{
                this.app.lobby.AddUser(message['user'], message['socketId']);
                this.app.LobbyDisplayUsers();
            }
        }.bind(this));

        LISTEN_SOCKET.on(`ReceiveLobbyLeave:${app.lobby.connectionString}`, function (message){
            // lobby owner left, pause screen
            var userLeft = this.app.lobby.getUserBySocket(message['socketId'])
            if(userLeft && userLeft.user.id == this.app.lobby.owner.id){
                this.hostLeftSceen.show();
            }

            // random user join, remove from list
            else{
                this.app.lobby.RemoveUser(message['socketId']);
                this.app.LobbyDisplayUsers();
            }

        }.bind(this));

        
        
   }

} export {
    SocketListener as
        default
}
