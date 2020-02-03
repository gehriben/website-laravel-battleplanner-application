/**************************
	Extention class type
**************************/
const Helpers = require('./Helpers.js').default;

class Slot extends Helpers {

    /**************************
            Constructor
    **************************/

    constructor() {
        // Super Class constructor call
        super();
    }

	init(){
		
	}
    setOperator(operator){
        if(operator != null){
           this.operator = operator

        } else{
            this.operator = null;
        }
    }

    generateDom(isOwner){
        var dom = "";
        if (isOwner) {
            if (this.operator == null) {
                dom += `<img type="image" id="operatorSlot-${this.id}" data-id="${this.id}" src="/media/ops/empty.png" class=" op-icon operator-slot operator-border" data-toggle="modal" data-target="#opModal" onmouseup="setEditingSlot($(this).data('id'),event, this)" style="border-color: #black" />`
            } else{
                dom += `<img type="image" draggable="true" ondragstart="app.engine.drag(event)" id="operatorSlot-${this.id}" data-id="${this.id}" src="${this.operator.icon}" class=" op-icon operator-slot operator-border" data-toggle="modal" data-target="#opModal" onmouseup="setEditingSlot($(this).data('id'),event,this)" style="border-color: #${this.operator.colour}"/>`
            }
        } else{
            if (this.operator == null) {
                dom += `<img type="image" id="operatorSlot-${this.id}" data-id="${this.id}" src="/media/ops/empty.png" class=" op-icon operator-slot operator-border no-pointer" style="border-color: black" />`
            } else{
                dom += `<img type="image" draggable="true" ondragstart="app.engine.drag(event)" id="operatorSlot-${this.id}" data-id="${this.id}" src="${this.operator.icon}" class=" op-icon operator-slot operator-border" style="border-color: #${this.operator.colour}"/>`
            }
        }
        return dom;
    }

    /**************************
        Public functions
    **************************/

}
export {
    Slot as
    default
}
