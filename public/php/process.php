<?php 

require_once('../../functions/sqlQuery.function.php');
require_once('../../functions/system.function.php');
require_once('../../library/directoryPath.php');

$PATH_ADMIN = '../../views/admin/';
$PATH_STAFF = '../../views/staff/';
$PATH_GENERAL = '../../views/';	

if(isset($_POST["deleteTransactions"])){
	query("DELETE FROM tbl_transactions");
	query("DELETE FROM tbl_transactionbreakdowns");
	query("DELETE FROM tbl_paymentmodificationbreakdown");
}

if(isset($_POST['showComponents'])){
	
	$components = $_POST['components'];
	$page = $_POST['page'];
	$tblname = $_POST['tblname'];
	$sortOrder = $_POST['sortOrder'];
	$id = $_POST['id'];
	$textData = sanitizeInput($_POST['textData']);
	$filterData = $_POST['filterData'];
	$dateSort = isset($_POST["dateData"]) ? $_POST["dateData"] : "";
	
	if($components == 'pagination'){
		
		$query = '';
		$preparedQuery = '';
		$actualValues = array();
		
			if($tblname == 'tbl_items'){
				if($id == 0 || $id == 3){
					$query = 'SELECT * FROM tbl_items';
					
					if($textData != ''){
						$preparedQuery .= 'WHERE description LIKE :description OR area LIKE :area OR supplier LIKE :supplier OR itemCode LIKE :itemCode OR unit LIKE :unit';
						$actualValues += array(':description' => '%'.$textData.'%', ':area' => '%'.$textData.'%', ':supplier' => '%'.$textData.'%', ':itemCode' => '%'.$textData.'%', ':unit' => '%'.$textData.'%');
					}
					
					if($preparedQuery != ''){
						$preparedQuery .= ' ORDER BY description '.$sortOrder;
					}else{
						$query .= ' ORDER BY description '.$sortOrder;
					}	
				}elseif($id == 1){
					$query = 'SELECT * FROM tbl_items';
					
					$preparedQuery .= ' WHERE stocks <= :stocks';
					$actualValues += array(':stocks' => 20);
					
					if($preparedQuery != ''){
						$preparedQuery .= ' ORDER BY description '.$sortOrder;
					}else{
						$query .= ' ORDER BY description '.$sortOrder;
					}	
					
				}if($id == 2){
					$query = 'SELECT * FROM tbl_items';
					
					if($textData != ''){
						$preparedQuery .= ' WHERE description LIKE :id';
						$actualValues += array(':id' => '%'.$textData.'%');
					}
					
					if($preparedQuery != ''){
						$preparedQuery .= ' ORDER BY description '.$sortOrder;
					}else{
						$query .= ' ORDER BY description '.$sortOrder;
					}	
				}
				
				$dupQuery = $query.' '.$preparedQuery;
				
			}elseif($tblname == 'tbl_units'){
				$query = 'SELECT * FROM tbl_units ORDER BY unit '.$sortOrder;
				
			}elseif($tblname == "tbl_expenses"){
				if($id == 0){
					$query = 'SELECT * FROM '.$tblname;
					$preparedQuery = '';
					$actualValues = array();
					
					if($dateSort != ""){
						$preparedQuery = ' WHERE DATE_FORMAT(tbl_expenses.date,"%Y-%m-%d") >= :dateFrom AND DATE_FORMAT(tbl_expenses.date,"%Y-%m-%d") <= :dateTo';
						$actualValues = array(':dateFrom' => $dateSort["dateFrom"], ':dateTo' => $dateSort["dateTo"]);
					}
					
					if($preparedQuery != ''){
						$preparedQuery .= ' ORDER BY date '.$sortOrder;
					}else{
						$query .= ' ORDER BY date '.$sortOrder;
					}
					
					$dupQuery = $query.' '.$preparedQuery;
				}
			}elseif($tblname == 'tbl_transactions'){
				
				if($id == 0){
					$query = 'SELECT * FROM tbl_transactions';
					$preparedQuery = ' WHERE customer_id = :id';
					$actualValues = array(':id' => 0);
				
					if($textData != ''){
						$preparedQuery .= ' AND transaction_id = :filterData';
						$actualValues += array(':filterData' => $textData);
					}
					
					if($dateSort != ""){
						$preparedQuery .= ' AND DATE_FORMAT(tbl_transactions.dateTime,"%Y-%m-%d") >= :dateFrom AND DATE_FORMAT(tbl_transactions.dateTime,"%Y-%m-%d") <= :dateTo';
						$actualValues += array(':dateFrom' => $dateSort["dateFrom"], ':dateTo' => $dateSort["dateTo"]);
					}
					
					if($preparedQuery != ''){
						$preparedQuery .= ' ORDER BY dateTime '.$sortOrder;
					}else{
						$query .= ' ORDER BY dateTime '.$sortOrder;
					}
					
					$dupQuery = $query.' '.$preparedQuery;
					
				}elseif($id == 1){
					
					$query = 'SELECT * FROM tbl_transactions, tbl_customers WHERE tbl_transactions.customer_id = tbl_customers.customer_id';
					
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
					
					if($preparedQuery != ''){
						$preparedQuery .= ' ORDER BY dateTime '.$sortOrder;
					}else{
						$query .= ' ORDER BY dateTime '.$sortOrder;
					}
					$dupQuery = $query.' '.$preparedQuery;
					
				}elseif($id == 2){
					
					$query = 'SELECT * FROM tbl_transactions INNER JOIN tbl_customers ON tbl_transactions.customer_id = tbl_customers.customer_id';
					$preparedQuery = 'WHERE remarks = :remarks';
					$actualValues = array(':remarks' => 0);
					
					if($textData != ''){
						$preparedQuery .= ' AND (tbl_customers.name LIKE :name OR transaction_id LIKE :id)';
						$actualValues += array(':name' => '%'.$textData.'%', ':id' => '%'.$textData.'%');
					}
					
					if($preparedQuery != ''){
						$preparedQuery .= ' ORDER BY dateTime '.$sortOrder;
					}else{
						$query .= ' ORDER BY dateTime '.$sortOrder;
					}
					$dupQuery = $query.' '.$preparedQuery;
				}
				
				
			}elseif($tblname == 'tbl_accounts'){
				session_start();
				
				$query = 'SELECT * FROM tbl_accounts';
				$preparedQuery = ' WHERE account_id != :id';
				$actualValues = array(':id' => parseSession($_SESSION['account_id']));
				
				if($textData != ''){
					$preparedQuery .= ' AND accountName LIKE :accountName';
					$actualValues += array(':accountName' => '%'.$textData.'%');
				}
				
				$preparedQuery .= ' ORDER BY account_id '.$sortOrder;
				$dupQuery = $query.' '.$preparedQuery;
			}elseif($tblname == "tbl_itempricepercustomer"){
				
				$query = "SELECT * FROM tbl_itempricepercustomer INNER JOIN tbl_items ON tbl_itempricepercustomer.itemId = tbl_items.itemId";
				
				if($id != ""){
					$preparedQuery = " WHERE customer_id = :id";
					$actualValues = array(":id" => $id);
					if($textData != ""){
						
						$preparedQuery .= " AND tbl_items.description LIKE :description";
						$actualValues += array(":description" => '%'.$textData.'%');
					}
				}
				
				$preparedQuery .= ' ORDER BY description '.$sortOrder;
				$dupQuery = $query.' '.$preparedQuery;
			}elseif($tblname == "tbl_customers"){
				$query = "SELECT * FROM tbl_customers";
				
				if($textData != ""){
					$preparedQuery = " WHERE customer_id = :id";
					$actualValues = array(":id" => $textData);
				}
				
				$preparedQuery .= ' ORDER BY name '.$sortOrder;
				$dupQuery = $query.' '.$preparedQuery;
			}
		
		$executeQuery = query($query,$preparedQuery,$actualValues,'variable');
		$countRow = query($query,$preparedQuery,$actualValues,'rows');
		
		if($tblname == 'tbl_items'){
			$compareQuery = "SELECT * FROM tbl_items ORDER BY description $sortOrder";
			$message = 'Empty item list.';
		}elseif($tblname == 'tbl_suppliers'){
			$compareQuery = "SELECT * FROM tbl_suppliers ORDER BY supplier $sortOrder";
			$message = 'Empty supplier list.';
		}elseif($tblname == 'tbl_itemcategories'){
			$compareQuery = "SELECT * FROM tbl_itemcategories ORDER BY itemCategory $sortOrder";
			$message = 'Empty item category list.';
		}elseif($tblname == 'tbl_units'){
			$compareQuery = "SELECT * FROM ORDER BY unit $sortOrder";
			$message = 'Empty unit list.';
		}elseif($tblname == 'tbl_transactions'){
			if($id == 0){
				$compareQuery = "SELECT * FROM tbl_transactions WHERE customer_id = :id ORDER BY dateTime $sortOrder";
				$message = 'Empty transaction list.';	
			}elseif($id == 1){
				$compareQuery = "SELECT * FROM tbl_transactions WHERE remarks = :remarks ORDER BY dateTime $sortOrder";
				$message = 'Empty transaction list.';	
			}elseif($id == 2){
				$compareQuery = "SELECT * FROM tbl_transactionsWHERE remarks = :remarks ORDER BY dateTime $sortOrder";
				$message = 'No Pending Transactions.';
			}
		}elseif($tblname == 'tbl_accounts'){
			$compareQuery = "SELECT * FROM tbl_accounts WHERE account_id != :id ORDER BY account_id $sortOrder";
			$message = 'Empty account list.';
		}elseif($tblname == 'tbl_expenses'){
			$compareQuery = "SELECT * FROM tbl_expenses ORDER BY dateTime $sortOrder";
			$message = 'Empty expenses list.';
		}elseif($tblname == "tbl_itempricepercustomer"){
			$compareQuery = "SELECT * FROM tbl_itempricepercustomer INNER JOIN tbl_items ON tbl_itempricepercustomer.itemId = tbl_items.itemId WHERE customer_id = :id ORDER BY description $sortOrder";
			$message = 'Empty item list.';
		}elseif($tblname == "tbl_customers"){
			$compareQuery = "SELECT * FROM tbl_customers ORDER BY name $sortOrder";
			$message = 'Empty customer list.';
		}
		
		if(empty($executeQuery)){
			
			if($tblname == 'tbl_units' || ($tblname == 'tbl_transactions')|| $tblname == 'tbl_accounts'){
				if($dupQuery != $compareQuery){
					echo '
						<div class="box-body" style="margin-top:30px;">
							<div class="box-body">
								<div class="callout callout-danger">
									'.$message.'
								</div>
							</div>
						</div>
					';
					}else{
						
						echo '
							<div class="box-body">
								<div class="box-body">
									<div class="callout callout-danger">
										No Results Found..
									</div>
								</div>
							</div>
								';
					}	
			}else{
				if($query == $compareQuery){
					echo '
						<div class="box-body" style="margin-top:30px;">
							<div class="box-body">
								<div class="callout callout-danger">
									'.$message.'
								</div>
							</div>
						</div>
					';
					}else{
						echo '
							<div class="box-body">
								<div class="box-body">
									<div class="callout callout-danger">
										No Results Found..
									</div>
								</div>
							</div>
								';
					}	
			}
		}else{
			if($tblname == 'tbl_items'){
				if($id == 0 || $id == 1 ){
					require_once($PATH_ADMIN.'supplies/supplies/listOfItems.php');
				}elseif($id == 2){
					require_once($PATH_ADMIN.'supplies/supplies/listOfItemsPerCustomerSearch.php');
				}elseif($id == 3){
					require_once($PATH_ADMIN.'transactions/createTransactions/listOfItems.php');
				}
			}elseif($tblname == 'tbl_suppliers'){
				require_once($PATH_ADMIN.'supplies/suppliers/listOfSuppliers.php');
			}elseif($tblname == 'tbl_itemcategories'){
				require_once($PATH_ADMIN.'supplies/itemCategory/listOfItemCategory.php');
			}elseif($tblname == 'tbl_units'){
				require_once($PATH_ADMIN.'supplies/units/listOfUnits.php');
			}elseif($tblname == 'tbl_transactions'){
				if($id == 0){
					
					$expectedCash = getExpectedAmountPerDateForWalkIn($textData, $dateSort);
					$actualCash = getActualAmountPerDateForWalkIn($textData, $dateSort);
					
					require_once($PATH_ADMIN.'transactions/viewTransactions/listOfAllWalkInTransactions.php');
				}elseif($id == 1){
					
					$expectedCash = getExpectedAmountPerDateForExisting($filterData, $textData, $dateSort);
					$actualCash = getActualAmountPerDateForExisting($filterData, $textData, $dateSort);
					
					require_once($PATH_ADMIN.'transactions/viewTransactions/listOfAllExistingTransactions.php');
				}elseif($id == 2){
					require_once($PATH_ADMIN.'transactions/viewTransactions/listOfAllPendingTransactions.php');
				}
			}elseif($tblname == 'tbl_accounts'){
				require_once($PATH_ADMIN.'accounts/listOfAllAccounts.php');
			}elseif($tblname == 'tbl_expenses'){
				require_once($PATH_ADMIN.'expenses/viewExpenses/listOfAllExpenses.php');
			}elseif($tblname == "tbl_itempricepercustomer"){
				require_once($PATH_ADMIN.'supplies/supplies/listOfItemsPerCustomer.php');
			}elseif($tblname == "tbl_customers"){
				require_once($PATH_ADMIN.'customers/customers/listOfAllCustomers.php');
			}
			
		}
	}elseif($components == 'unitList'){
		$category_id = $_POST['id'];
		$unitList = query('SELECT * FROM tbl_units','WHERE itemCategory_id = :id',[':id' => $category_id],'variable');
		require_once($PATH_ADMIN.'supplies/supplies/listOfUnits.php');
	}elseif($components == 'itemBreakdown'){
		session_start();
		
		$itemBreakdown = query(
							'SELECT 
								
								tbl_activetransactionbreakdown.activeTransactionBreakdown_id, 
								tbl_activetransactionbreakdown.noOfItem, 
								tbl_activetransactionbreakdown.itemPrice, 
								FORMAT(tbl_activetransactionbreakdown.amount,2) AS amount, 
								
								tbl_items.description, 
								FORMAT(tbl_items.suggestedRetailPrice,2) AS suggestedRetailPrice,
								unit
							FROM 
								tbl_activetransactionbreakdown INNER JOIN tbl_items ON tbl_activetransactionbreakdown.item_id = tbl_items.itemId','WHERE tbl_activetransactionbreakdown.account_id = :id ORDER BY tbl_activetransactionbreakdown.activeTransactionBreakdown_id DESC;',[':id' => parseSession($_SESSION['account_id'])],'variable'
						);
						
		require_once($PATH_ADMIN.'transactions/createTransactions/itemBreakdown.php');
	}elseif($components == 'listOfPendingTransactions'){
		$pendingTransactions = query('SELECT * FROM tbl_transactions','WHERE remarks = :remarks ORDER BY transaction_id DESC',[':remarks' => 0],'variable');
		require_once($PATH_ADMIN.'transactions/viewTransactions/listOfAllPendingTransactions.php');
	}elseif($components == 'itemBreakdownExisting'){
		session_start();
		
		$itemBreakdown = query('SELECT * FROM tbl_activetransactionbreakdown INNER JOIN tbl_items ON tbl_activetransactionbreakdown.item_id = tbl_items.itemId','WHERE tbl_activetransactionbreakdown.account_id = :id ORDER BY tbl_activetransactionbreakdown.activeTransactionBreakdown_id DESC;',[':id' => parseSession($_SESSION['account_id'])],'variable');
						
		require_once($PATH_ADMIN.'transactions/createTransactions/itemBreakdownExisting.php');
	}elseif($components == 'listOfCrucialItems'){
		$executeQuery = query('SELECT * FROM tbl_items WHERE stocks <= 20','','','variable');
		require_once($PATH_ADMIN.'supplies/supplies/listOfItems.php');
	}elseif($components == 'noOfCrucialItems'){
		$totalTransactions = query('SELECT * FROM tbl_items WHERE stocks <=20 ','','','rows');
		echo $totalTransactions;
		exit;
	}elseif($components == 'selectItemForm'){
		$customer_id = $_POST["id"];
		require_once($PATH_ADMIN."transactions/createTransactions/selectItemsForm.php");
		exit;
	}elseif($components == 'viewSales'){
		$dailySales = [];
		$dateSales = [];
		$sales = [];
		
		$dates = getDateOfTransactions($dateSort, $sortOrder);
		$noOfdays = count($dates);
		
		$totalSales = 0;
		
		foreach($dates as $date){
			$dailySales[] = array($date["row"]["date"],(getOverAllActualAmountPerDay($date["row"]["date"]) - getOverAllExpensesPerDay($date["row"]["date"])));
			$totalSales += getOverAllActualAmountPerDay($date["row"]["date"]) - getOverAllExpensesPerDay($date["row"]["date"]);
		}
		require_once($PATH_ADMIN."sales/viewSales/listOfAllSales.php");
		exit;
	}
	exit;
}

