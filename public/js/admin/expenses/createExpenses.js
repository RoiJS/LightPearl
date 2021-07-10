$(document).ready(function(){
	
	var boxAddExpense = "";
	
	//================================================ Create Expenses ==========================================
	
	$("body").delegate(".btn-add-expense","click",function(){
		var addExpenseForm = ajax({addExpenseForm : 1},true);
		boxAddExpense = modalForm("Add Expense", addExpenseForm);
	});
	
	$("body").delegate(".btn-close-add-expense","click",function(){
		boxAddExpense.modal("hide");
	});
	
	$("body").delegate(".btn-add-expense-field","click",function(){
		var len = $(".no-of-expense-field").val();
		var content = "";
		var tr_length = $(".expense").length;
		
		for(var i = 1; i <= len; i++){
			
			content += '<tr class="expense" id="expense' + (tr_length + i) + '">' +
						'<td><input type="text" class="exp-description" placeholder="Please enter description&hellip;"></td>' + 
						'<td><input type="number" class="exp-amount" placeholder="Enter amount&hellip;" type="number" min=0 step="0.01" onchange="if(this.value < 0){this.value = 0};"></td>' +
						
						'<td><button class="btn btn-danger btn-remove-expense" id="' + (tr_length + i) + '"><i class="fa fa-remove"></i></button></td>' +
					'</tr>';
		}
		
		$("tbody.list-of-expenses").append(content);
		$(".no-of-expense-field").val("");
	});
	
	$("body").delegate(".btn-save-expense","click",function(){
		
		var date = $(".expense-date").val();
		var expenses = [];
		
		$(".expense").each(function(i, e){
			var id = $(this).attr("id");
			var desc = $("#" + id + " input.exp-description").val();
			var amount = $("#" + id + " input.exp-amount").val();
			
			if(desc != "" && amount != ""){
				expenses[i] = {desc : desc, amount : amount};
			}
		});
		
		if(expenses.length > 0){
			if(date != ""){
				bootbox.confirm({
					title : "Save new expense details",
					message : messageBody("question", "Are you sure to save new expense?"),
					callback : function(result){
						if(result){
							var saveNewExpense = ajax({saveNewExpense : 1, date : date, expenses : expenses},true);
							bootbox.alert({
								title : "New expense saved",
								message : messageBody("info","New expense details has been successfully saved&hellip;"), 
								callback : function(){
									location.reload();		
								}
							});
						}
						
					}
				});
			}else{				
				bootbox.alert({
					title : "No dates specified",
					message : messageBody("warning","No date has been specified. Please select date above&hellip;")
				});
			}
		}else{
			bootbox.alert({
				title : "Missing expense date",
				message : messageBody("warning","No expense has been entered. Please enter atleast one expense information before saving&hellip;")
			});
		}
	});
	
	$("body").delegate(".btn-remove-expense","click", function(){
		var id = $(this).attr("id");
		$("#expense" + id).remove();
	});
})

