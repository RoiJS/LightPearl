function ajax(ajaxData, isReturn, activateTransition, transitionMessage, ajaxRequest){
	
	ajaxUrl = typeof ajaxUrl !== 'undefined' ? ajaxUrl : '';   
	ajaxData = typeof ajaxData !== 'undefined' ? ajaxData : ''; 
	ajaxRequest = typeof ajaxRequest !== 'undefined' ? ajaxRequest : 'get'; 
	activateTransition = typeof activateTransition !== 'undefined' ? activateTransition : false;
	transitionMessage = typeof transitionMessage !== 'undefined' ? transitionMessage : '';
	
	if(activateTransition != false){
		$('.execution-transition').css('display','block');
		$('.transition-message').html(transitionMessage + " Please wait...");
	}
	
	if(ajaxRequest == 'post'){
		
		$.ajax({
			url : 'public/php/process.php',
			type : "POST",
			cache : false, 
			async : false,
			contentType: false,
			processData: false,
			data : ajaxData,
			success: function(data){
				getData = data;
			}	
		});
		
	}else if(ajaxRequest == 'get'){
		
		$.ajax({
			url : 'public/php/process.php',
			type : "POST",
			cache : false, 
			async : false,
			data : ajaxData,
			success: function(data){
				getData = data;
			}	
		});
	}
	
	if(activateTransition != false){
		$('.execution-transition').css('display','none');
	}
	
	if(isReturn == true)
		return getData;
}

function processResult(result, successMessge, failedMessage, redirection, path){
	
	result = typeof result !== 'undefined' ? result : ''; 
	successMessge = typeof successMessge !== 'undefined' ? successMessge : ''; 
	failedMessage = typeof failedMessage !== 'undefined' ? failedMessage : '';
	redirection = typeof redirection !== 'undefined' ? redirection : false;
	path = typeof path !== 'undefined' ? path : '';
	
	if(result == 1){
		$('.transition-message').html(successMessge);
		$('.success-execution').show().fadeOut(3000,function(){
			if(redirection != false){
				window.location = path;
			}
		});
	}else{
		$('.transition-message').html(failedMessage);
		$('.failed-execution').show().fadeOut(3000);
	}
}

function modalForm(title,content,size){
	
	size = typeof size !== 'undefined' ? size : '';   
	
	box = bootbox.dialog({
		size: size,
		title : title,
		message : content
	});
	
	return box;
}

function showComponents(components, spot ,tblname ,page, sortOrder, id, textData, filterData, dateData, activateTransition, transitionMessage){
	
	id = typeof id !== 'undefined' ? id : '';
	spot = typeof spot !== 'undefined' ? spot : '.displayContents';
	tblname = typeof tblname !== 'undefined' ? tblname : '';
	page = typeof page !== 'undefined' ? page : '';
	sortOrder = typeof sortOrder !== 'undefined' ? sortOrder : 'DESC';
	textData = typeof textData !== 'undefined' ? textData : '';
	filterData = typeof filterData !== 'undefined' ? filterData : '';
	dateData = typeof dateData !== 'undefined' ? dateData : '';
	activateTransition = typeof activateTransition !== 'undefined' ? activateTransition : false;
	transitionMessage = typeof transitionMessage !== 'undefined' ? transitionMessage : '';
	
	content = ajax(
				{
					showComponents : 1,
					components : components, 
					tblname : tblname, 
					page : page,
					sortOrder : sortOrder,
					id : id, 
					textData : textData,
					filterData : filterData,
					dateData : dateData,
				},
				true,activateTransition,transitionMessage
			);
			
	$(spot).html(content);
}


function resetItemBreakdown(){
	ajax({resetItemBreakdown : 1},true);
	refreshItemBreakdown()
}

function refreshItemBreakdown(){
	breakDownTotalInfo = ajax({breakDownTotalInfo : 1},true);
	var itemBreakdownInfo = jQuery.parseJSON(breakDownTotalInfo);
	
	$('.vatable').html(itemBreakdownInfo.row.totalVatable != null ? itemBreakdownInfo.row.totalVatable : '0.00');
	$('.vat').html(itemBreakdownInfo.row.totalVat != null ? itemBreakdownInfo.row.totalVat : '0.00');
	$('.amountDue').html(itemBreakdownInfo.row.totalAmountDue != null ? itemBreakdownInfo.row.totalAmountDue : '0.00');
	showComponents('itemBreakdown','.displayItemBreakdown');
}


function refreshItemBreakdownExisting(){
	breakDownTotalInfo = ajax({breakDownTotalInfo : 1},true);
	var itemBreakdownInfo = jQuery.parseJSON(breakDownTotalInfo);
	
	$('.vatable').html(itemBreakdownInfo.row.totalVatable != null ? itemBreakdownInfo.row.totalVatable : '0.00');
	$('.vat').html(itemBreakdownInfo.row.totalVat != null ? itemBreakdownInfo.row.totalVat : '0.00');
	$('.amountDue').html(itemBreakdownInfo.row.totalAmountDue != null ? itemBreakdownInfo.row.totalAmountDue : '0.00');
	showComponents('itemBreakdownExisting','.displayItemBreakdown');
}

