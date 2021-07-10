<?php

function sanitizeInput($input) {
	
	$search = array(
		'@<script[^>]*?>.*?</script>@si',   // Strip out javascript
		'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
		'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
		'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
	  );
	
		$output = preg_replace($search, '', $input);
		return $output;
  }


 function sanitizeText($input) {

	  $search = array(
		'@<script[^>]*?>.*?</script>@si',   // Strip out javascript
		'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
		'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
	  );
	
		$output = preg_replace($search, '', $input);
		return $output;
  } 
  
  function hashTag($tableName,$fieldName){
	$tableInfo = query('SELECT * FROM '.$tableName.' ORDER BY '.$fieldName.' DESC LIMIT 1','','','variable',1);
	query('UPDATE '.$tableName.' ','SET hashed_id = :hashed_id WHERE '.$fieldName.' = :fieldValue;',[':hashed_id' =>  sha1($tableInfo['row'][$fieldName]) , ':fieldValue' => $tableInfo['row'][$fieldName]]);
  }

function generateFileName($file, $tableName, $fieldName){
	
	$fileName = $file['name'];
	$parseFile = explode('.',$fileName);
	$extension = $parseFile[1];
	
	do{
		$random = rand(1,1000000000).'_'.rand(1,1000000000).'_'.rand(1,1000000000);
		$count = query('SELECT * FROM '.$tableName.'','WHERE '.$fieldName.' LIKE :randomName',[':randomName' => '%'.$random.'%'],'rows');
	}while($count > 0);
	
	return $random.'.'.$extension;
}
 
function unlinkImage($tableName, $fieldName, $id, $sources){
	
	$getImage = query('SELECT * FROM '.$tableName.'','WHERE '.$fieldName.' = :id;',[':id' => $id],'variable',1);
	
	if($getImage['row']['image'] != ''){
		unlink($sources.$getImage['row']['image']);
	}
	
}

