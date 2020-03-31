$(document).ready(function(){
if ($("form").length!=0)
{
	//проверка пароля на сложность
	$('input[name="password"]').keyup(function(){test_password($(this).val());});  
}

$(".submit").click(function(){

	if (!$(this).hasClass("disabled"))
	{
		$("#pass").css("display","none");
		

		if ($('form').parsley().validate())
		{
			login=$("[name='login']").val();
			password=$("[name='password']").val();
			key=$("[name='key']").val();

			$(this).addClass("disabled");
			$.post("build/php/save_parents_log_pas.php",
				{
					login:login,
					password:password,
					key:key 
				},
				function(data){
					console.log(data); 
					
					if (data)
					{
						location.reload();
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
	
	});
});



function test_password(pas)//проверка пароля на сложность
{ind=checkPassword(pas);
    if (ind==0) {col='rgba(250,189,189,1)';txtCol='rgba(255,0,0,0.9)';bcol='red';str='обяз-но для заполнения';}
    if (ind==1) {col='rgba(250,189,189,1)';txtCol='rgba(255,0,0,0.9)';bcol='red';str='простой';}
    if (ind==2) {col='rgba(255,216,0,0.2)';txtCol='rgba(255,216,0,0.9)';bcol='yellow';str='средний';}
    if (ind==3) {col='rgba(38,127,0,0.2)';txtCol='rgba(38,127,0,0.9)';bcol='green';str='сложный';}
    $('#pass').css({'background-color':col,'color':txtCol,'border-top':('1px solid '+bcol)}).html(str);
    $('#pass').css('display','block');
    return ind;
}

function checkPassword(password)
{var s_letters = "qwertyuiopasdfghjklzxcvbnm"; // Буквы в нижнем регистре
    var b_letters = "QWERTYUIOPLKJHGFDSAZXCVBNM"; // Буквы в верхнем регистре
    var digits = "0123456789"; // Цифры
    var specials = "!@#$%^&*()_-+=\|/.,:;[]{}"; // Спецсимволы
    var is_s = false; // Есть ли в пароле буквы в нижнем регистре
    var is_b = false; // Есть ли в пароле буквы в верхнем регистре
    var is_d = false; // Есть ли в пароле цифры
    var is_sp = false; // Есть ли в пароле спецсимволы
    for (var i = 0; i < password.length; i++) {
        // Проверяем каждый символ пароля на принадлежность к тому или иному типу
        if (!is_s && s_letters.indexOf(password[i]) != -1) is_s = true;
        else if (!is_b && b_letters.indexOf(password[i]) != -1) is_b = true;
        else if (!is_d && digits.indexOf(password[i]) != -1) is_d = true;
        else if (!is_sp && specials.indexOf(password[i]) != -1) is_sp = true;
    }
    var rating = 0;
    var text = 0;
    if (is_s) rating++; // Если в пароле есть символы в нижнем регистре, то увеличиваем рейтинг сложности
    if (is_b) rating++; // Если в пароле есть символы в верхнем регистре, то увеличиваем рейтинг сложности
    if (is_d) rating++; // Если в пароле есть цифры, то увеличиваем рейтинг сложности
    if (is_sp) rating++; // Если в пароле есть спецсимволы, то увеличиваем рейтинг сложности
    // Далее идёт анализ длины пароля и полученного рейтинга, и на основании этого готовится текстовое описание сложности пароля 
    if (password.length < 6 && rating < 3) text = 1;//"Простой";
    else if (password.length < 6 && rating >= 3) text = 2;//"Средний";
    else if (password.length >= 8 && rating < 3) text = 2;//"Средний";
    else if (password.length >= 8 && rating >= 3) text = 3;//"Сложный";
    else if (password.length >= 6 && rating == 1) text = 1;//"Простой";
    else if (password.length >= 6 && rating > 1 && rating < 4) text = 2;//"Средний";
    else if (password.length >= 6 && rating == 4) text = 3;//"Сложный";
    if (password.replace(/^\s+|\s+$/g, '')=='') text=0;
    return text; // Выводим итоговую сложность пароля
}