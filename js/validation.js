
function validateCredentails(credentials)
{
	$('.validators').hide();
	var formErrors = false;

	if ('username' in credentials) {
		formErrors = validateUsername(credentials.username);
	};
	if ('password' in credentials && !formErrors) {
		formErrors = validatePassword(credentials.password);
	};

	if ('passwordConfirm' in credentials && !formErrors) {
		formErrors = validateConfirmPass(credentials.password, credentials.passwordConfirm);
	};

	if ('email' in credentials && !formErrors) {
		formErrors = validateEmail(credentials.email);
	};

	if ('name' in credentials && !formErrors) {
		formErrors = validateName(credentials.name);	
	};

	if (formErrors) {
		$('#validationBlock').show();
		return false
	}

	return true;
}

function validateUsername(username)
{
	var usernameErrors = false;
	if (username == '' || username == null) {
		$('#emptyUsername').show();
		usernameErrors = true;
	}else{
		if (username.length >= 25){
			$('#longUsername').show();
			usernameErrors = true;
		};

		if (username.match(/^[a-zA-Z0-9]+$/) == null) {
			$('#invalidUsername').show();
			usernameErrors = true;
		};
	}

	return usernameErrors;
}

function validatePassword(password, passwordConfirm)
{
	var passwordErrors = false;
	if (password == '' || username == null) {
		$('#emptyPassword').show();
		passwordErrors = true;
	}else{
		if (password.length > 255){
			$('#longPassword').show();
			passwordErrors = true;
		};

		if (password.indexOf(' ') >= 0) {
			$('#invalidPassword').show();
			passwordErrors = true;
		};
	};

	return passwordErrors;
}

function validateConfirmPass(password, passwordConfirm)
{
	if (password === passwordConfirm) {
		return false;
	};
	$('#confirmPass').show();
	return true;
}

function validateEmail(email)
{
	var emailErrors = false;
	if (email == '' || username == null) {
		$('#emptyEmail').show();
		emailErrors = true;
	}else{
		if (email.length >= 255){
			$('#longEmail').show();
			emailErrors = true;
		};

		if (email.match(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/) == null) {
			$('#invalidEmail').show();
			emailErrors = true;
		};
	};

	
	return emailErrors;
}

function validateName(name)
{
	var nameErrors = false;
	if (name == '' || username == null) {
		$('#emptyName').show();
		nameErrors = true;
	}else{
		if (name.length >= 100){
			$('#longName').show();
			nameErrors = true;
		};

		if (name.match(/^[a-zA-Z0-9 .,-]+$/) == null) {
			$('#invalidName').show();
			nameErrors = true;
		};
	};

	
	return nameErrors;
	
	return true;
}

function authUser(data)
{
	$('#userForm').hide();
	$('#displayName').text(data.user.name);
	$('#displayUn').text(data.user.username);
	$('#displayEmail').text(data.user.email);
	$('#createdAt').text(data.user.created_at);
	$('#lastLog').text(data.login_time);

	$('#authUser').show();
}

function showRegistration(message)
{
	$('.logUser').hide();
	$('.register-user').show();
	if (message) {
		$('#errorBlock').text(message);
		$('#errorBlock').show();
	}else{
		$('#errorBlock').hide();
	}
	$('#pass').val('');
}

function showLogin()
{
	$('.register-user').hide();
	$('.logUser').show();
	$('#pass').val('');
	$('#username').val('');
	$('#errorBlock').hide();
}