//====================================== Log in ===============================================

if(isset($_POST['login'])){
	session_start();
	
	$username = sanitizeInput($_POST['username']);
	$password = sanitizeInput($_POST['password']);
	
	$accountInfo = query('SELECT * FROM tbl_accounts','WHERE username = :username AND password = :password',[':username' => $username, ':password' => $password],'variable',1);
	
	if(!empty($accountInfo)){
		
		if($accountInfo['row']['accountStatus'] != 0){
							
			$verifyAccountLogIn = query('SELECT * FROM tbl_accounts','WHERE flag = :flag AND account_id = :id',[':flag' => 0, ':id' => $accountInfo['row']['account_id']],'rows');
							
			//if($verifyAccountLogIn > 0){
				query('UPDATE tbl_accounts','SET flag = :flag, timeSpan = :timeSpan, dateTimeLastLoggedIn = :lastLoggedIn WHERE account_id = :id',[':flag' => 1, ':timeSpan' => date('Y-m-d h:i:s') , ':id' => $accountInfo['row']['account_id'], ':lastLoggedIn' => date('Y-m-d h:i:s a')]);
							
				$_SESSION['account_id'] = $accountInfo['row']['account_id']."/".$accountInfo['row']['accountType'];
							
				echo $accountInfo['row']['accountType'];
			/*}else{
				$timeSpan = strtotime($accountInfo['row']['timeSpan']);
				$currentTimeSpan = strtotime(date('Y-m-d h:i:s'));
				$timeSpanDiff = $currentTimeSpan - $timeSpan;
									
				if($timeSpanDiff > 10){
					query('UPDATE tbl_accounts','SET flag = :flag, timeSpan = :timeSpan, dateTimeLastLoggedIn = :lastLoggedIn WHERE account_id = :id',[':flag' => 1, ':timeSpan' => date('Y-m-d h:i:s') , ':id' => $accountInfo['row']['account_id'], ':lastLoggedIn' => date('Y-m-d h:i:s a')]);
								
					$_SESSION['account_id'] = $accountInfo['row']['account_id']."/".$accountInfo['row']['accountType'];
								
					echo $accountInfo['row']['accountType'];
				}else{
					echo 2;
				}	
			}*/
		}else{
			echo 1;
		}		
	}else{
		echo 0;
	}
		
		exit;
	
	exit;
}

if(isset($_POST['accountStatus'])){
	session_start();
	
	if(isset($_SESSION['account_id']) && $_SESSION['account_id'] != ''){
		query('UPDATE tbl_accounts','SET timeSpan = :timeSpan WHERE account_id = :id',[':timeSpan' => date('Y-m-d h:i:s a'), ':id' => parseSession($_SESSION['account_id'])]);
	}
	
	exit;
}


//====================================Create Transactions=======================================

if(isset($_POST['refreshitemList'])){
	require_once($PATH_ADMIN.'transactions/createTransactions/listOfItemDescription.php');
	exit;
}

if(isset($_POST['getInvoice'])){
	$id = $_POST['id'];
	
	$getLatestTransaction = query('SELECT * FROM tbl_transactions INNER JOIN tbl_accounts ON tbl_transactions.account_id = tbl_accounts.account_id','WHERE tbl_transactions.account_id = :id ORDER BY tbl_transactions.id DESC LIMIT 1',[':id' => parseSession($_SESSION['account_id'])],'variable',1);
	require_once($PATH_ADMIN.'createTransactions/invoice.php');
}

if(isset($_POST['selectItem'])){
	$id = $_POST['id'];
	$itemPrice = sanitizeInput($_POST['itemPrice']);
	$qty = sanitizeInput($_POST['qty']);
	
	/* $amount = $qty * $itemPrice;
	$vatable = $amount / 1.12;
	$vat = $amount - $vatable; */ 
	
	$percentage_vat = query("SELECT vat FROM tbl_settings","","","variable",1);
	
	$amount = $qty * $itemPrice;
	$vat = $amount * ($percentage_vat["row"]["vat"] / 100);
	$vatable = $amount - $vat;

	$selectItem = query('UPDATE tbl_activetransactionbreakdown','SET itemPrice = :price, amount = :amount, VATableAmount = :vatable, VATAmount = :vatamount WHERE activeTransactionBreakdown_id = :id',[':price'=> $itemPrice, ':amount' => $amount, ':vatable' => $vatable, ':vatamount' => $vat, ':id' => $id ]);
	
	exit;
}

if(isset($_POST['getLatestTransactionDetails'])){
	session_start();
	$transaction = query('SELECT * FROM tbl_transactions','WHERE account_id = :id ORDER BY id DESC LIMIT 1',[':id' => parseSession($_SESSION['account_id'])],'variable',1);
	require_once($PATH_ADMIN.'transactions/createTransactions/transactionSummaryDetails.php');
}

if(isset($_POST['getModificationPaymentForm'])){
	$customer_id = $_POST['customer_id'];
	$expectedCashGiven = number_format(getExpectedAmountGivenPerCustomer($customer_id),2,".",",");
	$actualCashGiven = number_format(getActualAmountGivenPerCustomer($customer_id),2,".",",");
	require_once($PATH_ADMIN.'transactions/viewTransactions/modifyPaymentForm.php');
	exit;
}


if(isset($_POST['verifyInvoiceNo'])){
	$invoiceNo = sanitizeInput($_POST['invoiceNo']);
	
	$verifyInvoiceNo = query('SELECT * FROM tbl_transactions','WHERE transaction_id = :id',[':id' => $invoiceNo],'rows');
	$isAlreadyExists = $verifyInvoiceNo > 0 ? true : false;
	echo $isAlreadyExists;
	
	exit;
	
}

if(isset($_POST['resetItemBreakdown'])){
	session_start();
	
	$items = query('SELECT * FROM tbl_activetransactionbreakdown INNER JOIN tbl_items ON tbl_activetransactionbreakdown.item_id = tbl_items.itemId',' WHERE tbl_activetransactionbreakdown.account_id = :id',[':id' => parseSession($_SESSION['account_id'])],'variable');
	
	foreach($items as $item){
		$returnStock = (int)$item['row']['noOfItem'] + (int)$item['row']['stocks'];
		$updateItems = query('UPDATE tbl_items','SET stocks = :stocks WHERE itemId = :id',[':stocks' => $returnStock,':id' => $item['row']['itemId']]);
	}
	
	$reset = query('DELETE FROM tbl_activetransactionbreakdown','WHERE account_id = :id',[':id' => parseSession($_SESSION['account_id'])]);
	
	echo $reset;
	exit;
}

if(isset($_POST['itemList'])){
	require_once($PATH_ADMIN.'transactions/createTransactions/seeItems.php');
	echo '<div class="displayItemList"></div>
	<button class="btn btn-warning close-itemList-form">Close</button>';
	exit;
}


