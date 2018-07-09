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
    // edit clickable row
    $(".clickable_row_no_href").click(function(e) {
      if ($(this).data("target") == "#edit_user_modal") {
        //default password change safeguard behaviour
        $("#edit_password").prop("disabled", true);
        $("#edit_pass_change_confirmation").prop("checked", false);
        //fill user data
        if (e.target.type == "checkbox") {
            e.stopPropagation();
        }
        else {
          var userId = $(this).data("userId");
          var userName = $(this).data("userName");
          var userEmail = $(this).data("userEmail");
          var userAccountType = $(this).data("userAccountType");

          $("#edit_user_modal").find("#edit_id").val(userId);
          $("#edit_user_modal").find("#edit_name").val(userName);
          $("#edit_user_modal").find("#edit_email").val(userEmail);

          if (userAccountType == "administrator") {
            $("#edit_radio_admin").attr("checked", "checked");
          } else {
            $("#edit_radio_user").attr("checked", "checked");
          }
        }
      } else if ($(this).data("target") == "#edit_supplier_modal") {
        console.log("supplier modal");
        if (e.target.type == "checkbox") {
            e.stopPropagation();
        }
        else {
          var supplierId = $(this).data("supplierId");
          var supplierName = $(this).data("supplierName");
          var supplierAddress = $(this).data("supplierAddress");
          var supplierNip = $(this).data("supplierNip");
          var supplierEmail = $(this).data("supplierEmail");
          var supplierPhoneNumber = $(this).data("supplierPhoneNumber"); //podkreslnik
          var supplierDetails= $(this).data("supplierDetails");

           $("#edit_supplier_modal").find("#edit_id").val(supplierId);
           $("#edit_supplier_modal").find("#edit_name").val(supplierName);
           $("#edit_supplier_modal").find("#edit_address").val(supplierAddress);
           $("#edit_supplier_modal").find("#edit_nip").val(supplierNip);
           $("#edit_supplier_modal").find("#edit_email").val(supplierEmail);
           $("#edit_supplier_modal").find("#edit_phone_number").val(supplierPhoneNumber);
           $("#edit_supplier_modal").find("#edit_details").val(supplierDetails);
        }
      }
    });

    //edit user pass change safeguard
    $("#edit_pass_change_confirmation").click(function() {
      if ($("#edit_pass_change_confirmation").is(":checked")) {
        $("#edit_password").prop("disabled", false);
      } else {
        $("#edit_password").prop("disabled", true);
      }
    })


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
