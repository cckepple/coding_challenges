$(document).ready(function(){

	$('#submitLogin').on('click', function(e){
		e.preventDefault();
		$('#errorBlock').hide();

		var credentials = {
							username: $('#username').val(),
							password: $('#pass').val()
		};

		if (validateCredentails(credentials)) {
			$.post('php/login.php',
			{
				username:credentials.username,
				password:credentials.password

			}).success(function(data){
				console.log(data);
				if (data.error == false) {
					authUser(data);
				}else if(data.error == 1){
					// username / pw don't match
					$('#errorBlock').text(data.message);
					$('#errorBlock').show();
				}else{
					// username not in DB
					showRegistration(data.message);
				}
			}).error(function(data){
				console.log('Server Error -- submit login');
				console.log(data);
				$('#errorBlock').html(data.responseText);
				$('#errorBlock').show();
			});
		};
	});

	$('#submitRegister').on('click', function(e){
		e.preventDefault();
		$('#errorBlock').hide();

		var credentials = {
							username: $('#username').val(),
							password: $('#pass').val(),
							passwordConfirm: $('#passConf').val(),
							email: $('#email').val(),
							name: $('#name').val(),
		};
		if (validateCredentails(credentials)) {
			$.post('php/register.php',
			{
				username: credentials.username,
				password: credentials.password,
				email: credentials.email, 
				name: credentials.name

			}).success(function(data){
				console.log(data);
				authUser(data);
			}).error(function(data){
				console.log('Server Error -- register user');
				console.log(data);
				$('#errorBlock').html(data.responseText);
				$('#errorBlock').show();
			});
		};
	});

});