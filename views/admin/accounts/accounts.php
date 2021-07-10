<?php require_once('views/header.php');?>
<input type="hidden" value="<?php echo $_GET['pg'];?>" class="page" /> 
<div id="body-container">
   <div id="body-content">
	<?php require_once('views/'.getPage().'/navbar.php');?>
	
     <section class="nav nav-page nav-page-fixed">
        <div class="container">
            <div class="row">
                <div class="span7">
                    <header class="page-header">
                        <h3>Accounts<br/>
                            <small>Light Pearl Enterprises</small>
                        </h3>
                    </header>
                </div>
                <div class="page-nav-options">
                    <div class="span9">
                        <ul class="nav nav-pills">
							<li>
                                <a class="btn-update-account" rel="tooltip" data-placement="left" title="Update Account Information"><i class="icon-edit icon-large"></i></a>
                            </li>
                            <li>
                                <a class="btn-add-account" rel="tooltip" data-placement="left" title="Create New Account"><i class="icon-key icon-large"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
	
	<section class="page container">
				<div class="row">
					<div class="span16">
						<div class="row">
							<div class="span4">
								<div class="box well well-small well-shadow mainform">
									<div class="row">
										<div style="text-align:center;float:left;width:50%;padding-left:40px;">
											<i class="fa fa-users fa-5x"></i>
											<p>Total Accounts</p>
										</div>
										<div>
											<?php $totalAccounts = query('SELECT * FROM tbl_accounts','','','rows');?>
											<h3 style="font-size:55px;margin-top:50px;float:left;" class="totalAccounts"><?php echo $totalAccounts; ?></h3>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<div class="box well well-small well-shadow mainform" >
											<div class="row">
												<div  style="float:left;width:50%;padding-left:40px;">
													<p style="margin-top:-10px;">Active</p>
													<?php $activeAccounts = query('SELECT * FROM tbl_accounts','WHERE accountStatus = :status',[':status' => 1],'rows');?>
													<h3 style="font-size:30px;margin-top:-15px;" class="activeAccounts"><?php echo $activeAccounts; ?></h3>
												</div>
											</div>
										</div>
									</div>
									<div class="span2">
										<div class="box well well-small well-shadow mainform">
											<div class="row">
												<div style=";float:left;width:50%;padding-left:40px;">
													<p style="margin-top:-10px;">Inactive</p>
													<?php $inactiveAccounts = query('SELECT * FROM tbl_accounts','WHERE accountStatus = :status',[':status' => 0],'rows'); ?>
													<h3 style="font-size:30px;margin-top:-15px;" class="inactiveAccounts"><?php echo $inactiveAccounts;?></h3>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="span12">
								<div class="box mainform" style="padding:10px;">
									<legend>
										Accounts Information
									</legend>
									<div class="well well-small well-shadow mainform" style="width:120px;margin-bottom:-20px;margin-left:20px;">
												Search Accounts
									</div>
									
									<div class="box">
										<div class="box-content">
											<br>
											<div class="row">
												<div class="span7">
													<div class="row">
														<div class="span3">
															<h6 >Search by name:</h6>
														</div>
														<div class="span7">
															<input type="text" placeholder="Enter staff name" style="width:90%;" class="txt-search-account"/> 		
														</div>
													</div>
												</div> 
															
												<div class="span4" style="float:right;">
													<div class="row">
														<div class="span2">
															<h6 >Sort item:</h6>
														</div>
														<div class="span4">
															<select style="width:53%;margin-right:5px;" class="select-account-order">
																<option value="DESC">Descending</option>
																<option value="ASC">Ascending</option>
															</select>
														</div>
													</div>
												</div>	
											</div>
										</div>
									</div>
									<div class="box-content">
										<div class="row displayAccounts">
											<!--display all accounts-->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
		</section>
	</div>
</div>

<script src="public/js/admin/accounts/accounts.js" type="text/javascript"></script>
<?php require_once('views/footer.php');?>
