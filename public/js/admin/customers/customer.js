$(document).ready(function(){
	
	var boxEditCustomerForm = null;
	var textDataForAllCustomers = "";
	var sortOrderForAllCustomers = "ASC";
	
	var customerSelected = "";
	
	showComponents('pagination','.displayAllCustomers',"tbl_customers","",sortOrderForAllCustomers,"",textDataForAllCustomers);
	
	$("body").delegate(".frm-add-customer","submit",function(e){
		e.preventDefault();
		
		formdata = new FormData($(this)[0]);
		formdata.append("addCustomer", 1);
		
		if(verifyCustomerInput("add")){
			bootbox.confirm({
				title : "Save new customer",
				message : messageBody("question", "Are you sure to save new customer details?"),	
				callback : function(result){
					if(result){
						ajax(formdata,true,"","","post");
						location.reload();
					}
				}
			});
		}else{
			bootbox.alert({
				title : "No customer name",
				message : messageBody("warning", "No customer name. Please enter atleast the customer's name in order to save new customer details.")
			});
		}
	});
	
	$("body").delegate(".btn-update-customer","click",function(){
		id = customerSelected;
		if(!$(this).attr("class").match(/disabled/i)){
			getEditCustomerForm = ajax({editCustomerForm : 1, id : id},true);
			boxEditCustomerForm = modalForm("Edit Customer", getEditCustomerForm);	
		}
	});
	
	$("body").delegate(".btn-close-edit-customer-form","click",function(){
		boxEditCustomerForm.modal("hide");
		boxEditCustomerForm = null;
	});
	
	$("body").delegate(".frm-edit-customer","submit",function(e){
		e.preventDefault();
		
		idec = $(this).attr("id");
		
		formdata = new FormData($(this)[0]);
		formdata.append("editCustomer", 1);
		formdata.append("id", id);
		
		if(verifyCustomerInput("edit")){
			bootbox.confirm({
				title : "Update customer details",
				message : messageBody("question", "Are you sure to update selected customer details?"),	
				callback : function(result){
					if(result){
						ajax(formdata,true,"","","post");
						location.reload();
					}
				}
			});
		}else{
			bootbox.alert({
				title : "No customer name",
				message : messageBody("warning", "No customer name. Please enter atleast the customer's name in order to save changes to the selected customer details.")
			});
		}
	});
	
	$("body").delegate(".btn-remove-customer","click",function(){
		var id = customerSelected;

		if(!$(this).attr("class").match(/disabled/i)){
			if(!verifyCustomerIfHasTransactionsRecord(id)){
				bootbox.confirm({
					title : "Remove customer details",
					message : messageBody("question", "Are you sure to remove customer details?"),	
					callback : function(result){
						if(result){
							ajax({removeCustomer : 1, id: id},true);
							location.reload()
						}
					}
				});
			}else{
				bootbox.confirm({
					title : "Remove customer details",
					message : messageBody("question", "Selected customer has transactions record in the system. Would you still want to remove selected customer?"),	
					callback : function(result){
						if(result){
							ajax({removeCustomer : 1, id: id},true);
							location.reload()
						}
					}
				});
			}
		}
	});
	
	function verifyCustomerIfHasTransactionsRecord(id){
		verify = ajax({verifyCustomerIfHasTransactionsRecord : 1, id : id},true);
		console.log(verify);
		return verify == 1 ? true : false;
	}
	
	$("body").delegate(".frm-search-customers","submit",function(e){
		e.preventDefault();
		textDataForAllCustomers = $.trim($(".customer-name",this).val());
		showComponents('pagination','.displayAllCustomers',"tbl_customers","",sortOrderForAllCustomers,"",textDataForAllCustomers);
	});
	
	$("body").delegate(".btn-refresh-customers","click",function(){
		textDataForAllCustomers = "";
		$(".customer-name").val("");
		showComponents('pagination','.displayAllCustomers',"tbl_customers","",sortOrderForAllCustomers,"",textDataForAllCustomers);
	});
	
	$("body").delegate(".select-customer","click",function(){
		id = $(this).attr("idsc");
		
		if(customerSelected == id){
			customerSelected = "";
			$(".select-customer").removeClass("success");
			$(".btn-update-customer").addClass("disabled");
			$(".btn-remove-customer").addClass("disabled");
		}else{
			customerSelected = id;
			$(".btn-update-customer").removeClass("disabled");
			$(".btn-remove-customer").removeClass("disabled");
			$(".select-customer").removeClass("success");
			$("#select-customer" + customerSelected).addClass("success");	
		}
	});
	
	$("body").delegate(".menu-sort-customer-z-to-a","click",function(){
		sortOrderForAllCustomers = "DESC";
		$(".option-sort-customer-a-to-z").removeClass("disabled");
		$(".option-sort-customer-z-to-a").addClass("disabled");
		showComponents('pagination','.displayAllCustomers',"tbl_customers","",sortOrderForAllCustomers,"",textDataForAllCustomers);
		
		if(customerSelected != ""){
			$(".btn-update-customer").removeClass("disabled");
			$(".btn-remove-customer").removeClass("disabled");
			$("#select-customer" + customerSelected).addClass("success");	
		}
	});
	
	$("body").delegate(".menu-sort-customer-a-to-z","click",function(){
		sortOrderForAllCustomers = "ASC";
		$(".option-sort-customer-a-to-z").addClass("disabled");
		$(".option-sort-customer-z-to-a").removeClass("disabled");
		showComponents('pagination','.displayAllCustomers',"tbl_customers","",sortOrderForAllCustomers,"",textDataForAllCustomers);
		
		if(customerSelected != ""){
			$(".btn-update-customer").removeClass("disabled");
			$(".btn-remove-customer").removeClass("disabled");
			$("#select-customer" + customerSelected).addClass("success");	
		}
	});
	
	function verifyCustomerInput(action){
		
		action = (action !== "undefined") ? action : "add";
		field = (action == "add") ? ".txt-customer-name" : ".txt-edit-customer-name";
		name = $.trim($(field).val());
		
		hasName = (name != 0) ? true : false;
		
		if(hasName != false){
			return true;
		}else{
			return false;
		}
	}
})