if(isset($_POST['pickItem'])){
	session_start();
	$item_id = $_POST['id'];
	
	$itemStocks = query('SELECT stocks FROM tbl_items','WHERE itemId = :id',[':id' => $item_id],'variable',1);
	
	if($itemStocks['row']['stocks'] > 0){
		$verifyItem  = query('SELECT * FROM tbl_activetransactionbreakdown INNER JOIN tbl_items ON tbl_activetransactionbreakdown.item_id = tbl_items.itemId','WHERE tbl_activetransactionbreakdown.item_id = :item_id AND tbl_activetransactionbreakdown.account_id = :id',[':item_id' => $item_id, ':id' => parseSession($_SESSION['account_id'])],'variable',1);
		
		if(!empty($verifyItem)){
			$updateItemQty = $verifyItem['row']['stocks'] - 1;
			$updateQty = query('UPDATE tbl_items','SET stocks = :stocks WHERE itemId = :id',[':stocks' => $updateItemQty, ':id' => $item_id]);
			
			/* $updateQty = $verifyItem['row']['noOfItem'] + 1;
			$updateAmount = $updateQty * $verifyItem['row']['suggestedRetailPrice'];
			$updateVATableAmount = $updateAmount / 1.12;
			$updateVATAmount = $updateAmount - $updateVATableAmount; */
			
			$percentage_vat = query("SELECT vat FROM tbl_settings","","","variable",1);
	
			$updateQty = $verifyItem['row']['noOfItem'] + 1;
			$updateAmount = $updateQty * $verifyItem['row']['suggestedRetailPrice'];
			$updateVATAmount = $updateAmount * ($percentage_vat["row"]["vat"] / 100);
			$updateVATableAmount = $updateAmount - $updateVATAmount;
			
			$updateItemBreakdown = query('UPDATE tbl_activetransactionbreakdown','SET noOfItem = :noOfItem, amount = :amount, VATableAmount = :VATableAmount, VATAMount = :VATAmount WHERE item_id = :item_id AND account_id = :id',[':noOfItem' => $updateQty, ':amount' => $updateAmount, ':VATableAmount' => $updateVATableAmount, ':VATAmount' => $updateVATAmount, ':item_id' => $item_id , ':id' => parseSession($_SESSION['account_id'])]);
			echo 1;
		}else{
			$itemInfo = query('SELECT * FROM tbl_items','WHERE itemId = :id',[':id' => $item_id],'variable',1);
			$pickItem = query('INSERT INTO tbl_activetransactionbreakdown(account_id, item_id) VALUES(:account_id,:item_id);','',[':account_id' => parseSession($_SESSION['account_id']),':item_id' => $item_id]);
			echo 1;
		}
		
	}else{
		echo 0;
	}
	
	exit;
}

if(isset($_POST['finalizedItem'])){
	session_start();
	
	$id = $_POST['id'];
	$qty = $_POST['qty'];
	$price = $_POST['price'];
	$amount = $qty * $price;
	
	$item = query('SELECT * FROM tbl_activetransactionbreakdown INNER JOIN tbl_items ON tbl_activetransactionbreakdown.item_id = tbl_items.itemId','WHERE tbl_activetransactionbreakdown.account_id = :id ORDER BY tbl_activetransactionbreakdown.activeTransactionBreakdown_id DESC LIMIT 1',[':id' => parseSession($_SESSION['account_id'])],'variable',1);
	
	if($item['row']['stocks'] >= $qty){

		/* $vatable = $amount / 1.12; 
		$vat = $amount - $vatable; */
		
		$percentage_vat = query("SELECT vat FROM tbl_settings","","","variable",1);
		
		$vat = $amount * ($percentage_vat["row"]["vat"] / 100);
		$vatable = $amount - $vat; 
		
		$itemTransactionInfo = query('SELECT * FROM tbl_activetransactionbreakdown','WHERE activeTransactionBreakdown_id = :id',[':id' => $id],'variable',1);
		$itemStocks = query('SELECT * FROM tbl_items','WHERE itemId = :id',[':id' => $itemTransactionInfo['row']['item_id']],'variable',1);
		$updateQty = $itemStocks['row']['stocks'] - $qty;
		
		query('UPDATE tbl_items','SET stocks = :stocks WHERE itemId = :id',[':stocks' => $updateQty, ':id' => $itemTransactionInfo['row']['item_id']]);
		
		$udpateTransactionInfo = query('UPDATE tbl_activetransactionbreakdown','SET noOfItem = :noOfItem, itemPrice = :price, amount = :amount, VATableAmount = :vatable, VATAmount = :vat WHERE activeTransactionBreakdown_id = :id',[':noOfItem' => $qty, ':price' => $price, ':amount' => $amount, ':vatable' => $vatable, ':vat' => $vat, ':id' => $id]);	
		echo 1;
	}else{
		echo trim('Insufficient stocks for the selected item. Only <b>'.$item['row']['stocks'].'</b> available quantity left for this item&hellip;');
	}
	
	exit;
}

if(isset($_POST['removeItem'])){
	$id = $_POST['id'];
	$item = query('SELECT * FROM tbl_activetransactionbreakdown INNER JOIN tbl_items ON tbl_activetransactionbreakdown.item_id = tbl_items.itemId','WHERE tbl_activetransactionbreakdown.activeTransactionBreakdown_id = :id',[':id' => $id],'variable',1);
	
	$returnStock = $item['row']['noOfItem'] + $item['row']['stocks'];
	
	$updateItemList = query('UPDATE tbl_items','SET stocks = :stocks WHERE itemId = :id',[':stocks' => $returnStock, ':id' => $item['row']['itemId']]);
	$removeItem = query('DELETE FROM tbl_activetransactionbreakdown','WHERE activeTransactionBreakdown_id = :id',[':id' => $id]);
	
	exit;
}

if(isset($_POST["removeItemsNotAlreadyExistsInItemsPerCustomer"])){
	query("DELETE FROM tbl_itempricepercustomer WHERE itemId NOT IN(SELECT itemId FROM tbl_items);");
}

if(isset($_POST['breakDownTotalInfo'])){
	session_start();
	$breakDownTotalInfo = query('SELECT FORMAT(SUM(VATAmount),2) AS totalVat, FORMAT(SUM(VATableAmount),2) AS totalVatable, FORMAT(SUM(amount),2) AS totalAmountDue FROM tbl_activetransactionbreakdown',' WHERE account_id = :id',[':id' => parseSession($_SESSION['account_id'])],'variable',1);
	echo json_encode($breakDownTotalInfo);
	exit;
}

if(isset($_POST['updateTransactionItem'])){
	session_start();
	
	$id = $_POST['id'];
	$qty = $_POST['qty'];
	$price = $_POST['price'];
	
	$verifyItemTransaction = query('SELECT * FROM tbl_activetransactionbreakdown','WHERE noOfItem = :qty AND itemPrice = :price AND activeTransactionBreakdown_id = :id',[':qty' => $qty, ':price' => $price, ':id' => $id],'rows');
	
	if($verifyItemTransaction == 0){
		$item = query('SELECT * FROM tbl_activetransactionbreakdown INNER JOIN tbl_items ON tbl_activetransactionbreakdown.item_id = tbl_items.itemId','WHERE tbl_activetransactionbreakdown.activeTransactionBreakdown_id = :id',[':id' => $id],'variable',1);
		
		if($item['row']['stocks'] >= $qty){
			
			if($qty > $item['row']['noOfItem']){
				$addCurrentStocks = $qty - $item['row']['noOfItem'];
				$updateItemStocks = $item['row']['stocks'] - $addCurrentStocks;
			}else{
				$deductCurrentStocks = $item['row']['noOfItem'] - $qty;
				$updateItemStocks = $item['row']['stocks'] + $deductCurrentStocks;
			}
			
			$updateItemList = query('UPDATE tbl_items','SET stocks = :stocks WHERE itemId = :id',[':stocks' => $updateItemStocks, ':id' => $item['row']['itemId']]);
			
			$percentage_vat = query("SELECT vat FROM tbl_settings","","","variable",1);
			
			/* $amount = $qty * $price;
			$VATable = $amount / 1.12;
			$VATAmount = $amount - $VATable; */
			
			$amount = $qty * $price;
			$VATAmount = ($amount * ($percentage_vat["row"]["vat"] / 100));
			$VATable = $amount - $VATAmount;
			
			$pickItem = query('UPDATE tbl_activetransactionbreakdown','SET itemPrice = :itemPrice, noOfItem = :noOfItem, amount = :amount, VATableAmount = :VATableAmount, VATAMount = :VATAMount WHERE activeTransactionBreakdown_id = :id',[':itemPrice' => $price, ':noOfItem' => $qty, ':amount' => $amount, ':VATableAmount' => $VATable, ':VATAMount' => $VATAmount, ':id' => $id]);
			
			if($pickItem == 1){
				echo 1;
			}else{
				echo 0;
			}		
		}else{
			if($item['row']['stocks'] == 0){
				echo trim('No more enough quantity left for this item.');
			}else{
				echo trim('Insufficient stocks for the selected item. Only '.$item['row']['stocks'].' available quantity left for this item&hellip;');
			}
		}
	}else{
		echo 0;
	}
	
	exit;
}

if(isset($_POST['transaction'])){
	session_start();
	
	$invoiceNo = $_POST['invoiceNo'];
	$view = $_POST["view"];
	
	$transactionDetails = query('SELECT FORMAT(SUM(amount),2) AS totalAmountDue, FORMAT(SUM(VATableAmount),2) AS totalVatable, FORMAT(SUM(VATAmount),2) AS totalVat FROM tbl_activetransactionbreakdown','WHERE account_id = :id',[':id' => parseSession($_SESSION['account_id'])],'variable',1);
	
	require_once($PATH_ADMIN.'transactions/createTransactions/transactionDetails.php');
	exit;
}

if(isset($_POST['customerAddress'])){
	$customer =  $_POST['customer'];
	$address = query('SELECT address FROM tbl_transactions','WHERE customer = :customer ORDER BY id DESC',[':customer' => $customer],'variable',1);
	echo trim($address['row']['address']);
	
	exit;
}

if(isset($_POST['customerContactNo'])){
	$customer =  $_POST['customer'];
	$contactNo = query('SELECT contactNo FROM tbl_transactions','WHERE customer = :customer ORDER BY id DESC',[':customer' => $customer],'variable',1);
	echo trim($contactNo['row']['contactNo']);
	
	exit;
}

