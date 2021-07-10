
<?php foreach($executeQuery as $transaction):?>
<tr title="<?php echo $transaction['row']['name'];?>" class="existing-transaction" id="existing-transaction<?php echo $transaction["row"]["id"]?>" idet="<?php echo $transaction["row"]["id"];?>">
	<td style="width:150px;text-align:center;"><?php echo $transaction['row']['transaction_id'];?></td>
	<td style="width:200px;text-align:center;"><?php echo date('M d, Y',strtotime($transaction['row']['dateTime']));?></td>
	<td style="width:300px;text-align:center;"><?php echo $transaction['row']['name'];?></td>
	<td style="width:200px;text-align:center;"><?php echo number_format($transaction['row']['discountedAmount'],2,'.',',');?></td>
</tr>
<?php endforeach;?>
<tr>
	<td hidden colspan="4" class="expectedAmountExistingTransaction"><?php echo number_format($expectedCash,2,".",","); ?></td>
</tr>
<tr> 
	<td hidden colspan="4" class="actualAmountExistingTransaction"><?php echo number_format($actualCash,2,".",","); ?></td>
</tr>
<tr> 
	<td hidden colspan="4" class="noOfDaysExistingTransaction"><?php echo getDaysForExistingTransactions($dateSort, $filterData); ?></td>
</tr>