function validateFile($file,$fileTypeRequested = 'img'){
	
	$fileName = $file['name'];
	$fileType =  strtolower($file['type']);
	$fileSize = $file['size'] /1024;
	$extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
	
	if($fileTypeRequested == 'doc'){
		$allowedExtensions = array('pdf','doc','docx');
		$allowedFileType = array('application/doc','application/docx','application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
		$allowedSize = 5000000;
	}elseif($fileTypeRequested == 'img'){
		$allowedExtensions = array('jpeg','png','jpg','gif');
		$allowedFileType = array('image/gif','image/jpeg','image/jpg','image/png');
		$allowedSize = 10000000;
	}
	
	if(in_array($extension,$allowedExtensions) && in_array($fileType,$allowedFileType)){
		if($fileSize < $allowedSize){
			return 1;
		}else{	
			return 'Invalid File Size. Maximum '.$allowedSize / 1000000 .' Mb allowed.';
		}
	}else{
		return 'Invalid File Type.';
	}
	
}
	function getMonthName($month){
		if($month == 1){
			return 'January';
		}elseif($month == 2){
			return 'February';
		}elseif($month == 3){
			return 'March';
		}elseif($month == 4){
			return 'April';
		}elseif($month == 5){
			return 'May';
		}elseif($month == 6){
			return 'June';
		}elseif($month == 7){
			return 'July';
		}elseif($month == 8){
			return 'August';
		}elseif($month == 9){
			return 'September';
		}elseif($month == 10){
			return 'October';
		}elseif($month == 11){
			return 'November';
		}elseif($month == 12){
			return 'December';
		}
	}

function parseSession($account_id, $index = 0){
	$parseAccount_id = explode('/',$account_id);
	return $parseAccount_id[$index];
}

function getAccountTimeSpan(){
	$accountInfo = query('SELECT * FROM tbl_accounts','','','variable');
	
	foreach($accountInfo as $account){
		$array[] = $account['row']['timeSpan'];
	}
	
	return $array;
}


function savedTransactionPerCustomer($transaction_id){
	
	$getTransactionDetails = query('SELECT * FROM tbl_transactions','WHERE transaction_id = :id',[':id' => $transaction_id],'variable',1);
	$verifyCustomer = query('SELECT * FROM tbl_customerpaymentinfo','WHERE customer_id = :id',[':id' => $getTransactionDetails['row']['customer_id']],'variable',1);
	
	$discountedAmount = floatval(str_replace(",","",$getTransactionDetails['row']['discountedAmount']));
	
	if(!empty($verifyCustomer)){
		
		if($getTransactionDetails['row']['remarks'] == 1){
			$newExpectedCash = $verifyCustomer['row']['expectedCashReceived'] + $discountedAmount;
			$newActualCash = $verifyCustomer['row']['actualCashReceived'] + $discountedAmount;
			query('UPDATE tbl_customerpaymentinfo','SET expectedCashReceived = :expected , actualCashReceived = :actual WHERE customerPaymentInfo_id = :id',[':id' => $verifyCustomer['row']['customerPaymentInfo_id'], ':expected' => $newExpectedCash, ':actual'=> $newActualCash]);
		}else{
			$newExpectedCash = $verifyCustomer['row']['expectedCashReceived'] + $discountedAmount;
			query('UPDATE tbl_customerpaymentinfo','SET expectedCashReceived = :expected WHERE customerPaymentInfo_id = :id',[':id' => $verifyCustomer['row']['customerPaymentInfo_id'], ':expected' => $newExpectedCash]);
		}
		
	}else{
		
		if($getTransactionDetails['row']['remarks'] == 1){
			query('INSERT INTO tbl_customerpaymentinfo(customer_id, expectedCashReceived, actualCashReceived) VALUES(:customer, :expected, :actual)','',[':customer' => $getTransactionDetails['row']['customer_id'], ':expected' =>  $discountedAmount, ':actual' =>  $discountedAmount]);
		}else{
			query('INSERT INTO tbl_customerpaymentinfo(customer_id, expectedCashReceived) VALUES(:customer, :expected)','',[':customer' => $getTransactionDetails['row']['customer_id'], ':expected' =>  $discountedAmount]);
		}
	}
	
}

function getExpectedAmountGivenPerCustomer($customer_id){
	$expectedCashGiven = query("SELECT SUM(discountedAmount) as ecg FROM tbl_transactions","WHERE customer_id = :id",[":id" => $customer_id],"variable",1); 
	return (!empty($expectedCashGiven) ? $expectedCashGiven["row"]["ecg"] : 0);
}

function getExpectedAmountGivenPerCustomerPerDay($customer_id, $date){
	$expectedCashGiven = query("SELECT SUM(discountedAmount) as ecg FROM tbl_transactions ","WHERE customer_id = :id AND DATE_FORMAT(dateTime, '%Y-%m-%d') = :date",[":id" => $customer_id, ":date" => $date],"variable",1); 
	return (!empty($expectedCashGiven) ? $expectedCashGiven["row"]["ecg"] : 0);
}

function getActualAmountGivenPerCustomer($customer_id){
	if($customer_id != 0){

		$amountPaid = query("SELECT SUM(amountGiven) AS amountPaid FROM tbl_paymentmodificationbreakdown","WHERE customer_id = :id",[":id" => $customer_id],"variable",1);
		
		if((getExpectedAmountGivenPerCustomer($customer_id) == $amountPaid["row"]["amountPaid"])){
			return getExpectedAmountGivenPerCustomer($customer_id);
		}else{
			return $amountPaid["row"]["amountPaid"];
		}		
	}else{
		return 0;
	}
	
}

function getActualAmountGivenPerCustomerPerDay($customer_id, $date){
	if($customer_id != 0){
		$amountPaid = query("SELECT SUM(amountGiven) AS amountPaid FROM tbl_paymentmodificationbreakdown","WHERE customer_id = :id AND DATE_FORMAT(dateTimePaid, '%Y-%m-%d') = :date",[":id" => $customer_id, ":date" => $date],"variable",1);	
		return $amountPaid["row"]["amountPaid"];
	}else{
		return 0;
	}
}


function getOverAllExpectedAmount(){
	$totalExpectedAmount = query("SELECT SUM(discountedAmount) AS 'result' FROM tbl_transactions","","","variable",1);
	return !empty($totalExpectedAmount) ? $totalExpectedAmount["row"]["result"] : 0.00;
}

function getOverAllActualAmount(){
	
	$customerPaidTransactions = query("SELECT SUM(amountGiven) as amountPaid FROM tbl_paymentmodificationbreakdown","","","variable",1);

	$paidTransactionAmount = query("SELECT SUM(discountedAmount) as paidTransactionAmount FROM tbl_transactions WHERE customer_id = 0","","","variable",1);
	
	return $customerPaidTransactions["row"]["amountPaid"] + $paidTransactionAmount["row"]["paidTransactionAmount"];
}

function getOverAllExpectedAmountPerDate($dateSort = ""){
	$query = "SELECT SUM(discountedAmount) AS 'result' FROM tbl_transactions";
	$preparedQuery = "";
	$actualValues = array();
	
	if($dateSort != ""){
		$preparedQuery .= "WHERE DATE_FORMAT(dateTime, '%Y-%m-%d') >= :dateFrom AND DATE_FORMAT(dateTime, '%Y-%m-%d') <= :dateTo";
		$actualValues += array(':dateFrom' => $dateSort["dateFrom"], ':dateTo' => $dateSort["dateTo"]);
	}
	
	$totalExpectedAmount = query($query,$preparedQuery,$actualValues,"variable",1);
	return !empty($totalExpectedAmount) ? number_format($totalExpectedAmount["row"]["result"],2,".",",") : 0.00;
}

function getOverAllActualAmountPerDate($dateSort = ""){
	
	$actualAmount = 0;
	$dates = getDateOfTransactions($dateSort);
	$totalAmount = 0;
	
	foreach($dates as $date){
		$totalAmount += getOverAllActualAmountPerDay($date["row"]["date"]);
	}
	
	return number_format($totalAmount,2,".",",");
}

function getTotalNumberOfTransactionsPerDate($dateSort = ""){
	
	$query = "SELECT COUNT(id) AS 'totalNumberOfTransactions' FROM tbl_transactions";
	$preparedQuery = "";
	$actualValues = array();
	
	if($dateSort != ""){
		$preparedQuery .= "WHERE DATE_FORMAT(dateTime, '%Y-%m-%d') >= :dateFrom AND DATE_FORMAT(dateTime, '%Y-%m-%d') <= :dateTo";
		$actualValues += array(':dateFrom' => $dateSort["dateFrom"], ':dateTo' => $dateSort["dateTo"]);
	}
	$totalNumberOfTransactions = query($query,$preparedQuery,$actualValues,"variable",1);
	return $totalNumberOfTransactions["row"]["totalNumberOfTransactions"];
}

function getTotalNumberOfPaidTransactionsPerDate($dateSort = ""){
	
	$query = "SELECT COUNT(id) AS 'totalNumberOfPaidTransactions' FROM tbl_transactions";
	$preparedQuery = "WHERE remarks = :remarks";
	$actualValues = array(":remarks" => 1);
	
	if($dateSort != ""){
		$preparedQuery .= " AND DATE_FORMAT(dateTime, '%Y-%m-%d') >= :dateFrom AND DATE_FORMAT(dateTime, '%Y-%m-%d') <= :dateTo";
		$actualValues += array(':dateFrom' => $dateSort["dateFrom"], ':dateTo' => $dateSort["dateTo"]);
	}
	$totalNumberOfTransactions = query($query,$preparedQuery,$actualValues,"variable",1);
	return $totalNumberOfTransactions["row"]["totalNumberOfPaidTransactions"];
}

function getTotalNumberOfPendingTransactionsPerDate($dateSort = ""){
	
	$query = "SELECT COUNT(id) AS 'totalNumberOfPendingTransactions' FROM tbl_transactions";
	$preparedQuery = "WHERE remarks = :remarks";
	$actualValues = array(":remarks" => 0);
	
	if($dateSort != ""){
		$preparedQuery .= " AND DATE_FORMAT(dateTime, '%Y-%m-%d') >= :dateFrom AND DATE_FORMAT(dateTime, '%Y-%m-%d') <= :dateTo";
		$actualValues += array(':dateFrom' => $dateSort["dateFrom"], ':dateTo' => $dateSort["dateTo"]);
	}
	$totalNumberOfTransactions = query($query,$preparedQuery,$actualValues,"variable",1);
	return $totalNumberOfTransactions["row"]["totalNumberOfPendingTransactions"];
}

function getOverAllActualAmountPerDay($date){
	
	$actualAmount = 0;
	$getCustomerWithTransactions = query("SELECT DISTINCT(customer_id) as customer_id FROM tbl_paymentmodificationbreakdown","WHERE DATE_FORMAT(dateTimePaid, '%Y-%m-%d') = :date",[":date" => $date],"variable");
	
	$paidTransactionAmount = query("SELECT SUM(discountedAmount) as paidTransactionAmount FROM tbl_transactions","WHERE customer_id = :id AND DATE_FORMAT(dateTime, '%Y-%m-%d') = :date",[":id" => 0, ":date" => $date],"variable",1);
	
	foreach($getCustomerWithTransactions as $customer){
		$actualAmount += getActualAmountGivenPerCustomerPerDay($customer["row"]["customer_id"], $date);
	}
	
	return $actualAmount + $paidTransactionAmount["row"]["paidTransactionAmount"];
}

function getOverAllExpensesPerDay($date){
	$totalExpenses = query("SELECT SUM(amount) AS totalExpenses FROM tbl_expenses","WHERE DATE_FORMAT(date, '%Y-%m-%d') = :date",[":date" => $date],"variable",1);
	return !empty($totalExpenses) ? $totalExpenses["row"]["totalExpenses"] : 0.00; 
}

function getOverAllExpenses(){
	$totalExpenses = query("SELECT SUM(amount) AS totalExpenses FROM tbl_expenses","","","variable",1);
	return !empty($totalExpenses) ? $totalExpenses["row"]["totalExpenses"] : 0.00; 
}

function getRemainingBalance($customer_id){
	$amountPaid = query("SELECT SUM(amountGiven) AS ap FROM tbl_paymentmodificationbreakdown","WHERE customer_id = :id",[":id" => $customer_id],"variable",1);	
	
	if(($amountPaid["row"]["ap"]) < getExpectedAmountGivenPerCustomer($customer_id)){
		$bal = getExpectedAmountGivenPerCustomer($customer_id) - ($amountPaid["row"]["ap"]);
	}else{
		$bal = 0;
	}
	return $bal;
}


function getExpectedAmountPerDateForExisting($filterData = "", $textData = "", $dateSort = ""){
	
	$query = '';
	$preparedQuery = '';
	$actualValues = array();
	
	$query = 'SELECT SUM(discountedAmount) AS expectedAmount FROM tbl_transactions, tbl_customers WHERE tbl_transactions.customer_id = tbl_customers.customer_id';
					
	if($textData != ''){
		$preparedQuery .= ' AND tbl_transactions.'.$filterData.' = :filterData';
		$actualValues += array(':filterData' => $textData);
	}else{
		$preparedQuery .= ' AND tbl_customers.customer_id != :id';
		$actualValues += array(':id' => 0);
	}
	
	if($dateSort != ""){
		$preparedQuery .= ' AND DATE_FORMAT(tbl_transactions.dateTime,"%Y-%m-%d") >= :dateFrom AND DATE_FORMAT(tbl_transactions.dateTime,"%Y-%m-%d") <= :dateTo';
		$actualValues += array(':dateFrom' => $dateSort["dateFrom"], ':dateTo' => $dateSort["dateTo"]);
	}
	
	$expectedAmount = query($query,$preparedQuery,$actualValues,'variable',1);
	
	return $expectedAmount["row"]["expectedAmount"];	
}

function getActualAmountPerDateForExisting($filterData = "", $textData = "", $dateSort = ""){
	
	$query = '';
	$preparedQuery = '';
	$actualValues = array();
	
	if($filterData == "customer_id"){
		$query = 'SELECT SUM(amountGiven) AS actualAmount FROM tbl_paymentmodificationbreakdown, tbl_customers WHERE tbl_paymentmodificationbreakdown.customer_id = tbl_customers.customer_id';
						
		if($textData != ''){
			$preparedQuery .= ' AND tbl_customers.customer_id = :filterData';
			$actualValues += array(':filterData' => $textData);
		}else{
			$preparedQuery .= ' AND tbl_customers.customer_id != :id';
			$actualValues += array(':id' => 0);
		}
		
		if($dateSort != ""){
			$preparedQuery .= ' AND DATE_FORMAT(tbl_paymentmodificationbreakdown.dateTimePaid,"%Y-%m-%d") >= :dateFrom AND DATE_FORMAT(tbl_paymentmodificationbreakdown.dateTimePaid,"%Y-%m-%d") <= :dateTo';
			$actualValues += array(':dateFrom' => $dateSort["dateFrom"], ':dateTo' => $dateSort["dateTo"]);
		}	
		
		$actualAmount = query($query,$preparedQuery,$actualValues,'variable',1);
		
		return $actualAmount["row"]["actualAmount"];
	}else{
		$query = 'SELECT discountedAmount, remarks FROM tbl_transactions, tbl_customers WHERE tbl_transactions.customer_id = tbl_customers.customer_id';
						
		if($textData != ''){
			$preparedQuery .= ' AND tbl_transactions.id = :filterData';
			$actualValues += array(':filterData' => $textData);
		}
		
		if($dateSort != ""){
			$preparedQuery .= ' AND DATE_FORMAT(tbl_transactions.dateTime,"%Y-%m-%d") >= :dateFrom AND DATE_FORMAT(tbl_transactions.dateTime,"%Y-%m-%d") <= :dateTo';
			$actualValues += array(':dateFrom' => $dateSort["dateFrom"], ':dateTo' => $dateSort["dateTo"]);
		}	
		
		$result = query($query,$preparedQuery,$actualValues,'variable',1);
		
		if($result["row"]["remarks"] != 0){
			$actualAmount = number_format($result["row"]["discountedAmount"],2,".",",");
		}else{
			$actualAmount = 0.00;
		}
		return $actualAmount;
	}
}

function getActualAmountPerDateForWalkIn($textData = "", $dateSort = ""){
	
	$query = 'SELECT SUM(discountedAmount) AS actualAmount FROM tbl_transactions';
	$preparedQuery = 'WHERE customer_id = :id AND remarks = :remarks';
	$actualValues = array(":id" => 0, ":remarks" => 1);
			
	if($textData != ""){
		$preparedQuery .= ' AND transaction_id = :filterData';
		$actualValues += array(':filterData' => $textData);
	}

	if($dateSort != ""){
		$preparedQuery .= ' AND DATE_FORMAT(dateTime,"%Y-%m-%d") >= :dateFrom AND DATE_FORMAT(dateTime,"%Y-%m-%d") <= :dateTo';
		$actualValues += array(':dateFrom' => $dateSort["dateFrom"], ':dateTo' => $dateSort["dateTo"]);
	}
	
	$actualAmount = query($query,$preparedQuery,$actualValues,'variable',1);
	
	return $actualAmount["row"]["actualAmount"];	
}

function getExpectedAmountPerDateForWalkIn($textData = "", $dateSort = ""){
	
	$query = 'SELECT SUM(discountedAmount) AS expectedAmount FROM tbl_transactions';
	$preparedQuery = 'WHERE customer_id = :id';
	$actualValues = array(":id" => 0);
			
	if($textData != ""){
		$preparedQuery .= ' AND transaction_id = :filterData';
		$actualValues += array(':filterData' => $textData);
	}

	if($dateSort != ""){
		$preparedQuery .= ' AND DATE_FORMAT(dateTime,"%Y-%m-%d") >= :dateFrom AND DATE_FORMAT(dateTime,"%Y-%m-%d") <= :dateTo';
		$actualValues += array(':dateFrom' => $dateSort["dateFrom"], ':dateTo' => $dateSort["dateTo"]);
	}
	
	$expectedAmount = query($query,$preparedQuery,$actualValues,'variable',1);
	
	return $expectedAmount["row"]["expectedAmount"];	
}


function getDaysForExistingTransactions($dateSort = "", $filterData = "customer_id"){
	
	if($filterData == "customer_id"){
		$query = "SELECT DISTINCT(DATE_FORMAT(dateTime,'%Y-%m-%d')) FROM tbl_transactions";
		$preparedQuery = 'WHERE customer_id != :id';
		$actualValues = array(":id" => 0);
		
		if($dateSort != ""){
			$preparedQuery .= " AND DATE_FORMAT(dateTime,'%Y-%m-%d') = :dateFrom AND DATE_FORMAT(dateTime,'%Y-%m-%d') = :dateTo";
			$actualValues += array(":dateFrom" => $dateSort["dateFrom"], "dateTo" => $dateSort["dateTo"]);
		}
		$getDays = query($query,$preparedQuery,$actualValues,"variable");

		return count($getDays);	
	}else{
		return 1;
	}
}

function getDaysForWalkInTransactions($dateSort = "", $textData = ""){
	
	$query = "SELECT DISTINCT(DATE_FORMAT(dateTime,'%Y-%m-%d')) FROM tbl_transactions";
	$preparedQuery = 'WHERE customer_id = :id';
	$actualValues = array(":id" => 0);
	
	if($textData != ""){
		$preparedQuery .= " AND transaction_id = :transaction_id";
		$actualValues += array(":transaction_id" => $textData);
	}
	
	if($dateSort != ""){
		$preparedQuery .= " AND DATE_FORMAT(dateTime,'%Y-%m-%d') = :dateFrom AND DATE_FORMAT(dateTime,'%Y-%m-%d') = :dateTo";
		$actualValues += array(":dateFrom" => $dateSort["dateFrom"], "dateTo" => $dateSort["dateTo"]);
	}
	$getDays = query($query, $preparedQuery, $actualValues,"variable");
	
	return count($getDays);	
}


function getDateOfTransactions($dateSort = "", $sortOrder = "DESC"){
	
	$query = "SELECT DISTINCT(DATE_FORMAT(dateTimePaid, '%Y-%m-%d')) as date FROM tbl_paymentmodificationbreakdown";
	$preparedQuery = "";
	$actualValues = array();
	
	if($dateSort != ""){
		$preparedQuery .= " WHERE DATE_FORMAT(dateTimePaid, '%Y-%m-%d') >= :dateFrom AND DATE_FORMAT(dateTimePaid, '%Y-%m-%d') <= :dateTo";
		$actualValues += array(':dateFrom' => $dateSort["dateFrom"], ':dateTo' => $dateSort["dateTo"]);
	}
	
	if($preparedQuery != ''){
		$preparedQuery .= " ORDER BY DATE_FORMAT(dateTimePaid, '%Y-%m-%d') ".$sortOrder;
	}else{
		$query .= " ORDER BY DATE_FORMAT(dateTimePaid, '%Y-%m-%d') ".$sortOrder;
	}
	
	$dates1 = query($query, $preparedQuery, $actualValues, "variable");

	$query = "SELECT DISTINCT(DATE_FORMAT(dateTime, '%Y-%m-%d')) as date FROM tbl_transactions";
	$preparedQuery = "WHERE customer_id = :id";
	$actualValues = array(":id" => 0);
	
	if($dateSort != ""){
		$preparedQuery .= " AND DATE_FORMAT(dateTime, '%Y-%m-%d') >= :dateFrom AND DATE_FORMAT(dateTime, '%Y-%m-%d') <= :dateTo";
		$actualValues += array(':dateFrom' => $dateSort["dateFrom"], ':dateTo' => $dateSort["dateTo"]);
	}
	
	if($preparedQuery != ''){
		$preparedQuery .= " ORDER BY DATE_FORMAT(dateTime, '%Y-%m-%d') ".$sortOrder;
	}else{
		$query .= " ORDER BY DATE_FORMAT(dateTime, '%Y-%m-%d') ".$sortOrder;
	}
	
	$dates2 = query($query, $preparedQuery, $actualValues, "variable");
	
	$dates = array_merge($dates1, $dates2);
	$officialDates = array_unique(sortDateOrder($dates, $sortOrder),SORT_REGULAR);
	
	return $officialDates;
}

function sortDateOrder($dates, $sortOrder = ""){
	
	for($i = 0; $i < count($dates); $i++){
		for($j = 0;$j < count($dates); $j++){
			
			if($sortOrder == "DESC"){
				if(strtotime($dates[$i]["row"]["date"]) > strtotime($dates[$j]["row"]["date"])){
					$temp = $dates[$i]["row"]["date"];
					$dates[$i]["row"]["date"] = $dates[$j]["row"]["date"];
					$dates[$j]["row"]["date"] = $temp;
					
				}	
			}elseif($sortOrder == "ASC"){
				if(strtotime($dates[$i]["row"]["date"]) < strtotime($dates[$j]["row"]["date"])){
					$temp = $dates[$i]["row"]["date"];
					$dates[$i]["row"]["date"] = $dates[$j]["row"]["date"];
					$dates[$j]["row"]["date"] = $temp;
				}	
			}
		}
	}
	return $dates;
}


function getTotalCapital(){
	$capital = query("SELECT SUM(wholeSalePrice * stocks) as capital FROM tbl_items","","","variable",1);

	return $capital["row"]["capital"];
}

function printInvoice($id){
	
	require_once('../../PHPExcel/PHPExcel/IOFactory.php');

	//Load Invoice format
	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	$objPHPExcel = $objReader->load("../../eiblinFiles/invoice/template/invoice format.xlsx");

	$getLatestTransaction = query('SELECT * FROM tbl_transactions INNER JOIN tbl_accounts ON tbl_transactions.account_id = tbl_accounts.account_id','WHERE tbl_transactions.account_id = :account_id AND tbl_transactions.id = :id',[":id" => $id, ':account_id' => parseSession($_SESSION['account_id'])],'variable',1);
	
	$get_customer_info = query("SELECT * FROM tbl_customers","WHERE customer_id = :id",[":id" => $getLatestTransaction["row"]["customer_id"]],"variable",1);
	
	$customer_name = !empty($get_customer_info) ? $get_customer_info["row"]["name"] : "";
	$customer_address = !empty($get_customer_info) ? $get_customer_info["row"]["address"] : "";
	$customer_TIN_No = !empty($get_customer_info) ? $get_customer_info["row"]["TinNo"] : "";
	
	// Set page orientation and size
	
	$objPHPExcel->getActiveSheet()->setCellValue('G2', date('m-d-Y',strtotime($getLatestTransaction['row']['dateTime'])))
								  ->setCellValue('C3', $customer_name)
								  ->setCellValue('B5', $customer_address)
								  ->setCellValue('B6', $customer_TIN_No)
								  ->setCellValue('F5', $getLatestTransaction['row']['purchaseOrderNo']);
	
	$getTransactionDetails = query('SELECT * FROM tbl_transactionbreakdowns INNER JOIN tbl_items ON tbl_transactionbreakdowns.item_id = tbl_items.itemId INNER JOIN tbl_units ON tbl_items.unit_id = tbl_units.unit_id','WHERE tbl_transactionbreakdowns.transaction_id = :id ORDER BY tbl_transactionbreakdowns.transactionBreakdown_id DESC',[':id' => $getLatestTransaction['row']['transaction_id']],'variable');
	
	//Display all transacted items
	$i = 8;
	foreach($getTransactionDetails as $transaction){
		$objPHPExcel->getACtiveSheet()->setCellValue('A'.$i, $transaction['row']['noOfItem'])
									  ->setCellValue('B'.$i, $transaction['row']['unit'])
								      ->setCellValue('C'.$i, $transaction['row']['description'])
									  ->setCellValue('G'.$i, $transaction['row']['itemPrice'])
									  ->setCellValue('H'.$i, $transaction['row']['amount']);
		$i = $i + 1;
	}
	
	$objPHPExcel->getACtiveSheet()->setCellValue('H24', $getLatestTransaction['row']['totalVATable'])
								  ->setCellValue('H26', $getLatestTransaction['row']['totalVAT'])
								  ->setCellValue('H27', $getLatestTransaction['row']['discountedAmount'])
								  ->setCellValue('H28', $getLatestTransaction['row']['amountChange']);
	
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Save Excel 2007 file
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	
	$customer = str_replace("/"," ",$customer_name);
	
	//$path = 'C:xampp/htdocs/benCopier/benCopierFiles/invoice/'.$customer;
	$path = 'D:/EIBLIN/Desktop/invoice/'.$customer;
	//$path = 'C:/xampp/htdocs/eiblin/eiblinFiles/invoice/'.$customer;
	
	if(file_exists($path)){
		$path .= '/invoice '.$getLatestTransaction['row']['transaction_id'].'.xlsx';
	}else{
		mkdir($path);
		$path .= '/invoice '.$getLatestTransaction['row']['transaction_id'].'.xlsx';
	}
	
	$objWriter->save($path);
}


function uploadFile($file){
	
	require_once('../../PHPExcel/PHPExcel/IOFactory.php');
	
	$objPHPExcel = PHPExcel_IOFactory::load($file);
	
	foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
		$worksheetTitle     = $worksheet->getTitle();
		$highestRow         = $worksheet->getHighestRow(); // e.g. 10
		$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
		
		for($row = 2; $row <= $highestRow; ++ $row) {
			$val = array();
			for ($col = 0; $col < $highestColumnIndex; ++ $col) {
			   $cell = $worksheet->getCellByColumnAndRow($col, $row);
			   $val[] = $cell->getValue();
			}
			$uploadResult = insertNewItem($val);
		}	
	}

	return $uploadResult;
}

