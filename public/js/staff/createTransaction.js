$(document).ready(function(){
	
	//================================================ Create Transactions ==========================================
	var boxSeeItems = '';
	var boxTransaction = '';
	var tblname = 'tbl_items';
	var page = $('.page').val();
	var pageNo = 0;
	var sortOrder = 'DESC';
	var textData = '';
	var transactionStatus = 1;
	var inputCustomerName = 1;
	
	resetItemBreakdown();
	
	showComponents('itemBreakdown','.displayItemBreakdown');
	$('body').delegate('.btn-see-items','click',function(){
		itemList = ajax({itemList : 1},true);
		boxSeeItems = modalForm('Item List',itemList);
		showComponents('pagination','.displayItemList',tblname , page, sortOrder, 0, textData);
	});
	
	$('body').delegate('.close-itemList-form','click',function(){
		boxSeeItems.modal('hide');
		return false;
	});
	
	$('body').delegate('.txt-item-search','keyup',function(){
		textData = $(this).val();
		showComponents('pagination','.displayItemList',tblname , page, sortOrder, 0, textData);
	});
	
	$('body').delegate('.item-sort-order','change',function(){
		sortOrder = $(this).val();
		showComponents('pagination','.displayItemList',tblname , page, sortOrder, 0, textData);
	});
	
	
	$('body').delegate('.pick-item','dblclick',function(){
		id = $(this).attr('idpi');
		
		if(!verifyIfZeroQuantity()){
			pickItem = ajax({pickItem : 1 , id: id},true);
			refreshItemBreakdown();
			box.modal('hide');
			document.getElementById("txt-add-breakdown-id").focus();	
		}else{
			alert('Enter qty first before selecting another item.');
		}
	})
	
	$('body').delegate('.remove-item','click',function(){
		id = $(this).attr('idri');
		if(confirm('Are you sure to remove item?')){
			removeItemBreakdown = ajax({removeItemBreakdown : 1, id : id},true);
			processResult(removeItemBreakdown,'Removing selected item.','Failed to remove selected item.');
			refreshItemBreakdown();
			document.getElementById("select-items").focus();
		}
	});
	
	$('body').delegate('.frm-add-item-qty','submit',function(e){
		e.preventDefault();
		id = $(this).attr('idriq');
		qty = $.trim($('.txt-add-qty'+id).val());
		
		if(qty != 0){
			addQty = ajax({addQty : 1 , id : id, qty : qty},true);
			if(addQty != 1){
				alert(addQty);
				$('.txt-add-qty'+id).val('')
			}else{
				document.getElementById("select-items").focus();
				refreshItemBreakdown();	
			}
		}else{
			alert('Missing quantity.');
		}
		
	});
	
	$('body').delegate('.update-qty','click',function(){
		refreshItemBreakdown();
		id = $(this).attr('iduq');
		$('.display-item-qty'+id).hide();
		$('.update-item-qty'+id).show();
		$('.add-breakdown-option'+id).hide();
		$('.update-breakdown-option'+id).show();
	});
	
	$('body').delegate('.btn-cancel-update-item','click',function(){
		refreshItemBreakdown();	
	});
	
	$('body').delegate('.frm-update-item-qty','submit',function(e){
		e.preventDefault();
		id = $(this).attr('idriq'); 
		qty = $.trim($('.txt-update-qty'+id).val());
		
		if(qty != 0){
			updateQty = ajax({updateQty : 1 , id : id, qty : qty},true);
			if(updateQty != 1){
				alert(updateQty)
			}else{
				document.getElementById("select-items").focus();
				refreshItemBreakdown();	
			}
		}else{
			alert('Missing quantity.');
		}
		
	});
	
	$('body').delegate('.item-select','submit',function(e){
		e.preventDefault();
		id = $('.select-items').val();
		
		if(!verifyIfZeroQuantity()){
			if(id != ''){
				pickItem = ajax({pickItem : 1 , id: id},true);	
				refreshItemBreakdown();
				$('.select-items').val('');
				
				if(pickItem != 1){
					alert('No more stocks stocks left for this item.');
				}else{
					document.getElementById("txt-add-breakdown-id").focus();
				}
				
			}else{
				alert('Please select an item.');
			}	
		}else{
			alert('Enter qty first before selecting another item.');
		}
	});
	
	$('body').delegate('.frm-submit-transaction','submit',function(e){
		e.preventDefault();
		
		customerName = inputCustomerName == 1 ? $.trim($('.customer-name.i-new-customer').val()) : $.trim($('.customer-name.i-existing-customer').val());
		invoiceNo = $.trim($('.invoice-no').val());
		
		if(verifyTransactionInfo()){
			if(invoiceNo != 0){
				if(verifyInvoiceNo(invoiceNo) != true){
					transaction = ajax({transaction : 1, customerName : customerName , invoiceNo : invoiceNo},true);
					boxTransaction = modalForm('Invoice no: '+  invoiceNo+ "<br><br>" + 'Customer: ' + customerName ,transaction);
				}else{
					alert('Invoice no already exists. Input a unique invoice no.')
				}
			}else{
				alert('Missing Invoice no.');
			}
		}else{
			alert('Empty transaction list.');
		}
		
	});	
	
	$('body').delegate('.close-trasaction-form','click',function(){
		boxTransaction.modal('hide');
		return false;
	});
	
	$('body').delegate('.frm-transaction-details','submit',function(e){
		e.preventDefault();
		
		customerName = inputCustomerName == 1 ?  $.trim($('.customer-name.i-new-customer').val()) : $.trim($('.customer-name.i-existing-customer').val());
		invoiceNo = $('.invoice-no').val();
		totalAmountDue = $('.txt-total-due').val();
		totalVatable = $('.txt-total-vatable').html();
		totalVat = $('.txt-total-vat').html();
		discount = $('.txt-discount').val();
		discountedDue = $('.txt-discounted-due').html();
		cashReceived = $('.txt-cash-received').val();
		change = $('.txt-change').html();
		remarks = transactionStatus;
		
		if(remarks != 0){
			if(cashReceived != 0){
				
				totalAmountDue = totalAmountDue.replace(",","");	
				
				if(parseFloat(totalAmountDue) < cashReceived){
					
					printStatus = confirm('Save invoice for the current transaction?') ? 1 : 0;
					
					boxTransaction.modal('hide');
					
					saveTransaction = ajax({saveTransaction : 1, invoiceNo : invoiceNo , customerName : customerName, totalAmountDue : totalAmountDue , totalVatable : totalVatable , totalVat : totalVat, discount : discount, discountedDue : discountedDue, cashReceived : cashReceived, change : change, printStatus : printStatus, remarks : remarks},true);
					printStatus == 1 ? alert('Invoice saved. File Path: ' + printInvoice()) : '';
					
					if(confirm('Create new transaction?')){
						window.location = '?pg=staff&vw=createTransactions&dir=60858ae3126c1c2c153d4a9b21f7aff9ac5aef2f';
					}
					
				}else{
					alert('Invalid amount received.');
					 $('.txt-cash-received').val('');
				}
			}else{
				alert('No cash amount received.');
			}	
		}else{
			
			printStatus = confirm('Save invoice for the current transaction?') ? 1 : 0;	
			
			boxTransaction.modal('hide');
					
			saveTransaction = ajax({saveTransaction : 1, invoiceNo : invoiceNo , customerName : customerName, totalAmountDue : totalAmountDue , totalVatable : totalVatable , totalVat : totalVat, discount : discount, discountedDue : discountedDue, cashReceived : cashReceived, change : change, printStatus : printStatus, remarks : remarks},true);
			processResult(saveTransaction,'Saving Transaction.','Failed to save transaction');
			printStatus == 1 ? alert('Invoice saved. File Path: ' + printInvoice()) : '';
			
			if(confirm('Create new transaction?')){
				window.location = '?pg=staff&vw=createTransactions&dir=60858ae3126c1c2c153d4a9b21f7aff9ac5aef2f';
			}		
		}
		
	});
	
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
		cashReceived = $.trim($(this).val());
		totalAmountDue = totalAmountDue.replace(",","");
		
		if(cashReceived != 0){
			if(parseFloat(totalAmountDue) < cashReceived){
				computeChange = ajax({computeChange : 1, cashReceived : cashReceived, totalAmountDue : totalAmountDue},true);
				$('.txt-change').html(computeChange);
			}
		}
	});
	
	$('body').delegate('.pay-now','click',function(){
		transactionStatus = 1;
		$('.pending').prop('checked',false);
		$(".box-transaction-details").prop("disabled",false);
		$(".box-transaction-details").find(":input").prop("disabled",false);
	});
	
	$('body').delegate('.pending','click',function(){
		transactionStatus = 0;
		$('.pay-now').prop('checked',false);
		$(".box-transaction-details").prop("disabled",true);
		$(".box-transaction-details").find(":input").prop("disabled",true);
		$('.txt-cash-received').val('');
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
})

