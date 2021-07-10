<?php
set_time_limit(0);
$page  = getPage();
$view = getView();
$dirPath = getPath();

function redirect($page = NULL ,$dirPath = NULL,$view = NULL)
{
	if(file_exists(ROOT.DS.'views'.DS.$page))
	{
		if(file_exists(ROOT.DS.'views'.DS.$page.DS.$dirPath.DS.$view.'.php'))
		{
			$title = getTitle($page,$view);

			session_start();
			if($page == 'admin' || $page == 'staff'){
				if(!isset($_SESSION['account_id'])){
				
					header('location: ?pg=access');
				}	
			}
			
			viewHeader($title);
			require_once(ROOT.DS.'views'.DS.$page.DS.$dirPath.DS.$view.'.php');
			viewFooter();
			
		}else{
			get404Error();
		}
	}else{
		get404Error();
	}
}


function viewHeader($title)
{	
	require_once('views/mainheader.php');		
}

function viewFooter()
{
	require_once('views/mainfooter.php');
}

function getTitle($page,$view)
{
	if($page == 'access'){
		if($view == 'index'){
			$title = 'Light Pearl Enterprises | Log in';
		}elseif($view == 'logout'){
			$title = 'Logging out..';
		}
	}elseif($page == 'admin'){
		if($view == 'index'){
			$title = 'Administrator | Dashboard';
		}elseif($view == 'createTransactions'){
			$title = 'Administrator | Create Transactions';
		}elseif($view == 'createTransactionsExisting'){
			$title = 'Administrator | Create Transactions';
		}elseif($view == 'viewTransactions'){
			$title = 'Administrator | View Transactions';
		}elseif($view == 'expenses'){
			$title = 'Administrator | Expenses';
		}elseif($view == 'viewSelectedExpenses'){
			$title = 'Administrator | View Expenses';
		}elseif($view == 'sales'){
			$title = 'Administrator | Sales';
		}elseif($view == 'supplies'){
			$title = 'Administrator | Supplies';
		}elseif($view == 'editItems'){
			$title = 'Administrator | Edit supplies';
		}elseif($view == 'accounts'){
			$title = 'Administrator | Accounts';
		}elseif($view == 'profile'){
			$title = 'Administrator | Profile';
		}elseif($view == 'customers'){
			$title = 'Administrator | Customers';
		}elseif($view == 'viewSelectedTransactions'){
			$title = 'Administrator | Walk in Transactions';
		}elseif($view == 'updateItemsForAllItems'){
			$title = 'Administrator | Update Items';
		}
	}elseif($page == 'staff'){
		if($view == 'index'){
			$title = 'Staff | Dashboard';
		}elseif($view == 'createTransactionsExisting'){
			$title = 'Administrator | Create Transactions';
		}elseif($view == 'createTransactions'){
			$title = 'Staff | Create Transactions';
		}elseif($view == 'viewTransactions'){
			$title = 'Staff | View Transactions';
		}elseif($view == 'profile'){
			$title = 'Staff | Profile';
		}
	}
	return $title;
}

function get404Error()
{
	require_once('views/error404.php');
}

function getPage()
{
	if(isset($_GET['pg']))
		$page = $_GET['pg'];
	else
		$page = 'access';
	
	return $page;
}

function getView()
{
	if(isset($_GET['vw']))
		$view = $_GET['vw'];
	else{
		$view = 'index';
	}
	return $view;
}

function getPath()
{
	if(getPage() == 'access'){
		if(isset($_GET['dir'])){
			$dir = $_GET['dir'];
			if($dir == sha1('login')){
				$path = 'login';		
			}else if($dir == sha1('logout')){
				$path = 'logout';		
			}
		}else{
			$path = 'login';
		}
	}elseif(getPage() == 'admin' || getPage() == 'staff'){
		if(isset($_GET['dir'])){
			$dir = $_GET['dir'];
			if($dir == sha1('dashboard')){
				$path = 'dashboard';
			}elseif($dir == sha1('transactions')){
				$path = 'transactions';
			}elseif($dir == sha1('expenses')){
				$path = 'expenses';
			}elseif($dir == sha1('sales')){
				$path = 'sales';
			}elseif($dir == sha1('supplies')){
				$path = 'supplies';
			}elseif($dir == sha1('accounts')){
				$path = 'accounts';
			}elseif($dir == sha1('customers')){
				$path = 'customers';
			}elseif($dir == sha1('profile')){
				$path = 'profile';
			}else{
				$path = 'dashboard';
			}
		}else{
			$path = 'dashboard';
		}
	}else{
		$path = 'login';
	}
	
	return $path;
}
?>
