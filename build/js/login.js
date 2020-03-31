$(document).ready(function(){

	$("[name='login'],[name='password']").focus(function(){
		$('.error-login').css('visibility','hidden');
	});


	$(".submit").click(function(){

		if (!$(this).hasClass("disabled"))
		{
			$(this).addClass("disabled");

			login=$("[name='login']").val();
			password=$("[name='password']").val();
			role=$("[name='role']").val();
			
			$.post("build/php/login.php",
			{
				login:login,
				password:password,
				id_role:role
			},
			function(data){
				//console.log(data);
				response=JSON.parse(data);

				console.log(response);

				if (response.error==0) 
				{
					console.log('Авторизация прошла успешно!');
					window.location.href = response.start_page;	 
								
				}
				else
				{
					$('.error-login').css('visibility','visible');
					$('.error-login').addClass('fadeIn');
					$("[name='login']").addClass('pulse');
					$("[name='password']").addClass('pulse');

					 setTimeout(function(){
						$('.error-login').removeClass('fadeIn');
						$("[name='login']").removeClass('pulse');
						$("[name='password']").removeClass('pulse');

					 }, 1000); 
				}
				
				$(".submit").removeClass("disabled");
			});
		}
	});
})