<?php foreach($executeQuery as $item):?>
<tr class="all-items-per-customer-search" id="all-items-per-customer-search<?php echo $item['row']['itemId']?>" idaipcs="<?php echo $item['row']['itemId']?>">
	<td><?php echo $item['row']['unit'];?></td>
	<td><?php echo $item['row']['description'];?></td>
	<td><?php echo number_format($item['row']['suggestedRetailPrice'],2,'.',',');?></td>
	<td><?php echo $item['row']['stocks'];?></td>
	</tr>
<?php endforeach;?>