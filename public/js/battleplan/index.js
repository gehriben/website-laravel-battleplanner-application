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
            $("#vote-value-" + battleplanId ).html(result);
            // alert("voted!");
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