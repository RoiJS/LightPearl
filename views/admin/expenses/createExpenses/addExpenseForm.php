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
							<input type="date" class="expense-date" value="<?php echo date("Y-m-d");?>">
						</div>
					</div>
				</div>
			</div>
			<div class="span4">
				<div class="row">
					<div class="span4">
						<h5>Add Field:</h5> 
						<input type="number" min=0 onchange="if(this.value < 0){this.value = 0};" style="width:50px;" placeholder="0" class="no-of-expense-field">
						<button class="btn btn-primary btn-add-expense-field" type="button" style="margin-top:-10px;"><i class="fa fa-plus"></i></button>
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
									<th ></th>
								</tr>
							</thead>
							<tbody class="list-of-expenses">
								<tr>
									<td colspan=2>
										<h5 style="color:red;">Add field by clicking the "+" button above.</h5>
									</td>
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
		<button class="btn btn-warning btn-close-add-expense" type="button">Close</button>
		<button class="btn btn-primary btn-save-expense" type="button" >Save</button>
	</div>
</div>
