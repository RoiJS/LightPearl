<?php foreach($executeQuery as $item):?>
<tr class="all-items-per-customer" id="all-items-per-customer<?php echo $item['row']['itemId']?>" idaipc="<?php echo $item['row']['itemId']?>">	
	<td style="width:300px;text-align:center;"><?php echo $item['row']['unit'];?></td>
	<td style="width:300px;text-align:center;"><?php echo $item['row']['itemCode'];?></td>
	<td style="width:300px;text-align:center;"><?php echo $item['row']['description'];?></td>
	<td style="width:300px;text-align:center;"><?php echo number_format($item['row']['price'],2,'.',',');?></td>
	<td style="width:300px;text-align:center;"><?php echo $item['row']['supplier'];?></td>
	<td style="width:300px;text-align:center;"><?php echo $item['row']['stocks'];?></td>
	<td style="width:300px;text-align:center;"><?php echo $item['row']['area'];?></td>
</tr>
<?php endforeach;?>