$(document).ready(function(){
	
	//================================================ Create Transactions ==========================================
	var boxSeeItems = '';
	var boxTransaction = '';
	var boxTransactionSummary = '';
	var tblname = 'tbl_items';
	var page = $('.page').val();
	var pageNo = 0;
	var sortOrder = 'ASC';
	var textData = '';
	var transactionStatus = 1;
	var inputCustomerName = 1;
	var selectedItem = "";
	
	var page = $('.page').val();
	
	resetItemBreakdown();
	
	showComponents('itemBreakdown','.displayItemBreakdown');
	
	$('body').delegate('.btn-see-items','click',function(){
		selectedItem = "";
		itemList = ajax({itemList : 1},true);
		boxSeeItems = modalForm('Item List', itemList);
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
		
		if(!$(this).attr("class").match(/disabled/i)){
			if(!verifyIfZeroQuantity()){
				if(id != ''){
					pickItem = ajax({pickItem : 1 , id: id},true);
					if(pickItem == 0){
						alert('No more stocks left for this item.');
					}else{
						refreshItemBreakdown();
						$('.select-items').val('');
						boxSeeItems.modal('hide');
						if(verifyIfItemNotAlreadyExistInActiveTransactionBreakdown(id)){
							document.getElementById("add-qty").focus();	
						}
					}
				}else{
					alert('Please select an item.');
				}	
			}else{
				alert('Enter qty first before selecting another item.');
			}	
		}
	})
	
	$('body').delegate('.item-select','submit',function(e){
		e.preventDefault();
		id = $('.select-items').val();
		
		if(!verifyIfZeroQuantity()){
			if(id != ''){
				pickItem = ajax({pickItem : 1 , id: id},true);
				if(pickItem == 0){
					alert('No more stocks left for this item.');
					$('.select-items').val('')
				}else{
					refreshItemBreakdown();
					$('.select-items').val('');
					if(verifyIfItemNotAlreadyExistInActiveTransactionBreakdown(id)){
						document.getElementById("add-qty").focus();	
					}
				}	
			}else{
				alert('Please select an item.');
			}	
		}else{
			alert('Enter qty first before selecting another item.');
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
				refreshItemBreakdown();
				document.getElementById("select-items").focus();
			}else{
				alert(finalizedItem);
			}
		}else{
			if(qty == 0 && price == 0){
				alert('Please enter qty and unit price');
				document.getElementById("add-qty").focus();
			}else if(qty == 0){
				alert('Please enter qty.');
				document.getElementById("add-qty").focus();
			}else if(price == 0){
				alert('Please input unit price.');
				document.getElementById("add-item-price").focus();
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
				refreshItemBreakdown();
				document.getElementById("select-items").focus();
			}else{
				alert(finalizedItem);
			}
		}else{
			if(qty == 0 && price == 0){
				alert('Please enter qty and unit price');
				document.getElementById("add-qty").focus();
			}else if(qty == 0){
				alert('Please enter qty.');
				document.getElementById("add-qty").focus();
			}else if(price == 0){
				alert('Please input unit price.');
				document.getElementById("add-item-price").focus();
			}
		}
	});
	
	$('body').delegate('.btn-update-item-breakdown','click',function(){
		id = $(this).attr('id');
		refreshItemBreakdown();
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
				alert(updateTransactionItem)
				document.getElementById("add-qty").focus();
			}
		}else{
			if(newQty == 0 && newPrice == 0){
				alert('Please enter qty and unit price');
				document.getElementById("update-qty").focus();
			}else if(newQty == 0){
				alert('Please enter qty.');
				document.getElementById("update-qty").focus();
			}else if(newPrice == 0){
				alert('Please input unit price.');
				document.getElementById("update-item-price").focus();
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
				alert(updateTransactionItem)
				document.getElementById("add-qty").focus();
			}
		}else{
			if(newQty == 0 && newPrice == 0){
				alert('Please enter qty and unit price');
				document.getElementById("update-qty").focus();
			}else if(newQty == 0){
				alert('Please enter qty.');
				document.getElementById("update-qty").focus();
			}else if(newPrice == 0){
				alert('Please input unit price.');
				document.getElementById("update-item-price").focus();
			}
		}
	})
	
	$('body').delegate('.btn-cancel-update-item-price','click',function(){
		refreshItemBreakdown();
	})
	
	$('body').delegate('.btn-remove-item-breakdown, .btn-remove-item','click',function(){
		id = $(this).attr('id');
		if(confirm('Are you sure to remove item from the list?')){
			removeItem = ajax({removeItem : 1,id : id},true);
			refreshItemBreakdown();
		}
	})
	

	$('body').delegate('.frm-submit-transaction','submit',function(e){
		e.preventDefault();
		
		invoiceNo = $.trim($('.invoice-no').html());
		purchaseOrderNo = $('.purchase-order-no').val();
		
		if(verifyTransactionInfo()){
			if(invoiceNo != 0){
				if(verifyInvoiceNo(invoiceNo) != true){
					transaction = ajax({transaction : 1, invoiceNo : invoiceNo, view : "createTransactions"},true);
					boxTransaction = modalForm('Invoice no: '+  invoiceNo ,transaction);
				}else{
					alert('Invoice no already exists. Input a unique invoice no.')
					document.getElementById("invoice-no").focus();	
				}
			}else{
				alert('Missing Invoice no.');
				document.getElementById("invoice-no").focus();	
			}
		}else{
			alert('Empty transaction list.');
			document.getElementById("select-items").focus();	
		}
		
	});	
	
	$('body').delegate('.close-trasaction-form','click',function(){
		boxTransaction.modal('hide');
	});
	
	$('body').delegate('.frm-submit-expense','submit',function(e){
		e.preventDefault(); 
		
		var expenseNo = $.trim($(".expense-no").html());
		var date = $.trim($(".expense-date").val());
		var totalAmountDue = $('.amountDue').html();
		totalAmountDue = totalAmountDue.replace(",","");
		
		if(confirm("Are you sure to save new expense?")){
			saveTransaction = ajax({saveExpense : 1, expenseNo : expenseNo, date : date, totalAmountDue : totalAmountDue},true);
			console.log(saveTransaction);				
			alert("New expense has been successfully saved.");
			location.reload();
		}			
	});
	
	$('body').delegate('.btn-print-transaction','click',function(){
		outputtype = $(this).attr("outputtype");
		id = $(this).attr("id");
		if(confirm("Are you sure to print " + outputtype + " ?")){
			generateOutput(id, page,'createTransactions', outputtype)
		}
	})
	
	$('body').delegate('.close-trasaction-details-form','click',function(){
		boxTransactionSummary.modal('hide');
		alert("Press enter to proceed to new transaction.");
		location.reload();
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
	
	$('body').delegate('.whole-sale-price','keyup',function(){
		
		if($.trim($(this).val()) != 0){
			if(parseFloat($(this).val()) > 0){
				value = parseFloat($(this).val().replace(",","")).toFixed(2);
			}else{
				$(this).val('0');
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
		wholeSalePrice = $('.whole-sale-price').val().replace(",","");
		
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
	})
	
	$('body').delegate('.frm-add-new-item','submit',function(e){
		e.preventDefault();
		formdata = new FormData($(this)[0]);
		formdata.append('saveNewItem',1);
		
		if(validateItemInputs() == true){
			$('.displayVerificationRespondent').hide()
			if(confirm('Are you sure to save new item?')){
				saveNewItem = ajax(formdata,true,true,'Saving new item.','post');
				box.modal('hide');
				itemList = ajax({itemList : 1},true);
				boxSeeItems = modalForm('Item List',itemList);
				showComponents('pagination','.displayItemList',tblname , page, sortOrder, 3, textData);
				refreshItemList();
			}
		}else{
			$('.displayVerificationRespondent span').html("Please fill up all required fields..");
			$('.displayVerificationRespondent').show()
		}
	})
	
	$('body').delegate('.btn-update-item','click',function(){
		id = selectedItem;
		
		if(!$(this).attr("class").match(/disabled/i)){
			itemUpdateInfo = ajax({itemUpdateInfo : 1, id : id},true);
			requestInfo = itemUpdateInfo.split('==');
			boxSeeItems.modal('hide')
			boxUpdateItem = modalForm(requestInfo[0],requestInfo[1]);	
		}
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
				if(confirm('Are you sure to update selected item?')){
					updateItem = ajax(formdata,true,true,'Updating selected item.','post');
					box.modal('hide');
					itemList = ajax({itemList : 1},true);
					boxSeeItems = modalForm('Item List',itemList);
					showComponents('pagination','.displayItemList',tblname , page, sortOrder, 3, textData);
					refreshItemList();
					refreshItemBreakdown();
				}
			}else{
				$('.displayVerificationRespondent span').html("Please fill up all required fields..");
				$('.displayVerificationRespondent').show()
			}	
		}
	})
	
	function refreshItemList(){
		itemList = ajax({refreshitemList : 1},true);
		$('.item-select').html(itemList);	
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
	
	function verifyIfItemNotAlreadyExistInActiveTransactionBreakdown(id){
		ifExist = false;
		
		if($(".row-item-breakdown td:nth-of-type(1) form.frm-add-qty").length != 0){
			ifExist = true;
		}
		
		return ifExist;
	}
})

