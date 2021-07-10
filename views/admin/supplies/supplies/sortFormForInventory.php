<div class="row">
	<div class="span7">
		<div class="row" style="margin-left:0;">
			<div class="span3">
				<div class="row" >
					<div class="span3">
						<b>Date from:</b>
					</div>
					<div class="span3">
						<div id="datepicker" class="input-prepend date" style="margin-top:20px;">
							<span class="add-on"><i class="icon-th"></i></span>
							<input style="width:90%;" class="inventory-date-from required" type="date" value="<?php echo isset($_GET["p_d"]) ? $_GET["p_d"] : ""; ?>"/>
						</div>
					</div>
				</div>
			</div>
			<div class="span3">
				<div class="row">
					<div class="span3">
						<b>Date to:</b>
					</div>
					<div class="span3">
						<div id="datepicker" class="input-prepend date" style="margin-top:20px;">
							<span class="add-on"><i class="icon-th"></i></span>
							<input style="width:90%;" class="inventory-date-to required" type="date" value="<?php echo isset($_GET["r_d"]) ? $_GET["r_d"] : ""; ?>"/>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<hr>
<div class="row">
	<div class="span3">
		<button class="btn btn-warning btn-close-sort-inventory-by-date-form" type="button">Close</button>
		<button class="btn btn-primary btn-sort-inventory-by-date-form" type="button">Sort</button>
	</div>
</div>