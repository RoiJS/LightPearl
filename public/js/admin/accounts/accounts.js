$(document).ready(function(){
	
	var boxAddAccountForm = '';
	var boxUpdateAccountForm = '';
	var textDataAccounts = '';
	var sortOrderAccounts = 'DESC';
	var tblname = 'tbl_accounts';
	var page = $('.page').val();
	
	showComponents('pagination','.displayAccounts',tblname, page, sortOrderAccounts, '' , textDataAccounts);
	$('body').delegate('.btn-add-account','click',function(){
		addAccount = ajax({addAccount : 1},true);
		boxAddAccountForm = modalForm('Add new account',addAccount);
	});
	
	$('body').delegate('.frm-add-account','submit',function(e){
		e.preventDefault();
		
		name = $.trim($('.name').val());
		username = $.trim($('.username').val());
		password = $.trim($('.password').val());
		
		verifyAccountInfo = verifyAccountInputs();
		
		if(verifyAccountInfo == 3){
			$('.displayVerificationRespondent').hide();
			if(confirm('Are you sure to save new account?')){
				saveAccount = ajax({saveAccount : 1, name : name, username : username , password : password}, true);
				showComponents('pagination','.displayAccounts',tblname, page, sortOrderAccounts, '' , textDataAccounts);
				refreshAccountInfo();
				boxAddAccountForm.modal('hide');
			}	
		}else if(verifyAccountInfo == 2){
			$('.displayVerificationRespondent').show();
			$('.displayVerificationRespondent span.display-message').html("Password you've entered does not match.");
		}else if(verifyAccountInfo == 1){
			$('.displayVerificationRespondent').show();
			$('.displayVerificationRespondent span.display-message').html("Username entered already exists. Please provide a unique username.")
		}else if(verifyAccountInfo == 0){
			$('.displayVerificationRespondent').show();
			$('.displayVerificationRespondent span.display-message').html("Please fill up all required fields")
		}
	});
	
	$('body').delegate('.close-account-form','click',function(){
		boxAddAccountForm.modal('hide');
		return false;
	});
	
	$('body').delegate('.txt-search-account','keyup',function(){
		textDataAccounts = $(this).val();
		showComponents('pagination','.displayAccounts',tblname, page, sortOrderAccounts, '' , textDataAccounts);
	});
	
	$('body').delegate('.select-account-order','change',function(){
		sortOrderAccounts = $(this).val();
		showComponents('pagination','.displayAccounts',tblname, page, sortOrderAccounts, '' , textDataAccounts);
	});
	
	$('body').delegate('.btn-set-active','click',function(){
		id = $(this).attr('idsa');
		setActive = ajax({setActive : 1, id : id},true);
		showComponents('pagination','.displayAccounts',tblname, page, sortOrderAccounts, '' , textDataAccounts);
		refreshAccountInfo();
	})
	
	$('body').delegate('.btn-set-inactive','click',function(){
		id = $(this).attr('idsi');
		setInactive = ajax({setInactive : 1, id : id},true);
		showComponents('pagination','.displayAccounts',tblname, page, sortOrderAccounts, '' , textDataAccounts);
		refreshAccountInfo();
	})
	
	
	$('body').delegate('.btn-update-account','click',function(){
		updateAccount = ajax({updateAccount : 1},true);
		boxUpdateAccountForm = modalForm('Update account',updateAccount);
	});
	
	$('body').delegate('.close-update-account-form','click',function(){
		boxUpdateAccountForm.modal('hide');
		return false;
	});
	
	$('body').delegate('.btn-show-account-name-form','click',function(e){
		$('.display-account-name').hide()
		$('.frm-update-account-name').show();
	});
	
	$('body').delegate('.btn-cancel-update-name','click',function(){
		$('.display-account-name').show()
		$('.frm-update-account-name').hide();
	});
	
	$('body').delegate('.frm-update-account-name','submit',function(e){
		e.preventDefault();
		
		id = $(this).attr('id');
		name = $.trim($('.name').val());
		duplicateName = $.trim($('.duplicate-name').val());
		
		if(name != 0){
			$('.name').removeClass('no-input');
			if(name != duplicateName){
				if(confirm('Are you sure to save new account name?')){
					saveNewName = ajax({saveNewName : 1, id : id, name : name},true);
					$('.show-name').html(name)
					$('.duplicate-name').val(name)
					$('.display-account-name').show()
					$('.frm-update-account-name').hide();
				}
			}
		}else{
			$('.name').addClass('no-input');
		}
	});
	
	$('body').delegate('.btn-show-username-form','click',function(e){
		$('.display-username').hide()
		$('.frm-update-account-username').show();
	});
	
	$('body').delegate('.btn-cancel-update-username','click',function(){
		$('.display-username').show()
		$('.frm-update-account-username').hide();
	});
	
	$('body').delegate('.frm-update-account-username','submit',function(e){
		e.preventDefault();
		
		id = $(this).attr('id');
		username = $.trim($('.username').val());
		duplicateUsername = $.trim($('.duplicate-username').val())
		
		if(username != 0){
			$('.username').removeClass('no-input');
			if(username != duplicateUsername){
				if(!verifyUsername(username)){
					$('.displayVerificationRespondent').hide()
					if(confirm('Are you sure to save new username?')){
						saveNewUsername = ajax({saveNewUsername : 1, id : id, username : username} ,true);
						$('.show-username').html(username)
						$('.duplicate-username').val(username);
						$('.display-username').show()
						$('.frm-update-account-username').hide();
					}
				}else{
					$('.displayVerificationRespondent span').html("Username is already exists. Please provide a unique username..");
					$('.displayVerificationRespondent').show()
				}
			}
		}else{
			$('.username').addClass('no-input');
		}
	});
	
	$('body').delegate('.btn-show-password-form','click',function(e){
		$('.display-password').hide()
		$('.frm-update-password').show();
	});
	
	$('body').delegate('.btn-cancel-update-password','click',function(){
		$('.display-password').show()
		$('.frm-update-password').hide();
	});
	
	$('body').delegate('.frm-update-password','submit',function(e){
		e.preventDefault();
		
		id = $(this).attr('id');
		password = $.trim($('.password').val());
		retypePassword = $.trim($('.retype-password').val());
		
		if(password != 0 && retypePassword != 0){
			if(password == retypePassword){
				$('.displayVerificationRespondent').hide()
				if(confirm('Are you sure to save new password?')){
					saveNewPassword = ajax({saveNewPassword : 1, id : id, password : password} ,true);
					
					newPassword = '';
					for(i=0;i<password.length; i++){
						newPassword += '*';
					}
					
					$('.show-password').html(newPassword);
					$('.display-password').show();
					$('.frm-update-password').hide();	
				}
			}else{
				$('.displayVerificationRespondent span').html("Password you've entered does not match.");
				$('.displayVerificationRespondent').show()
			}
		}else{
			if(password == 0){
				$('.password').addClass('no-input');
			}else{
				$('.password').removeClass('no-input');
			}
			
			if(retypePassword == 0){
				$('.retype-password').addClass('no-input');
			}else{
				$('.retype-password').removeClass('no-input');
			}
		}
	})
	
	var boxViewAccountForm = '';
	$('body').delegate('.btn-view-account','click',function(){
		id = $(this).attr('idva');
		viewAccount = ajax({viewAccount :1, id : id},true);
		boxViewAccountForm = modalForm('View Account',viewAccount);
	})
	
	$('body').delegate('.close-view-account-form','click',function(){
		boxViewAccountForm.modal('hide');
	})
	
	function verifyAccountInputs(){
		
		name = $.trim($('.name').val());
		username = $.trim($('.username').val());
		password = $.trim($('.password').val());
		retypePassword = $.trim($('.retype-password').val());
		
		if(name != 0){
			hasName = true;
			$('.name').removeClass('no-input');
			$('.input-name').hide();
			$('.input-name-success').show();
			$('.input-name-failed').hide();
		}else{
			hasName = false;
			$('.name').addClass('no-input');
			$('.input-name').hide();
			$('.input-name-success').hide();
			$('.input-name-failed').show();
		}
		
		if(username != 0){
			hasUsername = true;
			$('.username').removeClass('no-input');
			
			if(verifyUsername(username)){
				isUsernameExists = true;
				$('.input-username').hide();
				$('.input-username-success').hide();
				$('.input-username-failed').show();
			}else{
				isUsernameExists = false;
				$('.input-username').hide();
				$('.input-username-success').show();
				$('.input-username-failed').hide();
			}
		}else{
			hasUsername = false;
			$('.username').addClass('no-input');
			$('.input-username').hide();
			$('.input-username-success').hide();
			$('.input-username-failed').show();
		}
		
		if(password != 0){
			hasPassword = true;
			$('.password').removeClass('no-input');
			$('.input-password').hide();
			$('.input-password-success').show();
			$('.input-password-failed').hide();
			
			if(password == retypePassword){
				isPasswordMarch = true;
				$('.input-password-success').show();
				$('.input-password-failed').hide();
				$('.input-confirm-password-success').show();
				$('.input-confirm-password-failed').hide()
			}else{
				isPasswordMarch = false;
				$('.input-password-success').hide();
				$('.input-password-failed').show();
				$('.input-confirm-password-success').hide();
				$('.input-confirm-password-failed').show()
			}
			
		}else{
			hasPassword = false;
			$('.password').addClass('no-input');
			$('.input-password').hide();
			$('.input-password-success').hide();
			$('.input-password-failed').show();
		}
		
		if(retypePassword != 0){
			hasRetypePassword = true;
			$('.retype-password').removeClass('no-input');
			$('.input-confirm-password').hide();
			$('.input-confirm-password-success').show();
			$('.input-confirm-password-failed').hide();
			
			
			if(password == retypePassword){
				isPasswordMarch = true;
				$('.input-password-success').show();
				$('.input-password-failed').hide();
				$('.input-confirm-password-success').show();
				$('.input-confirm-password-failed').hide()
			}else{
				isPasswordMarch = false;
				$('.input-password-success').hide();
				$('.input-password-failed').show();
				$('.input-confirm-password-success').hide();
				$('.input-confirm-password-failed').show()
			}
			
		}else{
			hasRetypePassword = false;
			$('.retype-password').addClass('no-input');
			$('.input-confirm-password').hide();
			$('.input-confirm-password-success').hide();
			$('.input-confirm-password-failed').show();
		}
		
		
		
		if(hasName == true && hasPassword == true && hasPassword == true && hasRetypePassword == true){
			if(isUsernameExists != true){
				if(isPasswordMarch === true){
					return 3;
				}else{
					return 2;
				}
			}else{
				return 1;
			}
		}else{
			return 0;
		}
	}
	
	function verifyUsername(username){
		verifyUname = ajax({verifyUname : 1, username : username},true);
		verifyUnameResult = verifyUname == 1 ? true : false;
		return verifyUnameResult;
	}
})