<style>
	div.input-prepend{margin-bottom:15px; }
	div.input-prepend input[type="text"], div.input-prepend input[type="password"]{ height:22px;}
	div.input-prepend span[class="add-on"]{height:22px;}
</style>

<form class="frm-add-account" autocomplete='off'>
	<div class="box">
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
								<h6 class="input-name">Person name: </h6>
								<h6 style="color:green;" hidden class="input-name-success">Person name:  <span><i class="fa fa-check"></i></span></h6>
								<h6 style="color:red;" hidden class="input-name-failed">Person name:  <span><i class="fa fa-remove"></i></span></h6>
								<span class="add-on" rel="tooltip" title="Username" data-placement="top"><i class="fa fa-user"></i></span>
								<input type='text' class='span4 name' name="name" autofocus="autofocus" placeholder="Your name" />
							</div>
							<div class="input-prepend">
								<h6 class="input-username">Username:</h6>
								<h6 style="color:green;" hidden class="input-username-success">Username:  <span><i class="fa fa-check"></i></span></h6>
								<h6 style="color:red;" hidden class="input-username-failed">Username:  <span><i class="fa fa-remove"></i></span></h6>
								<span class="add-on"><i class="fa fa-tag"></i></span>
								<input type='text' class='span4 username' name="username" placeholder="Desired username" />
							</div>	
							<div class="input-prepend">
								<h6 class="input-password">Password:</h6>
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
						</div>
				</div>
			</div>	
		</div>
	</div>
	<button class="btn btn-primary" type="submit" style="margin-left:20px;" name="btn-add-account">Save Account</button>
	<button class="btn btn-warning close-account-form" type="button">Close</button>
</form>