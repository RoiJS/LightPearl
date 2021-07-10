<?php foreach($executeQuery as $transaction):?>
<tr class="transaction" id="transaction<?php echo $transaction["row"]["id"];?>" idt="<?php echo $transaction["row"]["id"];?>">
	<td style="width:150px;text-align:center;"><?php echo $transaction['row']['transaction_id'];?></td>
	<td style="width:300px;text-align:center;"><?php echo date('M d, Y',strtotime($transaction['row']['dateTime']));?></td>
	<td style="width:300px;text-align:center;"><?php echo number_format($transaction['row']['discountedAmount'],2,'.',',');?></td>
</tr>
<?php endforeach;?>
<tr>
	<td hidden colspan="4" class="expectedAmountWalkInTransaction"><?php echo number_format($expectedCash,2,".",","); ?></td>
</tr>
<tr> 
	<td hidden  colspan="4" class="actualAmountWalkInTransaction"><?php echo number_format($actualCash,2,".",","); ?></td>
</tr>
<tr> 
	<td hidden colspan="4" class="noOfDaysWalkInTransaction"><?php echo getDaysForWalkInTransactions($dateSort, $textData); ?></td>
</tr>