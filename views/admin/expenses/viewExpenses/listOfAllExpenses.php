<?php $totalExpense = 0;?>
<?php foreach($executeQuery as $expense):?>
<tr class="transaction" id="transaction<?php echo $expense["row"]["expenseID"];?>" idt="<?php echo $expense["row"]["expenseID"];?>">
	<td style="width:300px;text-align:center;"><?php echo date('M d, Y',strtotime($expense['row']['date']));?></td>
	<td style="width:300px;text-align:center;"><?php if($expense['row']['description'] != ""){ echo $expense['row']['description']; } else {echo "-------------------------------"; } ?></td>
	<td style="width:300px;text-align:center;"><?php if($expense['row']['amount'] != ""){echo number_format($expense['row']['amount'],2,'.',','); $totalExpense += $expense['row']['amount']; }else{echo "-------------------------------"; }; ?></td>
</tr>
<?php endforeach;?>
<tr hidden>
	<td><span class="no-of-expenses"><?php echo count($executeQuery); ?></span></td>
	<td><span class="total-expenses"><?php echo number_format($totalExpense,2,".",",") ?></span></td>
	<td><span class="start-date"><?php echo $dateSort != "" ? date("M d, Y", strtotime($dateSort["dateFrom"])) : "none"; ?></span></td>
	<td><span class="end-date"><?php echo $dateSort != "" ? date("M d, Y", strtotime($dateSort["dateTo"])) : "none"; ?></span></td>
</tr>