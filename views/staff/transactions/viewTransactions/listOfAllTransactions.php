<?php foreach($executeQuery as $transaction):?>
<tr>
	<td><input type="checkbox" <?php echo $transaction['row']['checkStatus'] == 1 ? 'checked' : '';?> class="select-transaction" id="select-transaction<?php echo $transaction['row']['id'];?>" idst="<?php echo $transaction['row']['id'];?>" /></td>
	<td><button class="btn btn-primary btn-view-transaction-breakdown" idvtb="<?php echo $transaction['row']['id'];?>"><i class="fa fa-search"></i></button></td>
	<td><button class="btn btn-danger btn-remove-transaction" id="btn-remove-transaction<?php echo $transaction['row']['id'];?>" idrt="<?php echo $transaction['row']['id'];?>"><i class="fa fa-remove"></i></button></td>
	<td><?php echo date('m-d-Y',strtotime($transaction['row']['dateTime']));?></td>
	<td><?php echo $transaction['row']['transaction_id'];?></td>
	<td><?php echo $transaction['row']['purchaseOrderNo'];?></td>
	<td><?php echo $transaction['row']['customer'];?></td>
	<td><?php echo number_format($transaction['row']['discountedAmount'],2,'.',',');?></td>
	<td><?php if($transaction['row']['remarks'] == 1){echo 'Paid';}else{echo 'Pending';}?></td>
</tr>
<?php endforeach;?>