function getFileRows($file){
	
	require_once('../../PHPExcel/PHPExcel/IOFactory.php');
	
	$objPHPExcel = PHPExcel_IOFactory::load($file);
	
	foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
		$highestRow  = $worksheet->getHighestRow(); // e.g. 10
	}

	return $highestRow;
}

function getItemCategory($itemCategoryInfo){
	
	if($itemCategoryInfo != '' || $itemCategoryInfo != NULL){
		$getItemCategory = query('SELECT * FROM tbl_itemcategories','WHERE itemCategory LIKE :itemCategory',[':itemCategory' => $itemCategoryInfo],'variable',1);
		
		if(!empty($getItemCategory)){
			$itemCategory = $getItemCategory['row']['itemCategory_id'];
		}else{
			$insertNewItemCategory = query('INSERT INTO tbl_itemcategories(itemCategory) VALUES(:itemCategory)','',[':itemCategory' => $itemCategoryInfo]);
			$getItemCategory = query('SELECT itemCategory_id FROM tbl_itemcategories ORDER BY itemCategory_id DESC LIMIT 1','','','variable',1);
			$itemCategory = $getItemCategory['row']['itemCategory_id'];
		}	
	}else{
		$itemCategory = '';
	}
	
	return $itemCategory;
}

function getUnit($unitInfo = NULL){
	
	if($unitInfo != ''){
		$getUnit = query('SELECT * FROM tbl_units','WHERE unit LIKE :unit ',[':unit' => $unitInfo],'variable',1);	
		
		if(!empty($getUnit)){
			$unit = $getUnit['row']['unit_id'];
		}else{
			$insertNewUnit = query('INSERT INTO tbl_units(unit) VALUES(:unit_id)','',[':unit_id' => $unitInfo]);
			$getUnit = query('SELECT unit_id FROM tbl_units ORDER BY unit_id DESC LIMIT 1','','','variable',1);
			$unit = $getUnit['row']['unit_id'];
		}	
	}else{
		$unit = '';
	}
	
	return $unit;
}

