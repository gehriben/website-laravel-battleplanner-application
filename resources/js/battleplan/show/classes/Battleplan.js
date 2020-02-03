/**************************
	Extention class type
**************************/
const Helpers = require('./Helpers.js').default;

class Battleplan extends Helpers {

    /**************************
            Constructor
    **************************/

    constructor() {
        // Super Class constructor call
        super();

        // Instantiatable class types
        this.Battlefloor = require('./Battlefloor.js').default;
        this.Slot = require('./Slot.js').default;

        // Variables
        this.battlefloor = null;
        this.draws_transit = [];
        // this.draws_limbo = [];//draws that have been sent for saving

    }

	/**************************
		Initialisation functions
	**************************/

	init() {
		this.initFloors();
		this.initSlots();
	}

	initFloors(){
		for (var i = 0; i < this.battlefloors.length; i++) {
			this.battlefloors[i] = Object.assign(new this.Battlefloor, this.battlefloors[i]);
			this.battlefloors[i].init();
		}
		// set default floor
		this.battlefloor = this.battlefloors[0];
	}

	initSlots(){
		for (var i = 0; i < this.slots.length; i++) {
			this.slots[i] = Object.assign(new this.Slot, this.slots[i]);
			this.slots[i].init();
		}
	}


	/**************************
		Slot Methods
	**************************/

    getSlot(id){
        return this.slots.filter(slot => this._objectIdEquals(slot,id))[0];
    }

    /**************************
		  Battlefloor Methods
	  **************************/
    getBattlefloor(id){
      return this.battlefloors.filter(battlefloor => this._objectIdEquals(battlefloor,id))[0];
    }
    /**************************
        Floor Methods
    **************************/
    getFloor(id){
        return this.battlefloors.filter(floor => this._objectIdEquals(floor,id))[0];
    }

    getFloorDbId(dbId){
        return this.battlefloors.filter(floor => this._objectDbIdEquals(floor,dbId))[0];
    }

    //Positive or negative values accepted
    changeFloor(amount){
      if(amount == 0){
        throw new Error("Cannot change floor by 0.");
        return;
      }

      // positive
      if (amount > 0) {
        for (var i = 0; i != amount; i++) {
          if (this.hasNextFloor()) {
            this.nextFloor();
          } else{
            return;
          }
        }
      //Negative
      } else{
        for (var i = 0; i != amount; i--) {
          if (this.hasPreviousFloor()) {
            this.previousFloor();
          } else{
            return;
          }
        }
      }
      // Error checking
      if (!this.battlefloor){
        throw new Error("Something when wrong when changing floors");
      }
    }

    changeFloorById(floorId){
       this.battlefloor = this.getFloor(floorId);
    }

    nextFloor(){
      if (this.hasNextFloor()) {
        this.battlefloor = this.battlefloors[this.battlefloor.floor.floorNum + 1];
      }
    }

    previousFloor(){
      if (this.hasPreviousFloor()) {
        this.battlefloor = this.battlefloors[this.battlefloor.floor.floorNum - 1];
      }
    }

    hasNextFloor(){
      if(this.battlefloor.floor.floorNum < this.battlefloors.length -1 ){
        return true;
      }
      return false;
    }

    hasPreviousFloor(){
        if(this.battlefloor.floor.floorNum - 1 >= 0){
          return true;
        }
        return false;
    }

    setFloor(id){
      var floor = this.getFloor(id)
      if (floor) {
        this.battlefloor = floor;
      }
    }

    /**************************
        Gather draw functions
    **************************/
	acquireUnsavedDraws(){
		var draws_transit = [];
		// Acquire the drawings that have not been saved
		for (var i = 0; i < this.battlefloors.length; i++) {
      draws_transit = draws_transit.concat(this.battlefloors[i].draws_unpushed);
      // this.battlefloors[i].draws = this.battlefloors[i].draws.concat(draws_transit);
			this.battlefloors[i].draws_unpushed = [];
		}
		return draws_transit;
  }
  
  
  acquireUnsavedDeletes(){
		var deletes_transit = [];
		// Acquire the drawings that have not been saved
		for (var i = 0; i < this.battlefloors.length; i++) {
			deletes_transit = deletes_transit.concat(this.battlefloors[i].draws_deleted);
			this.battlefloors[i].draws_deleted = [];
		}
		return deletes_transit;
  }

}
export {
    Battleplan as
    default
}