if(isset($_POST['saveTransaction'])){
	
	session_start();
	$customer_id = $_POST["customer_id"];
	$invoiceNo = $_POST['invoiceNo'];
	$purchaseOrderNo = $_POST['purchaseOrderNo'];
	$dateTime = date('Y-m-d',strtotime($_POST['date']))." ".date('h:i:s a');
	$customer_id = $_POST['customer_id'];
	$totalAmountDue = $_POST['totalAmountDue'];
	$totalVatable = $_POST['totalVatable'];
	$totalVat = $_POST['totalVat'];
	$discount = $_POST['discount'];
	$discountedAmount = $_POST['discountedDue'];
	$cashReceived = $_POST['cashReceived'];
	$change = $_POST['change'];
	$remarks = $_POST['remarks'];
	
	$saveTransaction = query(
						'INSERT INTO tbl_transactions(
							transaction_id,
							purchaseOrderNo,
							account_id,
							dateTime,
							customer_id,
							amountReceived,
							amountChange,
							totalAmountDue,
							discount,
							discountedAmount,
							totalVATable,
							totalVAT,
							remarks
						)VALUES(
							:transaction_id,
							:purchaseOrderNo,
							:account_id,
							:dateTime,
							:customer_id,
							:amountReceived,
							:amountChange,
							:totalAmountDue,
							:discount,
							:discountedAmount,
							:totalVATable,
							:totalVAT,
							:remarks
						)',
						'',
						[
							':transaction_id' => $invoiceNo,
							':purchaseOrderNo' => $purchaseOrderNo,
							':account_id' => parseSession($_SESSION['account_id']),
							':dateTime' => $dateTime,
							':customer_id' => $customer_id,
							':amountReceived' => $cashReceived,
							':amountChange' => $change,
							':totalAmountDue' => $totalAmountDue,
							':discount' => $discount,
							':discountedAmount' => $discountedAmount,
							':totalVATable' => $totalVatable,
							':totalVAT' => $totalVat,
							':remarks' => $remarks
						]
					);
	
	$latestTransaction_id = query('SELECT transaction_id FROM tbl_transactions','WHERE account_id = :id ORDER BY id DESC LIMIT 1',[':id' => parseSession($_SESSION['account_id'])],'variable',1);
	
	if(($customer_id != "" || $customer_id != 0) && $remarks == 1){
		query(
			'INSERT INTO tbl_paymentmodificationbreakdown(
				customer_id, 
				account_id, 
				dateTimePaid, 
				amountGiven
			) VALUES(
				:customer_id, 
				:account_id, 
				:dateTimePaid, 
				:amountGiven
			)','',
			[
				':customer_id' => $customer_id,
				':account_id' => parseSession($_SESSION['account_id']),
				':dateTimePaid' => date('Y-m-d h:i:s a'), 
				':amountGiven' => $discountedAmount
			]
		);
	}
	
	$itemBreakdown = query('SELECT * FROM tbl_activetransactionbreakdown','WHERE account_id = :id',[':id' => parseSession($_SESSION['account_id'])],'variable');
	
	foreach($itemBreakdown as $item){
		
		if($customer_id != 0 || $customer_id != ""){
			$verifyIfItemExistsInCustomerOfficialItemList = query("SELECT itemId FROM tbl_itempricepercustomer","WHERE customer_id = :customer_id AND itemId = :id",[":customer_id" => $customer_id, ":id" => $item["row"]["item_id"]],"variable",1);
			
			if(!empty($verifyIfItemExistsInCustomerOfficialItemList)){
				query("UPDATE tbl_itempricepercustomer","SET price = :price WHERE customer_id = :customer_id AND itemId = :itemId",[":price" => $item["row"]["itemPrice"], ":customer_id" => $customer_id, ":itemId" => $item["row"]["item_id"]]);
			}else{
				query("INSERT INTO tbl_itempricepercustomer(itemId, customer_id, price) VALUES(:itemId, :customer_id, :price)","",[":itemId" => $item["row"]["item_id"],":customer_id" => $customer_id, ":price" => $item["row"]["itemPrice"]]);
			}	
		}
		
		$saveItemBreakdown = query(
								'INSERT INTO tbl_transactionbreakdowns(
									transaction_id,
									item_id,
									itemPrice,
									noOfItem,
									amount,
									VATableAmount,
									VATAmount
								)VALUES(
									:transaction_id,
									:item_id,
									:itemPrice,
									:noOfItem,
									:amount,
									:VATableAmount,
									:VATAmount
								)','',
								[
									':transaction_id' => $latestTransaction_id['row']['transaction_id'],
									':item_id' => $item['row']['item_id'],
									':itemPrice' => $item['row']['itemPrice'],
									':noOfItem' => $item['row']['noOfItem'],
									':amount' => $item['row']['amount'],
									':VATableAmount' => $item['row']['VATableAmount'],
									':VATAmount' => $item['row']['VATAmount']
								]
							);
	}
	
	$deleteActiveItemBreakdown = query('DELETE FROM tbl_activetransactionbreakdown','WHERE account_id = :id',[':id' => parseSession($_SESSION['account_id'])]);
	
	if($saveTransaction == 1 && $saveItemBreakdown == 1 && $deleteActiveItemBreakdown == 1){
		echo 1;
	}else{
		echo 0;
	}
	exit;
}
if(isset($_POST['discountAmountDue'])){
	
	$totalAmountDue = $_POST['totalAmountDue'];
	$discount = $_POST['discount'];
	
	$discountedAmount =  $totalAmountDue - (($discount / 100) * $totalAmountDue);
	$discountedVATable = $discountedAmount / 1.12;
	$discountedVAT = $discountedAmount - $discountedVATable;
	
	$arrayResult = number_format(round($discountedAmount,2),2,'.',',')."-".number_format(round($discountedVAT , 2) , 2, '.', ',')."-".number_format(round($discountedVATable, 2) , 2, '.', ',');
	
	echo $arrayResult;
	exit;
}

if(isset($_POST['computeChange'])){
	$cashReceived = $_POST['cashReceived'];
	$totalAmountDue = $_POST['totalAmountDue'];
	
	$change = $cashReceived - $totalAmountDue;
	
	echo number_format(round($change, 2),2,'.',',');
	exit;
}

if(isset($_POST['verifyTransaction'])){
	session_start();
	$verifyTransactionInfo = query('SELECT * FROM tbl_activetransactionbreakdown','WHERE account_id = :id AND noOfItem != :noOfItem',[':id' => parseSession($_SESSION['account_id']), ':noOfItem' => 0],'rows');
	
	echo $verifyTransactionInfo;
	
	exit;
}

if(isset($_POST['verifyZero'])){
	session_start();
	
	$count = query('SELECT * FROM tbl_activetransactionbreakdown','','','rows');
		
	if($count > 0){
		$item = query('SELECT * FROM tbl_activetransactionbreakdown','WHERE noOfItem = :noOfItem AND account_id = :id',[':noOfItem' => 0, ':id' => parseSession($_SESSION['account_id'])],'variable');
		
		if(!empty($item)){
			echo 1;
		}else{
			echo 0;
		}
	}else{
		echo 0;
	}
	
	exit;
}

if(isset($_POST['printOutput'])){
	$id = $_POST['id'];
	$outputType = $_POST['outputType'];
	
	session_start();
	//printInvoice($id);
	
	$getLatestTransaction = query('SELECT * FROM tbl_transactions INNER JOIN tbl_accounts ON tbl_transactions.account_id = tbl_accounts.account_id','WHERE tbl_transactions.account_id = :account_id AND tbl_transactions.id = :id',[":id" => $id, ':account_id' => parseSession($_SESSION['account_id'])],'variable',1);
	
	$getTransactionDetails = query('SELECT * FROM tbl_transactionbreakdowns INNER JOIN tbl_items ON tbl_transactionbreakdowns.item_id = tbl_items.itemId','WHERE tbl_transactionbreakdowns.transaction_id = :id ORDER BY tbl_transactionbreakdowns.transactionBreakdown_id DESC',[':id' => $getLatestTransaction['row']['transaction_id']],'variable');
	
	$get_customer_name = query("SELECT name FROM tbl_customers","WHERE customer_id = :id",[":id" => $getLatestTransaction["row"]["customer_id"]],"variable",1);
	
	$customer_name = !empty($get_customer_name) ? $get_customer_name["row"]["name"] : "";
	
	if($outputType == 'invoice'){
		echo '<div class="row">
		<div class="span7">
			<div >
				<div class="row">
					<div class="span7">
						<table class="invoice" >
							<!--Invoice header-->
							<tr>
								<td>
									<table cellspacing=0 class="invoice-header">
										<tr >
											<td style="padding-left:600px;">';
												 echo date('m-d-Y',strtotime($getLatestTransaction['row']['dateTime']));
											echo'</td>
										</tr>
										<tr>
											<td style="padding-left:130px;"><b>'; echo $customer_name; echo'</b></td>
										<tr>
										<tr>
											<td style="padding-left:350px;">'; echo $getLatestTransaction['row']['purchaseOrderNo']; echo'</td>
										<tr>
									</table>		
								</td>
							</tr>
							
							<!--Invoice body-->
							<tr >
								<td>
									<div class="row">
										<div class="span6" style="height:305px;">
											<table cellspacing=0 class="invoice-body" >';
												foreach($getTransactionDetails as $transaction):
												echo'<tr >
													<td style="text-align:center;width:70px">';echo $transaction['row']['noOfItem']; echo'</td>
													<td style="text-align:center;width:90px">';echo $transaction['row']['unit']; echo'</td>
													<td style="padding-left:5px;">'; echo $transaction['row']['description']; echo'</td>
													<td style="text-align:center;">'; echo number_format($transaction['row']['itemPrice'],2,'.',','); echo'</td>
													<td style="text-align:center;padding-right:10px;">'; echo number_format($transaction['row']['amount'],2,'.',','); echo' </td>
												</tr>';
												endforeach;
											echo'</table>	
										</div>
									</div>
								</td>
							</tr>
							
							<!--Invoice footer-->
							<tr>
								<td>
									<table cellspacing=0  class="invoice-footer" >
										<tr >
											<td >'; echo number_format($getLatestTransaction['row']['totalVATable'],2,'.',',');echo'</td>
										</tr>
										
										<tr >
											<td style="padding-top:18px;">'; echo number_format($getLatestTransaction['row']['totalVAT'],2,'.',','); echo'</td>
										</tr>
										<tr >
											<td>'; echo number_format($getLatestTransaction['row']['discountedAmount'],2,'.',','); echo'</td>
										</tr>
										<tr>
											<td >'; echo number_format($getLatestTransaction['row']['amountChange'],2,'.',','); echo'</td>
										</tr>
									</table>		
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>';	
	}else{
		echo '<div class="row">
	<div class="span7">
		<div >
			<div class="row">
				<div class="span7">
					<table class="delivery-report" >
						<!--Invoice header-->
						<tr>
							<td>
								<table cellspacing=0 class="delivery-report-header">
									<tr >
										<td style="padding-left:500px;padding-bottom:39.5px;">';
											echo date('m-d-Y',strtotime($getLatestTransaction['row']['dateTime'])); 
										echo'</td>
									</tr>
									<tr>
										<td style="padding-left:130px;"><b>'; echo $customer_name; echo'</b></td>
									<tr>
									<tr>
										<td style="padding-left:350px;">';echo $getLatestTransaction['row']['purchaseOrderNo']; echo'</td>
									<tr>
								</table>		
							</td>
						</tr>
						
						<!--Invoice body-->
						<tr >
							<td>
								<div class="row">
									<div class="span6" style="height:323px;">
										<table cellspacing=0 class="delivery-report-body">';
											foreach($getTransactionDetails as $transaction):
											echo'<tr >
												<td style="text-align:center;width:40px">'; echo $transaction['row']['noOfItem']; echo'</td>
												<td style="text-align:center;width:45px">'; echo $transaction['row']['unit']; echo'</td>
												<td style="padding-left:20px;">'; echo $transaction['row']['description']; echo'</td>
											</tr>';
											endforeach;
										echo'</table>	
									</div>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>';
		
	}
	
}

if(isset($_POST['itemBreakdown'])){
	$id = $_POST['id'];
	
	$getLatestTransaction = query('SELECT * FROM tbl_transactions','WHERE id = :id',[':id' => $id],'variable',1);
	
	$getTransactionDetails = query('SELECT * FROM tbl_transactionbreakdowns INNER JOIN tbl_items ON tbl_transactionbreakdowns.item_id = tbl_items.itemId','WHERE tbl_transactionbreakdowns.transaction_id = :id ORDER BY tbl_transactionbreakdowns.transactionBreakdown_id DESC',[':id' => $getLatestTransaction['row']['transaction_id']],'variable');
	
	echo '<div class="row" >
	<div class="span12">
		<div >
			<div class="row">
				<div class="span12">
					<table class="transaction" >
						<!--Invoice header-->
						<tr>
							<td>
								<table cellspacing=0 class="transaction-header">';
								if($getLatestTransaction["row"]["customer_id"] != 0){
									echo '<tr >
										<td >
											<b>Customer:</b> ';
											$customer = query("SELECT name FROM tbl_customers","WHERE customer_id = :id",[":id" => $getLatestTransaction["row"]["customer_id"]],"variable",1);
											
											if(!empty($customer)) echo $customer["row"]["name"];
										echo'</td>
									</tr>';
								}
								
								echo'<tr >
										<td >
											<b>Date:</b> '; echo date('m-d-Y',strtotime($getLatestTransaction['row']['dateTime']));
										echo'</td>
									</tr>';
								
								if($getLatestTransaction['row']['purchaseOrderNo'] != ""){
									echo'<tr >
										<td >
											<b>Date:</b> '; echo date('m-d-Y',strtotime($getLatestTransaction['row']['purchaseOrderNo']));
										echo'</td>
									</tr>';
								}
								echo'</table>		
							</td>
						</tr>
						
						<!--Invoice body-->
						<tr >
							<td>
								<div class="row">
									<div class="span12">
										<table cellspacing=0 class="transaction-body" border=3>
											<tr >
												<th >Qty</th>
												<th >Unit</th>
												<th >Item Description</th>
												<th >Unit Price</th>
												<th >Amount</th>
											</tr>';
											 foreach($getTransactionDetails as $transaction):
											echo'<tr >
												<td style="text-align:center;width:70px">'; echo $transaction['row']['noOfItem']; echo'</td>
												<td style="text-align:center;width:90px">'; echo $transaction['row']['unit']; echo'</td>
												<td style="padding-left:5px;">'; echo $transaction['row']['description']; echo'</td>
												<td style="text-align:center;">'; echo number_format($transaction['row']['itemPrice'],2,'.',','); echo'</td>
												<td style="text-align:center;padding-right:10px;">'; echo number_format($transaction['row']['amount'],2,'.',','); echo'</td>
											</tr>';
											 endforeach;
										echo'</table>	
									</div>
								</div>
							</td>
						</tr>	
						
						<!--Invoice footer-->
						<tr>
							<td>
								<table cellspacing=0  class="transaction-footer">
									<tr >
										<td > <b>Vatable:</b> Php '; echo number_format($getLatestTransaction['row']['totalVATable'],2,'.',','); echo'</td>
									</tr>
									
									<tr >
										<td style="padding-top:18px;"><b>Vat:</b> Php '; echo number_format($getLatestTransaction['row']['totalVAT'],2,'.',','); echo'</td>
									</tr>
									<tr >
										<td><b>Total Amount Due:</b> Php '; echo number_format($getLatestTransaction['row']['discountedAmount'],2,'.',','); echo'</td>
									</tr>
									<tr>
										<td ><b>Change:</b> Php '; echo number_format($getLatestTransaction['row']['amountChange'],2,'.',','); echo'</td>
									</tr>
								</table>		
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<br><hr>
<div class="row">
	<div class="span12">
		<button class="btn btn-warning close-trasaction-form" style="float:left;" type="button" >Close</button>
		<button class="btn btn-primary btn-print-as-invoice" style="float:right;margin-right:10px;" type="button" id="'.$getLatestTransaction['row']['id'].'" >Print as Invoice</button>
		<button class="btn btn-success btn-print-as-delivery-report" style="float:right;margin-right:10px;" type="button" id="'.$getLatestTransaction['row']['id'].'">Print as Delivery Report</button>
	</div>
</div>';
	
}

