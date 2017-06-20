$(document).ready(function() {
    //alert box
    setTimeout(
        function(){
            $(".alert_box").fadeOut();
        }, 2000);
        
    //accept delivery increase/decrease buttons
    $(".resource_increase").click(function() {
        var clickedBtnId = $(this).attr("id");
        var inputFieldId = clickedBtnId.replace("_inc_btn", "_field");
        var currVal = $("#"+inputFieldId).val();
        currVal++;
        $("#"+inputFieldId).val(currVal);
    });
    $(".resource_decrease").click(function() {
        var clickedBtnId = $(this).attr("id");
        var inputFieldId = clickedBtnId.replace("_dec_btn", "_field");
        var currVal = $("#"+inputFieldId).val();
        if (currVal>0) {
            currVal--;
            $("#"+inputFieldId).val(currVal);
        }
    });
    
    //draggable modal
    $(".modal-dialog").draggable({
        handle: ".modal-header"
    }); 
});

