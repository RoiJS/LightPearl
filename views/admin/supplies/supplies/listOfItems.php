<?php $counter = 0;?>
<?php foreach($executeQuery as $item):?>
<?php $counter+=1;?>
<tr <?php if($item['row']['stocks'] <= 20){echo "style='background-color:#FF7C7C';";}?> class="all-items" id="all-items<?php echo $item['row']['itemId']?>" idai="<?php echo $item['row']['itemId']?>">
	<td style="width:300px;text-align:center;"><?php echo $item['row']['unit'];?></td>
	<td style="width:300px;text-align:center;"><?php echo $item['row']['itemCode'];?></td>
	<td style="width:300px;text-align:center;"><?php echo $item['row']['description'];?></td>
	<td style="width:300px;text-align:center;"><?php echo number_format($item['row']['wholeSalePrice'],2,'.',',');?></td>
	<td style="width:300px;text-align:center;"><?php echo number_format($item['row']['suggestedRetailPrice'],2,'.',',');?></td>
	<td style="width:300px;text-align:center;"><?php echo $item['row']['supplier'];?></td>
	<td style="width:300px;text-align:center;"><?php echo $item['row']['stocks'];?></td>
	<td style="width:300px;text-align:center;"><?php echo $item['row']['area'];?></td>
</tr>
<?php endforeach;?>
<tr hidden>
	<td><span class="noOfSearchedItems"><?php echo number_format($counter,0,"",",");?></span></td>
</tr>