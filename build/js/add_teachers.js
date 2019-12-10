
function add_teacher()
{
	//проверяем форму добавления данных преподавателя
	var validate_teacher = $('form#add_teacher').parsley().validate(); 

	console.log(validate_teacher);
	if (validate_teacher)
	{	
		var data={};
			data.teacher={};//данные преподавателя

		//собираем данные преподавателя - начало
		$("form#add_teacher").find("input[type='text'],input[type='date'],input[type='radio']:checked,input[type='email'],textarea[name='note']").each(function(){
			
			var name=$(this).attr("name");
			var val=$(this).val(); 
			data.teacher[name]=val;
		});//собираем данные преподавателя - конец

		console.log(data); 

		var fd=new FormData();
		fd.append('img',$('[name="img_of_user"]')[0].files[0]);
		//console.log(fd.getAll('img'));
		fd.append('str',JSON.stringify(data));
		$.ajax({
			url:"../build/php/save_teachers.php",
			data:fd,
			processData: false,//Отправка DOM элемента
			contentType: false,//Отправка DOM элемента
			type: 'POST',
			success:
			function(info){
				console.log(info);
				if (info)  
					{
						print_info('Успешно', 'Данные успешно сохранены', 'success',delay=4000);
						reset_forms();
					}
					else
					{
						print_info('Ошибка', 'Ошибка при работе с базой данных','error',delay=4000);
					}				
				}
			});
	}
	else
	{
		console.log("Валидность не пройдена");
	}
		
}

//очищаем форму
function reset_forms() 
{

	$('form').trigger('reset');

	$("[name='note']").val("");

	$("#myphoto").find("img").attr("src","/images/Teacher-female-icon.png");
}