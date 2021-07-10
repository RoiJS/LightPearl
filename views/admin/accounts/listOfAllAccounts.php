<?php foreach($executeQuery as $account):?>
<div class="span5" style="margin-bottom:15px;">
	<div style="float:left;">
		<div style="width:120px; height:120px;border:1px inset black;"><center><i class="fa fa-user" style="font-size:130px;margin-top:10px;"></i></center></div>
	</div>
	<div style="float:left;margin-bottom:15px;"> 
		<legend style="margin-left:10px;"><?php echo $account['row']['accountName'];?></legend>
		<h6 style="margin-left:10px;margin-top:10px;">Last Access: <span><?php if($account['row']['dateTimeLastLoggedIn'] != '0000-00-00 00:00:00'){echo date('F d, Y',strtotime($account['row']['dateTimeLastLoggedIn']));} ?></span></h6>
		<h6 style="margin-left:10px;margin-top:-10px;">Date Created: <span><?php if($account['row']['dateTimeCreated'] != '0000-00-00 00:00:00'){echo date('F d, Y',strtotime($account['row']['dateTimeCreated']));};?></span></h6>
		<?php if($account['row']['accountStatus'] == 0){?>
			<button class="btn btn-success btn-set-active"   id="btn-set-active<?php echo $account['row']['account_id'];?>" idsa="<?php echo $account['row']['account_id'];?>" style="margin-left:10px;margin-top:-10px;"><i class="fa fa-check"></i></button>
		<?php }else{?>
			<button class="btn btn-danger btn-set-inactive"  id="btn-set-inactive<?php echo $account['row']['account_id'];?>" idsi="<?php echo $account['row']['account_id'];?>" style="margin-left:10px;margin-top:-10px;"><i class="fa fa-remove"></i></button>
		<?php }?>
		<button class="btn btn-primary btn-view-account" id="btn-view-account<?php echo $account['row']['account_id'];?>" idva="<?php echo $account['row']['account_id'];?>" style="margin-top:-10px;"><i class="fa fa-search"></i></button>
	</div>
</div>
<?php endforeach;?>