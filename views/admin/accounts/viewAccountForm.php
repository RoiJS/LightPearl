<style>
	div.input-prepend{margin-bottom:15px; }
	div.input-prepend input[type="text"], div.input-prepend input[type="password"]{ height:22px;}
	div.input-prepend span[class="add-on"]{height:22px;}
</style>

<div class="box" >
	<div class="box-content">
		<div class="row ">
			<div class="span5">
				<div class="alert alert-block alert-danger displayVerificationRespondent" hidden>
					<i class="fa fa-warning" style="font-size:18px;"></i> <span class="display-message" style="text-align:justify;"></span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="span5" style="margin-top:-30px;">
				<br>
					<div class="form-inner">
						<div class="input-prepend">
							<div class="row display-account-name">
								<div class="span5" style="border-bottom: 2px solid #20a3fb; border-bottom-right-radius: 5px;">
									<div class="row">
										<div class="span3">
											<div class="row">
												<div class="span3" style="margin-bottom:-20px;">
													<h6 class="input-name">Person name: </h6>	
												</div>
												<div class="span3">
													<h4 class="show-name"><?php echo $accountInfo['row']['accountName'];?></h4>		
												</div>
											</div>
										</div>
										<div class="span2">
											<button class="btn btn-warning btn-show-account-name-form" style="margin-right:10px;margin-top:30px;float:right;"><i class="fa fa-edit"></i></button>
										</div>
									</div>
								</div>
							</div>
							<form class="frm-update-account-name" id="<?php echo $accountInfo['row']['account_id'];?>" hidden >
								<h6 class="input-name">Person name: </h6>
								<h6 style="color:green;" hidden class="input-name-success">Person name:  <span><i class="fa fa-check"></i></span></h6>
								<h6 style="color:red;" hidden class="input-name-failed">Person name:  <span><i class="fa fa-remove"></i></span></h6>
								<span class="add-on" rel="tooltip" title="Username" data-placement="top"><i class="fa fa-user"></i></span>
								<input type='text' value="<?php echo $accountInfo['row']['accountName']?>" class='span3 name' name="name" autofocus="autofocus" placeholder="Your name" style="margin-right:20px;"/>
								<button class="btn btn-primary" style="margin-right:10px;"><i class="fa fa-save"></i></button>
								<button class="btn btn-danger btn-cancel-update-name" type="button"><i class="fa fa-remove"></i></button>
								
								<input type='hidden' value="<?php echo $accountInfo['row']['accountName']?>" class='span4 duplicate-name' name="name" autofocus="autofocus" placeholder="Your name" />
							</form>
						</div>
						
						<div class="input-prepend">
							<div class="row display-username">
								<div class="span5" style="border-bottom: 2px solid #20a3fb; border-bottom-right-radius: 5px;">
									<div class="row">
										<div class="span3">
											<div class="row">
												<div class="span3" style="margin-bottom:-20px;">
													<h6 class="input-name">Username: </h6>	
												</div>
												<div class="span3">
													<h4 class="show-username"><?php echo $accountInfo['row']['username'];?></h4>		
												</div>
											</div>
										</div>
										<div class="span2">
											<button class="btn btn-warning btn-show-username-form" style="margin-right:10px;margin-top:30px;float:right;"><i class="fa fa-edit"></i></button>
										</div>
									</div>
								</div>
							</div>
							<form class="frm-update-account-username" id="<?php echo $accountInfo['row']['account_id'];?>" hidden >
								<h6 class="input-username">Username:</h6>
								<h6 style="color:green;" hidden class="input-username-success">Username:  <span><i class="fa fa-check"></i></span></h6>
								<h6 style="color:red;" hidden class="input-username-failed">Username:  <span><i class="fa fa-remove"></i></span></h6>
								<span class="add-on"><i class="fa fa-tag"></i></span>
								<input type='text' value="<?php echo $accountInfo['row']['username']; ?>" class='span3 username' name="username" placeholder="Desired username" style="margin-right:20px;"/>
								
								<button class="btn btn-primary" style="margin-right:10px;margin-right:10px;"><i class="fa fa-save"></i></button>
								<button class="btn btn-danger btn-cancel-update-username" type="button" ><i class="fa fa-remove"></i></button>
								<input type='hidden' value="<?php echo $accountInfo['row']['username']; ?>" class='span4 duplicate-username' name="username" placeholder="Desired username" />
							</form>
						</div>
						
						<div class="input-prepend">
							<div class="row display-password">
								<div class="span5" style="border-bottom: 2px solid #20a3fb; border-bottom-right-radius: 5px;">
									<div class="row">
										<div class="span3">
											<div class="row">
												<div class="span3" style="margin-bottom:-20px;">
													<h6 class="input-name">Password: </h6>	
												</div>
												<div class="span3">
													<h4 class="show-password">
														<?php for($i = 0 ; $i < strlen($accountInfo['row']['password']); $i++):?>
															<?php echo '*';?>
														<?php endfor;?>	
													</h4>
												</div>
											</div>
										</div>
										<div class="span2">
											<button class="btn btn-warning btn-show-password-form" style="margin-right:10px;margin-top:30px;float:right;"><i class="fa fa-edit"></i></button>
										</div>
									</div>
								</div>
							</div>
							<form class="frm-update-password" id="<?php echo $accountInfo['row']['account_id'];?>" hidden >
								<div class="input-prepend">
									<h6 class="input-password">Enter new password:</h6>
									<h6 style="color:green;" hidden class="input-password-success">Password:  <span><i class="fa fa-check"></i></span></h6>
									<h6 style="color:red;" hidden class="input-password-failed"> Password:  <span><i class="fa fa-remove"></i></span></h6>
									<span class="add-on"><i class="icon-key"></i></span>
									<input type='password' class='span4 password' name="password" placeholder="Password" />
								</div>	
								<div class="input-prepend">
									<h6 class="input-confirm-password">Confirm password:</h6>
									<h6 style="color:green;" hidden class="input-confirm-password-success">Confirm Password:  <span><i class="fa fa-check"></i></span></h6>
									<h6 style="color:red;" hidden class="input-confirm-password-failed">Confirm Password:  <span><i class="fa fa-remove"></i></span></h6>
									<span class="add-on"><i class="icon-key"></i></span>
									<input type='password' class='span4 retype-password' name="retype-password" placeholder="Retype password"/>
								</div>	
								<div class="input-prepend" style="float:right;">
									<button class="btn btn-primary" style="margin-right:10px;"><i class="fa fa-save"></i></button>
									<button class="btn btn-danger btn-cancel-update-password" type="button" ><i class="fa fa-remove"></i></button>
								</div>
							</form>
						</div>
					</div>
			</div>
		</div>	
	</div>
</div>
<button class="btn btn-warning close-view-account-form" type="button">Close</button>