function insertNewItem($itemInfo){
	
	$itemCode = isset($itemInfo[0]) || $itemInfo[0] != NULL  ? $itemInfo[0] : '';
	$itemDescription = isset($itemInfo[1]) || $itemInfo[1] != NULL ? $itemInfo[1] : '';
	$wholeSalePrice = isset($itemInfo[2]) || $itemInfo[2] != NULL ? $itemInfo[2] : '';
	$wholePricePercentageIncrease = isset($itemInfo[3]) || $itemInfo[3] != NULL ? $itemInfo[3] : '';
	$suggestedRetailPrice = isset($itemInfo[4]) || $itemInfo[4] != NULL ? $itemInfo[4] : '';
	$unit = getUnit($itemInfo[5]);
	$stocks = isset($itemInfo[6]) ? $itemInfo[6] : '';
		
	/* $verifyItemCode = query('SELECT * FROM tbl_items','WHERE description = :description',[':description' => $itemDescription],'variable',1);
	
	if(!empty($verifyItemCode)){
		$updateStocks = query(
								'UPDATE tbl_items',
								'SET 
									itemCode = :itemCode, 
									wholePricePercentageIncrease = :wholePricePercentageIncrease, 
									wholeSalePrice = :wholeSalePrice,
									suggestedRetailPrice = :suggestedRetailPrice,
									unit_id = :unit_id,
									stocks = :stocks
								WHERE 
									description = :description',
							[
								':itemCode' => $itemCode, 
								':wholePricePercentageIncrease' => $wholePricePercentageIncrease, 
								':wholeSalePrice' => $wholeSalePrice, 
								':suggestedRetailPrice' => $suggestedRetailPrice, 
								':unit_id' => $unit, 
								':stocks' => $stocks,
								'description' => $itemDescription
							]
						);
	}else{ */
		$insertNewItem = query(
						'INSERT INTO tbl_items(
							itemCode,
							description,
							wholePricePercentageIncrease,
							wholeSalePrice,
							suggestedRetailPrice,
							unit_id,
							stocks
						) VALUES(
							:itemCode,
							:description,
							:wholePricePercentageIncrease,
							:wholeSalePrice,
							:suggestedRetailPrice,
							:unit_id,
							:stocks
						)','',
						[	
							':itemCode' => $itemCode,
							':description' => $itemDescription,
							':wholePricePercentageIncrease' => $wholePricePercentageIncrease,
							':wholeSalePrice' => $wholeSalePrice,
							':suggestedRetailPrice' => $suggestedRetailPrice,
							':unit_id' => $unit,
							':stocks' => $stocks
						]
				);	
					
	//}
	
	return 1;
}


