<div class="box">
	<div class="box-content">
		<div class="table-responsive" style="height:300px;overflow-y:auto;">
			<table class="table table-hover" >
				<thead>
					<tr>
						<th>Invoice no.</th>
						<th>Date</th>
						<th>Customer</th>
						<th>Amount Due</th>
					</tr>
					</thead>
					<tbody >
						<?php foreach($executeQuery as $transaction):?>
						<tr >
							<td><?php echo $transaction['row']['transaction_id'];?></td>
							<td><?php echo date('M d,Y',strtotime($transaction['row']['dateTime']));?></td>
							<td><?php echo $transaction['row']['name'];?></td>
							<td><?php echo number_format($transaction['row']['discountedAmount'],2,'.',','); ?></td>
							<td><button class="btn btn-success btn-mark-as-paid" id="btn-mark-as-paid<?php echo $transaction['row']['id'];?>" idmap="<?php echo $transaction['row']['id'];?>">Mark as Paid</button></td>
						</tr>
						<?php endforeach;?>
					</tbody>
			</table>
		</div>
	</div>
</div>
