$(document).ready(function() {

    let tableToPrepare;
    function prepareTableData() {
        switch ($(location).attr('href').substring($(location).attr('href').lastIndexOf("/"))) {
            case "/supplierManager": 
                tableToPrepare = "tableSuppliers";
                return ['jSortName', 'jSortAddress', 'jSortNip', 'jSortEmail', 'jSortPhoneNumber', 'jSortDetails'];
                break;
            case "/userManager": 
                tableToPrepare = "tableUsers";
                return ['jSortName', 'jSortEmail', 'jSortAccountType'];
                break;
            case "/warehouseOperations": 
                tableToPrepare = "tableWarehouseOperations";
                return ['jSortName', 'jSortOperationType', 'jSortOldVal', 'jSortValChange', 'jSortNewVal', 
                    'jSortSupplierName', 'jSortOperationDate', 'jSortUser'];
                break;
            case "/resourceManager": 
                tableToPrepare = "tableResources";
                return ['jSortName', 'jSortQuantity', 'jSortCriticalQuantity', 'jSortCapacity', 'jSortProportions'];
                break;
            case "/carTaskManager": 
                tableToPrepare = "tableCarTasks";
                return ['jSortRegNum', 'jSortCarTaskType', 'jSortStatus', 'jSortBeginTime', 'jSortBeginUser' ,'jSortEndTime', 'jSortEndUser'];
                break;
            case "/carManager": 
                tableToPrepare = "tableCars";
                return ['jSortRegNum', 'jSortMake', 'jSortModel', 'jSortStatus'];
                break;
            default:
                return [];
                break;
        }
    }

    var tableOptions = {
          //have to be the same as in data-sort header attributes, and td classes
          valueNames: prepareTableData(),
          page: 20, //rows count for pagination
          pagination: {
            innerWindow: 3,
            left: 1,
            right: 1,
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

    //draggable modal
    $(".modal-dialog").draggable({
        handle: ".modal-header"
    });


    //clickable rows and checkbox click fix
    $(".clickable_row").click(function(e) {
        if (e.target.getAttribute('class') == "checkmark" || e.target.type == "checkbox") {
            e.stopPropagation();
        }
        else {
            window.location = $(this).data("href");
        }
    });


    // edit clickable row

    $(".ap_table").on("click", ".clickable_row_no_href", function(e) {
        if (e.target.getAttribute('class') == "checkmark" || e.target.type == "checkbox") {
            e.stopPropagation();
        }
        
        //edit user
        if ($(this).data("target") == "#edit_user_modal") {
            //default password change safeguard behaviour
            $("#edit_password").prop("disabled", true);
            $("#edit_pass_change_confirmation").prop("checked", false);
            //fill user data
            $("#edit_id").val($(this).data("userId"));
            $("#edit_name").val($(this).data("userName"));
            $("#edit_email").val($(this).data("userEmail"));

            if ($(this).data("userAccountType") == 0) {
              $("#edit_radio_admin").attr("checked", "checked");
            } else {
              $("#edit_radio_user").attr("checked", "checked");
            }
        //edit supplier
        } else if ($(this).data("target") == "#edit_supplier_modal") {
           $("#edit_id").val($(this).data("supplierId"));
           $("#edit_name").val($(this).data("supplierName"));
           $("#edit_address").val($(this).data("supplierAddress"));
           $("#edit_nip").val($(this).data("supplierNip"));
           $("#edit_email").val($(this).data("supplierEmail"));
           $("#edit_phone_number").val($(this).data("supplierPhoneNumber"));
           $("#edit_details").val($(this).data("supplierDetails"));
        //edit car
        } else if ($(this).data("target") == "#edit_car_modal") {
            $("#edit_id").val($(this).data("carId"));
            $("#edit_reg_num").val($(this).data("carRegNum"));
            $("#edit_make").val($(this).data("carMake"));
            $("#edit_model").val($(this).data("carModel"));
        //resource row click decision modal
        } else if ($(this).data("target") == "#row_click_decision_modal") {
            var resourceId = $(this).data("resourceId");
            var resourceName = $(this).data("resourceName");
            var resourceCriticalQuantity = $(this).data("resourceCriticalQuantity");
            var resourceCapacity = $(this).data("resourceCapacity");
            var resourceProportions = $(this).data("resourceProportions");
            var resourceDescription = $(this).data("resourceDescription");
            //set properties
              //details btn
            $("#details_btn_href").attr("href", "resourceManager/"+resourceId);
              //edit btn
            $("#edit_resource_btn").data("resource-id", $(this).data("resourceId"));
            $("#edit_resource_btn").data("resource-name", $(this).data("resourceName"));
            $("#edit_resource_btn").data("resource-critical-quantity", $(this).data("resourceCriticalQuantity"));
            $("#edit_resource_btn").data("resource-capacity", $(this).data("resourceCapacity"));
            $("#edit_resource_btn").data("resource-proportions", $(this).data("resourceProportions"));
            $("#edit_resource_btn").data("resource-description", $(this).data("resourceDescription"));
        //edit car task
        } else if ($(this).data("target") == "#edit_car_task_modal") {
            $('#begin_time_datepicker').datetimepicker({format : "YYYY-MM-DD HH:mm:ss"});
            $('#end_time_datepicker').datetimepicker({format : "YYYY-MM-DD HH:mm:ss"});

             $("#edit_id").val($(this).data("carTaskId"));
             $("#edit_car_reg_num").val($(this).data("carTaskCarRegNum"));
             $("#edit_task_type").val($(this).data("carTaskTaskType"));
             $("#edit_begin_time").val($(this).data("carTaskBeginTime"));
             $("#edit_begin_user_name").val($(this).data("carTaskBeginUserName"));
             $("#edit_end_time").val($(this).data("carTaskEndTime"));
             $("#edit_end_user_name").val($(this).data("carTaskEndUserName"));

             $("#edit_car_reg_num").select2({
                width: '100%',
                language: "pl",
                dropdownParent: $("#edit_car_task_modal")
             });
             $("#edit_task_type").select2({
                width: '100%',
                language: "pl",
                dropdownParent: $("#edit_car_task_modal")
             });
             $("#edit_begin_user_name").select2({
                width: '100%',
                language: "pl",
                dropdownParent: $("#edit_car_task_modal")
             });
             $("#edit_end_user_name").select2({
                width: '100%',
                language: "pl",
                dropdownParent: $("#edit_car_task_modal")
             });
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
          $("#accept_delivery_select_resources").select2({
             width: '100%',
             language: "pl",
             dropdownParent: $("#accept_delivery_modal")
          });
          $("#accept_delivery_select_supplier").select2({
             width: '100%',
             language: "pl",
             dropdownParent: $("#accept_delivery_modal")
          });
      });
      
      //clear modal after closing
      $("#accept_delivery_modal").on("hidden.bs.modal", function () {
        $("#accept_delivery_resources").empty();
    });
    
    //accept delivery confirm resources
    $("#accept_delivery_resources_btn").click(function() {
        $("#accept_delivery_resources").empty();
        var resourceIds = [];
        var resourceNames = [];
        var selectedResources = $("#accept_delivery_select_resources").select2('data');
        for (var i=0; i<selectedResources.length; i++){
            resourceIds[i] = selectedResources[i].id;
            resourceNames[i] = selectedResources[i].text;
        };
        for (var i=0; i<resourceIds.length; i++) {
          $("#accept_delivery_resources").append(
            "<div class='row'>\
                <div class='ap_form_row'>\
                    <label class='control-label col-sm-7 horizontal_label' for='"+resourceNames[i]+"_field_accept'>"+resourceNames[i]+"</label>\
                    <div class='col-sm-3'>\
                        <button type='button' class='resource_increase btn_styled' id='"+resourceIds[i]+"_inc_btn_accept'>+</button>\
                        <button type='button' class='resource_decrease btn_styled' id='"+resourceIds[i]+"_dec_btn_accept'>-</button>\
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
    })

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
        
        //accept release
    $("#warehouse_release_btn").click(function() {
        $("#accept_release_select_resources").select2({
           width: '100%',
           language: "pl",
           dropdownParent: $("#warehouse_release_modal")
        });
    });

    //clear modal after closing
    $("#accept_release_modal").on("hidden.bs.modal", function () {
        $("#accept_release_resources").empty();
    });
    //warehouse release confirm resources
    $("#accept_release_resources_btn").click(function() {
        $("#accept_release_resources").empty();
        var resourceIds = [];
        var resourceNames = [];
        var selectedResources = $("#accept_release_select_resources").select2('data');
        for (var i=0; i<selectedResources.length; i++){
            resourceIds[i] = selectedResources[i].id;
            resourceNames[i] = selectedResources[i].text;
        };
        for (var i=0; i<resourceIds.length; i++) {
          $("#accept_release_resources").append(
            "<div class='row'>\
                <div class='form-group'>\
                    <label class='control-label col-sm-7 horizontal_label' for='"+resourceNames[i]+"_field_release'>"+resourceNames[i]+"</label>\
                    <div class='col-sm-3'>\
                        <button type='button' class='resource_increase btn_styled' id='"+resourceIds[i]+"_inc_btn_release'>+</button>\
                        <button type='button' class='resource_decrease btn_styled' id='"+resourceIds[i]+"_dec_btn_release'>-</button>\
                    </div>\
                    <div class='col-sm-2'>\
                        <input type='hidden' name='res_id[]' value="+resourceIds[i]+">\
                        <input id='"+resourceIds[i]+"_field_release' type='text' class='form-control horizontal_input' name='qty_field_release[]'\
                               value=0>\
                    </div>\
                </div>\
            </div>"
          )
        }
    })

    //warehouse release increase/decrease buttons
    $("#warehouse_release_modal").on("click", ".resource_increase", function() {
            var clickedBtnId = $(this).attr("id");
            var inputFieldId = clickedBtnId.replace("_inc_btn_release", "_field_release");
            var currVal = $("#"+inputFieldId).val();
            currVal++;
            $("#"+inputFieldId).val(currVal);
        });
    $("#warehouse_release_modal").on("click", ".resource_decrease", function() {
            var clickedBtnId = $(this).attr("id");
            var inputFieldId = clickedBtnId.replace("_dec_btn_release", "_field_release");
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
      $("#add_car_reg_num").select2({
          width: '100%',
          language: "pl",
          dropdownParent: $("#add_car_task_modal")
      });
      $("#add_car_task_type").select2({
          width: '100%',
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
