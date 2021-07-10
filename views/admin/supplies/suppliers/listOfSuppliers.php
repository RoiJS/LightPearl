<div class="box" >
	<div class="box-content" style="overflow-y:auto;height:200px;width:440px;">
		<?php foreach($executeQuery as $supplier):?>
		<div class="row" id="div-cancel-update-supplier<?php echo $supplier['row']['supplier_id'];?>">
			<div class="span6" style="border-bottom:1px inset #20a3fb;10px;margin-bottom:10px; padding-bottom:10px;">
				<div class="row">
					<div class="span4">
						<?php echo $supplier['row']['supplier'];?>
					</div>
					<div class="span2">
						<div  style="float:right;">
							<a class="btn btn-success btn-update-supplier" id="btn-update-supplier<?php echo $supplier['row']['supplier_id']?>" idus="<?php echo $supplier['row']['supplier_id']?>"><i class="fa fa-edit" style="font-size:20px;"></i></a>
							<a class="btn btn-danger btn-remove-supplier" id="btn-remove-supplier<?php echo $supplier['row']['supplier'];?>" idrs="<?php echo $supplier['row']['supplier_id'];?>"><i class="fa fa-remove" style="font-size:20px;"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<form class="frm-update-supplier" idfus="<?php echo $supplier['row']['supplier_id']; ?>">
			<div class="row" id="div-update-supplier<?php echo $supplier['row']['supplier_id'];?>" style="display:none;">
				<div class="span6" style="border-bottom:1px inset #20a3fb;10px;margin-bottom:10px; padding:10px;">
					<div class="row">
						<div class="span3">
							<div>
								<input type="text" value="<?php echo $supplier['row']['supplier'];?>" name="new-supplier"/>
							</div>
						</div>
						<div class="span3">
							<div  style="float:right;">
								<button class="btn btn-primary btn-save-update-supplier" type="submit" id="btn-save-update-supplier<?php echo $supplier['row']['supplier_id'];?>" idsus="<?php echo $supplier['row']['supplier_id'];?>">Save</button>
								<button class="btn btn-default btn-cancel-update-supplier" type="button">Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
		<?php endforeach;?>
	</div>
</div>
