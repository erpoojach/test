//Added by pooja on 31 may 2017

function tottravelerInRoom(roomno) {
//    alert(roomno);
    var adult = $("#adult_" + roomno).val();
    var child = $("#child_" + roomno).val();
    var infant = $("#infant_" + roomno).val();
    var totalPaxInRoom = parseInt(adult) + parseInt(child) + parseInt(infant);
    var Group = $('.Group').is(":checked");
    if(Group === false){
        if (totalPaxInRoom >= 5) {
            alert('Only 4 pax are allowed in each room. Please modify travelers in Room no. ' + roomno);
            return false;
        }
    }

}

function addroom() {
    var roomlp = $("#roomlp").val();
    var showroom = parseInt(roomlp) + 1;
    if (showroom === 6) {
        alert('Only 5 rooms are allowed.');
        return false;
//            $('.addroom').hide();
    }
    $("#roomlp").val(showroom);
    $("#rmres_" + showroom).show();
    $('.disproom').hide();
    $('.disproom_' + showroom).show();
}

function delroom(id) {
    var showroom = parseInt(id) - 1;
    $('.addroom').show();
    $("#roomlp").val(showroom);
    $("#rmres_" + id).hide();
    $('.disproom').hide();
    $('.disproom_' + showroom).show();
}

function showchildagebox(id) {
    var childrencount = $("#child_" + id).val();
//        alert(childrencount+'___'+id);
    var j;
    $(".childcl_" + id).show();
    $(".childage_" + id).hide();
    if (childrencount === '0') {
        $(".childcl_" + id).hide();
        return false;
    }

    for (j = 1; j <= childrencount; j++) {

        $("#child_" + id + "_" + j).show();
    }
    //var showroom = parseInt(roomlp)+parseInt(roomlp);
    //$("#rmres_"+showroom).show();adult_ child_ roomBoxMain
    tottravelerInRoom(id);
}
function showextrabedchildagebox(id) {
    var childrencount = $("#child_" + id).val();
//        alert(childrencount+'___'+id);
    var j;
    $(".childage_" + id).hide();
    for (j = 1; j <= childrencount; j++) {
        $("#childcl_" + id + "_" + j).show();
    }
    tottravelerInRoom(id);
}

function showextrabedbox(roomno) {
    var adult = $("#adult_" + roomno).val();
    if (adult == 3) {
        $(".adultcl_" + roomno + '_3').show();
    } else {
        $(".adultcl_" + roomno + '_3').hide();
    }
    tottravelerInRoom(roomno);
}

