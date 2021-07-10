<div class="box" >
	<div class="box-content" style="overflow-y:auto;height:200px;width:440px;">
		<?php foreach($executeQuery as $unit):?>
		<div class="row" id="div-cancel-update-unit<?php echo $unit['row']['unit_id'];?>">
			<div class="span6" style="border-bottom:1px inset #20a3fb;10px;margin-bottom:10px; padding-bottom:10px;">
				<div class="row">
					<div class="span4">
						<div>
							<?php echo $unit['row']['unit'];?>
						</div>
					</div>
					<div class="span2">
						<div  style="float:right;">
							<a class="btn btn-success btn-update-unit" id="btn-update-unit<?php echo $unit['row']['unit_id']?>" iduu="<?php echo $unit['row']['unit_id']?>"><i class="fa fa-edit" style="font-size:20px;"></i></a>
							<a class="btn btn-danger btn-remove-unit" id="btn-remove-unit<?php echo $unit['row']['unit_id'];?>" idru="<?php echo $unit['row']['unit_id'];?>"><i class="fa fa-remove" style="font-size:20px;"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<form class="frm-update-unit" idfuu="<?php echo $unit['row']['unit_id']; ?>">
			<div class="row" id="div-update-unit<?php echo $unit['row']['unit_id'];?>" style="display:none;">
				<div class="span6" style="border-bottom:1px inset #20a3fb;10px;margin-bottom:10px; padding:10px;">
					<div class="row">
						<div class="span3">
							<div>
								<input type="text" value="<?php echo $unit['row']['unit'];?>" name="new-unit"/>
							</div>
						</div>
						<div class="span3">
							<div  style="float:right;">
								<button class="btn btn-primary btn-save-update-unit" type="submit" id="btn-save-update-unit<?php echo $unit['row']['unit_id'];?>" idsuu="<?php echo $unit['row']['unit_id'];?>">Save</button>
								<button class="btn btn-default btn-cancel-update-unit" type="button">Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
		<?php endforeach;?>
	</div>
</div>
