<select class="select-items refresh-item-list span6" placeholder="Enter item description&hellip;">
	<option></option>
	<?php $itemList = query('SELECT * FROM tbl_items ORDER BY itemId DESC','','','variable');?>
	<?php foreach($itemList as $item):?>
		<?php $itemUnit = query('SELECT unit FROM tbl_units','WHERE unit_id = :id',[':id' => $item['row']['unit_id']],'variable',1);?>
		<option value="<?php echo $item['row']['itemId'];?>"><?php echo $item['row']['description'];?> <?php echo !empty($itemUnit) ? "(" .$itemUnit['row']['unit'].")" : ''; ?></option>
	<?php endforeach;?>
</select>
<script>
	$(function() {
		$('select.select-items').selectToAutocomplete();
    });
</script>