if(isset($_POST["addExpenseForm"])){
	
	require_once($PATH_ADMIN."expenses/createExpenses/addExpenseForm.php");
}

if(isset($_POST["saveNewExpense"])){
	$expenses = $_POST["expenses"];
	$date = $_POST["date"];
	
	foreach($expenses as $expense){
		query("INSERT INTO tbl_expenses(description, amount, date) VALUES(:description, :amount, :date)","",[":description" => $expense["desc"], ":amount" => $expense["amount"], ":date" => $date]);
	}

	exit;
}

if(isset($_POST["saveUpdateExpense"])){
	$id = $_POST["id"];
	$desc = $_POST["desc"];
	$amount = $_POST["amount"];
	$date = $_POST["date"];
	
	query("UPDATE tbl_expenses","SET description = :desc, amount = :amount, date = :date WHERE expenseID = :id",[":desc" => $desc, ":amount" => $amount, ":date" => $date, ":id" => $id]);
	
	exit;
}

if(isset($_POST["contentForm"])){
	$id = $_POST["expense_id"];
	$expense = query("SELECT * FROM tbl_expenses","WHERE expenseID = :id",[":id" => $id],"variable",1);
	require_once($PATH_ADMIN."expenses/createExpenses/updateExpenseForm.php");
}


//------------------------------------------- Create Transactions (Existing) -------------------------

if(isset($_POST['transactionInfo'])){
	session_start();
	
	$customer_id = sanitizeInput($_POST['customer_id']);
	$_SESSION['customer_id'] = $customer_id;
	
	$customer_name = query("SELECT name FROM tbl_customers","WHERE customer_id = :id",[":id" => $customer_id],"variable",1);
	$lastestTransaction = query('SELECT dateTime FROM tbl_transactions','WHERE customer_id = :id ORDER BY dateTime DESC LIMIT 1',[':id' => $customer_id],'variable',1);
	$totalTransactions = query('SELECT * FROM tbl_transactions','WHERE customer_id = :id',[':id' => $customer_id],'rows');
	
	$dateLastTransaction = !empty($lastestTransaction) ? date('M d, Y',strtotime($lastestTransaction['row']['dateTime'])) : "No date";
	echo json_encode(array($customer_name["row"]["name"],$dateLastTransaction,$totalTransactions));
	
	exit;
}

if(isset($_POST["sortSalesByDate"])){
	require_once($PATH_ADMIN."sales/viewSales/sortFormForAllSalesForm.php");
	exit;
}

if(isset($_POST["sortExistingTransactionByDate"])){
	require_once($PATH_ADMIN."transactions/viewTransactions/sortFormForAllExistingForm.php");
	exit;
}


if(isset($_POST["sortExistingTransactionByDate"])){
	require_once($PATH_ADMIN."transactions/viewTransactions/sortFormForAllExistingForm.php");
	exit;
}

if(isset($_POST["sortGeneralTransactionByDate"])){
	require_once($PATH_ADMIN."transactions/viewTransactions/sortFormForGeneralTransactions.php");
	exit;
}

if(isset($_POST["sortExpensesByDate"])){
	require_once($PATH_ADMIN."expenses/viewExpenses/sortFormForAllExpensesForm.php");
	exit;
}

if(isset($_POST["getSortByInventory"])){
	require_once($PATH_ADMIN."supplies/supplies/sortFormForInventory.php");
	exit;
}
 
if(isset($_POST["generalTransactionStatus"])){
	
	$dateSort = isset($_POST["dateSortForGeneralTransactions"]) ? $_POST["dateSortForGeneralTransactions"] : "";
	
	echo json_encode(array(
			getOverAllExpectedAmountPerDate($dateSort),
			getOverAllActualAmountPerDate($dateSort),
			getTotalNumberOfTransactionsPerDate($dateSort),
			getTotalNumberOfPaidTransactionsPerDate($dateSort),
			getTotalNumberOfPendingTransactionsPerDate($dateSort)));
	exit;
}


// ==================================== View Transactions ====================================

if(isset($_POST["viewSelectedMultipleTransactions"])){
	session_start();
	$selectedTransactions = $_POST["selectedTransactions"];
	$_SESSION["TransactionsSelected"] = $selectedTransactions;
	echo true;
	exit;
}

if(isset($_POST["viewSelectedMultipleExpenses"])){
	session_start();
	$selectedTransactions = $_POST["selectedExpenses"];
	$_SESSION["ExpensesSelected"] = $selectedTransactions;
	echo true;
	exit;
}

if(isset($_POST['payAllTransactions'])){
	session_start();
	$customer_id = $_POST['customer_id'];
	
	$actualPayment = getRemainingBalance($customer_id);
	
	query(
		'INSERT INTO tbl_paymentmodificationbreakdown(
			customer_id, 
			account_id, 
			dateTimePaid, 
			amountGiven
		) VALUES(
			:customer_id, 
			:account_id, 
			:dateTimePaid, 
			:amountGiven
		)','',
		[
			':customer_id' => $customer_id,
			':account_id' => parseSession($_SESSION['account_id']),
			':dateTimePaid' => date('Y-m-d h:i:s a'), 
			':amountGiven' => $actualPayment
		]
	);
	
	$markAllTransactionAsPaid = query('UPDATE tbl_transactions','SET remarks = :remarks WHERE customer_id = :customer_id',[':remarks' => 1, ':customer_id' => $customer_id]);
	
	
	exit;
}

if(isset($_POST['removeAllSelectedTransactionsPerCustomer'])){
	$customer = $_POST['customer'];
	
	$transactionPerCustomer = query('SELECT * FROM tbl_transactions','WHERE checkStatus = :status AND customer = :customer',[':status' => 1 , ':customer' => $customer],'variable');
	echo json_encode($transactionPerCustomer);
	exit;
}

if(isset($_POST['verifyTransactionSelectedPerCustomer'])){
	$customer = $_POST['customer'];
	$verifyTransactionSelectedPerCustomer = query("SELECT * FROM tbl_transactions",' WHERE checkStatus = :status AND customer = :customer',[':status' => 1, ':customer' => $customer],'rows');
	echo $verifyTransactionSelectedPerCustomer;
	exit;
}
if(isset($_POST['changeStatus'])){
	$id = $_POST['id'];
	$status = $_POST['status'];
	$changeStatus = query('UPDATE tbl_transactions','SET checkStatus = :status WHERE id = :id',[':status' => $status, ':id' => $id]);
	exit;
}

if(isset($_POST['verifyTransactionSelected'])){
	$verifyTransactionSelected = query('SELECT * FROM tbl_transactions WHERE checkStatus = 1','','','rows');
	echo $verifyTransactionSelected;
	exit;
}

if(isset($_POST['verifySelectedCustomer'])){
	$customer = $_POST['customer'];
	$verifyCustomer = query('SELECT * FROM tbl_transactions','WHERE customer = :customer',[':customer' => $customer],'rows');
	echo $verifyCustomer > 0 ? 1 : 0;
	exit;
}

if(isset($_POST['refreshTransactions'])){
	$customer_id = $_POST['customer_id'];
	$listTransactions = query('SELECT * FROM tbl_transactions','WHERE customer_id = :customer_id ORDER BY id DESC;',[':customer_id' => $customer_id],'variable');
	
	require_once($PATH_ADMIN.'transactions/viewTransactions/refreshCustomerTransactions.php');
}

if(isset($_POST['removeAllSelectedTransactions'])){
	session_start();
	
	$selectedTransactions = $_POST["transactionSelected"];
	
	foreach($selectedTransactions as $transaction){
		
		$transactionInfo = query('SELECT * FROM tbl_transactions','WHERE id = :id',[':id' => $transaction],'variable',1);
		
		$selectAllItems = query('SELECT * FROM tbl_transactionbreakdowns','WHERE transaction_id = :id',[':id' => $transactionInfo['row']['transaction_id']],'variable');

		foreach($selectAllItems as $item){
			$itemInfo = query('SELECT * FROM tbl_items','WHERE itemId = :id',[':id' => $item['row']['item_id']],'variable',1);
			$returnStocks = $item['row']['noOfItem'] + $itemInfo['row']['stocks'];
			query('UPDATE tbl_items','SET stocks = :stocks WHERE itemId = :id',[':stocks' => $returnStocks, ':id' => $item['row']['item_id']]);
		}

		$newExpectedAmountPerCustomer = getExpectedAmountGivenPerCustomer($transactionInfo["row"]["customer_id"]) - $transactionInfo["row"]["discountedAmount"]; 
		
		if($newExpectedAmountPerCustomer < (getActualAmountGivenPerCustomer($transactionInfo["row"]["customer_id"]))){
			$amount = (getActualAmountGivenPerCustomer($transactionInfo["row"]["customer_id"])) - $newExpectedAmountPerCustomer;
			
			query(
				"INSERT INTO tbl_paymentmodificationbreakdown(
					customer_id, 
					account_id, 
					dateTimePaid, 
					amountGiven
				) VALUES(
					:customer_id, 
					:account_id, 
					:dateTimePaid, 
					:amountGiven
				)","",
				[
					':customer_id' =>  $transactionInfo['row']['customer_id'],
					':account_id' => parseSession($_SESSION['account_id']),
					':dateTimePaid' => date('Y-m-d h:i:s a'), 
					':amountGiven' => (-1 * $amount)
				]
			);	
		}																		
		
		$deleteTransactionBreakdown = query('DELETE FROM tbl_transactionbreakdowns','WHERE transaction_id = :id',[':id' => $transactionInfo['row']['transaction_id']]);
		
		$removeTransaction =  query('DELETE FROM tbl_transactions','WHERE id = :id',[':id' => $transaction]);
		$noOfTransactionsPerCustomer = query("SELECT COUNT(*) as noOfTransactionsPerCustomer FROM tbl_transactions","WHERE customer_id = :id",[":id" => $transactionInfo["row"]["customer_id"]],"variable",1);
		
		if($noOfTransactionsPerCustomer["row"]["noOfTransactionsPerCustomer"] == 0){
			query("DELETE FROM tbl_paymentmodificationbreakdown","WHERE customer_id = :id",[":id" => $transactionInfo["row"]["customer_id"]]);
		}
		
		if(getRemainingBalance($transactionInfo["row"]["customer_id"]) == 0){
			query('UPDATE tbl_transactions','SET remarks = :remarks WHERE customer_id = :customer_id',[':customer_id' => $transactionInfo['row']['customer_id'], ':remarks' => 1]);
		}			
	}
	
	exit;
}

if(isset($_POST['removeAllSelectedExpenses'])){
	
	$selectedTransactions = $_POST["transactionSelected"];
	
	foreach($selectedTransactions as $expense){
		$removeTransaction =  query('DELETE FROM tbl_expenses','WHERE expenseID = :id',[':id' => $expense]);
	}
	exit;
}

if(isset($_POST['transactionCustomerStatus'])){
	$customer_id = $_POST['customer_id'];
	
	$transactions = query('SELECT * FROM tbl_transactions','WHERE customer_id = :customer_id',[':customer_id' => $customer_id],'rows');
	$pendingTransactions = query('SELECT * FROM tbl_transactions','WHERE customer_id = :customer_id AND remarks = :remarks',[':customer_id' => $customer_id, ':remarks' => 0],'rows');
	
	$expectedCashGiven = number_format(getExpectedAmountGivenPerCustomer($customer_id),2,".",",");
	$actualCashGiven = number_format(getActualAmountGivenPerCustomer($customer_id),2,".",",");
	
	echo json_encode(array($transactions, $pendingTransactions, $expectedCashGiven, $actualCashGiven));
	
	exit;
}

