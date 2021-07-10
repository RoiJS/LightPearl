<?php foreach($executeQuery as $customer):?>
	<tr class="select-customer" id="select-customer<?php echo $customer["row"]["customer_id"];?>" idsc="<?php echo $customer["row"]["customer_id"];?>">
		<td><?php echo $customer["row"]["name"];?></td>
		<td><?php echo $customer["row"]["address"];?></td>
		<td><?php echo $customer["row"]["contactInfo"];?></td>
	</tr>
<?php endforeach;?>