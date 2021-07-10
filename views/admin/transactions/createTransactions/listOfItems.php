<div class="row">
	<div class="span7" >
		<div class="box">
			<div class="box-content">
				<div class="table-responsive" style="overflow-y:auto;height:300px;overflow-x:auto;">
					<table class="table table-hover table-striped" >
						<thead>
							<tr>
								<th>Code</th>
								<th>Unit</th>
								<th>Description</th>
								<th>Unit price</th>
								<th>Stocks</th>
								<th>Area</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($executeQuery as $item):?>
							<tr class="pick-item" id="pick-item<?php echo $item['row']['itemId'];?>" idpi="<?php echo $item['row']['itemId'];?>">
								<td><?php echo $item['row']['itemCode'];?></td>
								<td><?php echo $item['row']['unit'];?></td>
								<td><?php echo $item['row']['description'];?></td>
								<td><?php echo number_format($item['row']['suggestedRetailPrice'],2,'.',',');?></td>
								<td><?php echo $item['row']['stocks'];?></td>
								<td><?php echo $item['row']['area'];?></td>
							</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
			</div>
		</div>	
	</div>
	<div class="span2" >
		<button class="span2 btn btn-add-new-item" style="float:right;height:50px;"> Add new item</button>
		<button class="disabled span2 btn  btn-update-item" style="float:right;margin-top:20px;height:50px;"> Update item</button>
		<button class="disabled span2 btn btn-pick-item" style="float:right;margin-top:20px;height:50px;"> Pick item</button>	
	</div>
</div>
