$(document).ready(function(){
	
	var walkInTransactionsSelected = [];
	
	var boxItemBreakdown = '';
	var boxSortWalkInTransactionsByDate = '';
	
	var boxUpdateExpense = '';
	var sortOrderForAllWalkInTransactions = 'DESC';
	var textDataForAllWalkInTransactions = '';
	var dateSortForAllWalkInTransactions = {};
	
	var tblname = 'tbl_expenses';
	var page = $('.page').val();
	
	var transactionSelectionOptionForWalkInTransactions = 0;

	showComponents('pagination','.displayAllWalkInTransactions',tblname, page, sortOrderForAllWalkInTransactions,0, textDataForAllWalkInTransactions,"",dateSortForAllWalkInTransactions);
	
	displayExpenseStatus();
	displayDateStatus();
	
	// ======================== Walk In Transactions Functions ============================
	
	$("body").delegate(".menu-refresh-expenses-list","click",function(){
		textDataForAllWalkInTransactions = "";
		var sortOrderForAllWalkInTransactions = 'DESC';
		dateSortForAllWalkInTransactions = {};
		walkInTransactionsSelected = [];
		$(".transaction").removeClass("success");
		$(".btn-edit-walk-in-transactions").addClass("disabled");
		$(".btn-remove-walk-in-transactions").addClass("disabled");
		$(".option-deselect-walk-in-transaction").addClass("disabled");
		$(".option-select-all-walk-in-transaction").removeClass("disabled");
		$(".option-sort-most-previous-walk-in-transaction").removeClass("disabled");
		$(".option-sort-most-recent-walk-in-transaction").addClass("disabled");
		$(".frm-search-walk-in-transaction .invoice-no").val("");
		showComponents('pagination','.displayAllWalkInTransactions',tblname, page, sortOrderForAllWalkInTransactions,0, textDataForAllWalkInTransactions,"",dateSortForAllWalkInTransactions);
		displayExpenseStatus();
		displayDateStatus();
	});
	
	$("body").delegate(".menu-select-single-walk-in-transaction","click",function(){
		transactionSelectionOptionForWalkInTransactions = 0;
		$(".option-select-single-walk-in-transaction").addClass("disabled");
		$(".option-select-several-walk-in-transaction").removeClass("disabled");
	});
	
	$("body").delegate(".menu-select-several-walk-in-transaction","click",function(){
		transactionSelectionOptionForWalkInTransactions = 1;
		$(".option-select-single-walk-in-transaction").removeClass("disabled");
		$(".option-select-several-walk-in-transaction").addClass("disabled");
	});
	
	$("body").delegate(".menu-sort-most-recent-walk-in-transaction","click",function(){
		sortOrderForAllWalkInTransactions = "DESC";
		$(".option-sort-most-previous-walk-in-transaction").removeClass("disabled");
		$(".option-sort-most-recent-walk-in-transaction").addClass("disabled");
		showComponents('pagination','.displayAllWalkInTransactions',tblname, page, sortOrderForAllWalkInTransactions,0, textDataForAllWalkInTransactions,"",dateSortForAllWalkInTransactions);
	});
	
	$("body").delegate(".menu-sort-most-previous-walk-in-transaction","click",function(){
		sortOrderForAllWalkInTransactions = "ASC";
		$(".option-sort-most-previous-walk-in-transaction").addClass("disabled");
		$(".option-sort-most-recent-walk-in-transaction").removeClass("disabled");
		showComponents('pagination','.displayAllWalkInTransactions',tblname, page, sortOrderForAllWalkInTransactions,0, textDataForAllWalkInTransactions,"",dateSortForAllWalkInTransactions);
	});
	
	$("body").delegate(".transaction","click",function(){
		id = $(this).attr("idt");
		
		if(transactionSelectionOptionForWalkInTransactions == 0){
			
			if($.inArray(id, walkInTransactionsSelected) != -1){
				walkInTransactionsSelected = [];
				$(".transaction").removeClass("success");	
			}else{
				walkInTransactionsSelected = [];
				walkInTransactionsSelected.push(id);
				$(".transaction").removeClass("success");
				$("#transaction" + walkInTransactionsSelected[0]).addClass("success");
			}
		}else{
			
			if($.inArray(id, walkInTransactionsSelected) != -1){
				position = walkInTransactionsSelected.indexOf(id);
				walkInTransactionsSelected.splice(position,1);
				$("#transaction"+id).removeClass("success");
			}else{
				walkInTransactionsSelected.push(id);
				$("#transaction"+id).addClass("success");
			}	
		}
		
		if(walkInTransactionsSelected.length > 0){
			$(".btn-edit-walk-in-transactions").removeClass("disabled");
			$(".btn-remove-walk-in-transactions").removeClass("disabled");
			
			$(".option-deselect-walk-in-transaction").removeClass("disabled");
			
			if($(".transaction").length == walkInTransactionsSelected.length){
				$(".option-select-all-walk-in-transaction").addClass("disabled");
			}else{
				$(".option-select-all-walk-in-transaction").removeClass("disabled");
			}
		}else{
			$(".btn-edit-walk-in-transactions").addClass("disabled");
			$(".btn-remove-walk-in-transactions").addClass("disabled");
			
			$(".option-deselect-walk-in-transaction").addClass("disabled");
		}
	});
	
	$(".btn-edit-walk-in-transactions").on("click",function(e){
		if(!$(this).attr("class").match(/disabled/i)){
			var id = walkInTransactionsSelected[0];
			var contentForm = ajax({contentForm : 1, expense_id : id},true);
			boxUpdateExpense = modalForm("Update Expense", contentForm);
			
		}
	});
	
	
	$("body").delegate(".btn-save-update-expense","click",function(){
		var desc = $.trim($(".exp-description").val());
		var date = $.trim($(".exp-date").val());
		var amount = $.trim($(".exp-amount").val());
		var id = $.trim($(".exp-id").val());
		
		if(desc != 0 && amount != 0 && date != 0){
			bootbox.confirm({
				title : "Update expense details",
				message : messageBody("question", "Are you sure to update selected expense details?"),
				callback : function(result){
					if(result){
						ajax({saveUpdateExpense : 1, id : id, desc : desc, amount : amount, date : date},true);
						location.reload();
					}
				}
			});		
		}else{
			bootbox.alert({
				title : "Incomplete expense details",
				message : messageBody("warning","Expense details is incomplete. Please complete the expense details.")
			});
		}
	});
	
	$("body").delegate(".btn-close-update-expense","click",function(){
		boxUpdateExpense.modal("hide");
	});
	
	$(".btn-remove-walk-in-transactions").click(function(){
		if(!$(this).attr("class").match(/disabled/i)){
			bootbox.confirm({
				title : "Remove expense details",
				message : messageBody("error","Removing expense details can never be undo anymore. Are you really sure to remove selected expense?"),
				callback : function(result){
					if(result){
						removeSelectedExpenses(walkInTransactionsSelected);
						location.reload();
					}
				}
			}); 
		}
	})
	
	$(".menu-select-all-walk-in-transaction").click(function(e){
		if($(".transaction").length > 0){
			$(".transaction").each(function(){
				id = $(this).attr("idt");
				if($.inArray(id, walkInTransactionsSelected) == -1){
					walkInTransactionsSelected.push(id);
				}
			})
			$(".transaction").addClass("success");
			$(".btn-edit-walk-in-transactions").removeClass("disabled");
			$(".btn-remove-walk-in-transactions").removeClass("disabled");
			$(".option-deselect-walk-in-transaction").removeClass("disabled");
			$(".option-select-all-walk-in-transaction").addClass("disabled");	
		}
	});
	
	$(".menu-deselect-walk-in-transaction").click(function(e){
		walkInTransactionsSelected = [];
		$(".transaction").removeClass("success");
		$(".btn-edit-walk-in-transactions").addClass("disabled");
		$(".btn-remove-walk-in-transactions").addClass("disabled");	
		$(".option-deselect-walk-in-transaction").addClass("disabled");
		$(".option-select-all-walk-in-transaction").removeClass("disabled");
	});
	
	$("body").delegate(".menu-sort-by-date-walk-in-transaction","click",function(){
		sortform = ajax({sortExpensesByDate : 1},true);
		boxSortWalkInTransactionsByDate = modalForm("Sort Expenses", sortform);
		$(".transaction-date-from").val(dateSortForAllWalkInTransactions.dateFrom)
		$(".transaction-date-to").val(dateSortForAllWalkInTransactions.dateTo)
	});
	
	$("body").delegate(".btn-close-sort-expenses-by-date-form","click",function(){
		boxSortWalkInTransactionsByDate.modal("hide");
	});
	
	$("body").delegate(".btn-sort-expenses-by-date-form","click",function(){
		dateSortForAllWalkInTransactions.dateFrom = $.trim($(".transaction-date-from").val());
		dateSortForAllWalkInTransactions.dateTo = $.trim($(".transaction-date-to").val());
		
		if(dateSortForAllWalkInTransactions.dateTo !=0 && dateSortForAllWalkInTransactions.dateFrom != 0){
			showComponents('pagination','.displayAllWalkInTransactions',tblname, page, sortOrderForAllWalkInTransactions,0, textDataForAllWalkInTransactions,"",dateSortForAllWalkInTransactions);
			boxSortWalkInTransactionsByDate.modal("hide");
			displayExpenseStatus();
			displayDateStatus();
		}else{
			bootbox.alert({
				title : "No dates specified",
				message : messageBody("warning","Please select date from and date to sort order transactions.")
			});
		}
	});
	
	$('body').delegate('.close-trasaction-form','click',function(){
		boxItemBreakdown.modal('hide');
	});
	
	function removeSelectedTransactions(transactionSelected){
		removeTransactions = ajax({removeAllSelectedTransactions : 1, transactionSelected : transactionSelected},true);
	}
	
	function removeSelectedExpenses(transactionSelected){
		removeTransactions = ajax({removeAllSelectedExpenses : 1, transactionSelected : transactionSelected},true);
	}
	
	function displayExpenseStatus(){
		$(".totalNoExpenses").html($(".no-of-expenses").html());
		$(".totalExpenses").html($(".total-expenses").html());
	}
	
	function displayDateStatus(){
		if($.trim($(".start-date").html()) != "none" && $.trim($(".end-date").html()) != "none"){
			$(".view-start-end-date").removeAttr("hidden");
		}else{
			$(".view-start-end-date").attr("hidden","hidden");
		}
		$(".startDate").html($.trim($(".start-date").html()) != "none" ? $(".start-date").html() : "-----------------------");
		$(".endDate").html($.trim($(".end-date").html()) != "none" ? $(".end-date").html() : "-----------------------");
	}
});
