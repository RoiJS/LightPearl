<style>
	input[type ='text'],input[type ='number'] {width:90%;}
</style>
<div class="row">
	<div class="span8">
		<div class="row">
			<div class="span4">
				<div class="row">
					<div class="span4">
						<h5>Date:</h5> 
						<div id="datepicker" class="input-prepend date">
							<span class="add-on"><i class="icon-th"></i></span>
							<input type="date" class="exp-date" value="<?php echo date("Y-m-d", strtotime($expense["row"]["date"]));?>">
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="span8">
				<div class="box well well-small">
					<div class="table-responsive" style="overflow-x:hidden;height:auto;">
						<table class="table table-striped">
							<thead>
								<tr>
									<th style="width:70%;">Description</th>
									<th style="width:30%;">Amount</th>
								</tr>
							</thead>
							<tbody class="list-of-expenses">
								<input type="hidden" class="exp-id" value="<?php echo $expense["row"]["expenseID"]; ?>">
								<tr class="expense">
									<td><input class="exp-description" type="text" placeholder="Please enter description&hellip;" value="<?php echo $expense["row"]["description"]; ?>"></td>
									<td><input class="exp-amount" type="number" placeholder="Enter amount&hellip;" type="number" min=0 step="0.01" onchange="if(this.value < 0){this.value = 0};" value="<?php echo number_format($expense["row"]["amount"],2,".",""); ?>"></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="span8">
		<button class="btn btn-warning btn-close-update-expense" type="button">Close</button>
		<button class="btn btn-primary btn-save-update-expense" type="button" >Save</button>
	</div>
</div>
