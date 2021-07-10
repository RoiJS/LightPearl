<div class="body-nav body-nav-vertical body-nav-fixed" >
    <div class="container">
         <ul>
            <li class="<?php echo getPage() == 'staff' && getView() == 'index' ? 'active' : '';?>">
                 <a href="?pg=staff">
                     <i class="icon-dashboard icon-large"></i> Dashboard
                 </a>
            </li>
            <li class="<?php echo getPage() == 'staff' && getView() == 'createTransactions' ? 'active' : '';?>">
				<a href="?pg=staff&vw=createTransactions&dir=<?php echo sha1('transactions');?>">
					<i class="icon-edit icon-large"></i> Create Transaction<br>(Walk in)
                </a>
            </li>
            <li class="<?php echo getPage() == 'staff' && getView() == 'createTransactionsExisting' ? 'active' : '';?>">
                <a href="?pg=staff&vw=createTransactionsExisting&dir=<?php echo sha1('transactions');?>">
					<i class="icon-edit icon-large"></i> Create Transaction<br>(Existing)
                </a>
            </li>
			<li class="<?php echo getPage() == 'staff' && getView() == 'viewTransactions' ? 'active' : '';?>">
                <a class="btn-view-transactions" href="?pg=staff&vw=viewTransactions&dir=<?php echo sha1('transactions');?>">
					<i class="icon-search icon-large"></i> View Transactions
                </a>
            </li>
        </ul>
    </div>
</div>
<script>
$(document).ready(function(){
	
	$('body').delegate('.btn-view-transactions','click',function(){
		
		password = prompt('This page is password protected. Enter password: ');
		if(password != null){
			verifyPassword = ajax({verifyPassword : 1, password : password},true);
			verifyPassword != 0 ? location =  $(this).attr('href') : alert('Invalid password.');
		}
		return false;
	});
})
</script>