if(isset($_POST['savePaymentModifications'])){
	session_start();
	$amountEntered = $_POST['amountEntered'];
	$date = $_POST['date'];
	$customer_id = $_POST['customer_id'];
	
	$newTotalCustomerPayment = getActualAmountGivenPerCustomer($customer_id) + $amountEntered;

	if(($newTotalCustomerPayment) > getExpectedAmountGivenPerCustomer($customer_id)){
		$amount = getExpectedAmountGivenPerCustomer($customer_id) - getActualAmountGivenPerCustomer($customer_id);
	}else{
		$amount = $amountEntered;
	}
	
	query(
		'INSERT INTO tbl_paymentmodificationbreakdown(
			customer_id, 
			account_id, 
			dateTimePaid, 
			amountGiven
		) VALUES(
			:customer_id, 
			:account_id, 
			:dateTimePaid, 
			:amountGiven
		)','',
		[
			':customer_id' => $customer_id,
			':account_id' => parseSession($_SESSION['account_id']),
			':dateTimePaid' => $date." ".date("h:i:s a"), 
			':amountGiven' => $amount
		]
	);
	
	
	if(getRemainingBalance($customer_id) == 0){
		query('UPDATE tbl_transactions','SET remarks = :remarks WHERE customer_id = :customer_id',[':remarks' => 1, ':customer_id' => $customer_id]);
		echo 1;
	}else{
		echo 2;
	}
	
	exit;
}

if(isset($_POST['getModifiedPayment'])){
	$cashEntered = $_POST['cashEntered'];
	$customer_id = $_POST['customer_id'];
	
	$newActualAmount = getActualAmountGivenPerCustomer($customer_id) + $cashEntered;
	
	if($newActualAmount >= getExpectedAmountGivenPerCustomer($customer_id)){
		$change =  number_format(($cashEntered - (getExpectedAmountGivenPerCustomer($customer_id) - getActualAmountGivenPerCustomer($customer_id))),2,".",",");
		echo number_format(getExpectedAmountGivenPerCustomer($customer_id),2,".",",")."-".$change;
	}else{
		echo number_format($newActualAmount,2,".",",")."-".'0.00';
	}
	
	exit;
}

if(isset($_POST['getTransaction_id'])){
	$customer = $_POST['customer'];
	
	$getTransaction_id = query('SELECT * FROM tbl_transactions','WHERE customer = :customer',[':customer' => $customer],'variable');
	
	foreach($getTransaction_id as $transaction){
		$transaction_id[] = $transaction['row']['transaction_id'];
	}
	
	echo json_encode($transaction_id);
	exit;
}

if(isset($_POST['generateTransactionPurchaseOrder'])){
	$id = $_POST['id'];
	$withDate = $_POST['withDate'];
	echo generatePurchaseOrder($id, $withDate);
	exit;
}

if(isset($_POST['generateStatement'])){
	session_start();
	$customer_id = $_POST['customer_id'];
	
	echo generateStatement($customer_id);
	
	$getCustomerPaymentInfo = query("SELECT * FROM tbl_customerpaymentinfo","WHERE customer_id = :id",[":id" => $customer_id],"variable",1);
	$amountPaid = $getCustomerPaymentInfo["row"]["expectedCashReceived"] - $getCustomerPaymentInfo["row"]["actualCashReceived"];
	
	query("INSERT INTO 
				tbl_paymentmodificationbreakdown(
					customerPaymentInfo_id,
					account_id, 
					dateTimePaid, 
					amountGiven
				) 
			VALUES(
				:customerPaymentInfo_id, 
				:account_id, 
				:dateTimePaid, 
				:amountGiven
			)","",
			[
				":customerPaymentInfo_id" => $getCustomerPaymentInfo["row"]["customerPaymentInfo_id"], 
				":account_id" => parseSession($_SESSION["account_id"]), 
				":dateTimePaid" => date("Y-m-d h:i:s a"), 
				":amountGiven" => $amountPaid
			]
		);
	
	query("UPDATE tbl_customerpaymentinfo","SET actualCashReceived = :actualCashReceived WHERE customer_id = :id",[":actualCashReceived" => $getCustomerPaymentInfo["row"]["expectedCashReceived"], ":id" => $customer_id]);
	
	query("UPDATE tbl_transactions","SET remarks = :remarks WHERE customer_id = :id",[":remarks" => 1 ,":id" => $customer_id]);
	
	exit;
}

if(isset($_POST['pendingTransactions'])){
	require_once($PATH_ADMIN.'transactions/viewTransactions/pendingTransactionsHeader.php');
	echo '<div class="displayPendingTransactions"></div><button class="btn btn-warning btn-close-pending-transaction-form">Close</button>';
	exit;
}

if(isset($_POST['markAsPaid'])){
	session_start();
	$id = $_POST['id'];
	
	$getTransactionInfo = query('SELECT * FROM tbl_transactions','WHERE id = :id',[':id' => $id],'variable',1);
	
	$customer_id = $getTransactionInfo['row']['customer_id'];
	$transactionAmount = $getTransactionInfo['row']['discountedAmount'];
	
	$newTotalCustomerPayment = getActualAmountGivenPerCustomer($customer_id) + $transactionAmount;
	
	if(($newTotalCustomerPayment) > getExpectedAmountGivenPerCustomer($customer_id)){
		$amount = getExpectedAmountGivenPerCustomer($customer_id) - getActualAmountGivenPerCustomer($customer_id);
	}else{
		$amount = $transactionAmount;
	}
	
	query(
		'INSERT INTO tbl_paymentmodificationbreakdown(
			customer_id, 
			account_id, 
			dateTimePaid, 
			amountGiven
		) VALUES(
			:customer_id, 
			:account_id, 
			:dateTimePaid, 
			:amountGiven
		)','',
		[
			':customer_id' => $customer_id,
			':account_id' => parseSession($_SESSION['account_id']),
			':dateTimePaid' => date("Y-m-d"), 
			':amountGiven' => $amount
		]
	);
	
	if(getRemainingBalance($customer_id) == 0){
		query('UPDATE tbl_transactions','SET remarks = :remarks WHERE customer_id = :customer_id',[':remarks' => 1, ':customer_id' => $customer_id]);
		echo 1;
	}else{
		$markAsPaid = query('UPDATE tbl_transactions','SET remarks = :remarks WHERE id = :id',[':remarks' => 1, ':id' => $id]);
		echo 2;
	}
	exit;
}

if(isset($_POST['transactionStatus'])){
	
	$totalTransactions = query('SELECT * FROM tbl_transactions','','','rows');
	$totalPaidTransactions = query('SELECT * FROM tbl_transactions','WHERE remarks = :remarks',[':remarks' => 1],'rows');
	$totalPendingTransactions = query('SELECT * FROM tbl_transactions','WHERE remarks = :remarks',[':remarks' => 0],'rows');
	
	$customerPaidAmount = query("SELECT SUM(amountGiven) AS 'result' FROM tbl_paymentmodificationbreakdown","","","variable",1);
	
	$actualCashReceived = number_format(getOverAllActualAmount(),2,".",",");
	
	$expectedCashReceived =  number_format(getOverAllExpectedAmount(),2,".",",");
	
	$transactionStatus = $totalTransactions."-".$totalPaidTransactions."-".$totalPendingTransactions."-".$expectedCashReceived."-".$actualCashReceived;
	
	echo $transactionStatus;
	exit;
}

if(isset($_POST["salesStatus"])){
	$sql = json_decode($_POST["sql"]);
	
	$query = $sql->query;
	$preparedQuery = $sql->preparedQuery;
	$actualValues = $sql->actualValues;
	
	echo $actualValues[":dateFrom"]."/n";
	echo $actualValues[":dateTo"];
	exit;
}

if(isset($_POST['viewTransaction'])){
	$customer_id = sanitizeInput($_POST['customer_id']);
	$viewTransaction = query('SELECT * FROM tbl_transactions INNER JOIN tbl_customers ON tbl_transactions.customer_id = tbl_customers.customer_id','WHERE tbl_transactions.customer_id = :customer_id ORDER BY dateTime DESC',[':customer_id' => $customer_id],'variable');
	require_once($PATH_ADMIN.'transactions/viewTransactions/viewCustomerTransactions.php');
	exit;
}


if(isset($_POST['viewTransactionByDate'])){
	session_start();
	
	$date = sanitizeInput($_POST['textDataForAllTransactions']);
	
	$viewTransactionByDate = query('SELECT * FROM tbl_transactions','WHERE account_id = :id AND dateTime LIKE :dateTime',[':id' => parseSession($_SESSION['account_id']), ':dateTime' => '%'.$date.'%'],'variable');
	require_once($PATH_STAFF.'transactions/viewTransactions/viewCustomerTransactions.php');
	exit;
}

if(isset($_POST["removePayment"])){
	$id = $_POST["id"];
	$customer_id = $_POST["customer_id"];

	echo $id." ".$customer_id."\n";

	query("DELETE FROM tbl_paymentmodificationbreakdown","WHERE paymentmodificationbreakdown_id = :id", [":id" => $id]);

	echo getActualAmountGivenPerCustomer($customer_id)." ".getExpectedAmountGivenPerCustomer($customer_id);

	if(getActualAmountGivenPerCustomer($customer_id) < getExpectedAmountGivenPerCustomer($customer_id)){

		query("UPDATE tbl_transactions", "SET remarks = :remarks WHERE customer_id = :customer_id",[":remarks" => 0, ":customer_id" => $customer_id]);
		
	}
	exit;
}


// ===================================== Customers =====================================

if(isset($_POST["addCustomer"])){
	$name = sanitizeInput($_POST["txt-customer-name"]);
	$address = isset($_POST["txt-customer-address"]) ? $_POST["txt-customer-address"] : "";
	$contactInfo = isset($_POST["txt-customer-contact-info"]) ? $_POST["txt-customer-contact-info"] : "";
	$TinNo = isset($_POST["txt-customer-tin-no"]) ? $_POST["txt-customer-tin-no"] : "";
	
	$addCustomer = query(
					"INSERT INTO 
						tbl_customers(
							name, 
							address, 
							contactInfo,
							TinNo
						)
					VALUES (
						:name,
						:address,
						:contactInfo,
						:TinNo
					)","",
					[
						":name" => $name,
						":address" => $address,
						":contactInfo" => $contactInfo,
						":TinNo" => $TinNo
					]
				);
				
	exit;
}

if(isset($_POST["editCustomerForm"])){
	$id = $_POST["id"];
	
	$customerInfo = query("SELECT * FROM tbl_customers","WHERE customer_id = :id",[":id" => $id],"variable",1);
	
	require_once($PATH_ADMIN."/customers/editCustomerForm.php");
	exit;
}

if(isset($_POST["editCustomer"])){
	$id = $_POST["id"];
	
	$name = sanitizeInput($_POST["txt-edit-customer-name"]);
	$address = isset($_POST["txt-edit-customer-address"]) ? $_POST["txt-edit-customer-address"] : "";
	$contactInfo = isset($_POST["txt-edit-customer-contact-info"]) ? $_POST["txt-edit-customer-contact-info"] : "";
	$TinNo = isset($_POST["txt-edit-customer-tin-no"]) ? $_POST["txt-edit-customer-tin-no"] : "";
	
	$editCustomer = query(
						"UPDATE 
							tbl_customers",
						"SET 
							name = :name,
							address = :address,
							contactInfo = :contactInfo,
							TinNo = :TinNo 
						WHERE 
							customer_id = :id",
						[
							":id" => $id,
							":name" => $name,
							":address" => $address,
							":contactInfo" => $contactInfo,
							":TinNo" => $TinNo
						]
					);
	exit;
}

if(isset($_POST["removeCustomer"])){
	$id = $_POST["id"];
	
	query("DELETE FROM tbl_paymentmodificationbreakdown","WHERE customer_id = :id",[":id" => $id]);
	query("DELETE FROM tbl_transactions","WHERE customer_id = :id",[":id" => $id]);
	query("DELETE FROM tbl_customers","WHERE customer_id = :id",[":id" => $id]);
	
	exit;
}

