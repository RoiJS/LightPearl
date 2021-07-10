<?php foreach($unitList as $unit):?>
<option value="<?php echo $unit['row']['unit_id'];?>"><?php echo $unit['row']['unit'];?></option>
<?php endforeach;?>