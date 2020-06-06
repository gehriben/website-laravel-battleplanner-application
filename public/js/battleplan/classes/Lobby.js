class Lobby {

    /**************************
            Constructor
    **************************/

    constructor(data) {
        this.id;
        this.connectionString;
        this.owner;
        this.users = [];
        
        this.initialize(data);
    }

    initialize(data){
        this.id = data["id"];
        this.connectionString = data["connection_string"];
        this.owner = data["owner"];
    }
    
    initializeByJson(json){
        json.users.forEach(userData => {
            this.AddUser(userData['user'], userData['socketId']);
        });
    }

    
    getUserBySocket(socketId){
        for (let i = 0; i < this.users.length; i++) {
            const user = this.users[i];
            if(user.socketId == socketId){
                return user;
            }
        }
    }

    AddUser(user, socketId){
        // user already in session
        if(this.getUserBySocket(socketId)){
            return;
        }

        // user does not exist yet, add them
        this.users.push({
            'user' : user,
            'socketId' : socketId
        });
    }

    RemoveUser(socketId){
        for (let i = 0; i < this.users.length; i++) {
            const lobbyUser = this.users[i];
            if(lobbyUser.socketId == socketId){
                this.users.splice(i, 1);
            }
        }
    }

    ToJson(){
        
        return {
            'id' : this.id,
            'connectionString' : this.connectionString,
            'owner' : this.owner,
            'users' : this.users
        }
    }
}
export {
    Lobby as
    default
}