if(isset($_POST["verifyCustomerIfHasTransactionsRecord"])){
	$id = $_POST["id"];
	$verify = query("SELECT customer_id FROM tbl_transactions","WHERE customer_id = :id",[":id" => $id],"variable");
	echo !empty($verify) ? 1 : 0;
	exit;
}
//===================================== Supplies ==============================================

if(isset($_POST["getCapital"])){
	echo "Php ".number_format(getTotalCapital(),2,".",",");
	exit;
}

if(isset($_POST["removeSelectedItems"])){
	$customer_id = $_POST["customerId"];
	$itemsId = $_POST["itemsId"];
	
	for($i = 0; $i < count($itemsId); $i++){
		query("DELETE FROM tbl_itempricepercustomer","WHERE itemId = :id AND customer_id = :customer_id",[":id" => $itemsId[$i], ":customer_id" => $customer_id]);
	}
	
	exit;
}

if(isset($_POST["updateItemPrice"])){
	$customer_id = $_POST["customerId"];
	$itemsInfo = $_POST["itemsInfo"];
	
	for($i = 0; $i < count($itemsInfo); $i++){
		query("UPDATE tbl_itempricepercustomer","SET price = :price WHERE itemId = :id AND customer_id = :customer_id",[":price" => $itemsInfo[$i][1], ":id" => $itemsInfo[$i][0], ":customer_id" => $customer_id]);
	}
	
	exit;
}

if(isset($_POST["saveSelectedItemsPerCustomer"])){
	$customer_id = $_POST["customer_id"];
	$itemData = $_POST["itemData"];
	
	for($i = 0; $i < count($itemData); $i++){
		$saveSelectedItemsPerCustomer = query("INSERT INTO tbl_itempricepercustomer(itemId, customer_id, price) VALUES(:itemId, :customer_id, :price)","",[":itemId" => $itemData[$i][0],":customer_id" => $customer_id, ":price" => $itemData[$i][1]]);	
		
	}
	exit;
}

if(isset($_POST["boxAddItemsPerCustomer"])){
	require_once($PATH_ADMIN."supplies/supplies/boxAddItemsPerCustomer.php");
	exit;
}

if(isset($_POST["getCustomerInfo"])){
	$customer_id = $_POST["customer_id"];
	$customer_name = query("SELECT name FROM tbl_customers","WHERE customer_id = :id",[":id" => $customer_id],"variable",1);
	$noOfItems = query("SELECT COUNT(*) as no_of_items FROM tbl_itempricepercustomer a, tbl_customers b","WHERE a.customer_id = b.customer_id AND b.customer_id = :id",[":id" => $customer_id],"variable",1);
	
	echo json_encode(array($customer_name["row"]["name"], $noOfItems["row"]["no_of_items"]));
	exit;	
}

if(isset($_POST["exportItemList"])){
	echo exportItemList();
	exit;
}
if(isset($_POST["removeItemsSelected"])){
	$itemsId = $_POST["itemsId"];
	
	foreach($itemsId as $itemId){
		query("DELETE FROM tbl_items","WHERE itemId = :id",[":id" => $itemId]);
	}
	exit;
}
if(isset($_POST["getItemsCannotBeRemoved"])){
	$itemsId = $_POST["itemsId"];
	
	$itemsCannotBeRemoved = array();
	
	foreach($itemsId as $item){
		$verifyIfExist = query("SELECT item_id FROM tbl_transactionbreakdowns","WHERE item_id = :id",[":id" => $item],"variable");
		
		if(!empty($verifyIfExist)){
			$itemsCannotBeRemoved[] += $item;
		}
	}
	echo json_encode($itemsCannotBeRemoved) ;
	exit;
}

if(isset($_POST["updateItems"])){
	session_start();
	$itemsId = $_POST["itemsId"];
	$_SESSION["itemsId"] = $itemsId;
	echo true;
	exit;
}

if(isset($_POST['getItemsID'])){
	session_start();;
	echo json_encode($_SESSION["itemsId"]);
	exit;
}

if(isset($_POST['removeAllSelectedItems'])){
	$removeAllSelectedItems = query('DELETE FROM tbl_items WHERE checkStatus = 1');
	exit;
}

if(isset($_POST['verifyIfItemSelected'])){
	$verifyIfItemSelected = query('SELECT * FROM tbl_items WHERE checkStatus = 1','','','rows');
	echo $verifyIfItemSelected;
	exit;
}
if(isset($_POST['checkAllItems'])){
	$textData = $_POST['textData'];
	$query = 'UPDATE tbl_items';
	$preparedQuery = 'SET checkStatus = :status';
	$actualValues = array(':status' => 1);
	
	if($textData != ''){
		$preparedQuery .= ' WHERE description LIKE :description OR itemCode LIKE :id';
		$actualValues += array(':description' => '%'.$textData.'%' , ':id' => '%'.$textData.'%');
	}
	
	$checkAllItems = query($query, $preparedQuery, $actualValues);
	exit;
}

if(isset($_POST['uncheckAllItems'])){
	$textData = $_POST['textData'];
	$query = 'UPDATE tbl_items';
	$preparedQuery = 'SET checkStatus = :status';
	$actualValues = array(':status' => 0);
	
	if($textData != ''){
		$preparedQuery .= ' WHERE description LIKE :description OR itemCode LIKE :id';
		$actualValues += array(':description' => '%'.$textData.'%' , ':id' => '%'.$textData.'%');
	}
	
	$checkAllItems = query($query, $preparedQuery, $actualValues);
	exit;
}

if(isset($_POST['selectStatus'])){
	$id = $_POST['id'];
	$status = $_POST['status'];
	$selectStatus = query('UPDATE tbl_items','SET checkStatus = :check WHERE itemId = :id',[':check' => $status, ':id' => $id]);
	exit;
}

if(isset($_POST['removeTransaction'])){
	session_start();
	$id = $_POST['id'];
	
	$transactionInfo = query('SELECT * FROM tbl_transactions','WHERE id = :id',[':id' => $id],'variable',1);
	
	$selectAllItems = query('SELECT * FROM tbl_transactionbreakdowns','WHERE transaction_id = :id',[':id' => $transactionInfo['row']['transaction_id']],'variable');

	foreach($selectAllItems as $item){
		$itemInfo = query('SELECT * FROM tbl_items','WHERE itemId = :id',[':id' => $item['row']['item_id']],'variable',1);
		$returnStocks = $item['row']['noOfItem'] + $itemInfo['row']['stocks'];
		query('UPDATE tbl_items','SET stocks = :stocks WHERE itemId = :id',[':stocks' => $returnStocks, ':id' => $item['row']['item_id']]);
	}

	$newExpectedAmountPerCustomer = getExpectedAmountGivenPerCustomer($transactionInfo["row"]["customer_id"]) - $transactionInfo["row"]["discountedAmount"]; 
	
	if($newExpectedAmountPerCustomer < (getActualAmountGivenPerCustomer($transactionInfo["row"]["customer_id"]))){
		$amount = (getActualAmountGivenPerCustomer($transactionInfo["row"]["customer_id"])) - $newExpectedAmountPerCustomer;
		
		query(
			"INSERT INTO tbl_paymentmodificationbreakdown(
				customer_id, 
				account_id, 
				dateTimePaid, 
				amountGiven
			) VALUES(
				:customer_id, 
				:account_id, 
				:dateTimePaid, 
				:amountGiven
			)","",
			[
				':customer_id' =>  $transactionInfo['row']['customer_id'],
				':account_id' => parseSession($_SESSION['account_id']),
				':dateTimePaid' => date('Y-m-d h:i:s a'), 
				':amountGiven' => (-1 * $amount)
			]
		);	
	}
	
	$deleteTransactionBreakdown = query('DELETE FROM tbl_transactionbreakdowns','WHERE transaction_id = :id',[':id' => $transactionInfo['row']['transaction_id']]);
	
	$removeTransaction =  query('DELETE FROM tbl_transactions','WHERE id = :id',[':id' => $id]);
	$noOfTransactionsPerCustomer = query("SELECT COUNT(*) as noOfTransactionsPerCustomer FROM tbl_transactions","WHERE customer_id = :id",[":id" => $transactionInfo["row"]["customer_id"]],"variable",1);
	
	if($noOfTransactionsPerCustomer["row"]["noOfTransactionsPerCustomer"] == 0){
		query("DELETE FROM tbl_paymentmodificationbreakdown","WHERE customer_id = :id",[":id" => $transactionInfo["row"]["customer_id"]]);
	}
	
	if(getRemainingBalance($transactionInfo["row"]["customer_id"]) == 0){
		query('UPDATE tbl_transactions','SET remarks = :remarks WHERE customer_id = :customer_id',[':customer_id' => $transactionInfo['row']['customer_id'], ':remarks' => 1]);
	} 
	
	exit;
}

if(isset($_POST['removeAllItems'])){
	$removeAllItems = query('DELETE FROM tbl_items');
	exit;
}
if(isset($_POST['uploadForm'])){
	require_once($PATH_ADMIN.'supplies/supplies/uploadForm.php');
}

if(isset($_POST['verifyRemoveModule'])){
	$id = $_POST['id'];
	$module = $_POST['module'];
	
	if($module == 'item category'){
		$colname = 'category_id';
	}elseif($module == 'suppliers'){
		$colname = 'supplier_id';
	}elseif($module == 'units'){
		$colname = 'unit_id';
	}
	
	$verifyRemoveModule = query("SELECT * FROM tbl_items","WHERE $colname = :colname",[':colname' => $id],'rows');
	
	echo $verifyRemoveModule;
	
	exit;
}
if(isset($_POST['suppliersList'])){
	require_once($PATH_ADMIN.'supplies/suppliers/addNewSupplier.php');
	echo '<div class="displaySuppliers"></div>
	<button class="btn btn-warning close-supplier-form">Close</button>';
	exit;
}	

if(isset($_POST['addSupplier'])){
	$supplier = ucwords(sanitizeInput($_POST['supplier']));
	
	$addSupplier = query('INSERT INTO tbl_suppliers(supplier) VALUES(:supplier);','',[':supplier' => $supplier]);
	hashTag('tbl_suppliers','supplier_id');
	echo $addSupplier;
	exit;
}

if(isset($_POST['saveUpdateSupplier'])){
	$supplierName = ucwords(sanitizeInput($_POST['supplierName']));
	$id  = $_POST['id'];
	
	$updateSupplier = query('UPDATE tbl_suppliers','SET supplier = :supplier WHERE supplier_id = :id',[':supplier' => $supplierName, ':id' => $id]);
	echo $updateSupplier;
	exit;
}

if(isset($_POST['removeSupplier'])){
	$id = $_POST['id'];
	$removeSupplier = query('DELETE FROM tbl_suppliers ','WHERE supplier_id = :id',[':id' => $id]);
	echo $removeSupplier;
	
	exit;
}

	

if(isset($_POST['itemCategoryList'])){
	
	require_once($PATH_ADMIN.'supplies/itemCategory/addNewItemCategory.php');
	echo '<div class="displayItemCategory">Success</div>
	<button class="btn btn-warning close-item-category-form">Close</button>';
	
	exit;
}

if(isset($_POST['saveNewItemCategory'])){
	$itemCategory = ucwords(sanitizeInput($_POST['itemCategory']));
	$saveNewItemCategory = query('INSERT INTO tbl_itemcategories(itemCategory) VALUES(:itemCategory)','',[':itemCategory' => $itemCategory]);
	echo $saveNewItemCategory;
	
	exit;
	
}

if(isset($_POST['saveUpdateItemCategory'])){
	$itemCategoryName = ucwords(sanitizeInput($_POST['itemCategoryName']));
	$id = $_POST['id'];
	
	$saveUpdateItemCategory = query('UPDATE tbl_itemcategories','SET itemCategory = :itemCategory WHERE itemCategory_id = :id',[':itemCategory' => $itemCategoryName, ':id' => $id]);
	echo $saveUpdateItemCategory;
	
	exit;
}

if(isset($_POST['removeItemCateogry'])){
	$id = $_POST['id'];
	
	$removeItemCateogry = query('DELETE FROM tbl_itemcategories','WHERE itemCategory_id = :id',[':id' => $id]);
	
	echo $removeItemCateogry;

	exit;
}

if(isset($_POST['unitList'])){
	require_once($PATH_ADMIN.'supplies/units/addNewUnit.php');
	echo '<div class="displayUnitList"></div>
	<button class="btn btn-warning close-unit-form">Close</button>';
	
}

