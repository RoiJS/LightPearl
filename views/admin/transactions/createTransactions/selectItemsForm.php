<?php $itemList = query('SELECT * FROM tbl_items ORDER BY itemId DESC','','','variable');?>
<?php $itemListPerCustomer = query('SELECT * FROM tbl_itempricepercustomer','WHERE customer_id = :id',[":id" => $id],'variable');?>
<form class="item-select">
	<select class="select-items span6" placeholder="Enter item description&hellip;">
		<option></option>
		<?php foreach($itemList as $item):?>
			<?php $exists = false;?>
			<?php foreach($itemListPerCustomer as $itemPerCustomer):?>
				<?php if($item["row"]["itemId"] == $itemPerCustomer["row"]["itemId"]){$exists = true;}?>
			<?php endforeach;?>
			
			<?php $itemUnit = query('SELECT unit FROM tbl_units','WHERE unit_id = :id',[':id' => $item['row']['unit_id']],'variable',1);?>
			<option value="<?php echo $item['row']['itemId'];?>"><?php echo $item['row']['description'];?> <?php echo !empty($itemUnit) ? "(" .$itemUnit['row']['unit'].")" : ''; ?> <?php if($exists){echo "--<< CP >>";}?></option>
		<?php endforeach;?>
	</select>
</form>
<script src="js/jquery/jquery-ui.min.js"></script>
<script src="js/jquery/jquery.select-to-autocomplete.js" type="text/javascript" ></script>
<script>
$(function() {
	$('select.select-items, select.customer-name, select.invoice-no').selectToAutocomplete();
});
</script>