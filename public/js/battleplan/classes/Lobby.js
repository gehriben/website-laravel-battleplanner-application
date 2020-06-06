class Lobby {

    /**************************
            Constructor
    **************************/

    constructor(data) {
        this.id;
        this.connectionString;
        this.owner;
        this.initialize(data);
    }

    initialize(data){
        this.id = data["id"];
        this.connectionString = data["connection_string"];
        this.owner = data["owner"];
    }

}
export {
    Lobby as
    default
}