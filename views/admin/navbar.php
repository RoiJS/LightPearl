<div class="body-nav body-nav-vertical body-nav-fixed" >
    <div class="container">
         <ul>
            <li class="<?php echo getPage() == 'admin' && getView() == 'index' ? 'active' : '';?>">
                 <a href="?pg=admin">
                     <i class="icon-dashboard icon-large"></i> Dashboard
                 </a>
            </li>
            <li class="<?php echo getPage() == 'admin' && getView() == 'createTransactions' ? 'active' : '';?>">
				<a href="?pg=admin&vw=createTransactions&dir=<?php echo sha1('transactions');?>&mainsub=create_transactions&sub=walk_in">
					<i class="icon-edit icon-large"></i> Transactions<br>
                </a>
            </li>
            <li class="<?php echo getPage() == 'admin' && getView() == 'expenses' ? 'active' : '';?>">
				<a href="?pg=admin&vw=expenses&dir=<?php echo sha1("expenses");?>&mainsub=create_expenses">
					<i class="icon-money icon-large"></i> Expenses<br>
                </a>
            </li>
            <li class="<?php echo getPage() == 'admin' && getView() == 'sales' ? 'active' : '';?>">
				<a href="?pg=admin&vw=sales&dir=<?php echo sha1('sales');?>">
					<i class="icon-bar-chart  icon-large"></i> Sales<br>
                </a>
            </li>
            <li class="<?php echo getPage() == 'admin' && getView() == 'customers' ? 'active' : '';?>">
                <a href="?pg=admin&vw=customers&dir=<?php echo sha1('customers');?>">
					<i class="icon-user icon-large"></i>Customers<br>
                </a>
            </li>
             <li class="<?php echo getPage() == 'admin' && getView() == 'supplies' ? 'active' : '';?>">
                <a href="?pg=admin&vw=supplies&dir=<?php echo sha1('supplies');?>&main=item_list">
                     <i class="fa fa-shopping-cart icon-large"></i>Supplies
                </a>
            </li>
            <li hidden class="<?php echo getPage() == 'admin' && getView() == 'accounts' ? 'active' : '';?>">
                <a href="?pg=admin&vw=accounts&dir=<?php echo sha1('accounts');?>">
                     <i class="icon-key icon-large"></i> Accounts
				</a>
            </li>
        </ul>
    </div>
</div>