if(isset($_POST['saveNewUnit'])){
	$unit = ucwords(sanitizeInput($_POST['unit']));
	$saveNewItemCategory = query('INSERT INTO tbl_units(unit) VALUES(:unit);','',[':unit' => $unit]);
	echo $saveNewItemCategory;
	exit;
}

if(isset($_POST['saveUpdateUnit'])){
	$unit = ucwords(sanitizeInput($_POST['unitName']));
	$id = $_POST['id'];
	
	$saveUpdateUnit = query('UPDATE tbl_units','SET unit = :unit WHERE unit_id = :id',[':unit' => $unit, ':id' => $id]);	
	echo $saveUpdateUnit;
	
	exit;
}

if(isset($_POST['removeUnit'])){
	$id = $_POST['id'];
	
	$removeUnit = query('DELETE FROM tbl_units','WHERE unit_id = :id',[':id' => $id]);
	echo $removeUnit;
	
	exit;
}

if(isset($_POST['itemForm'])){
	require_once($PATH_ADMIN.'supplies/supplies/addNewItem.php');
	exit;
}

if(isset($_POST['saveNewItem'])){
	
	$code = sanitizeInput($_POST['code']);
	$stocks = sanitizeInput($_POST['stocks']);
	$area = sanitizeInput($_POST['area']);
	$supplier = sanitizeInput($_POST['supplier']);
	$description = sanitizeInput($_POST['description']);
	$wholeSalePrice = str_replace(",","",$_POST['whole-sale-price']);
	$wholePricePercentageIncrease = $_POST['whole-sale-price-increase'];
	$suggestedRetailPrice = sanitizeInput($_POST['suggested-retail-price']);
	$unit_id = $_POST['unit-id'];
	
	$saveNewItem = query(
					'INSERT INTO tbl_items(
						itemCode, 
						description, 
						wholePricePercentageIncrease, 
						wholeSalePrice, 
						suggestedRetailPrice, 
						area,
						supplier,
						unit,
						stocks
					)VALUES(
						:code, 
						:description, 
						:wholePricePercentageIncrease, 
						:wholeSalePrice, 
						:suggestedRetailPrice, 
						:area,
						:supplier,
						:unit,
						:stocks
					)','',
					[
						':code' => $code, 
						':description' => $description, 
						':wholePricePercentageIncrease' => $wholePricePercentageIncrease, 
						':wholeSalePrice' => $wholeSalePrice, 
						':suggestedRetailPrice' => $suggestedRetailPrice, 
						':unit' => $unit_id,
						':stocks' => $stocks,
						':area' => $area,
						':supplier' => $supplier
					]
				);
	
	echo $saveNewItem;
	exit;
}

if(isset($_POST["getIdNewITem"])){
	$getID = query("SELECT itemId FROM tbl_items ORDER BY itemId DESC LIMIT 1","","","variable",1);
	echo trim($getID["row"]["itemId"]);
	exit;
}

if(isset($_POST['itemUpdateInfo'])){
	$id = $_POST['id'];
	$itemUpdateInfo = query('SELECT * FROM tbl_items','WHERE itemId = :id',[':id' => $id],'variable',1);
	echo $itemUpdateInfo['row']['description'].'==';
	require_once($PATH_ADMIN.'supplies/supplies/UpdateItem.php');
}

if(isset($_POST['updateItem'])){
	
	$id = $_POST['id'];
	$code = sanitizeInput($_POST['code']);
	$stocks = sanitizeInput($_POST['stocks']);
	$area = sanitizeInput($_POST['area']);
	$supplier = sanitizeInput($_POST['supplier']);
	$description = sanitizeInput($_POST['description']);
	$wholeSalePrice = str_replace(",","",$_POST['whole-sale-price']);
	$wholePricePercentageIncrease = $_POST['whole-sale-price-increase'];
	$suggestedRetailPrice =  str_replace(",","",sanitizeInput($_POST['suggested-retail-price']));
	$unit_id = $_POST['unit-id'];
	
	$updateItem = query(
					'UPDATE tbl_items',
					'SET itemCode = :itemCode, 
						 description = :description,
						 wholePricePercentageIncrease = :wholePricePercentageIncrease,
						 wholeSalePrice = :wholeSalePrice,
						 suggestedRetailPrice = :suggestedRetailPrice,
						 unit = :unit,
						 stocks = :stocks,
						 area = :area,
						 supplier = :supplier
					WHERE 
						itemId = :id;',
					[
						':itemCode' => $code,
						':description' => $description,
						':wholePricePercentageIncrease' => $wholePricePercentageIncrease,
						':wholeSalePrice' => $wholeSalePrice,
						':suggestedRetailPrice' => $suggestedRetailPrice,
						':unit' => $unit_id,
						':stocks' => $stocks,
						':area' => $area,
						':supplier' => $supplier,
						':id' => $id
					]
				);
	
	echo $updateItem;
	
	exit;
}


if(isset($_POST['updateMultipleItems'])){
	
	$id = $_POST['id'];
	$code = sanitizeInput($_POST['code']);
	$stocks = sanitizeInput($_POST['stocks']);
	$area = sanitizeInput($_POST['area']);
	$supplier = sanitizeInput($_POST['supplier']);
	$description = sanitizeInput($_POST['description']);
	$wholeSalePrice = str_replace(",","",$_POST['wholeSalePrice']);
	$wholePricePercentageIncrease = $_POST['wholeSalePriceIncrease'];
	$suggestedRetailPrice =  str_replace(",","",sanitizeInput($_POST['srp']));
	$unit_id = $_POST['unit'];
	
	$updateItem = query(
					'UPDATE tbl_items',
					'SET itemCode = :itemCode, 
						 description = :description,
						 wholePricePercentageIncrease = :wholePricePercentageIncrease,
						 wholeSalePrice = :wholeSalePrice,
						 suggestedRetailPrice = :suggestedRetailPrice,
						 area = :area,
						 supplier = :supplier,
						 unit = :unit,
						 stocks = :stocks
					WHERE 
						itemId = :id;',
					[
						':itemCode' => $code,
						':description' => $description,
						':wholePricePercentageIncrease' => $wholePricePercentageIncrease,
						':wholeSalePrice' => $wholeSalePrice,
						':suggestedRetailPrice' => $suggestedRetailPrice,
						':unit' => $unit_id,
						':stocks' => $stocks,
						':area' => $area,
						':supplier' => $supplier,
						':id' => $id
					]
				);
	
	echo $updateItem;
	
	exit;
}

if(isset($_POST['removeItemSupply'])){
	$id = $_POST['id'];
	$removeItem = query('DELETE FROM tbl_items','WHERE itemId = :id',[':id' => $id]);
	echo $removeItem;
	
	exit;
}

if(isset($_POST['uploadFile'])){
	echo uploadFile($_FILES['file-upload']['tmp_name']);
	header("location: ../../?pg=admin&vw=supplies&dir=72275625c8d96d9062889b056513dbc69c029f59");
	exit;
}

if(isset($_POST['fileDetails'])){
	$fileName =  $_FILES['file']['name'];
	$fileSize = round(($_FILES['file']['size'] / 1024), 2)." kb";
	$totalRows = (getFileRows($_FILES['file']['tmp_name']));
	
	echo json_encode(array($fileName, $fileSize, $totalRows));
	exit;
}
//=================================== Accounts =======================================

if(isset($_POST['verifyPassword'])){
	$password = sanitizeInput($_POST['password']);
	$verifyPassword = query('SELECT * FROM tbl_accounts','WHERE password = :password AND accountType = :type',[':password' => $password, ':type' => 'admin'],'variable',1);
	echo !empty($verifyPassword) ? 1 : 0;
	exit;
}

if(isset($_POST['viewAccount'])){
	$id = $_POST['id'];
	$accountInfo = query('SELECT * FROM tbl_accounts','WHERE account_id = :id',[':id' => $id],'variable',1);
	require_once($PATH_ADMIN.'accounts/viewAccountForm.php');
	
	exit;
}

if(isset($_POST['addAccount'])){
	require_once($PATH_ADMIN.'accounts/addAccounts.php');
	exit;
}

if(isset($_POST['saveAccount'])){
	
	$accountId = 'eib-'.rand(0,10000);
	$name = sanitizeInput($_POST['name']);
	$username = sanitizeInput($_POST['username']);
	$password = sanitizeInput($_POST['password']);
	
	$saveAccount = query('INSERT INTO tbl_accounts(account_id, accountName, username, password, dateTimeCreated) VALUES(:account_id, :accountName, :username, :password, :dateTimeCreated)','',[':account_id' => $accountId,':accountName' => $name, ':username' => $username, ':password' => $password, ':dateTimeCreated' => date('Y-m-d h:s:i a')]);
	hashTag('tbl_accounts','account_id');
	echo $saveAccount;
	exit;
}

if(isset($_POST['setActive'])){
	$id = $_POST['id'];
	
	$setActive = query('UPDATE tbl_accounts','SET accountStatus = :status WHERE account_id = :id',[':status' => 1, ':id' => $id]);
	echo $setActive;
	
	exit;
}

if(isset($_POST['setInactive'])){
	$id = $_POST['id'];
	
	$setInactive = query('UPDATE tbl_accounts','SET accountStatus = :status WHERE account_id = :id',[':status' => 0, ':id' => $id]);
	echo $setInactive;
	
	exit;
}

if(isset($_POST['accountInfo'])){
	
	$totalAccounts = query('SELECT * FROM tbl_accounts','','','rows');
	$activeAccounts = query('SELECT * FROM tbl_accounts','WHERE accountStatus = :status',[':status' => 1],'rows');
	$inactiveAccounts = query('SELECT * FROM tbl_accounts','WHERE accountStatus = :status',[':status' => 0],'rows');
	
	echo $totalAccounts."-".$activeAccounts."-".$inactiveAccounts;
	exit;
}

if(isset($_POST['verifyUname'])){
	$username = sanitizeInput($_POST['username']);
	$verifyUsername = query('SELECT * FROM tbl_accounts','WHERE username = :username',[':username' =>$username],'rows');
	echo $verifyUsername > 0 ? 1 : 0;
	exit;
}

if(isset($_POST['updateAccount'])){
	session_start();
	$accountInfo = query('SELECT * FROM tbl_accounts','WHERE account_id = :id',[':id' => parseSession($_SESSION['account_id'])],'variable',1);
	require_once($PATH_ADMIN.'accounts/updateAccounts.php');
	
	exit;
}

if(isset($_POST['saveNewName'])){
	$id = $_POST['id'];
	$name = sanitizeInput($_POST['name']);
	$saveNewName = query('UPDATE tbl_accounts','SET accountName = :name WHERE account_id = :id',[':name' => $name, ':id' => $id]);
	exit;
}

if(isset($_POST['saveNewUsername'])){
	$id = $_POST['id'];
	$username = sanitizeInput($_POST['username']);
	$saveNewUsername = query('UPDATE tbl_accounts','SET username = :username WHERE account_id = :id',[':username' => $username, ':id' => $id]);
	exit;
}

if(isset($_POST['saveNewPassword'])){
	$id = $_POST['id'];
	$password = sanitizeInput($_POST['password']);
	$saveNewPassword = query('UPDATE tbl_accounts','SET password = :password WHERE account_id = :id',[':id' => $id, ':password' => $password]);
	exit;
}

?>
<style>

	
	.invoice{
		font-family:'Arial';
		width:21.5cm;
		margin-left:20px;
		margin-top:49.5px;
		letter-spacing:5px;
	}
	
	.invoice-header{
		font-size:16px;
		margin-bottom:45px;
	}
	
	.invoice-body{
		width:100%;
		font-size:14px;
	}
	
	.invoice-footer{
		padding-left:660px;
		width:100%;
		font-size:12px;
	}
	
	
	
	
	.transaction-header{
		width:100%;
		font-size:16px;
	}
	
	.transaction-body{
		width:100%;
		font-size:14px;
		margin-bottom:30px;
	}
	
	.transaction-footer{
		padding-left:660px;
		width:100%;
		font-size:12px;
		text-align:right;
	}
	
	.delivery-report{
		font-family:'Arial';
		width:19.5cm;
		letter-spacing:5px;
		margin-top:-6px;
		margin-left:-20px;
	}
	
	.delivery-report-header{
		width:100%;
		font-size:16px;
		margin-bottom:28px;
	}
	
	.delivery-report-body{
		width:100%;
		font-size:14px;
	}
</style>


		