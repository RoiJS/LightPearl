<div class="box">
	<div class="box-content">
		<div class="table-responsive" style="overflow-y:auto;height:300px;">
			<table class="table table-hover table-striped" >
				<thead>
					<tr>
						<th></th>
						<th>Code</th>
						<th>Unit</th>
						<th>Description</th>
						<th>Unit price</th>
						<th>Stocks</th>
					</tr>
					</thead>
					<tbody>
						<?php foreach($executeQuery as $item):?>
						<tr class="pick-item" id="pick-item<?php echo $item['row']['itemId'];?>" idpi="<?php echo $item['row']['itemId'];?>">
							<td><button class="btn btn-warning btn-update-item" id="btn-update-item<?php echo $item['row']['itemId'];?>"  idui="<?php echo $item['row']['itemId'];?>"><i class="fa fa-edit"></i></button></td>
							<td><?php echo $item['row']['itemCode'];?></td>
							<td>
								<?php $unitInfo = query('SELECT * FROM tbl_units','WHERE unit_id = :id',[':id' => $item['row']['unit_id']],'variable',1); ?>
								<?php echo !empty($unitInfo) ? $unitInfo['row']['unit'] : '';?>
							</td>
							<td><?php echo $item['row']['description'];?></td>
							<td><?php echo number_format($item['row']['suggestedRetailPrice'],2,'.',',');?></td>
							<td><?php echo $item['row']['stocks'];?></td>
						</tr>
						<?php endforeach;?>
					</tbody>
			</table>
		</div>
	</div>
</div>