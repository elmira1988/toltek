$(document).ready(function(){

//проверка пароля на сложность
if ($('input[name="password"]').length>0) 
{
	$('input[name="password"]').keyup(function(){test_password($(this).val());});  
}

$(".submit").click(function(){

	//send to email link with restore log,pas
	if ($("input[name='email']").length>0)
	{
		if ($('form').parsley().validate())
		{
			let email=$("input[name='email']").val();
			//console.log(email);
			

			$(".submit").addClass("disabled"); 
			$.post("build/php/send_mail_restore_log_pas.php",{email:email},function(data){
				console.log(data);
				info=JSON.parse(data);

				if (info.result=="ok")
				{
					$('#email_block').addClass('fadeOutLeft');
					$('#info').addClass('fadeInRight');
				}
				else
				{
					print_info("Ошибка", info.msg, "warning",5000);
				}
				$(".submit").removeClass("disabled"); 
			});

		} 
		else
		{

			$("[name='email']").addClass('pulse');

			 setTimeout(function(){
				$("[name='email']").removeClass('pulse');
			 }, 1000); 
		}	
	}
	else
	{
	//save new log_pas		
	if (!$(this).hasClass("disabled"))
	{
		$("#pass").css("display","none");		

		if ($('form').parsley().validate())
		{
			login=$("[name='login']").val();
			password=$("[name='password']").val();
			id_parents_key=$("[name='id_parents_key']").val();

			$(this).addClass("disabled");
			$.post("build/php/update_parents_log_pas.php",
				{
					login:login,
					password:password,
					id_parents_key:id_parents_key
				},
				function(data){ 
					console.log(data); 
					if (data)
					{
						console.log("логин и пароль успешно изменены");
						$("#new_log_pas").addClass('fadeOutLeft');
						$("#info").addClass('fadeInRight');
					}
					else
					{
						print_info('Ошибка', 'Ошибка при работе с базой данных.<br> Обратитесь к администратору!', 'warning',4000);

					}
					$('form').find(".submit").removeClass("disabled"); 
					
					});  
					
		}
		else
		{

			$("[name='login']").addClass('pulse');
			$("[name='password']").addClass('pulse');

			 setTimeout(function(){
				$("[name='login']").removeClass('pulse');
				$("[name='password']").removeClass('pulse');

			 }, 1000); 
		}	
	}
	
	}

	
	});
});

