<div class="box">
	<div class="box-content" style="overflow-y:auto;height:200px;width:440px;">
		<?php foreach($executeQuery as $itemCategory):?>
		<div class="row" id="div-cancel-update-item-category<?php echo $itemCategory['row']['itemCategory_id'];?>">
			<div class="span6" style="border-bottom:1px inset #20a3fb;10px;margin-bottom:10px; padding-bottom:10px;">
				<div class="row">
					<div class="span4">
						<div>
							<?php echo $itemCategory['row']['itemCategory'];?>
						</div>
					</div>
					<div class="span2">
						<div  style="float:right;">
							<a class="btn btn-success btn-update-item-category" id="btn-update-item-category<?php echo $itemCategory['row']['itemCategory_id']?>" iduic="<?php echo $itemCategory['row']['itemCategory_id']?>"><i class="fa fa-edit" style="font-size:20px;"></i></a>
							<a class="btn btn-danger btn-remove-item-category" id="btn-remove-item-category<?php echo $itemCategory['row']['itemCategory_id'];?>" idric="<?php echo $itemCategory['row']['itemCategory_id'];?>"><i class="fa fa-remove" style="font-size:20px;"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<form class="frm-update-item-category" idfuic="<?php echo $itemCategory['row']['itemCategory_id']; ?>">
			<div class="row" id="div-update-item-category<?php echo $itemCategory['row']['itemCategory_id'];?>" style="display:none;">
				<div class="span6" style="border-bottom:1px inset #20a3fb;10px;margin-bottom:10px; padding:10px;">
					<div class="row">
						<div class="span3">
							<div>
								<input type="text" value="<?php echo $itemCategory['row']['itemCategory'];?>" name="new-item-category"/>
							</div>
						</div>
						<div class="span3">
							<div  style="float:right;">
								<button class="btn btn-primary btn-save-update-item-category" type="submit" id="btn-save-update-item-category<?php echo $itemCategory['row']['itemCategory_id'];?>" idsuic="<?php echo $itemCategory['row']['itemCategory_id'];?>">Save</button>
								<button class="btn btn-default btn-cancel-update-item-category" type="button">Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
		<?php endforeach;?>
	</div>
</div>
