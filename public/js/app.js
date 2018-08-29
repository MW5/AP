$(document).ready(function() {

    //alert box
    setTimeout(
        function(){
            $(".alert_box").fadeOut();
        }, 2000);

    //current nav indicator
    $( ".nav_href" ).each(function( index ) {
      var urlToCompare = $(location).attr('href').substring($(location).attr('href').lastIndexOf("/"));
      if(urlToCompare == $(this).attr('href')) {
        $(this).parent().addClass("curr_module");
      }
    });

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
      //edit user
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

          $("#edit_id").val(userId);
          $("#edit_name").val(userName);
          $("#edit_email").val(userEmail);

          if (userAccountType == "administrator") {
            $("#edit_radio_admin").attr("checked", "checked");
          } else {
            $("#edit_radio_user").attr("checked", "checked");
          }
        }
      //edit supplier
      } else if ($(this).data("target") == "#edit_supplier_modal") {
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

           $("#edit_id").val(supplierId);
           $("#edit_name").val(supplierName);
           $("#edit_address").val(supplierAddress);
           $("#edit_nip").val(supplierNip);
           $("#edit_email").val(supplierEmail);
           $("#edit_phone_number").val(supplierPhoneNumber);
           $("#edit_details").val(supplierDetails);
        }
      //edit car
      } else if ($(this).data("target") == "#edit_car_modal") {
          if (e.target.type == "checkbox") {
              e.stopPropagation();
          }
          else {
            var carId = $(this).data("carId");
            var carRegNum = $(this).data("carRegNum");
            var carMake = $(this).data("carMake");
            var carModel= $(this).data("carModel");

            $("#edit_id").val(carId);
            $("#edit_reg_num").val(carRegNum);
            $("#edit_make").val(carMake);
            $("#edit_model").val(carModel);
          }
      //resource row click decision modal
      } else if ($(this).data("target") == "#row_click_decision_modal") {
        if (e.target.type == "checkbox") {
            e.stopPropagation();
        } else {
          var resourceId = $(this).data("resourceId");
          var resourceName = $(this).data("resourceName");
          var resourceCriticalQuantity = $(this).data("resourceCriticalQuantity");
          var resourceCapacity = $(this).data("resourceCapacity");
          var resourceProportions = $(this).data("resourceProportions");
          var resourceDescription = $(this).data("resourceDescription");
          //set properties
            //details btn
          $("#details_btn_href").attr("href", "resourcesManager/"+resourceId);
            //edit btn
          $("#edit_resource_btn").data("resource-id", resourceId);
          $("#edit_resource_btn").data("resource-name", resourceName);
          $("#edit_resource_btn").data("resource-critical-quantity", resourceCriticalQuantity);
          $("#edit_resource_btn").data("resource-capacity", resourceCapacity);
          $("#edit_resource_btn").data("resource-proportions", resourceProportions);
          $("#edit_resource_btn").data("resource-description", resourceDescription);
        }
      //edit car task
      } else if ($(this).data("target") == "#edit_carTask_modal") {
        if (e.target.type == "checkbox") {
            e.stopPropagation();
        }
        else {
          $("#edit_car_id").select2({
              dropdownParent: $("#edit_carTask_modal")
          });
          //$('#edit_begin_time').data("DateTimePicker").moment().format("dddd, MMMM Do YYYY, h:mm:ss");
          $('#edit_begin_time').datetimepicker({format : "DD/MM/YYYY HH:mm"});

          var carTaskId = $(this).data("carTaskId");
          var carTaskCarId = $(this).data("carTaskCarId");
          var carTaskTaskType = $(this).data("carTaskTaskType");
          var carTaskBeginTime = $(this).data("carTaskBeginTime");
          var carTaskBeginUser = $(this).data("carTaskBeginUser");
          var carTaskEndTime = $(this).data("carTaskEndTime");
          var carTaskEndUser = $(this).data("carTaskEndUser");

           $("#edit_id").val(carTaskId);
           $("#edit_car_id").val(carTaskCarId);
           $("#edit_task_type").val(carTaskTaskType);
           $("#edit_begin_time").val(carTaskBeginTime);
           $("#edit_begin_user").val(carTaskBeginUser);
           $("#edit_end_time").val(carTaskEndTime);
           $("#edit_end_user").val(carTaskEndUser);
        }
      }
    });

    //edit resource modal
    $("#edit_resource_btn").click(function() {
          var resourceId = $(this).data("resourceId");
          var resourceName = $(this).data("resourceName");
          var resourceCriticalQuantity = $(this).data("resourceCriticalQuantity");
          var resourceCapacity = $(this).data("resourceCapacity");
          var resourceProportions = $(this).data("resourceProportions");
          var resourceDescription = $(this).data("resourceDescription");

          $("#edit_id").val(resourceId);
          $("#edit_name").val(resourceName);
          $("#edit_critical_quantity").val(resourceCriticalQuantity);
          $("#edit_capacity").val(resourceCapacity);
          $("#edit_proportions").val(resourceProportions);
          $("#edit_description").val(resourceDescription);
      })

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
