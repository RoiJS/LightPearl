<?php foreach($itemBreakdown as $item):?>
<tr class="row-item-breakdown" id="row-item-breakdown<?php echo $item['row']['activeTransactionBreakdown_id'];?>" idrib="<?php echo $item['row']['activeTransactionBreakdown_id'];?>">
	<td>
		<div class="div-add-item-qty" >
			<?php if($item['row']['noOfItem'] == 0){?>
				<form class="frm-add-qty" id="<?php echo $item['row']['activeTransactionBreakdown_id'];?>">
					<input type="text" class="add-qty required" id="add-qty" style="width:30px;" />
				</form>
			<?php }else{?>
				<?php echo $item['row']['noOfItem']; ?>
			<?php }?>	
		</div>
		<div class="div-update-qty" hidden>
			<form class="frm-update-qty" id="<?php echo $item['row']['activeTransactionBreakdown_id'];?>">
				<input type="text" class="update-qty required" id="update-qty" value="<?php echo $item['row']['noOfItem'];?>" class="qty" style="width:30px;" />
			</form>
		</div>
	</td>
	<td><?php echo $item['row']['unit'];?></td>
	<td><?php echo $item['row']['description'];?></td>
	<td>
		<div class="div-add-display-item-price">
			<?php if($item['row']['itemPrice'] == 0){?>
				<form class="frm-add-item-price" id="<?php echo $item['row']['activeTransactionBreakdown_id'];?>"> 
					<?php 
						$getPreviousTransactions = query('SELECT * FROM tbl_transactions','WHERE customer = :customer',[':customer' => $_SESSION['customer-name']],'variable');
						
						$verifiedItem = '';
						$verifiedPrice = '';
						
						if(!empty($getPreviousTransactions)){
							foreach($getPreviousTransactions as $transaction){
								$verifyItem = query('SELECT * FROM tbl_transactionbreakdowns','WHERE transaction_id = :id AND item_id = :item_id',[':id' => $transaction['row']['transaction_id'],':item_id' => $item['row']['item_id']],'variable',1);
								
								if(!empty($verifyItem)){
									$verifiedItem[] = $transaction['row']['dateTime'];
									$verifiedPrice[] = $verifyItem['row']['itemPrice'];
								}
							}
							
							if($verifiedItem != ''){
								if(count($verifiedItem) == 1){
									$srp = number_format($verifiedPrice[0],2,'.',',');
								}else{
									for($i = 0 ;$i < (count($verifiedItem) - 1); $i++){
										if(strtotime($verifiedItem[$i]) > strtotime($verifiedItem[$i + 1]) ){
											$srp = number_format($verifiedPrice[$i],2,'.',',');
										}else{
											$srp = number_format($verifiedPrice[$i + 1],2,'.',',');
										}
									}
								}	
							}else{
								$srp = number_format($item['row']['suggestedRetailPrice'],2,'.',',');
							}
						}else{
							$srp = number_format($item['row']['suggestedRetailPrice'],2,'.',',');
						}
						
					?>
					<input type="text" class="add-item-price required" id="add-item-price" value="<?php echo $srp; ?>" style="width:80px;" />	
				</form>
			<?php }else{?>
				<?php echo number_format($item['row']['itemPrice'],2,'.',',')?>
			<?php }?>
		</div>	
		<div class="div-update-item-price" hidden>
			<form class="frm-update-item-price" id="<?php echo $item['row']['activeTransactionBreakdown_id'];?>">
				<input type="text" class="update-item-price required" id="update-item-price" value="<?php echo number_format($item['row']['itemPrice'],2,'.',',')?>" style="width:70px;"/>
			</form>
		</div>
	</td>
	<td >
		<?php $amount = $item['row']['noOfItem'] * $item['row']['itemPrice']; ?>
		<?php echo number_format($amount,2,'.',',');?>
	</td>
	<td>
		<div class="add-option-btn">
			<?php if($item['row']['noOfItem'] == 0 || $item['row']['itemPrice'] == 0){?>
				<button class="btn btn-success btn-add-qty" id="<?php echo $item['row']['activeTransactionBreakdown_id'];?>">
					<i class="fa fa-check" style="font-size:15px;"></i>
				</button>
				<button class="btn btn-danger btn-remove-item" id="<?php echo $item['row']['activeTransactionBreakdown_id'];?>">
					<i class="fa fa-remove" style="font-size:15px;"></i>
				</button>		
			<?php }else{?>
				<button class="btn btn-success btn-update-item-breakdown" id="<?php echo $item['row']['activeTransactionBreakdown_id'];?>">
					<i class="fa fa-edit" style="font-size:15px;"></i>
				</button>
				<button class="btn btn-danger btn-remove-item-breakdown" id="<?php echo $item['row']['activeTransactionBreakdown_id'];?>">
					<i class="fa fa-remove" style="font-size:15px;" ></i>
				</button>	
			<?php }?>
		</div>
		
		<div class="update-option-btn" hidden>
			<button class="btn btn-success btn-save-update-item-price" id="<?php echo $item['row']['activeTransactionBreakdown_id'];?>">
				<i class="fa fa-check" style="font-size:15px;"></i>
			</button>
			<button class="btn btn-danger btn-cancel-update-item-price" id="<?php echo $item['row']['activeTransactionBreakdown_id'];?>">
				<i class="fa fa-remove" style="font-size:15px;" ></i>
			</button>	
		</div>
	</td>
</tr>
<?php endforeach;?>