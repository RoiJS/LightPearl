<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="icon" href="images/logo/lp.ico" type="image/x-icon" />
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="layout" content="main"/>
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>

    <script src="js/jquery/jquery-1.9.1.min.js" type="text/javascript" ></script>
	<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="css/customize-template.css" type="text/css" media="screen, projection" rel="stylesheet" />
	<link href="css/custom.css" type="text/css" media="screen, projection" rel="stylesheet" />
	<link href="css/all.css" rel="stylesheet" type="text/css" />
	
	<style>
	
		/*printing invoice*/
		
		@media print{
			body{
				margin-left:-20px;
			}
		}
		
		input.no-input{
			background-color: #f2dede;
		}

        #body-content{
			padding-top: 40px;
		}
		
		table.table-hover tr{
			cursor:pointer;
		}
		
		a{
			cursor:pointer;
		}
		
		input.required{
			background-color:bisque;
		}
		
		.mainform{
			background-color:#EFEFEF;
		}
		
		
		form{
			margin:0;
		}
		
		form.frm-add-customer input[type='text']{
			width:114%;
		}
		
		.success{
			background-color:green;
		}
		
		.danger{
			background-color:#ffa2a2;
		}
		.ui-autocomplete {
		  padding: 0;
		  list-style: none;
		  background-color: #fff;
		  width: 218px;
		  border: 1px solid #B0BECA;
		  max-height: 350px;
		  overflow-x: hidden;
		}
		.ui-autocomplete .ui-menu-item {
		  border-top: 1px solid #B0BECA;
		  display: block;
		  padding: 4px 6px;
		  color: #353D44;
		  cursor: pointer;
		}
		.ui-autocomplete .ui-menu-item:first-child {
		  border-top: none;
		}
		.ui-autocomplete .ui-menu-item.ui-state-focus {
		  background-color: #D5E5F4;
		  color: #161A1C;
		}
		
		
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
	
	
	.transaction{
		font-family:'Arial';
		width:21.5cm;
		margin-top:49.5px;
		margin-left:auto;
		margin-right:auto;
	}
	
	.transaction-header{
		width:100%;
		font-size:16px;
		margin-bottom:40px;
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
	
	.table-item-list thead tr, 
	.table-walk-in-transactions thead tr, 
	.table-existing-transactions thead tr, 
	.table-sales-list thead tr, 
	.table-expenses-list thead tr {
		background-color:#9cce38;
		font-family:Calibri;
		display: block;
		position: relative;
	}
	
	.table-item-list tbody,
	.table-walk-in-transactions tbody, 
	.table-sales-list tbody, 
	.table-existing-transactions tbody, 
	.table-expenses-list tbody {
		display: block;
		overflow: auto;
		height:500px;
		font-family:Calibri;
	}
    </style>
</head>
<body>