function generatePurchaseOrder($transaction_id, $withDate){
	
	require_once('../../PHPExcel/PHPExcel/IOFactory.php');

	//Load Invoice format
	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	$objPHPExcel = $objReader->load("../../eiblinFiles/purchase order/template/purchase order.xlsx");
	
	$getTransactionToBeGenerated = query('SELECT * FROM tbl_transactions','WHERE transaction_id = :id',[':id' => $transaction_id],'variable',1);
	
	$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Customer: '.$getTransactionToBeGenerated['row']['customer']);
	
	//if($withDate == 1)
		//$objPHPExcel->getActiveSheet()->setCellValue('H6',date('m-d-Y',strtotime($getTransactionToBeGenerated['row']['dateTime'])));	
	
	//$objPHPExcel->getActiveSheet()->setCellValue('C13',$getTransactionToBeGenerated['row']['customer']);
	//$objPHPExcel->getActiveSheet()->setCellValue('E40',$getTransactionToBeGenerated['row']['customer']);
	
	$getTransactionDetails = query('SELECT * FROM tbl_transactionbreakdowns INNER JOIN tbl_items ON tbl_transactionbreakdowns.item_id = tbl_items.itemId INNER JOIN tbl_units ON tbl_items.unit_id = tbl_units.unit_id','WHERE tbl_transactionbreakdowns.transaction_id = :id ORDER BY tbl_transactionbreakdowns.transactionBreakdown_id DESC',[':id' => $transaction_id],'variable');
	
	$itemNoCounter = 1;
	$purchaseOrderCounter = 17;
	$quotationCounter = 29;
	$requestCounter = 18;
	$inspectionCounter = 7;
	$requisitionCounter = 9;
	
	foreach($getTransactionDetails as $transaction){
		// for Purchase order
		$objPHPExcel->setActiveSheetIndex(2);
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$purchaseOrderCounter, $itemNoCounter)
									  ->setCellValue('C'.$purchaseOrderCounter, $transaction['row']['unit'])
									  ->setCellValue('D'.$purchaseOrderCounter, $transaction['row']['noOfItem'])
									  ->setCellValue('E'.$purchaseOrderCounter, $transaction['row']['description'])
									  ->setCellValue('G'.$purchaseOrderCounter, $transaction['row']['itemPrice'])
									  ->setCellValue('H'.$purchaseOrderCounter, $transaction['row']['amount']);
		
		
		// for Quotation
		$objPHPExcel->setActiveSheetIndex(1);
		$objPHPExcel->getACtiveSheet()->setCellValue('A'.$quotationCounter,'=PO!A'.$purchaseOrderCounter)
									  ->setCellValue('B'.$quotationCounter,'=PO!E'.$purchaseOrderCounter)
									  ->setCellValue('E'.$quotationCounter,'=PO!C'.$purchaseOrderCounter)
									  ->setCellValue('F'.$quotationCounter,'=PO!D'.$purchaseOrderCounter)
									  ->setCellValue('G'.$quotationCounter,'=PO!G'.$purchaseOrderCounter);
									  
		// for Request
		$objPHPExcel->setActiveSheetIndex(3);
		$objPHPExcel->getACtiveSheet()->setCellValue('A'.$requestCounter,'=PO!D'.$purchaseOrderCounter)
									  ->setCellValue('B'.$requestCounter,'=PO!C'.$purchaseOrderCounter)
									  ->setCellValue('C'.$requestCounter,'=PO!E'.$purchaseOrderCounter)
									  ->setCellValue('H'.$requestCounter,'=PO!A'.$purchaseOrderCounter)
									  ->setCellValue('I'.$requestCounter,'=PO!G'.$purchaseOrderCounter)
									  ->setCellValue('J'.$requestCounter,'=PO!H'.$purchaseOrderCounter);
									  
									  
		// for Inspection
		$objPHPExcel->setActiveSheetIndex(4);
		$objPHPExcel->getACtiveSheet()->setCellValue('A'.$inspectionCounter,'=PO!A'.$purchaseOrderCounter)
									  ->setCellValue('B'.$inspectionCounter,'=PO!C'.$purchaseOrderCounter)
									  ->setCellValue('C'.$inspectionCounter,'=PO!E'.$purchaseOrderCounter)
									  ->setCellValue('D'.$inspectionCounter,'=PO!D'.$purchaseOrderCounter);
									  
									  
		// for Requisition
		$objPHPExcel->setActiveSheetIndex(5);
		$objPHPExcel->getACtiveSheet()->setCellValue('A'.$requisitionCounter,'=PO!A'.$purchaseOrderCounter)
									  ->setCellValue('B'.$requisitionCounter,'=PO!C'.$purchaseOrderCounter)
									  ->setCellValue('C'.$requisitionCounter,'=PO!E'.$purchaseOrderCounter)
									  ->setCellValue('F'.$requisitionCounter,'=PO!D'.$purchaseOrderCounter);
									  
					
		$itemNoCounter = $itemNoCounter + 1;
		$purchaseOrderCounter = $purchaseOrderCounter + 1;
		$quotationCounter = $quotationCounter + 1;
		$inspectionCounter = $inspectionCounter + 1;
		$requestCounter = $requestCounter + 1;
		$requisitionCounter = $requisitionCounter + 1;
		$objPHPExcel->setActiveSheetIndex(2);
	}
	
	$objPHPExcel->setActiveSheetIndex(2);
	$objPHPExcel->getActiveSheet()->setCellValue('H46',$getTransactionToBeGenerated['row']['discountedAmount']);		

	// Save Excel 2007 file
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$customer = str_replace("/"," ",$getTransactionToBeGenerated['row']['customer']);
	$path = 'C:xampp/htdocs/benCopier/benCopierFiles/purchase order/'.$customer;
	
	if(file_exists($path)){
		$path .= '/purchase Order '.$transaction_id.'.xlsx';
	}else{
		mkdir($path);
		$path .= '/purchase Order '.$transaction_id.'.xlsx';
	}
	$objWriter->save($path);
	
	return $path;
}

