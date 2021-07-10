<?php if(!empty($listTransactions)){?>
<?php foreach($listTransactions as $transaction):?>
	<tr class="transaction-info" id="transaction-info<?php echo $transaction['row']['transaction_id'];?>" idti="<?php echo $transaction['row']['transaction_id'];?>">
		<?php //if(parseSession($_SESSION['account_id'],1) == 'admin'){?>
			<td>
				<button class="btn btn-primary generate-purchase-order" id="generate-purchase-order<?php echo $transaction['row']['transaction_id'];?>" idgpo="<?php echo $transaction['row']['transaction_id'];?>" style="float:right;display:none;" ><i class="fa fa-file-o"></i></button>
											
				<button class="btn btn-danger btn-remove-transaction" id="btn-remove-transaction<?php echo $transaction['row']['id'];?>" idrt="<?php echo $transaction['row']['id']; ?>" style="float:right;"><i class="fa fa-remove"></i></button>
			</td>
		<?php //}?>
		<td><button class="btn btn-primary btn-view-transaction-breakdown" idvtb="<?php echo $transaction['row']['id'];?>"><i class="fa fa-search"></i></button></td>
		<td><?php echo $transaction['row']['transaction_id'];?></td>
		<td><?php echo $transaction['row']['purchaseOrderNo'];?></td>
		<td><?php echo date('M d, Y',strtotime($transaction['row']['dateTime']));?></td>
		<td><?php echo number_format($transaction['row']['discountedAmount'],2,'.',',');?></td>
		<td><?php if($transaction['row']['remarks'] == 1){echo 'Paid';}else{echo 'Pending';}?></td>
	</tr>
<?php endforeach;?>
<?php }else{?>
	<h4>Empty transaction list.</h4>
<?php }?>