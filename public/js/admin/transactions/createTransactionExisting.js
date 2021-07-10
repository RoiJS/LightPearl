$(document).ready(function(){
	
	//================================================ Create Transactions ==========================================
	var boxSeeItems = '';
	var boxTransaction = '';
	var boxTransactionSummary = '';
	var tblname = 'tbl_items';
	var page = $('.page').val();
	var pageNo = 0;
	var sortOrder = 'DESC';
	var textData = '';
	var transactionStatus = 1;
	var inputCustomerName = 1;
	var selectedItem = "";
	
	var page = $('.page').val();
	resetItemBreakdown();
	
	var isFrmTransactionDetailsSubmit = "";
	
	//================== Select Customer ==================================
	
	$('body').delegate('.select-customer','submit',function(e){
		e.preventDefault();
		
		var customer_id = $.trim($('.customer-name').val());
		
		if(customer_id != 0){
			$('.select-existing-customer').hide();
			$('.display-selected-customer').show();
			
			var transactionInfo = ajax({transactionInfo : 1, customer_id : customer_id},true);
			info = jQuery.parseJSON(transactionInfo);
			name = info[0].substr(0,20);
			name += info[0].length > 20 ? '&hellip;' : '';
			$('.selected-customer-name').html(name);
			$('.customer-name-selected').val(info[0]);
			$('.date-last-transaction').html(info[1]);
			$('.total-transaction').html(info[2]);
			
			showComponents('itemBreakdownExisting','.displayItemBreakdown');
			$("input#select-items").focus();
			
			//getSelectItemForm(customer_id)
			$('html, body').animate({scrollTop : 300},700);
		}else{
			bootbox.alert({
				title : "No customer selecter",
				message : messageBody("warning", "No customer has been selected. Select customer first before starting the transaction&hellip;"), 
				callback : function(){
					$("input#customer-name").focus();
				}
			});
		}
	});

	function getSelectItemForm(customer_id){
		showComponents('selectItemForm','.frm-select-items',"","","", customer_id);
	}
	
	$('body').delegate('.btn-select-other-customer','click',function(){
		$(".customer-name").val("");
		$('.select-existing-customer').show();
		$('.display-selected-customer').hide();
		document.getElementById("customer-name").focus();
	});
	
	showComponents('itemBreakdownExisting','.displayItemBreakdown');
	$('body').delegate('.btn-see-items','click',function(){
		selectedItem = "";
		itemList = ajax({itemList : 1},true);
		boxSeeItems = modalForm('Item List',itemList);
		showComponents('pagination','.displayItemList',tblname , page, sortOrder, 3, textData);
	});
	
	$('body').delegate('.close-itemList-form','click',function(){
		selectedItem = "";
		boxSeeItems.modal('hide');
	});
	
	
	$('body').delegate('.frm-search-item','submit',function(e){
		e.preventDefault();
		textData = $.trim($($(".txt-item-search",this)).val());
		if(textData != 0){
			selectedItem = "";
			$(".btn-update-item").addClass("disabled");
			$(".btn-pick-item").addClass("disabled");
			showComponents('pagination','.displayItemList',tblname , page, sortOrder, 3, textData);	
		}
	});
	
	$('body').delegate('.btn-refresh-item-search','click',function(){
		$(".frm-search-item .txt-item-search").val("");
		textData = "";
		selectedItem = "";
		$(".btn-update-item").addClass("disabled");
		$(".btn-pick-item").addClass("disabled");
		showComponents('pagination','.displayItemList',tblname , page, sortOrder, 3, textData);	
	});
	
	$("body").delegate(".menu-sort-items-create-transactions-z-to-a","click",function(){
		sortOrder = "DESC";
		$(".option-sort-items-create-transactions-a-to-z").removeClass("disabled");
		$(".option-sort-items-create-transactions-z-to-a").addClass("disabled");
		showComponents('pagination','.displayItemList',tblname , page, sortOrder, 3, textData);	
		
		if(selectedItem != ""){
			$(".btn-update-item").removeClass("disabled");
			$(".btn-pick-item").removeClass("disabled");
			$("#pick-item" + selectedItem).addClass("success");	
		}
	});
	
	$("body").delegate(".menu-sort-items-create-transactions-a-to-z","click",function(){
		sortOrder = "ASC";
		$(".option-sort-items-create-transactions-a-to-z").addClass("disabled");
		$(".option-sort-items-create-transactions-z-to-a").removeClass("disabled");
		showComponents('pagination','.displayItemList',tblname , page, sortOrder, 3, textData);
		
		if(selectedItem != ""){
			$(".btn-update-item").removeClass("disabled");
			$(".btn-pick-item").removeClass("disabled");
			$("#pick-item" + selectedItem).addClass("success");	
		}
	});
	
	$("body").delegate(".pick-item","click",function(){
		id = $(this).attr("idpi");
		
		if(selectedItem == id){
			selectedItem = "";
			$(".pick-item").removeClass("success");
			$(".btn-update-item").addClass("disabled");
			$(".btn-pick-item").addClass("disabled");
		}else{
			selectedItem = id;
			$(".btn-update-item").removeClass("disabled");
			$(".btn-pick-item").removeClass("disabled");
			$(".pick-item").removeClass("success");
			$("#pick-item" + selectedItem).addClass("success");	
		}
	});
	
	
	$('body').delegate('.btn-pick-item','click',function(){
		id = selectedItem;
		
		customer = $('.customer-name-selected').val();
		 if(customer != ''){
			if(!verifyIfZeroQuantity()){
				if(id != ''){
					pickItem = ajax({pickItem : 1 , id: id},true);
					
					if(pickItem == 0){
						bootbox.alert({
							title : "Insufficient stocks",
							message : messageBody("warning", "Selected item does not have enough stocks. Please update its stocks field."), 
							callback : function(){
								$("input#select-items").focus();
							}
						});
					}else{
						refreshItemBreakdownExisting();
						$('.select-items').val('');
						boxSeeItems.modal('hide');
						if(verifyIfItemNotAlreadyExistInActiveTransactionBreakdown(id)){
							document.getElementById("add-qty").focus();	
						}
					}
				}else{
					bootbox.alert({
						title : "No item selected",
						message : messageBody("warning", "No item has been selected. Please select an item from the list."), 
						callback : function(){
							$("input#select-items").focus();
						}
					});
				}	
			}else{
				bootbox.alert({
					title : "Missing item quantity",
					message : messageBody("warning", "Enter quantity for the recently selected item first before selecting another item.")
				});
			}
		 }else{
			bootbox.alert({
				title : "No customer selected",
				message : messageBody("warning", "No customer has been selected. Select customer first before starting the transaction&hellip;"), 
				callback : function(){
					$('.select-items').val('');
					$("input#select-items").focus();
					$("input#customer-name").focus();
				}
			});
		 }
		
	})
	
	$('body').delegate('.item-select','submit',function(e){
		e.preventDefault();
		id = $('.select-items').val();
		
		customer = $('.customer-name-selected').val();
		 if(customer != ''){
			if(!verifyIfZeroQuantity()){
				if(id != ''){
					pickItem = ajax({pickItem : 1 , id: id},true);
					if(pickItem == 0){
						bootbox.alert(messageBody("warning", "Selected item does not have enough stocks. Please update its stocks field."), function(){
							$('.select-items').val('');
							$("input#select-items").focus();
						});
					}else{
						refreshItemBreakdownExisting();
						$('.select-items').val('');
						if(verifyIfItemNotAlreadyExistInActiveTransactionBreakdown(id)){
							document.getElementById("add-qty").focus();	
						}
					}
				}else{
					bootbox.alert(messageBody("warning", "No item has been selected. Please select an item from the list."), function(){
					$("input#select-items").focus();
				});
				}	
			}else{
				bootbox.alert(messageBody("warning", "Enter quantity for the recently selected item first before selecting another item."));
			}
		 }else{
			bootbox.alert(messageBody("warning", "No customer has been selected. Select customer first before starting the transaction&hellip;"), function(){
				$('.select-items').val('');
				$("input#select-items").focus();
				$("input#customer-name").focus();
			});
		 }
		
	});
	
	$('body').delegate('.frm-add-qty, .frm-add-item-price','submit',function(e){
		e.preventDefault();
		id = $('.row-item-breakdown').attr('idrib');
		qty = $.trim($('#row-item-breakdown'+id + " input.add-qty").val());
		price = $.trim($('#row-item-breakdown'+id +" input.add-item-price").val()).replace(",","");
		
		if(qty != 0 && price != 0){
			finalizedItem = ajax({finalizedItem : 1, id : id, qty : qty, price : price},true);
			if(finalizedItem == 1){
				refreshItemBreakdownExisting();
				$("input#select-items").focus();
			}else{
				bootbox.alert({
					title : "Insufficient stocks",
					message : messageBody("warning", finalizedItem), 
					callback : function(){
						$("input#add-qty").focus();
					}
				});
			}
		}else{
			if(qty == 0 && price == 0){
				bootbox.alert({
					title : "Missing quantity and unit price",
					message : messageBody("warning", "Please enter quantity and unit price for the selected item."), 
					callback : function(){
						document.getElementById("add-qty").focus();
					}	
				});
			}else if(qty == 0){
				bootbox.alert({
					title : "Missing quantity",
					message : messageBody("warning", "Please enter quantity for the selected item."), 
					callback : function(){
						$("input#add-qty").focus();
					}
				});
			}else if(price == 0){
				bootbox.alert({
					title : "Missing unit price",
					message :  messageBody("warning", "Please input unit price for the selected item."), 
					callback : function(){
						$("input#add-item-price").focus();
					}
				});
			}
		}
	})
	
	$('body').delegate('.btn-add-qty','click',function(){
		id = $('.row-item-breakdown').attr('idrib');
		qty = $.trim($('#row-item-breakdown'+id + " input.add-qty").val());
		price = $.trim($('#row-item-breakdown'+id +" input.add-item-price").val());
		
		if(qty != 0 && price != 0){
			finalizedItem = ajax({finalizedItem : 1, id : id, qty : qty, price : price},true);
			if(finalizedItem == 1){
				refreshItemBreakdownExisting();
				document.getElementById("select-items").focus();
			}else{
				bootbox.alert({
					title : "Insufficient stocks",
					message : messageBody("warning", finalizedItem), 
					callback : function(){
						$("input#add-qty").focus();
					}
				});
			}
		}else{
			if(qty == 0 && price == 0){
				bootbox.alert({
					title : "Missing quantity and unit price",
					message : messageBody("warning", "Please enter quantity and unit price for the selected item."), 
					callback : function(){
						document.getElementById("add-qty").focus();
					}
				});
			}else if(qty == 0){
				bootbox.alert({
					title : "Missing quantity",
					message : messageBody("warning", "Please enter quantity for the selected item."), 
					callback : function(){
						$("input#add-qty").focus();
					}
				});
			}else if(price == 0){
				bootbox.alert({
					title : "Missing unit price",
					message :  messageBody("warning", "Please input unit price for the selected item."), 
					callback : function(){
						$("input#add-item-price").focus();
					}
				});
			}
		}
	});
	
	$('body').delegate('.btn-update-item-breakdown','click',function(){
		id = $(this).attr('id');
		refreshItemBreakdownExisting();
		$('#row-item-breakdown'+id + " div.div-add-item-qty").hide()
		$('#row-item-breakdown'+id + " div.div-update-qty").show()
		
		$('#row-item-breakdown'+id + " div.div-add-display-item-price").hide()
		$('#row-item-breakdown'+id + " div.div-update-item-price").show()
		
		$('#row-item-breakdown'+id + " div.add-option-btn").hide()
		$('#row-item-breakdown'+id + " div.update-option-btn").show();
		
		document.getElementById("update-qty").focus();
	});
	
	$('body').delegate('.frm-update-qty, .frm-update-item-price','submit',function(e){
		e.preventDefault();
		id = $(this).attr('id');
		newQty = $('#row-item-breakdown'+id + " input.update-qty").val();
		newPrice= $('#row-item-breakdown'+id + " input.update-item-price").val();
		
		if(newQty != 0 && newPrice != 0){
			updateTransactionItem = ajax({updateTransactionItem: 1, id : id, qty : newQty ,price : newPrice},true);
			
			if(updateTransactionItem == 1 || updateTransactionItem == 0){
				refreshItemBreakdown();
				document.getElementById("select-items").focus();
			}else{
				bootbox.alert({
					title : "Insufficient stocks",
					message : messageBody("warning", updateTransactionItem),
					callback : function(){
						$("input#update-qty").focus();	
					}
				});
			}
		}else{
			if(newQty == 0 && newPrice == 0){
				bootbox.alert({
					title : "Missing quantity and unit price",
					message : messageBody("warning", "Please enter quantity and unit price for the selected item."), 
					callback : function(){
						$("input#update-qty").focus();
					}
				});
			}else if(newQty == 0){
				bootbox.alert({
					title : "Missing quantity",
					message : messageBody("warning", "Please enter quantity for the selected item."), 
					callback : function(){
						$("input#update-qty").focus();
					}
				});
			}else if(newPrice == 0){
				bootbox.alert({
					title : "Missing unit price",
					message : messageBody("warning", "Please enter unit price for the selected item."), 
					callback : function(){
						$("input#update-item-price").focus();
					}
				});
			}
		}
	});
	
	$('body').delegate('.btn-save-update-item-price','click',function(){
		id = $(this).attr('id');
		newQty = $('#row-item-breakdown'+id + " input.update-qty").val();
		newPrice= $('#row-item-breakdown'+id + " input.update-item-price").val();
		
		if(newQty != 0 && newPrice != 0){
			updateTransactionItem = ajax({updateTransactionItem: 1, id : id, qty : newQty ,price : newPrice},true);
			
			if(updateTransactionItem == 1 || updateTransactionItem == 0){
				refreshItemBreakdown();
				document.getElementById("select-items").focus();
			}else{
				bootbox.alert({
					title : "Insufficient stocks",
					message : messageBody("warning", updateTransactionItem),
					callback : function(){
						$("input#update-qty").focus();	
					}
				});
			}
		}else{
			if(newQty == 0 && newPrice == 0){
				bootbox.alert({
					title : "Missing quantity and unit price",
					message : messageBody("warning", "Please enter quantity and unit price for the selected item."), 
					callback : function(){
						$("input#update-qty").focus();
					}
				});
			}else if(newQty == 0){
				bootbox.alert({
					title : "Missing quantity",
					message : messageBody("warning", "Please enter quantity for the selected item."), 
					callback : function(){
						$("input#update-qty").focus();
					}
				});
			}else if(newPrice == 0){
				bootbox.alert({
					title : "Missing unit price",
					message : messageBody("warning", "Please enter unit price for the selected item."), 
					callback : function(){
						$("input#update-item-price").focus();
					}
				});
			}
		}
	})
	
	$('body').delegate('.btn-cancel-update-item-price','click',function(){
		refreshItemBreakdownExisting();
	})
	
	$('body').delegate('.btn-remove-item-breakdown, .btn-remove-item','click',function(){
		id = $(this).attr('id');
		
		bootbox.confirm({
			title : "Remove selected item",
			message : messageBody("question","Are you sure to remove selected item from the list?"),
			callback : function(result){
				if(result){
					removeItem = ajax({removeItem : 1,id : id},true);
					$("input#select-items").focus();
					refreshItemBreakdownExisting();
				}
			}
		});
	})
	

	$('body').delegate('.frm-submit-transaction','submit',function(e){
		e.preventDefault();
		
		customerName = $.trim($('.customer-name-selected').val());
		invoiceNo = $.trim($('.invoice-no').val());
		purchaseOrderNo = $('.purchase-order-no').val();
		
		if(verifyTransactionInfo()){
			if(!verifyIfZeroQuantity()){
				if(invoiceNo != 0){
					if(verifyInvoiceNo(invoiceNo) != true){
						transaction = ajax({transaction : 1, customerName : customerName , invoiceNo : invoiceNo, view : "createTransactionsExisting"},true);
						boxTransaction = modalForm("Transaction details",transaction);
					}else{
						bootbox.alert({
							title : "Duplicate invoice no.",
							message : messageBody("warning","Invoice no. already exists. Please enter a unique invoice no&hellip;"), 
							callback : function(){
								$("input#invoice-no").focus();	
							}
						});
					}
				}else{
					bootbox.alert({
						title : "Missing invoice no.",
						message : messageBody("warning","Missing invoice no. Please enter an invoice no. before saving transaction&hellip;"), 
						callback : function(){
							$("input#invoice-no").focus();
						}
					});
				}					
			}else{
				bootbox.alert({
					title : "Missing quantity",
					message : messageBody("warning","There is item from the list that has no quantity yet. Kindly verify it first&hellip;"), 
					callback : function(){
						$("input#add-qty").focus();		
					}
				});
			}
		}else{
			bootbox.alert({
				title : "Empty transaction",
				message : messageBody("warning","Unable to save transaction. No items has been selected. Please select atleast one item from the list in order to save current transaction&hellip;"), 
				callback : function(){
					$("input#select-items").focus();		
				}
			});	
		}
		
	});	
	
	$('body').delegate('.close-trasaction-form','click',function(){
		boxTransaction.modal('hide');
		return false;
	});
	
$('body').delegate('.frm-transaction-details','submit',function(e){
		e.preventDefault(); 
		
		customer_id = $.trim($('.customer-name').val());
		invoiceNo = $('.invoice-no').val()
		purchaseOrderNo = $('.purchase-order-no').val();
		date = $('.transaction-date').val();
		totalAmountDue = $('.txt-discounted-due').html();
		totalVatable = $('.txt-total-vatable').html();
		totalVat = $('.txt-total-vat').html();
		discount = $('.txt-discount').val();
		discountedDue = $('.txt-discounted-due').html();
		cashReceived = $('.txt-cash-received').val();
		change = $('.txt-change').html();
		remarks = transactionStatus;
		
		totalAmountDue = totalAmountDue.replace(",","");	
		totalVatable = totalVatable.replace(",","");	
		totalVat = totalVat.replace(",","");	
		discountedDue = discountedDue.replace(",","");	
		cashReceived = cashReceived.replace(",","");	
		change = change.replace(",","");	
		
		if(remarks != 0){
			if(cashReceived != 0){
				if(parseFloat(totalAmountDue) <= parseFloat(cashReceived)){
					boxTransaction.modal('hide');
					saveTransaction = ajax({saveTransaction : 1, invoiceNo : invoiceNo , purchaseOrderNo : purchaseOrderNo, date : date, customer_id : customer_id, totalAmountDue : totalAmountDue , totalVatable : totalVatable , totalVat : totalVat, discount : discount, discountedDue : discountedDue, cashReceived : cashReceived, change : change, remarks : remarks},true);
					getLatestTransactionDetails = ajax({getLatestTransactionDetails :1 }, true);
					
					bootbox.confirm({
						title : "Save Transaction Details", 
						message : messageBody("question","Transaction has been successfully saved. Do you want to print current transaction?"),
						callback : function(result){
							if(result && !isFrmTransactionDetailsSubmit){
								getLatestTransactionDetails = ajax({getLatestTransactionDetails :1 }, true);
								boxTransactionSummary = modalForm("Transaction Summary", getLatestTransactionDetails);
								isFrmTransactionDetailsSubmit = true;
							}else{
								location.reload();
							}	
						}
					});
					
				}else{
					$('.close-trasaction-form').click();
					bootbox.alert({
						title : "Invalid cash amount",
						message : messageBody("warning", "Invalid amount received! Please enter a valid amount. Amount should be greater than the total amount due&hellip;"), 
						callback : function(){
							$('.frm-submit-transaction').submit();
							$('.txt-cash-received').val('');
							$('.txt-cash-received').focus();
						}
					});
				}
			}else{
				$('.close-trasaction-form').click();
				bootbox.alert({
					title : "Missing cash amount",
					message : messageBody("warning", "No cash amount received! Please enter amount before saving&hellip;"), 
					callback : function(){
						$('.frm-submit-transaction').submit();
						$('.txt-cash-received').val('');
						$('.txt-cash-received').focus();
					}
				});
			}	
		}else{
			boxTransaction.modal('hide');
			saveTransaction = ajax({saveTransaction : 1, invoiceNo : invoiceNo, purchaseOrderNo : purchaseOrderNo, date : date, customer_id : customer_id, totalAmountDue : totalAmountDue , totalVatable : totalVatable , totalVat : totalVat, discount : discount, discountedDue : discountedDue, cashReceived : cashReceived, change : change, remarks : remarks},true);
			getLatestTransactionDetails = ajax({getLatestTransactionDetails :1 }, true);
			
			bootbox.confirm({
				title : "Save Transaction Details", 
				message : messageBody("question","Transaction has been successfully saved. Do you want to print current transaction?"),
				callback : function(result){
					if(result && !isFrmTransactionDetailsSubmit){
						getLatestTransactionDetails = ajax({getLatestTransactionDetails :1 }, true);
						boxTransactionSummary = modalForm("Transaction Summary", getLatestTransactionDetails);
						isFrmTransactionDetailsSubmit = true;
					}else{
						location.reload();
					}	
				}
			});
		}
	});
	
	$('body').delegate('.btn-print-transaction','click',function(){
		outputtype = $(this).attr("outputtype");
		id = $(this).attr("id");
		
		boxTransactionSummary.modal("hide");
		bootbox.confirm({
			title : "Print Transaction Details",
			message : messageBody("question", "Are you sure to print " + outputtype + "?"),
			callback : function(result){
				if(result){
					generateOutput(id, page,'createTransactions', outputtype, "existing");
				}else{
					getLatestTransactionDetails = ajax({getLatestTransactionDetails :1 }, true);
					boxTransactionSummary = modalForm("Transaction Summary", getLatestTransactionDetails);
				}
			}
		});
	})
	
	$('body').delegate('.close-trasaction-details-form','click',function(){
		boxTransactionSummary.modal('hide');
		bootbox.alert({
			title : "End of transaction",
			message : messageBody("info", "Please press enter to proceed to a new transaction."), 
			callback : function(){
				location.reload();
			}
		});
	})	
	$('body').delegate('.close-trasaction-details-form','click',function(){
		boxTransactionSummary.modal('hide');
	})
	
	$('body').delegate('.txt-discount','keyup',function(){
		totalAmountDue = $('.txt-total-due').val();
		discount = $.trim($(this).val());
		
		if(discount == 0){
			discount = 0;
		}
		
		totalAmountDue = totalAmountDue.replace(",","")
		discountAmountDue = ajax({discountAmountDue : 1, totalAmountDue : totalAmountDue, discount : discount},true);
		parseDiscountAmountDue = discountAmountDue.split("-");
		
		$('.txt-discounted-due').html(parseDiscountAmountDue[0]);
		$('.txt-total-vat').html(parseDiscountAmountDue[1]);
		$('.txt-total-vatable').html(parseDiscountAmountDue[2]);
	});
	
	$('body').delegate('.txt-cash-received','keyup',function(){
		
		totalAmountDue = $('.txt-discounted-due').html();
		cashReceived = $.trim($(this).val()) != 0 ? ($(this).val()) : 0;
		totalAmountDue = totalAmountDue.replace(",","");
		
		if(parseFloat(totalAmountDue) < cashReceived){
			computeChange = ajax({computeChange : 1, cashReceived : cashReceived, totalAmountDue : totalAmountDue},true);
			$('.txt-change').html(computeChange);
		}else{
			$('.txt-change').html('0.00');
		}
		
	});
	
	$('body').delegate('.pay-now','click',function(){
		transactionStatus = 1;
		$('.pending').prop('checked',false);
		$(".box-transaction-details").prop("disabled",false);
		$(".box-transaction-details").find(":input").prop("disabled",false);
		$(".txt-cash-received").addClass('required');
	});
	
	$('body').delegate('.pending','click',function(){
		transactionStatus = 0;
		$('.pay-now').prop('checked',false);
		$(".box-transaction-details").prop("disabled",true);
		$(".box-transaction-details").find(":input").prop("disabled",true);
		$('.txt-cash-received').val('');
		$(".txt-cash-received").removeClass('required');
	});

	$('body').delegate('.new-customer','click',function(){
		inputCustomerName = 1;
		$('.existing-customer').prop('checked',false);
		$('input.customer-name.i-new-customer').css('display','block');
		$('input.customer-name.i-existing-customer').css('display','none');
		$('input.customer-name.i-existing-customer').val('');
		$('input.customer-name.i-new-customer').val('');
		
	});
	
	$('body').delegate('.existing-customer','click',function(){
		inputCustomerName = 0;
		$('.new-customer').prop('checked',false);
		$('input.customer-name.i-new-customer').css('display','none');
		$('input.customer-name.i-existing-customer').css('display','block');
		$('input.customer-name.i-existing-customer').val('');
		$('input.customer-name.i-new-customer').val('');
	});

	//Manage list of items
	var boxAddItem = '';
	
	$('body').delegate('.btn-add-new-item','click',function(){
		itemForm = ajax({itemForm : 1},true);
		boxSeeItems.modal('hide');
		boxAddItem = modalForm('Add item',itemForm);
	});
	
	$('body').delegate('.close-add-item-form','click',function(){
		boxAddItem.modal('hide');
		itemList = ajax({itemList : 1},true);
		boxSeeItems = modalForm('Item List',itemList);
		showComponents('pagination','.displayItemList',tblname , page, sortOrder, 3, textData);
	});
	
	
	$('body').delegate('.select-category','change',function(){
		category = $(this).val();
		showComponents('unitList','.select-unit','','','',category);
	});
	
	$('body').delegate('.whole-sale-price','keyup',function(){
		
		var percentage = $.trim($('.whole-sale-price-increase').val());
		var wholeSalePrice = $.trim($(this).val());
		
		
		if(wholeSalePrice != 0){
			if(parseFloat($(this).val()) > 0){
				if(percentage != 0){
					percentage = percentage / 100;
					value = parseFloat(((percentage * parseFloat(wholeSalePrice)) + parseFloat(wholeSalePrice))).toFixed(2);	
				}else{
					value = parseFloat($(this).val().replace(",","")).toFixed(2);
				}
			}else{
				$(this).val('0.00');
				value = '0.00';
			}	
		}else{
			value = '0.00';
		}
		
		$('.suggested-retail-price-hidden').html(value);	
		$('.suggested-retail-price').val(value);
		
	});
	
	$('body').delegate('.whole-sale-price','change',function(){
		
		var percentage = $.trim($('.whole-sale-price-increase').val());
		var wholeSalePrice = $.trim($(this).val());
		
		
		if(wholeSalePrice != 0){
			if(parseFloat($(this).val()) > 0){
				if(percentage != 0){
					percentage = percentage / 100;
					value = parseFloat(((percentage * parseFloat(wholeSalePrice)) + parseFloat(wholeSalePrice))).toFixed(2);	
				}else{
					value = parseFloat($(this).val().replace(",","")).toFixed(2);
				}
			}else{
				$(this).val('0.00');
				value = '0.00';
			}	
		}else{
			value = '0.00';
		}
		
		$('.suggested-retail-price-hidden').html(value);	
		$('.suggested-retail-price').val(value);
		
	});
	
	$('body').delegate('.whole-sale-price-increase','keyup',function(){
		percentage = $(this).val();
		wholeSalePrice = $('.whole-sale-price').val();
		
		if($.trim(wholeSalePrice) != 0){
			if (parseFloat(wholeSalePrice) > 0){
				
				wholeSalePrice = parseFloat(wholeSalePrice);
				
				if($.trim(percentage) != 0){
					if(parseFloat(percentage) > 0){
						percentage = parseFloat(percentage) / 100;
					}else{
						percentage = 0;
					}
				}else{
					percentage = 0;
				}
			}else{
				percentage = 0;
				wholeSalePrice = 0;
				$(this).val('0');
			}
			
		}else{
			percentage = 0;
			wholeSalePrice = 0;
			$(this).val('0');
		}

		suggestedRetailPrice = parseFloat(((percentage * wholeSalePrice) + wholeSalePrice)).toFixed(2);
		$('.suggested-retail-price-hidden').html(suggestedRetailPrice);
		$('.suggested-retail-price').val(suggestedRetailPrice);	
	});
	
	$('body').delegate('.whole-sale-price-increase','change',function(){
		percentage = $(this).val();
		wholeSalePrice = $('.whole-sale-price').val();
		
		if($.trim(wholeSalePrice) != 0){
			if (parseFloat(wholeSalePrice) > 0){
				
				wholeSalePrice = parseFloat(wholeSalePrice);
				
				if($.trim(percentage) != 0){
					if(parseFloat(percentage) > 0){
						percentage = parseFloat(percentage) / 100;
					}else{
						percentage = 0;
					}
				}else{
					percentage = 0;
				}
			}else{
				percentage = 0;
				wholeSalePrice = 0;
				$(this).val('0');
			}
			
		}else{
			percentage = 0;
			wholeSalePrice = 0;
			$(this).val('0');
		}

		suggestedRetailPrice = parseFloat(((percentage * wholeSalePrice) + wholeSalePrice)).toFixed(2);
		$('.suggested-retail-price-hidden').html(suggestedRetailPrice);
		$('.suggested-retail-price').val(suggestedRetailPrice);	
	});
	
	$('body').delegate('.frm-add-new-item','submit',function(e){
		e.preventDefault();
		formdata = new FormData($(this)[0]);
		formdata.append('saveNewItem',1);
		
		if(validateItemInputs() == true){
			$('.displayVerificationRespondent').hide();
			
			bootbox.confirm({
				title : "Save new item details",
				message : messageBody("question", "Are you sure to save new item?"),
				callback : function(result){
					if(result){
						saveNewItem = ajax(formdata,true,true,'Saving new item.','post');
						box.modal('hide');
						itemList = ajax({itemList : 1},true);
						boxSeeItems = modalForm('Item List',itemList);
						showComponents('pagination','.displayItemList',tblname , page, sortOrder, 3, textData);
						refreshItemList();		
					}
				}
			});
		}else{
			$('.displayVerificationRespondent span').html("Please fill up all required fields..");
			$('.displayVerificationRespondent').show()
		}
	})
	
	$('body').delegate('.btn-update-item','click',function(){
		id = selectedItem;
		itemUpdateInfo = ajax({itemUpdateInfo : 1, id : id},true);
		requestInfo = itemUpdateInfo.split('==');
		boxSeeItems.modal('hide')
		boxUpdateItem = modalForm(requestInfo[0],requestInfo[1]);
	});
	
	$('body').delegate('.close-update-item-form-for-all-items','click',function(){
		boxUpdateItem.modal('hide');
		itemList = ajax({itemList : 1},true);
		boxSeeItems = modalForm('Item List',itemList);
		showComponents('pagination','.displayItemList',tblname , page, sortOrder, 3, textData);
	});
	
	$('body').delegate('.frm-update-item','submit',function(e){
		e.preventDefault();
		formdata = new FormData($(this)[0]);
		formdata.append('updateItem',1);
		formdata.append('id',$(this).attr('idfui'));
		
		if(changeVerification()){
			if(validateItemInputs()){
				bootbox.confirm({
					title : "Update item details",
					message : messageBody("question", "Are you sure to update selected item?"),
					callback : function(result){
						if(result){
							updateItem = ajax(formdata,true,true,'Updating selected item.','post');
							box.modal('hide');
							itemList = ajax({itemList : 1},true);
							boxSeeItems = modalForm('Item List',itemList);
							showComponents('pagination','.displayItemList',tblname , page, sortOrder, 3, textData);
							refreshItemList();
							refreshItemBreakdown();		
						}
					}
				});
			}else{
				$('.displayVerificationRespondent span').html("Please fill up all required fields..");
				$('.displayVerificationRespondent').show()
			}	
		}
	})
	
	$.Shortcuts.add({
		type: 'down',
		mask: 'F9',
		enableInInput: true,
		handler: function() {
			$("input.invoice-no").focus();
		}
	});
	
	$.Shortcuts.add({
		type: 'down',
		mask: 'Ctrl+S',
		enableInInput: true,
		handler: function() {
			$("input#select-items").focus();
			$("input#select-items").select();
		}
	});
	
	$.Shortcuts.add({
		type: 'down',
		mask: 'F12',
		enableInInput: true,
		handler: function() {
			$("input.txt-cash-received").focus();
			$("input.txt-cash-received").select();
		}
	});
	
	$.Shortcuts.add({
		type: 'down',
		mask: 'F8',
		enableInInput: true,
		handler: function() {
			$(".pending").click();
			$(".btn-submit-transaction-details").focus();
		}
	});
	
	$.Shortcuts.add({
		type: 'down',
		mask: 'F7',
		enableInInput: true,
		handler: function() {
			$(".pay-now").click();
			$(".btn-submit-transaction-details").focus();
		}
	});
	
	$.Shortcuts.start();
	
	function refreshItemList(){
		itemList = ajax({refreshitemList : 1},true);
		$('.item-select').html(itemList);	
	}
	
	function validateItemInputs(){
		
		code = $.trim($('.code').val());
		stocks = $.trim($('.stocks').val());
		description = $.trim($('.description').val());
		WSP = $.trim($('.whole-sale-price').val());
		unit_id = $('.select-unit').val();
		
		if(code != 0){
			hasCode = true
			$('.code').removeClass('no-input');
			
			$('.input-code').hide();
			$('.input-code-success').show();
			$('.input-code-failed').hide();
			
		}else{
			hasCode = false;
			$('.code').addClass('no-input');
			
			$('.input-code').hide();
			$('.input-code-success').hide();
			$('.input-code-failed').show();
		}
		
		if(stocks != 0){
			hasStocks = true;
			$('.stocks').removeClass('no-input');
			
			$('.input-stocks').hide();
			$('.input-stocks-success').show();
			$('.input-stocks-failed').hide();
		}else{
			hasStocks = false;
			$('.stocks').addClass('no-input');
			
			$('.input-stocks').hide();
			$('.input-stocks-success').hide();
			$('.input-stocks-failed').show();
		}
		
		if(description != 0){
			hasDescription = true;
			$('.description').removeClass('no-input');
			
			$('.input-description').hide();
			$('.input-description-success').show();
			$('.input-description-failed').hide();
		}else{
			hasDescription = false;
			$('.description').addClass('no-input');
			
			$('.input-description').hide();
			$('.input-description-success').hide();
			$('.input-description-failed').show();
		}
		
		if(WSP != 0){
			hasWSP = true;
			$('.whole-sale-price').removeClass('no-input');
			
			$('.input-whole-sale-price').hide();
			$('.input-whole-sale-price-success').show();
			$('.input-whole-sale-price-failed').hide();
		}else{
			hasWSP = false;
			$('.whole-sale-price').addClass('no-input');
			
			$('.input-whole-sale-price').hide();
			$('.input-whole-sale-price-success').hide();
			$('.input-whole-sale-price-failed').show();
		}
		
		if(unit_id != ''){
			hasUnit_id = true;
			$('.select-unit').removeClass('no-input');
			
			$('.input-unit').hide();
			$('.input-unit-success').show();
			$('.input-unit-failed').hide();
		}else{
			hasUnit_id = false;
			$('.select-unit').addClass('no-input');
			
			$('.input-unit').hide();
			$('.input-unit-success').hide();
			$('.input-unit-failed').show();
		}
		
		if(hasCode == true && hasStocks == true && hasDescription == true && hasWSP == true && hasUnit_id == true){
			return true;
		}else{
			return false;
		}
	}
	
	function changeVerification(){
		
		code = $.trim($('.code').val());
		stocks = $.trim($('.stocks').val());
		description = $.trim($('.description').val());
		WSP = $.trim($('.whole-sale-price').val());
		wholeSalePriceIncrease = $.trim($('.whole-sale-price-increase').val());
		unit_id = $('.select-unit').val();
		
		duplicateCode = $.trim($('.duplicate-code').val());
		duplicateStocks = $.trim($('.duplicate-stocks').val());
		duplicateDescription = $.trim($('.duplicate-description').val());
		duplicateWSP = $.trim($('.duplicate-whole-sale-price').val());
		duplicateWholeSalePriceIncrease = $.trim($('.duplicate-whole-sale-price-increase').val());
		duplicateUnit_id = $('.duplicate-unit').val();
		
		if(code != duplicateCode){
			isCodeChange = true;
		}else{
			isCodeChange = false;
		}
		
		if(stocks != duplicateStocks){
			isStocksChange = true;
		}else{
			isStocksChange = false;
		}
		
		if(description != duplicateDescription){
			isDescriptionChange = true;
		}else{
			isDescriptionChange = false;
		}
		
		if(WSP != duplicateWSP){
			isWholeSalePriceChange = true;
		}else{
			isWholeSalePriceChange = false;
		}
		
		if(wholeSalePriceIncrease != duplicateWholeSalePriceIncrease){
			isWholeSalePriceIncreaseChange = true;
		}else{
			isWholeSalePriceIncreaseChange = false;
		}
		
		if(unit_id != duplicateUnit_id){
			isUnitChange = true;
		}else{
			isUnitChange =  false;
		}
		
		if(isCodeChange == true || isStocksChange == true || isDescriptionChange == true || isWholeSalePriceChange == true || isWholeSalePriceIncreaseChange == true || isUnitChange == true){
			return true;
		}else{
			return false;
		}
	}
	
	function verifyTransactionInfo(){
		verifyTransaction = ajax({verifyTransaction : 1}, true);
		if(verifyTransaction > 0){
			return true;
		}else{
			return false;
		}
	}
	
	function verifyIfZeroQuantity(){
		verifyZero = ajax({verifyZero : 1},true);
		if(verifyZero == 1){
			return true;
		}else{
			return false;
		};
	}
	
	function verifyInvoiceNo(invoiceNo){
		verify = ajax({verifyInvoiceNo : 1, invoiceNo : invoiceNo},true);
		return verify == 1 ? true : false;
	}
	
	function verifyIfItemNotAlreadyExistInActiveTransactionBreakdown(id){
		ifExist = false;
		
		if($(".row-item-breakdown td:nth-of-type(1) form.frm-add-qty").length != 0){
			ifExist = true;
		}
		
		return ifExist;
	}
})

