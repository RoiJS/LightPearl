$(document).ready(function(){
	
	$('body').delegate('.loginForm','submit',function(e){
		e.preventDefault();
		username = $.trim($('.username').val());
		password = $.trim($('.password').val());
		
		if(username !=0 && password != 0){
			login = ajax({login : 1, username : username , password : password},true);
			
			if(login == 0){
				alert('Invalid username or password');
				document.getElementById("username").focus();	
				$('.username').val('');
				$('.password').val('');
			}else if(login == 1){
				alert('Your account has been temporarily deactivated.');
			}else if(login == 2){
				alert('You cannot login anymore because this account is currently logged in.');
			}else{
				window.location = '?pg='+login;
			}
		}else{
			alert('Please fill up all required fields.');
		}
	});
});