function refreshTransactionStatus(){
	transactionStatus = ajax({transactionStatus : 1},true);
	transactionInfo = transactionStatus.split("-");
	
	$('.totalTransactions').html(transactionInfo[0]);
	$('.totalPaidTransactions').html(transactionInfo[1]);
	$('.totalPendingTransactions').html(transactionInfo[2]);
	$('.expectedCash').html(transactionInfo[3]);
	$('.totalCash').html(transactionInfo[4]);
	
}

function refreshTransactionCustomerStatus(customer_id){
	transactionCustomerStatus = ajax({transactionCustomerStatus : 1, customer_id : customer_id},true);
	transactionCustomerStatus = jQuery.parseJSON(transactionCustomerStatus);
	
	$('.totalTransactionsCustomer').html(transactionCustomerStatus[0]);
	$('.totalPendingTransactionsCustomer').html(transactionCustomerStatus[1]);
	$('.expectedCashCustomer').html(transactionCustomerStatus[2]);
	$('.totalCashCustomer').html(transactionCustomerStatus[3]);
	
}

function refreshAccountInfo(){
	
	accountInfo = ajax({accountInfo : 1},true);
	parseAccountInfo = accountInfo.split("-");
	$('.totalAccounts').html(parseAccountInfo[0]);
	$('.activeAccounts').html(parseAccountInfo[1]);
	$('.inactiveAccounts').html(parseAccountInfo[2]);
}

function verifyCustomer(customer){
	verifySelectedCustomer = ajax({verifySelectedCustomer : 1, customer : customer},true);
	return verifySelectedCustomer == 1 ? true : false;
}

function validateAcountAccess(){
	$.ajax({
		url : 'public/php/process.php',
		type : "POST",
		async : true,
		cache : false,
		data : {
			accountStatus : 1
		},success:function(data){	
			//alert(data);
		}
	});
}

function verifyRemoveModule(module, id){
	verify = ajax({verifyRemoveModule : 1, module : module , id : id}, true);
	return verify > 0 ? true : false;
}

function verifyIfNumber(number){
	
	allow = '0123456789.,';
	arrayId = new Array();
	
	for(i = 0 ; i < number.length; i++){
		arrayId.push((allow.indexOf(number.charAt(i))) != -1 ? 'exists' : 'not exists');
	}
	alert(arrayId)
	return $.inArray('not exists', arrayId) ? 'not exists' : 'exists';
}

function refreshCustomerTransactions(customer_id){
	refreshTransactions = ajax({refreshTransactions : 1, customer_id : customer_id},true);
	$('.customer-transactions').html(refreshTransactions);
}

function printOutput(id, outputType){
	getprintOutput = ajax({printOutput : 1, id : id, outputType : outputType},true);
	return getprintOutput;
}

function generateOutput(id, page, vw, outputType, loc){
	invoice = window.open();
	invoice.document.write(printOutput(id, outputType));
	invoice.print();
	invoice.close();
	
	if(vw != '')
		window.location = '?pg=' + page + '&vw=' + vw +'&dir=60858ae3126c1c2c153d4a9b21f7aff9ac5aef2f&mainsub=create_transactions&sub=' + loc;
}

function getAddress(customer){
	return ajax({customerAddress : 1, customer : customer},true);
}
	
function getContact(customer){
	return ajax({customerContactNo : 1, customer : customer},true);
}

function viewMultipleTransactions(transactions){
	viewTransactions = ajax({viewSelectedMultipleTransactions : 1, selectedTransactions : transactions},true);
	return viewTransactions;
}

function viewMultipleExpenses(transactions){
	viewTransactions = ajax({viewSelectedMultipleExpenses : 1, selectedExpenses : transactions},true);
	return viewTransactions;
}

function deleteTransactions(){
	if(confirm("Sure ka?")){
		ajax({deleteTransactions : 1},true);
		location.reload();	
	}
}

function validateFile(){
	if($(".file-upload").val() == ""){
		alert("Please select a file to be uploaded.");
		return false;
	}else{
		return true;
	}
}

function refreshSalesStatus(sql){
	var salesStatus = ajax({salesStatus : 1, sql : sql},true);
	console.log(salesStatus);
} 

function messageBody(type, message){
	
	var icon;
	var message_extension = "";
	
	if(type == "info"){
		icon = "fa fa-info-circle fa-3x text-info";
	}else if(type == "error"){
		icon = "fa fa-exclamation-circle fa-3x text-error";
		message_extension = "<b>Note:</b>";
	}else if(type == "warning"){
		icon = "fa fa-warning fa-3x text-warning";
		message_extension = "<b>Warning:</b>";
	}else if(type == "question"){
		icon = "fa fa-question-circle fa-3x text-info";
	}
	
	var container = "<div class='row'>" +
						"<div class='span1'>" + 
							"<p><span class='" + icon + "'></span></p>" +
						"</div>" +
						"<div class='span7' style='margin-left:10px;margin-top:5px;'>" + 
							"<p>" + message_extension + " " + message + "</p>" +
						"</div>" +
					"</div>";
			
	return container;
	
}

function number_format(number, decimals, decPoint, thousandsSep) { 

  number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
  var n = !isFinite(+number) ? 0 : +number
  var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
  var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
  var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
  var s = ''

  var toFixedFix = function (n, prec) {
    var k = Math.pow(10, prec)
    return '' + (Math.round(n * k) / k)
      .toFixed(prec)
  }

  // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || ''
    s[1] += new Array(prec - s[1].length + 1).join('0')
  }

  return s.join(dec)
}