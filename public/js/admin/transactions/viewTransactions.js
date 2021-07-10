$(document).ready(function(){
	
	var walkInTransactionsSelected = [];
	var existingTransactionsSelected = [];
	
	var boxPendingForm = '';
	var boxTransactionForm = '';
	var boxModifyPayment = '';
	var boxItemBreakdown = '';
	var boxSortExistingTransactionsByDate = '';
	var boxSortWalkInTransactionsByDate = '';
	var boxSortGeneralTransactionsByDate = '';
	
	var sortOrderForAllWalkInTransactions = 'DESC';
	var textDataForAllWalkInTransactions = '';
	var dateSortForAllWalkInTransactions = {};
	
	var sortOrderForAllExistingTransactions = 'DESC';
	var textDataForAllExistingTransactions = '';
	var dateSortForAllExistingTransactions = {};
	var dateSortForGeneralTransactions = {};
	
	var sortOrderForPendingTransactions = 'DESC';
	var textDataForPendingTransactions = '';
	
	var filterData = 'customer_id';
	var tblname = 'tbl_transactions';
	var page = $('.page').val();
	var customerName = '';
	var selector = '.customer-name';
	
	var transactionSelectionOptionForWalkInTransactions = 0;
	var transactionSelectionOptionForExistingTransactions = 0;
	
	showComponents('pagination','.displayAllWalkInTransactions',tblname, page, sortOrderForAllWalkInTransactions,0, textDataForAllWalkInTransactions,"",dateSortForAllWalkInTransactions);
	
	showComponents('pagination','.displayAllExistingTransactions',tblname, page, sortOrderForAllExistingTransactions,1, textDataForAllExistingTransactions, filterData, dateSortForAllExistingTransactions);
	displayExistingTransactionStatusSort();
	displayWalkInTransactionStatusSort();
	displayGeneralTransactionStatusSort();
	
	// ======================== Walk In Transactions Functions ============================
	
	$("body").delegate(".frm-search-walk-in-transaction","submit",function(e){
		e.preventDefault();
		textDataForAllWalkInTransactions = $.trim($(".frm-search-walk-in-transaction .invoice-no").val());
		if(textDataForAllWalkInTransactions != 0){
			showComponents('pagination','.displayAllWalkInTransactions',tblname, page, sortOrderForAllWalkInTransactions,0,textDataForAllWalkInTransactions);
			displayWalkInTransactionStatusSort();
			$('html, body').animate({scrollTop : 400},700);
			
			walkInTransactionsSelected = [];
			$(".btn-view-walk-in-transactions").addClass("disabled");
			$(".btn-remove-walk-in-transactions").addClass("disabled");
			$(".option-select-all-walk-in-transaction").removeClass("disabled");
			$(".option-deselect-walk-in-transaction").addClass("disabled");
		}
	});
	
	$("body").delegate(".btn-refresh-walk-in-transactions","click",function(){
		textDataForAllWalkInTransactions = "";
		walkInTransactionsSelected = [];
		$(".transaction").removeClass("success");
		$(".btn-view-walk-in-transactions").addClass("disabled");
		$(".btn-remove-walk-in-transactions").addClass("disabled");
		$(".option-deselect-walk-in-transaction").addClass("disabled");
		$(".option-select-all-walk-in-transaction").removeClass("disabled");
		$(".option-sort-most-previous-walk-in-transaction").removeClass("disabled");
		$(".option-sort-most-recent-walk-in-transaction").addClass("disabled");
		$(".frm-search-walk-in-transaction .invoice-no").val("");
		showComponents('pagination','.displayAllWalkInTransactions',tblname, page, sortOrderForAllWalkInTransactions,0, textDataForAllWalkInTransactions);
		displayWalkInTransactionStatusSort();
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
		showComponents('pagination','.displayAllWalkInTransactions',tblname, page, sortOrderForAllWalkInTransactions,0, textDataForAllWalkInTransactions);
	});
	
	$("body").delegate(".menu-sort-most-previous-walk-in-transaction","click",function(){
		sortOrderForAllWalkInTransactions = "ASC";
		$(".option-sort-most-previous-walk-in-transaction").addClass("disabled");
		$(".option-sort-most-recent-walk-in-transaction").removeClass("disabled");
		showComponents('pagination','.displayAllWalkInTransactions',tblname, page, sortOrderForAllWalkInTransactions,0, textDataForAllWalkInTransactions);
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
			$(".btn-view-walk-in-transactions").removeClass("disabled");
			$(".btn-remove-walk-in-transactions").removeClass("disabled");
			
			$(".option-deselect-walk-in-transaction").removeClass("disabled");
			
			if($(".transaction").length == walkInTransactionsSelected.length){
				$(".option-select-all-walk-in-transaction").addClass("disabled");
			}else{
				$(".option-select-all-walk-in-transaction").removeClass("disabled");
			}
		}else{
			$(".btn-view-walk-in-transactions").addClass("disabled");
			$(".btn-remove-walk-in-transactions").addClass("disabled");
			
			$(".option-deselect-walk-in-transaction").addClass("disabled");
		}
	});
	
	$(".btn-view-walk-in-transactions").on("click",function(e){
		if(!$(this).attr("class").match(/disabled/i)){
			if(walkInTransactionsSelected.length == 1){
				id = walkInTransactionsSelected[0];
				!(boxTransactionForm == '') ? boxTransactionForm.modal('hide') : '';
				boxItemBreakdown = modalForm('Transaction Breakdown',ajax({itemBreakdown : 1, id : id},true));
			}else{
				if(viewMultipleTransactions(walkInTransactionsSelected)) location = "?pg=admin&vw=viewSelectedTransactions&dir=60858ae3126c1c2c153d4a9b21f7aff9ac5aef2f";
			}
		}
	})
	
	$(".btn-remove-walk-in-transactions").click(function(){
		if(!$(this).attr("class").match(/disabled/i)){
			bootbox.confirm({
				title : "Remove Transaction",
				message : messageBody("error", "Removing transactions can never be undo anymore. Are you really sure to remove selected transaction/s?"),
				callback : function(result){
					if(result){
						removeSelectedTransactions(walkInTransactionsSelected);
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
			$(".btn-view-walk-in-transactions").removeClass("disabled");
			$(".btn-remove-walk-in-transactions").removeClass("disabled");
			$(".option-deselect-walk-in-transaction").removeClass("disabled");
			$(".option-select-all-walk-in-transaction").addClass("disabled");	
		}
	});
	
	$(".menu-deselect-walk-in-transaction").click(function(e){
		walkInTransactionsSelected = [];
		$(".transaction").removeClass("success");
		$(".btn-view-walk-in-transactions").addClass("disabled");
		$(".btn-remove-walk-in-transactions").addClass("disabled");	
		$(".option-deselect-walk-in-transaction").addClass("disabled");
		$(".option-select-all-walk-in-transaction").removeClass("disabled");
	});
	
	
	$("body").delegate(".menu-sort-by-date-walk-in-transaction","click",function(){
		sortform = ajax({sortWalkInTransactionByDate : 1},true);
		boxSortWalkInTransactionsByDate = modalForm("Sort Walk In Transactions", sortform);
		$(".transaction-date-from").val(dateSortForAllWalkInTransactions.dateFrom)
		$(".transaction-date-to").val(dateSortForAllWalkInTransactions.dateTo)
	});
	
	$("body").delegate(".btn-close-sort-walk-in-transaction-by-date-form","click",function(){
		boxSortWalkInTransactionsByDate.modal("hide");
	});
	
	$("body").delegate(".btn-sort-walk-in-transaction-by-date-form","click",function(){
		dateSortForAllWalkInTransactions.dateFrom = $.trim($(".transaction-date-from").val());
		dateSortForAllWalkInTransactions.dateTo = $.trim($(".transaction-date-to").val());
		
		if(dateSortForAllWalkInTransactions.dateTo !=0 && dateSortForAllWalkInTransactions.dateFrom != 0){
			showComponents('pagination','.displayAllWalkInTransactions',tblname, page, sortOrderForAllWalkInTransactions,0, textDataForAllWalkInTransactions,"",dateSortForAllWalkInTransactions);
			boxSortWalkInTransactionsByDate.modal("hide");
			displayWalkInTransactionStatusSort();
			$('html, body').animate({scrollTop : 400},700);
		}else{
			bootbox.alert({
				title : "No dates specified",
				message : messageBody("warning", "No dates has been specified. Please select date from and date to sort transactions.")
			});
		}
	});
	
	// ======================== Existing Transactions Functions =========================
	
	
	$("body").delegate(".existing-transaction","click",function(){
		
		id = $(this).attr("idet");
		
		if(transactionSelectionOptionForExistingTransactions == 0){
			
			if($.inArray(id, existingTransactionsSelected) != -1){
				existingTransactionsSelected = [];
				$(".existing-transaction").removeClass("success");	
			}else{
				existingTransactionsSelected = [];
				existingTransactionsSelected.push(id);
				$(".existing-transaction").removeClass("success");
				$("#existing-transaction" + existingTransactionsSelected[0]).addClass("success");
			}
		}else{
			
			if($.inArray(id, existingTransactionsSelected) != -1){
				position = existingTransactionsSelected.indexOf(id);
				existingTransactionsSelected.splice(position,1);
				$("#existing-transaction"+id).removeClass("success");
			}else{
				existingTransactionsSelected.push(id);
				$("#existing-transaction"+id).addClass("success");
			}	
		}
		
		if(existingTransactionsSelected.length > 0){
			$(".btn-view-existing-transactions").removeClass("disabled");
			$(".btn-remove-existing-transactions").removeClass("disabled");
			
			$(".option-deselect-existing-transaction").removeClass("disabled");
			
			if($(".existing-transaction").length == existingTransactionsSelected.length){
				$(".option-select-all-existing-transaction").addClass("disabled");
			}else{
				$(".option-select-all-existing-transaction").removeClass("disabled");
			}
		}else{
			$(".btn-view-existing-transactions").addClass("disabled");
			$(".btn-remove-existing-transactions").addClass("disabled");
			
			$(".option-deselect-existing-transaction").addClass("disabled");
		}
	});
	
	$("body").delegate(".menu-select-single-existing-transaction","click",function(){
		transactionSelectionOptionForExistingTransactions = 0;
		$(".option-select-single-existing-transaction").addClass("disabled");
		$(".option-select-several-existing-transaction").removeClass("disabled");
	});
	
	$("body").delegate(".menu-select-several-existing-transaction","click",function(){
		transactionSelectionOptionForExistingTransactions = 1;
		$(".option-select-single-existing-transaction").removeClass("disabled");
		$(".option-select-several-existing-transaction").addClass("disabled");
	});
	
	$("body").delegate(".menu-sort-most-recent-existing-transaction","click",function(){
		sortOrderForAllExistingTransactions = "DESC";
		$(".option-sort-most-previous-existing-transaction").removeClass("disabled");
		$(".option-sort-most-recent-existing-transaction").addClass("disabled");
		showComponents('pagination','.displayAllExistingTransactions',tblname, page, sortOrderForAllExistingTransactions,1, textDataForAllExistingTransactions, filterData);
		displayExistingTransactionStatusSort();
	});
	
	$("body").delegate(".menu-sort-most-previous-existing-transaction","click",function(){
		sortOrderForAllExistingTransactions = "ASC";
		$(".option-sort-most-previous-existing-transaction").addClass("disabled");
		$(".option-sort-most-recent-existing-transaction").removeClass("disabled");
		showComponents('pagination','.displayAllExistingTransactions',tblname, page, sortOrderForAllExistingTransactions,1, textDataForAllExistingTransactions, filterData);
		displayExistingTransactionStatusSort();
	});
	
	
	$(".btn-view-existing-transactions").on("click",function(e){
		if(!$(this).attr("class").match(/disabled/i)){
			if(existingTransactionsSelected.length == 1){
				id = existingTransactionsSelected[0];
				!(boxTransactionForm == '') ? boxTransactionForm.modal('hide') : '';
				boxItemBreakdown = modalForm('Transaction Breakdown',ajax({itemBreakdown : 1, id : id},true));
			}else{
				if(viewMultipleTransactions(existingTransactionsSelected)) location = "?pg=admin&vw=viewSelectedTransactions&dir=60858ae3126c1c2c153d4a9b21f7aff9ac5aef2f";
			}
		}
	})
	
	$("body").delegate(".menu-sort-by-date-existing-transaction","click",function(){
		sortform = ajax({sortExistingTransactionByDate : 1},true);
		boxSortExistingTransactionsByDate = modalForm("Sort Existing Transactions", sortform);
		$(".transaction-date-from").val(dateSortForAllExistingTransactions.dateFrom)
		$(".transaction-date-to").val(dateSortForAllExistingTransactions.dateTo)
	});
	
	$("body").delegate(".btn-close-sort-existing-transaction-by-date-form","click",function(){
		boxSortExistingTransactionsByDate.modal("hide");
	});
	
	$("body").delegate(".btn-sort-existing-transaction-by-date-form","click",function(){
		dateSortForAllExistingTransactions.dateFrom = $.trim($(".transaction-date-from").val());
		dateSortForAllExistingTransactions.dateTo = $.trim($(".transaction-date-to").val());
		
		if(dateSortForAllExistingTransactions.dateTo !=0 && dateSortForAllExistingTransactions.dateFrom != 0){
			showComponents('pagination','.displayAllExistingTransactions',tblname, page, sortOrderForAllExistingTransactions,1, textDataForAllExistingTransactions, filterData,dateSortForAllExistingTransactions);
			displayExistingTransactionStatusSort();
			boxSortExistingTransactionsByDate.modal("hide");
			$('html, body').animate({scrollTop : 400},700);
		}else{
			bootbox.alert({
				title : "No dates specified",
				message : messageBody("warning", "No dates has been specified. Please select date from and date to sort transactions.")
			});
		}
	});
	
	$(".btn-remove-existing-transactions").click(function(){
		if(!$(this).attr("class").match(/disabled/i)){
			bootbox.confirm({
				title : "Remove transaction",
				message : messageBody("error","Removing transactions can never be undo anymore. Are you really sure to remove selected transaction/s?"),
				callback : function(result){
					if(result){
						removeSelectedTransactions(existingTransactionsSelected);
						location.reload();		
					}
				}
			});
		}
	})
	
	$(".menu-select-all-existing-transaction").click(function(e){
		
		if($(".existing-transaction").length > 0){
			$(".existing-transaction").each(function(){
				id = $(this).attr("idet");
				if($.inArray(id,existingTransactionsSelected) == -1){
					existingTransactionsSelected.push(id);
				}
			})
			$(".existing-transaction").addClass("success");
			$(".btn-view-existing-transactions").removeClass("disabled");
			$(".btn-remove-existing-transactions").removeClass("disabled");
			$(".option-deselect-existing-transaction").removeClass("disabled");
			$(".option-select-all-existing-transaction").addClass("disabled");	
		}
	});
	
	$(".menu-deselect-existing-transaction").click(function(e){
		existingTransactionsSelected = [];
		$(".existing-transaction").removeClass("success");
		$(".btn-view-existing-transactions").addClass("disabled");
		$(".btn-remove-existing-transactions").addClass("disabled");
		$(".option-deselect-existing-transaction").addClass("disabled");
		$(".option-select-all-existing-transaction").removeClass("disabled");
	});
	
	$('body').delegate('.search-by','change',function(){
		filterData = $(this).val();
		if(filterData == 'customer_id'){
			$('.search-by-customer').show();
			$('.search-by-invoice-no').hide();
			$('.customer-name').val('');
			$('.invoice-no').val('');
			$('.btn-view-transaction-cutomer').removeClass('disabled');
			selector = '.customer-name';
		}else{
			$('.search-by-customer').hide();
			$('.search-by-invoice-no').show();
			$('.customer-name').val('');
			$('.invoice-no').val('');
			$('.btn-view-transaction-cutomer').addClass('disabled');
			selector = '.invoice-no';
		}
		
	});
	
	$('body').delegate('.frm-search-existing-transaction','submit',function(e){
		e.preventDefault();	
		
		textDataForAllExistingTransactions = $.trim($(".frm-search-existing-transaction " + selector).val());
		
		if(textDataForAllExistingTransactions != 0){
			showComponents('pagination','.displayAllExistingTransactions',tblname, page, sortOrderForAllExistingTransactions,1, textDataForAllExistingTransactions, filterData);
			displayExistingTransactionStatusSort();
			$(".btn-view-customer-account").removeClass("disabled");
			$('html, body').animate({scrollTop : 400},700);
			
			existingTransactionsSelected = [];
			$(".btn-view-existing-transactions").addClass("disabled");
			$(".btn-remove-existing-transactions").addClass("disabled");
			$(".option-select-all-existing-transaction").removeClass("disabled");
			$(".option-deselect-existing-transaction").addClass("disabled");
		}
	});
	
	
	
	$('body').delegate('.btn-view-customer-account','click',function(){
		customername = $(".frm-search-existing-transaction input.customer-name").val();
		textDataForAllExistingTransactions = $.trim($('.customer-name').val());
		
		if(!$(this).attr('class').match(/disabled/i)){
			if(textDataForAllExistingTransactions != 0){
				if(verifyIfHasTransactions(customername)){
					viewTransaction = ajax({viewTransaction : 1, customer_id : textDataForAllExistingTransactions},true);
					boxTransactionForm = modalForm(customername, viewTransaction);	
				}else{
					bootbox.alert({
						title : "Empty transaction",
						message :  messageBody("warning", "Selected customer doesn't have any transactions in the list.")
					});
				}
			}
		}
	});
	
	$('body').delegate('.btn-refresh-transactions-existing','click',function(){
		filterData = 'customer_id';
		existingTransactionsSelected = [];
		$('.search-by-customer').show();
		$('.search-by-invoice-no').hide();
		$('.search-by').val('customer_id');
		textDataForAllExistingTransactions = '';
		$('.customer-name').val('');
		$('.invoice-no').val('');
		$('.transaction-sort-order').val('DESC');
		selector = '.customer-name';
		$(".btn-view-customer-account").addClass("disabled");
		$(".btn-view-existing-transactions").addClass("disabled");
		$(".btn-remove-existing-transactions").addClass("disabled");
		dateSortForAllExistingTransactions = {};
		showComponents('pagination','.displayAllExistingTransactions',tblname, page, sortOrderForAllExistingTransactions,1, textDataForAllExistingTransactions, filterData,dateSortForAllExistingTransactions);
		displayExistingTransactionStatusSort();
	});
	
	$('body').delegate('.btn-close-customer-transaction-form','click',function(){
		boxTransactionForm.modal('hide');
		boxTransactionForm = '';
	});
	
	$('body').delegate('.transaction-sort-order-existing-transaction','change',function(){
		sortOrderForAllExistingTransactions = $(this).val();
		showComponents('pagination','.displayAllExistingTransactions',tblname, page, sortOrderForAllExistingTransactions,1, textDataForAllExistingTransactions, filterData);
	});
	
	$('body').delegate('.generate-purchase-order','click',function(){
		boxTransactionForm.modal('hide');
		bootbox.confirm({
			title : "Generate purchase order",
			message : messageBody("question", "Are you sure to generate purchase order for the seleceted transaction?"),
			callback : function(result){
				if(result){
					withDate = 0;
					generateTransactionPurchaseOrder = ajax({generateTransactionPurchaseOrder : 1, id : $(this).attr('idgpo'), withDate : withDate},true);
					bootbox.alert({
						title : "Purchase order generated",
						message : messageBody("info", "Purchase order for the seleceted transaction has been successfully generated. File has been saved at " + generateTransactionPurchaseOrder)
					});
					
				}
				
				viewTransaction = ajax({viewTransaction : 1, customer_id : textDataForAllExistingTransactions},true);
				boxTransactionForm = modalForm("View customer's transactions",viewTransaction);			
			}
		});
		
	});
	
	$('body').delegate('.btn-generate-statement','click',function(){
		boxTransactionForm.modal('hide');
		bootbox.confirm({
			title : "Generate statement of accounts",
			message : messageBody("question", "Are you sure to generate statement of accounts?"),
			callback : function(result){
				if(result){
					now = new Date();
					dateNow = (now.getMonth() + 1) + "-" + now.getDate() + "-" + now.getFullYear();
					generateStatement = ajax({generateStatement : 1, customer_id : $('.customer-name').val() },true);
					bootbox.alert({
						title : "Statement of account generated",
						message : messageBody("info", "Statement account of " + $('.customer-name').val() + " as of today(" + dateNow + ") has been successfully generated. File saved at: " + generateStatement)
					});
				}
				
				viewTransaction = ajax({viewTransaction : 1, customer_id : textDataForAllExistingTransactions},true);
				boxTransactionForm = modalForm("View customer's transactions",viewTransaction);		
			}
		});
	});
	
	$('body').delegate('.btn-modify-payment-form','click',function(){
		boxTransactionForm.modal('hide');
		customername = $(".frm-search-existing-transaction input.customer-name").val();
		getModificationPaymentForm = ajax({getModificationPaymentForm : 1, customer_id : textDataForAllExistingTransactions},true);
		boxModifyPayment = modalForm("Customer: " + customername,getModificationPaymentForm);
		
	});
	
	$("body").delegate(".btn-remove-payment","click",function(){
		var id = $(this).attr("idrp");
		
		$('.btn-close-customer-transaction-form').click();
		bootbox.confirm({
			title : "Remove payment details",
			message : messageBody("error","Removing payment details can never be undo again. Are you really sure to remove selected payment details?"),
			callback : function(result){
				if(result){

					ajax({removePayment : 1, id : id, customer_id : textDataForAllExistingTransactions},true);
					$("tr#payment-details" + id).remove();	
					refreshTransactionStatus();		
				}

				$('.btn-view-customer-account').click();
			}
		})
		
	});

	$('body').delegate('.btn-close-modify-payment-form','click',function(){
		boxModifyPayment.modal('hide');
		
		showComponents('pagination','.displayAllExistingTransactions',tblname, page, sortOrderForAllExistingTransactions,1, textDataForAllExistingTransactions, filterData);

		$(".btn-view-customer-account").click();
	})
	
	$('body').delegate('.txt-enter-cash','keyup',function(){
		cashEntered = $.trim($(this).val());
		
		cashEntered = cashEntered != 0 ? cashEntered.replace(",","") : 0;
		getModifiedPayment = ajax({getModifiedPayment : 1, customer_id : textDataForAllExistingTransactions ,cashEntered : cashEntered},true);
		parseInfo = getModifiedPayment.split("-");
		$('.totalCash').html(parseInfo[0]);
		$('.payment-change').html(parseInfo[1]);
		
	})
	
	$('body').delegate('.frm-modify-payment','submit',function(e){
		e.preventDefault();
		var amountEntered = $.trim($('.txt-enter-cash').val());
		var date = $.trim($(".date-paid").val());
		
		
		bootbox.confirm({
			title : "Pay unsettled account",
			message : messageBody("question", "Are you sure to modify this account?"),
			callback : function(result){
				if(result){
					savePaymentModifications = ajax({savePaymentModifications : 1, amountEntered : amountEntered, date : date, customer_id : textDataForAllExistingTransactions},true);	
				
					showComponents('pagination','.displayAllExistingTransactions',tblname, page, sortOrderForAllExistingTransactions,1, textDataForAllExistingTransactions, filterData);
						
					$('.btn-close-modify-payment-form').click();

					refreshTransactionStatus();	
				}
			}
		}); 
	})

	$('body').delegate('.btn-pay-all-transaction','click',function(){
		boxTransactionForm.modal('hide');
		bootbox.confirm({
			title : "Pay unsettled accounts",
			message : messageBody("question", "Are you sure to pay all pending transactions?"),
			callback : function(result){
				if(result){
					payAllTransactions = ajax({payAllTransactions : 1, customer_id : textDataForAllExistingTransactions},true);	
				}
				viewTransaction = ajax({viewTransaction : 1, customer_id : textDataForAllExistingTransactions},true);
				showComponents('pagination','.displayAllExistingTransactions',tblname, page, sortOrderForAllExistingTransactions,1, textDataForAllExistingTransactions, filterData);
				boxTransactionForm = modalForm("View customer's transactions",viewTransaction);		
			}
		});
	});
	
	$('body').delegate('.btn-remove-transaction','click',function(){
		id = $(this).attr('idrt');
		
		bootbox.confirm({
			title : "Remove transaction",
			message : messageBody("error", "Removing transaction can never be undo anymore. Are you really sure to remove selected transaction?"),
			callback : function(result){
				if(result){
					removeTransaction = ajax({removeTransaction : 1, id  : id},true);
					showComponents('pagination','.displayAllExistingTransactions',tblname, page, sortOrderForAllExistingTransactions,1, textDataForAllExistingTransactions, filterData);
					refreshTransactionStatus();
					if(textDataForAllExistingTransactions != ''){
						refreshCustomerTransactions(textDataForAllExistingTransactions);
						refreshTransactionCustomerStatus(textDataForAllExistingTransactions);
					}		
				}
			}
		});
	})
	
	// ======================= Administrator Functions ====================================
	
	$('body').delegate('.btn-view-pending-transactions','click',function(){
		pendingTransactions = ajax({pendingTransactions : 1},true);
		boxPendingForm = modalForm('Pending Transactions',pendingTransactions);
		showComponents('pagination','.displayPendingTransactions',tblname,page,sortOrderForPendingTransactions,2,textDataForPendingTransactions);
	});
	
	$('body').delegate('.btn-mark-as-paid','click',function(){
		id = $(this).attr('idmap');
		bootbox.confirm({
			title : "Mark paid transaction",
			message : messageBody("question", "Marking transaction as paid can never be change anymore. Are you sure to mark selected transaction as paid?"),
			callback : function(result){
				if(result){
					markAsPaid = ajax({markAsPaid : 1, id : id},true);
					showComponents('pagination','.displayPendingTransactions',tblname,page,sortOrderForPendingTransactions,2,textDataForPendingTransactions);
					refreshTransactionStatus();	
				}
			}
		});
	});
	
	$('body').delegate('.txt-pending-transaction-search','keyup',function(){
		textDataForPendingTransactions = $.trim($(this).val());
		if(sortOrderForPendingTransactions != 0){
			showComponents('pagination','.displayPendingTransactions',tblname,page,sortOrderForPendingTransactions,2,textDataForPendingTransactions);	
		}	
	});
	
	$('body').delegate('.pending-transaction-sort-order','change',function(){
		sortOrderForPendingTransactions = $.trim($(this).val());
		showComponents('pagination','.displayPendingTransactions',tblname,page,sortOrderForPendingTransactions,2,textDataForPendingTransactions);	
		
	});
	
	$('body').delegate('.btn-close-pending-transaction-form','click',function(){
		boxPendingForm.modal('hide');
		return false;
	});
	
	$('body').delegate('.btn-view-transaction-breakdown','click',function(){
		id = $(this).attr('idvtb');
		!(boxTransactionForm == '') ? boxTransactionForm.modal('hide') : '';
		boxItemBreakdown = modalForm('Transaction Breakdown',ajax({itemBreakdown : 1, id : id},true));
	});
	
	$('body').delegate('.btn-print-as-delivery-report','click',function(){
		var id = $(this).attr("id");
		
		bootbox.confirm({
			title : "Print delivery report",
			message : messageBody("question", "Are you sure to print transaction as delivery report?"),
			callback : function(result){
				if(result){
					generateOutput(id, page, '', 'dr', "existing_transaction");
				}
			}
		});
	});
	
	$('body').delegate('.btn-print-as-invoice','click',function(){
		id = $(this).attr("id");
		
		bootbox.confirm({
			title : "Print transaction invoice",
			message : messageBody("question", "Are you sure to print transaction as invoice?"),
			callback : function(result){
				if(result){
					
					generateOutput(id, page,'', 'invoice', "existing_transaction")
				}
			}
		});
	});
	
	$('body').delegate('.close-trasaction-form','click',function(){
		boxItemBreakdown.modal('hide');
		if(boxTransactionForm != ''){
			viewTransaction = ajax({viewTransaction : 1, customer_id : textDataForAllExistingTransactions},true);
			boxTransactionForm = modalForm("View customer's transactions",viewTransaction);			
		}
		return false;
	});
	
	$("body").delegate(".btn-sort-general-transactions","click",function(){
		var content = ajax({sortGeneralTransactionByDate : 1},true);
		boxSortGeneralTransactionsByDate = modalForm("Sort General Transaction Status", content);
		$(".general-transaction-date-from").val(dateSortForGeneralTransactions.dateFrom)
		$(".general-transaction-date-to").val(dateSortForGeneralTransactions.dateTo)
	});
	
	$("body").delegate(".btn-close-sort-general-transaction-by-date-form","click",function(){
		boxSortGeneralTransactionsByDate.modal("hide");
	});
	
	$("body").delegate(".btn-sort-general-transaction-by-date-form","click",function(){
		
		dateSortForGeneralTransactions.dateFrom = $.trim($(".general-transaction-date-from").val());
		dateSortForGeneralTransactions.dateTo = $.trim($(".general-transaction-date-to").val());
		
		if(dateSortForGeneralTransactions.dateTo !=0 && dateSortForGeneralTransactions.dateFrom != 0){
			displayGeneralTransactionStatusSort();
			boxSortGeneralTransactionsByDate.modal("hide");
			$('html, body').animate({scrollTop : 400},700);
		}else{
			bootbox.alert({
				title : "No dates specified",
				message : messageBody("warning", "No dates has been specified. Please select date from and date to sort transactions.")
			});
		}
	});
	
	function verifyIfTransactionSelected(){
		verifyTransactionSelected = ajax({verifyTransactionSelected : 1},true);
		return verifyTransactionSelected > 0 ? true : false;
	}
	
	function removeSelectedTransactions(transactionSelected){
		removeTransactions = ajax({removeAllSelectedTransactions : 1, transactionSelected : transactionSelected},true);
	}
	
	function verifyIfHasTransactions(customerName){
		isExist = false;
		$(".existing-transaction td:nth-of-type(3)").each(function(){
			if(customerName == this.innerHTML) isExist = true;
		})
		return isExist;
	}
	
	function displayExistingTransactionStatusSort(){
		$(".no-of-days-existing-transactions").html($(".noOfDaysExistingTransaction").html());
		$(".expected-amount-existing-transactions").html($(".expectedAmountExistingTransaction").html());
		$(".actual-amount-existing-transactions").html($(".actualAmountExistingTransaction").html());
	}
	
	function displayGeneralTransactionStatusSort(){
		
		generalTransactionStatus = ajax({generalTransactionStatus : 1, dateSortForGeneralTransactions : dateSortForGeneralTransactions},true);
		generalTransactionStatus = jQuery.parseJSON(generalTransactionStatus);
		
		$(".totalTransactions").html(generalTransactionStatus[2]);
		$(".totalPaidTransactions").html(generalTransactionStatus[3]);
		$(".totalPendingTransactions").html(generalTransactionStatus[4]);
		$(".expectedCash").html(generalTransactionStatus[0]);
		$(".totalCash").html(generalTransactionStatus[1]);
	}
	
	function displayWalkInTransactionStatusSort(){
		$(".no-of-days-walk-in-transactions").html($(".noOfDaysWalkInTransaction").html());
		$(".expected-amount-walk-in-transactions").html($(".expectedAmountWalkInTransaction").html());
		$(".actual-amount-walk-in-transactions").html($(".actualAmountWalkInTransaction").html());
	}
})
