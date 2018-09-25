$(document).ready(function() {

    let tableToPrepare;
    
    function prepareTableData() {
        switch ($(location).attr('href').substring($(location).attr('href').lastIndexOf("/"))) {
            case "supplierManager": 
                tableToPrepare = "tableSuppliers";
                return ['jSortName', 'jSortAddress', 'jSortNip', 'jSortEmail', 'jSortPhoneNumber', 'jSortDetails'];
                break;
            case "userManager": 
                tableToPrepare = "tableUsers";
                return ['jSortName', 'jSortEmail', 'jSortAcountType'];
                break;
            case "warehouseOperations": 
                tableToPrepare = "tableWarehouseOperations";
                return ['jSortName', 'jSortOperationType', 'jSortOldVal', 'jSortValChange', 'jSortNewVal', 
                    'jSortSupplierName', 'jSortOperationDate', 'jSortUser'];
                break;
            case "resourcesManager": 
                tableToPrepare = "tableResources";
                return ['jSortName', 'jSortQuantity', 'jSortCriticalQuantity', 'jSortCapacity', 'jSortProportions'];
                break;
            case "carTaskManager": 
                tableToPrepare = "tableCarTasks";
                return ['jSortRegNum', 'jSortCarTaskType', 'jSortStatus', 'jSortBeginTime', 'jSortBeginUser' ,'jSortEndTime', 'jSortEndUser'];
                break;
            case "carManager": 
                tableToPrepare = "tableCars";
                return ['jSortRegNum', 'jSortMake', 'jSortModel', 'jSortStatus'];
                break;
            default:
                return [];
                break;
        }
    }

//    var optionsSuppliers = {
//      //have to be the same as in data-sort header attributes, and td classes
//      valueNames: [ 'jSortName', 'jSortAddress', 'jSortNip', 'jSortEmail', 'jSortPhoneNumber', 'jSortDetails'],
//      page: 8, //page count for pagination
//      pagination: {
//        innerWindow: 1,
//        left: 0,
//        right: 0,
//        paginationClass: "pagination",
//        }
//    };

    var tableOptions = {
          //have to be the same as in data-sort header attributes, and td classes
          valueNames: prepareTableData(),
          page: 8, //page count for pagination
          pagination: {
            innerWindow: 1,
            left: 0,
            right: 0,
            paginationClass: "pagination",
            }
        };
    
    if (tableToPrepare != null) {
        var tableList = new List(tableToPrepare, tableOptions);
    }

	$('.jPaginateNext').on('click', function(){
	    var list = $('.pagination').find('li');
	    $.each(list, function(position, element){
	        if($(element).is('.active')){
	            $(list[position+1]).trigger('click');
	        }
	    })
	});


	$('.jPaginateBack').on('click', function(){
	    var list = $('.pagination').find('li');
	    $.each(list, function(position, element){
	        if($(element).is('.active')){
	            $(list[position-1]).trigger('click');
	        }
	    })
	});




    //alert box
    setTimeout(
        function(){
            $(".alert_box").fadeOut();
        }, 1000);

    //current nav indicator
    $( ".nav_href" ).each(function( index ) {
      var urlToCompare = $(location).attr('href').substring($(location).attr('href').lastIndexOf("/"));
      if(urlToCompare == $(this).attr('href')) {
        $(this).parent().addClass("curr_module");
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
          $("#edit_id").val($(this).data("userId"));
          $("#edit_name").val($(this).data("userName"));
          $("#edit_email").val($(this).data("userEmail"));

          if ($(this).data("userAccountType") == 0) {
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
            $("#edit_id").val($(this).data("carId"));
            $("#edit_reg_num").val($(this).data("carRegNum"));
            $("#edit_make").val($(this).data("carMake"));
            $("#edit_model").val($(this).data("carModel"));
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
      } else if ($(this).data("target") == "#edit_car_task_modal") {
        if (e.target.type == "checkbox") {
            e.stopPropagation();
        }
        else {
          $('#begin_time_datepicker').datetimepicker({format : "YYYY-MM-DD HH:mm:ss"});
          $('#end_time_datepicker').datetimepicker({format : "YYYY-MM-DD HH:mm:ss"});

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

           $("#edit_car_id").select2({
              language: "pl",
              dropdownParent: $("#edit_car_task_modal")
           });
           $("#edit_begin_user").select2({
              language: "pl",
              dropdownParent: $("#edit_car_task_modal")
           });
           $("#edit_end_user").select2({
              language: "pl",
              dropdownParent: $("#edit_car_task_modal")
           });
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

      //accept delivery
      $("#accept_delivery_btn").click(function() {
        var resourceIds = [];
        var resourceNames = [];
          $(':checkbox:checked').each(function(i){
            resourceIds[i] = $(this).val();
            resourceNames[i] = $(this).parent().parent().data("resourceName");
          });

          for (var i=0; i<resourceIds.length; i++) {
            $("#accept_delivery_resources").append(
              "<div class='row'>\
                  <div class='form-group'>\
                      <label class='control-label col-sm-6 horizontal_label' for='"+resourceNames[i]+"_field_accept'>"+resourceNames[i]+"</label>\
                      <div class='col-sm-4'>\
                          <button type='button' class='resource_increase' id='"+resourceIds[i]+"_inc_btn_accept'>+</button>\
                          <button type='button' class='resource_decrease' id='"+resourceIds[i]+"_dec_btn_accept'>-</button>\
                      </div>\
                      <div class='col-sm-2'>\
                          <input type='hidden' name='res_id[]' value="+resourceIds[i]+">\
                          <input id='"+resourceIds[i]+"_field_accept' type='text' class='form-control horizontal_input' name='qty_field_accept[]'\
                                 value=0>\
                      </div>\
                  </div>\
              </div>"
            )
          }
          $("#accept_delivery_select").select2({
             language: "pl",
             dropdownParent: $("#accept_delivery_modal")
          });
      });
      $("#accept_delivery_modal").on("hidden.bs.modal", function () {
        $("#accept_delivery_resources").empty();
    });

    //accept delivery increase/decrease buttons
        $("#accept_delivery_modal").on("click", ".resource_increase", function() {
            var clickedBtnId = $(this).attr("id");
            var inputFieldId = clickedBtnId.replace("_inc_btn_accept", "_field_accept");
            var currVal = $("#"+inputFieldId).val();
            currVal++;
            $("#"+inputFieldId).val(currVal);
        });
        $("#accept_delivery_modal").on("click", ".resource_decrease", function() {
            var clickedBtnId = $(this).attr("id");
            var inputFieldId = clickedBtnId.replace("_dec_btn_accept", "_field_accept");
            var currVal = $("#"+inputFieldId).val();
            if (currVal>0) {
                currVal--;
                $("#"+inputFieldId).val(currVal);
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

    //add car task modal
    $("#add_car_task_btn").click(function() {
      $("#add_car_id").select2({
          language: "pl",
          dropdownParent: $("#add_car_task_modal")
      });
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