function generateStatement($customer_id){
	require_once('../../PHPExcel/PHPExcel/IOFactory.php');

	$getPendingTransactions = query('SELECT * FROM tbl_transactions','WHERE customer_id = :customer_id AND remarks = :remarks ORDER BY dateTime ASC',[':customer_id' => $customer_id, ':remarks' => 0],'variable');
	
	$getPendingTransactionsCount = query('SELECT * FROM tbl_transactions','WHERE customer_id = :customer_id AND remarks = :remarks',[':customer_id' => $customer_id, ':remarks' => 0],'rows');
	
	$customerInfo = query('SELECT name,address,contactInfo FROM tbl_customers','WHERE customer_id = :customer_id',[':customer_id' => $customer_id],'variable',1);
	
	if($getPendingTransactionsCount < 27){
		//Load Invoice format
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objPHPExcel = $objReader->load("../../eiblinFiles/statement of accounts/template/statement-landscape.xlsx");
	
		$objPHPExcel->setActiveSheetIndex(0);
		
		$sheet = $objPHPExcel->getActiveSheet();
		
		$sheet->setCellValue('B7',$customerInfo['row']['name']);	
		$sheet->setCellValue('B8',$customerInfo['row']['address']);	
		$sheet->setCellValue('B9',$customerInfo['row']['contactInfo']);	
		$sheet->setCellValue('E7',date('M d, Y'));	
		
		$sheet->setCellValue('H7',$customerInfo['row']['name']);	
		$sheet->setCellValue('H8',$customerInfo['row']['address']);	
		$sheet->setCellValue('H9',$customerInfo['row']['contactInfo']);	
		$sheet->setCellValue('K7',date('M d, Y'));	
		
		$size = 11;
		foreach($getPendingTransactions as $transaction){
			
			$sheet->mergeCells('B'.$size.':C'.$size);
			$sheet->getStyle('B'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
			
			$sheet->mergeCells('H'.$size.':I'.$size);
			$sheet->getStyle('H'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
			
			$sheet->getStyle('D'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
			$sheet->getStyle('J'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
			
			$sheet->getStyle('E'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
			$sheet->getStyle('E'.$size)->getNumberFormat()->setFormatCode('#,##0.00'); 
			$sheet->getStyle('K'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
			$sheet->getStyle('K'.$size)->getNumberFormat()->setFormatCode('#,##0.00'); 
			
			
			$sheet->setCellValue('A'.$size, date('m d, Y' ,strtotime($transaction['row']['dateTime'])))
										  ->setCellValue('B'.$size, $transaction['row']['transaction_id'])
										  ->setCellValue('D'.$size, $transaction['row']['purchaseOrderNo'])
										  ->setCellValue('E'.$size, number_format($transaction['row']['discountedAmount'],2,'.',','));
				
			$sheet->setCellValue('G'.$size, date('m d, Y' ,strtotime($transaction['row']['dateTime'])))
										  ->setCellValue('H'.$size, $transaction['row']['transaction_id'])
										  ->setCellValue('J'.$size, $transaction['row']['purchaseOrderNo'])
										  ->setCellValue('K'.$size, number_format($transaction['row']['discountedAmount'],2,'.',','));
					
			$styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
			$sheet->getStyle('A'.$size.':E'.$size)->applyFromArray($styleArray);
			$sheet->getStyle('G'.$size.':K'.$size)->applyFromArray($styleArray);
			$size = $size + 1;
		
		}	
		
		$expectedCash = query('SELECT FORMAT(SUM(totalAmountDue),2) as expectedCash FROM tbl_transactions','WHERE customer_id = :customer_id AND remarks = :remarks',[':customer_id' => $customer_id, ':remarks' => 0],'variable',1);
		$expectedCash = empty($expectedCash['row']['expectedCash']) ? '0.00' : $expectedCash['row']['expectedCash'];
	
		$size = $size + 1;
		$sheet->mergeCells('B'.$size.':C'.$size);
		$sheet->getStyle('B'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$sheet->getStyle('E'.$size)->getNumberFormat()->setFormatCode('#,##0.00'); 
		$sheet->getStyle('E'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
		$sheet->setCellValue('B'.$size ,'TOTAL');	
		$sheet->setCellValue('E'.$size ,$expectedCash);	
		
		$sheet->mergeCells('H'.$size.':I'.$size);
		$sheet->getStyle('H'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$sheet->getStyle('K'.$size)->getNumberFormat()->setFormatCode('#,##0.00'); 
		$sheet->getStyle('K'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
		$sheet->setCellValue('H'.$size ,'TOTAL');	
		$sheet->setCellValue('K'.$size ,$expectedCash);	
		
		$size = $size + 1;
		$sheet->mergeCells('B'.$size.':C'.$size);
		$sheet->getStyle('B'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$sheet->setCellValue('B'.$size,'RETURNS');	
		
		$sheet->mergeCells('H'.$size.':I'.$size);
		$sheet->getStyle('H'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$sheet->setCellValue('H'.$size,'RETURNS');	
		
		
		$size = $size + 1;
		$sheet->mergeCells('B'.$size.':C'.$size);
		$sheet->getStyle('B'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$sheet->setCellValue('B'.$size,'PREVIOUS PAYMENT');	
		
		$sheet->mergeCells('H'.$size.':I'.$size);
		$sheet->getStyle('H'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$sheet->setCellValue('H'.$size,'PREVIOUS PAYMENT');	
		
		
		$size = $size + 1;
		$sheet->mergeCells('B'.$size.':C'.$size);
		$sheet->getStyle('B'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$sheet->getStyle('D'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
		$sheet->getStyle('E'.$size)->getNumberFormat()->setFormatCode('#,##0.00'); 
		$sheet->getStyle('E'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
		$sheet->setCellValue('B'.$size,'GRANDTOTAL');	
		$sheet->setCellValue('D'.$size,'Php');	
		$sheet->setCellValue('E'.$size ,$expectedCash);	
		
		$sheet->mergeCells('H'.$size.':I'.$size);
		$sheet->getStyle('H'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$sheet->getStyle('K'.$size)->getNumberFormat()->setFormatCode('#,##0.00'); 
		$sheet->getStyle('K'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
		$sheet->getStyle('J'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
		$sheet->setCellValue('H'.$size,'GRANDTOTAL');	
		$sheet->setCellValue('J'.$size,'Php');	
		$sheet->setCellValue('K'.$size ,$expectedCash);	
		
		
		$size = $size + 2;
		$sheet->setCellValue('A'.$size ,'Please disregard statement if payment has been made. Thank you...');	
		
		$sheet->setCellValue('G'.$size ,'Please disregard statement if payment has been made. Thank you...');	
		
		
		$size = $size + 2;
		$sheet->setCellValue('A'.$size ,'EIBLIN ENTERPRISES');	
		
		$sheet->setCellValue('G'.$size ,'EIBLIN ENTERPRISES');	
		
		$size = $size + 1;
		$sheet->setCellValue('A'.$size ,'_____________________');	
		
		$sheet->setCellValue('G'.$size ,'_____________________');	
		
		
		$size = $size + 1;
		$sheet->setCellValue('D'.$size ,'Received By');	
		
		$sheet->setCellValue('J'.$size ,'Received By');	
		
		
		$size = $size + 1;
		$sheet->setCellValue('D'.$size ,'________________________');	
		
		$sheet->setCellValue('J'.$size ,'________________________');	
		
		$size = $size + 1;
		$sheet->getStyle('D'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT));
		$sheet->getStyle('J'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT));
		
		$sheet->setCellValue('D'.$size ,'Signature over printed name');	
		
		$sheet->setCellValue('J'.$size ,'Signature over printed name');	
		
		
	}else{
		
		//Load Invoice format
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objPHPExcel = $objReader->load("../../eiblinFiles/statement of accounts/template/statement-portrait.xlsx");
	
		$objPHPExcel->setActiveSheetIndex(0);
		
		$sheet = $objPHPExcel->getActiveSheet();
		
		$sheet->setCellValue('B7',$customerInfo['row']['name']);	
		$sheet->setCellValue('B8',$customerInfo['row']['address']);	
		$sheet->setCellValue('B9',$customerInfo['row']['contactInfo']);	
		$sheet->setCellValue('E7',date('M d, Y'));	
		
		$size = 11;
		$init = 45;
		$page = 1;
		$pageTotal = 0;
		$counter = 1;
		$pageTotalArray = array();
		
		foreach($getPendingTransactions as $transaction){
			$styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
			$sheet->getStyle('A'.$size.':E'.$size)->applyFromArray($styleArray);
			
			$sheet->mergeCells('B'.$size.':C'.$size);
			$sheet->getStyle('B'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
			
			$sheet->getStyle('E'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
			$sheet->getStyle('E'.$size)->getNumberFormat()->setFormatCode('#,##0.00'); 
			$sheet->setCellValue('A'.$size, date('m d, Y' ,strtotime($transaction['row']['dateTime'])))
										  ->setCellValue('B'.$size, $transaction['row']['transaction_id'])
										  ->setCellValue('D'.$size, $transaction['row']['purchaseOrderNo'])
										  ->setCellValue('E'.$size, number_format($transaction['row']['discountedAmount'],2,'.',','));
					
			
			$pageTotal += $transaction['row']['discountedAmount'];
			if($size == $init){
				$init += 48;
				
				$size = $size + 2;
				$sheet->getStyle('A'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$sheet->setCellValue('A'.$size, 'PAGE '.$page);
				
				$sheet->mergeCells('B'.$size.':C'.$size);
				$sheet->getStyle('B'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
				$sheet->setCellValue('B'.$size, 'TOTAL');
				
				$sheet->getStyle('D'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
				$sheet->setCellValue('D'.$size, 'Php');
				
				$sheet->getStyle('E'.$size)->getNumberFormat()->setFormatCode('#,##0.00'); 
				$sheet->setCellValue('E'.$size, $pageTotal);
				
				$pageTotalArray[] = $pageTotal;
				$pageTotal = 0;
				$page += 1;
				$size = $size + 1;
				
			}else{
				
				if($counter == $getPendingTransactionsCount){
					$size = $size + 2;
					$sheet->getStyle('A'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
					$sheet->setCellValue('A'.$size, 'PAGE '.$page);
					
					$sheet->mergeCells('B'.$size.':C'.$size);
					$sheet->getStyle('B'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
					$sheet->setCellValue('B'.$size, 'TOTAL');
					
					$sheet->getStyle('D'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
					$sheet->setCellValue('D'.$size, 'Php');
					
					$sheet->getStyle('E'.$size)->getNumberFormat()->setFormatCode('#,##0.00'); 
					$sheet->setCellValue('E'.$size, $pageTotal);
					$pageTotalArray[] = $pageTotal;
				}
				
				$size = $size + 1;
			}

			$counter += 1;
		}	
		
		$expectedCash = query('SELECT FORMAT(SUM(totalAmountDue),2) as expectedCash FROM tbl_transactions','WHERE customer = :customer AND remarks = :remarks',[':customer' => $customer, ':remarks' => 0],'variable',1);
		$expectedCash = empty($expectedCash['row']['expectedCash']) ? '0.00' : $expectedCash['row']['expectedCash'];
	
		$size = $size + 1;
		$sheet->mergeCells('B'.$size.':C'.$size);
		$sheet->getStyle('B'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$sheet->setCellValue('B'.$size,'RETURNS');	
		
		
		$size = $size + 1;
		$sheet->mergeCells('B'.$size.':C'.$size);
		$sheet->getStyle('B'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$sheet->setCellValue('B'.$size,'PREVIOUS PAYMENT');	
		
	
		$grandTotal = 0;
		for($i = 0; $i < count($pageTotalArray); $i++){
			$size = $size + 1;
			$sheet->getStyle('E'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
			$sheet->getStyle('E'.$size)->getNumberFormat()->setFormatCode('#,##0.00'); 		
			$sheet->setCellValue('E'.$size, $pageTotalArray[$i]);
			$grandTotal += $pageTotalArray[$i];
		}
		
		$size = $size + 1;
		$sheet->mergeCells('B'.$size.':C'.$size);
		$sheet->getStyle('B'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$sheet->getStyle('E'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
		$sheet->getStyle('D'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
		$sheet->setCellValue('B'.$size,'GRANDsTOTAL');	
		$sheet->setCellValue('D'.$size,'Php');	
		$sheet->getStyle('E'.$size)->getNumberFormat()->setFormatCode('#,##0.00'); 	
		$sheet->setCellValue('E'.$size ,$grandTotal);	
		
		
		$size = $size + 2;
		$sheet->setCellValue('A'.$size ,'Please disregard statement if payment has been made. Thank you...');	
		
		
		$size = $size + 2;
		$sheet->setCellValue('A'.$size ,'EIBLIN ENTERPRISES');	
		
		
		$size = $size + 1;
		$sheet->setCellValue('A'.$size ,'_____________________');	
		
		
		$size = $size + 1;
		$sheet->setCellValue('D'.$size ,'Received By');	
		
		
		$size = $size + 1;
		$sheet->setCellValue('D'.$size ,'________________________');	
		
		$size = $size + 1;
		$sheet->getStyle('D'.$size)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT));
		$sheet->setCellValue('D'.$size ,'Signature over printed name');	
	}
	
	
	//$totalCash = query('SELECT FORMAT(SUM(discountedAmount),2) as totalCash FROM tbl_transactions','WHERE customer = :customer AND remarks = :remarks',[':customer' => $customer, ':remarks' => 1],'variable',1);
	//$totalCash = empty($totalCash['row']['totalCash']) ? '0.00' : $totalCash['row']['totalCash'];
	
	// Save Excel 2007 file
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$customer = str_replace("/"," ",$customerInfo['row']['name']);
	//$path = 'C:xampp/htdocs/benCopier/benCopierFiles/statement of accounts/'.$customer;
	$path = 'D:/EIBLIN/Desktop/statement of accounts/'.$customer;
	//$path = 'C:/xampp/htdocs/eiblin/eiblinFiles/statement of accounts/'.$customer;
	
	if(file_exists($path)){
		$path .= '/statement of account ('.date('M d,Y').').xlsx';
	}else{
		mkdir($path);
		$path .= '/statement of account ('.date('M d,Y').').xlsx';
	}
	
	$objWriter->save($path);
	
	return $path;
}

function exportItemList(){
	require_once('../../PHPExcel/PHPExcel/IOFactory.php');
	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	$objPHPExcel = $objReader->load("../../eiblinFiles/list of items/template/list of items.xlsx");
		
	$itemList = query("SELECT * FROM tbl_items ORDER BY description ASC","","","variable");	

	$row = 2;
	foreach($itemList as $item){
		$getUnit = query("SELECT unit FROM tbl_units","WHERE unit_id = :id",[":id" => $item["row"]["unit_id"]],"variable",1);
		$unit = !empty($getUnit) ? $getUnit["row"]["unit"] : "";
		$sheet = $objPHPExcel->getActiveSheet();
		
		$sheet->setCellValue('A'.$row, $item["row"]["itemId"]);
		$sheet->setCellValue('B'.$row, $item['row']['description']);
		$sheet->getStyle('C'.$row)->getNumberFormat()->setFormatCode('#,##0.00'); 	
		$sheet ->setCellValue('C'.$row, $item['row']['wholeSalePrice']);
		$sheet->setCellValue('D'.$row, $item['row']['wholePricePercentageIncrease']);
		$sheet->getStyle('E'.$row)->getNumberFormat()->setFormatCode('#,##0.00'); 
		$sheet->setCellValue('E'.$row, $item['row']['suggestedRetailPrice']);
		$sheet->setCellValue('F'.$row, $unit);
		$sheet->setCellValue('G'.$row, $item['row']['stocks']);
		
		$row = $row + 1;
	}
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$folder_path = "C:/Users/User/Desktop/Official Item List/";
	//$path = 'C:/xampp/htdocs/eiblin/eiblinFiles/list of items/official list of items.xlsx';
	if(!file_exists($folder_path)){
		mkdir($folder_path);
		$folder_path .= "official list of items.xlsx";
	}else{
		$folder_path .= "official list of items.xlsx";
	}
	$objWriter->save($folder_path);
	
	return $folder_path;
}
