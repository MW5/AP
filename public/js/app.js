$(document).ready(function() {
    
    //alert box
    setTimeout(
        function(){
            $(".alert_box").fadeOut();
        }, 2000);
        
    //accept delivery increase/decrease buttons
    $(".resource_increase").click(function() {
        var clickedBtnId = $(this).attr("id");
        var inputFieldId = clickedBtnId.replace("_inc_btn_accept", "_field_accept");
        var currVal = $("#"+inputFieldId).val();
        currVal++;
        $("#"+inputFieldId).val(currVal);
        console.log(clickedBtnId);
        console.log(inputFieldId);
    });
    $(".resource_decrease").click(function() {
        var clickedBtnId = $(this).attr("id");
        var inputFieldId = clickedBtnId.replace("_dec_btn_accept", "_field_accept");
        var currVal = $("#"+inputFieldId).val();
        if (currVal>0) {
            currVal--;
            $("#"+inputFieldId).val(currVal);
        }
    });
    
        //warehouse release increase/decrease buttons
    $(".resource_increase").click(function() {
        var clickedBtnId = $(this).attr("id");
        var inputFieldId = clickedBtnId.replace("_inc_btn_release", "_field_release");
        var currVal = $("#"+inputFieldId).val();
        currVal++;
        $("#"+inputFieldId).val(currVal);
    });
    $(".resource_decrease").click(function() {
        var clickedBtnId = $(this).attr("id");
        var inputFieldId = clickedBtnId.replace("_dec_btn_release", "_field_release");
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
    
    
    //clickable rows and checkbox click fix
    $(".clickable_row").click(function(e) {
        if (e.target.type == "checkbox") {
            e.stopPropagation();
        }
        else {
            window.location = $(this).data("href");
        }
    });
    
    //TEMPORARY SOLUTION
    $('#report_warehouse_operations').click(function () {
        var pageTitle = 'Raport operacji magazynowych',
            stylesheet = '../css/app.css',
            win = window.open('', 'Print', 'width=500,height=300');
        win.document.write('<html><head><title>' + pageTitle + '</title>' +
            '<link rel="stylesheet" href="' + stylesheet + '">' +
            '</head><body>' + $('.ap_table')[0].outerHTML + '</body></html>');
        win.document.close();
        win.print();
        win.close();
        return false;
    });
    
    
});

