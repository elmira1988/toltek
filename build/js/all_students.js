$(document).ready(function(){
	$('[data-toggle="popover"]').popover(); 

	//отображаем таблицу со студентами
	get_data_by_filter();

//фильтр
	$("#achive").find("button").click(function(){
		$("#achive").find("button").removeClass("active");
		$(this).addClass("active");
		$("#access_to_account").css("display","block");
		if ($(this).attr("value")=="true")
		{
			$("#access_to_account").css("display","none");
		}
		get_data_by_filter();
	});
});

//Отображаем отфильтрованные данные
function get_data_by_filter() 
{
	$("#table_block").html('<img src="images/preloader.gif" style="margin-left:45%;">');
	var arr=filter_data();

	console.log(arr);
	$.post("build/php/get_table_all_students.php",{data:JSON.stringify(arr)},
		function(data){
			//console.log(data);
			$("#table_block").html(data);
			init_table();
		});
		
} 

//собираем данные фильтра
function filter_data()
{
	var arr={};

	$("#filter-block").find("[name='id_students']:checked,[name='class_number']:checked,[name='id_groups']:checked,[name='id_roles']").each(function(){
		let name=$(this).attr("name");
		let val=$(this).val(); 

		if (!(name in arr))
		{
			arr[name]=[];
		}
		
		arr[name].push(val);
	});

	arr["achive"]=[$("#achive").find("button.active").attr("value")];

	return arr;
}


//инициализация таблицы
function init_table()
{
	let table=$('#datatable-fixed-header').DataTable({
	"bStateSave": true,
	"ordering": false,
    "fnStateSave": function (oSettings, oData) {
        localStorage.setItem('offersDataTables', JSON.stringify(oData));
    },
    "fnStateLoad": function (oSettings) {
        return JSON.parse(localStorage.getItem('offersDataTables'));
    },
  	 orderCellsTop: true,
     fixedHeader: true});

	init_all_in_table(table);//инициализируем checkbox при смене страницы и при поиске	
/*
	//добавляем класс selected выделенной строке 
	$("input[type='checkbox'][name='selected']").on('ifClicked',function(event){
		$(event.target).parents("tr").toggleClass('selected');
			});

	$('#datatable-fixed-header tbody').on( 'click', 'tr', function (e) {
        	$(this).toggleClass('selected');
        	$(this).find("input[type='checkbox'][name='selected']").iCheck("toggle");
        
    }); 
*/
	//переносим количество записей
	$("span#count_note").html($("input[name='count_note']").val());

}


//Печать договора
function print_contract(id_parents,fileName) 
{
	var arr={};
	arr.id_parents=id_parents;
	export_to_pdf(arr,"build/php/make_contract.php",('Договор - '+fileName));     
}

//Редактирование данных обучающегося
function get_data_student(id_students)
{
	reset_edit_forms();

	$.post("build/php/get_data_student.php",{id_students:id_students},
		function(data){
			
			let student=JSON.parse(data);
			console.log(student); 
			
			$("#edit_modal_block").find('[name="id_students"]').val(id_students);
			
			for (var key in student) {
			  switch(key) {
			  	  case 'photo': 
					  	  if (student[key]!="")
					  	  {
					  	  	$("#myphoto").find("img").attr("src",("photo/"+student[key]));
					  	  }
			  	  		break;

				  case 'gender': 
				  		$("#edit_modal_block").find('[name="'+key+'"][value="'+student[key]+'"]').next("ins").click();
				   		 break;

				  case 'type_of_doc':
				  		$("#edit_modal_block").find('[name="'+key+'"]').val(student[key]);
				  		$("#edit_modal_block").find('[name="'+key+'"]').trigger('onchange');
				  		$("#edit_modal_block").find('[name="series"][required="required"]').val(student['series']);
				  		break;

				  case 'series':
				  		
				  		break;

				  case 'parents': 
				   		let parents=student[key];	 		  		

				   		for (n=0;n<parents.length;n++)
				   		{
				   			if (n>0)
				   			{
				   				$("#add_parent").trigger("click");
				   			}
				   			//console.log(parents[n]);
				   			let form=$(".add_parent:eq("+n+")");

				   			for (var k in parents[n]) { 

				   				switch(k) {
				   					case 'series': 
								  		form.find('[name="parent_series_number"]').val(parents[n]['series']+' '+parents[n]['number']);
								    break;
								    default:
								    	form.find('[name="parent_'+k+'"]').val(parents[n][k]);
				   					break;
				   						}
				   					}
				   		}
				    break;    

				  default:
				   $("#edit_modal_block").find('[name="'+key+'"]').val(student[key]);
				}
			}

		//закрываем курсы для класса 
		//update_disabled_of_courses(request['class_number']);

		//открываем модальное окно редаткирования записи
   	 	$('#edit_modal_block').modal('show');
   	 	$('#edit_modal_block').modal('handleUpdate') //для обновления позиции модального элемента в случае
		})

	
}


//сохраняем изменения (редактирование записи)
function update_student()  
{
	//проверяем форму добавления данных студента
	var validate_student = $('#add_student').parsley().validate(); 
	/*
	//отмечены ли были группы
	var groups_count=$("form#add_student").find("input[name='id_groups'][type='checkbox']:checked").length;

	if (groups_count==0)
	{
		$("form#add_student").find("#multi_select_whith_meta").addClass("parsley-error");
	}
	*/
	console.log(validate_student);
	if (validate_student/* && groups_count>0*/)
	{	
		var data={};
			data.student={};//данные студента
			data.id_groups=[];//данные по группам
			data.parents=[];//данные представителей
		
			//console.log(data);
		//собираем данные студента и группы - начало 
		$("form#add_student").find("input[type='hidden'],input[type='text']:not('.display_none'):not([readonly='readonly']),input[type='date'],input[type='radio']:checked,input[type='email'],select,input[type='checkbox']:checked").each(function(){
			if ($(this).parents(".display_none").length==0)
			{
				var name=$(this).attr("name");
				var val=$(this).val(); 
				switch(name) {
				  case 'id_groups':  
				  		data.id_groups.push(val);
				  	break;
				  default:
				    data.student[name]=val;
							}
			
			}
		});//собираем данные студента и группы - конец

		data.student["note"]=$("textarea[name='note']").val();
	
		//собираем все данные форм с представителями
		$('form.add_parent').each(function(){

			let validate= $(this).parsley().validate(); 
			
			let value={};
			
			if (validate)
			{
				$(this).find("input[type='hidden'],input[type='text'],input[type='date'],input[type='radio']:checked,input[type='email'],select").each(function(){
					var name=$(this).attr("name").replace("parent_","");
					var val=$(this).val(); 
					if (name=="series_number")
					{
						let arr=val.split(" ");
						//console.log(arr);
						value["series"]=arr[0];
						value["number"]=arr[1];
					}
					else
					{
						value[name]=val;
					}					
					    
				});

				data.parents.push(value);
			}
		});

		//console.log(data);
		
		//если все формы с представителями валидны
		if (data.parents.length==$("form.add_parent").length)
		{
			console.log(data);
			 
			var fd=new FormData();
			fd.append('img',$('[name="img_of_user"]')[0].files[0]);
			//console.log(fd.getAll('img'));
			fd.append('str',JSON.stringify(data));
			$.ajax({
				url:"../build/php/update_student.php",
				data:fd,
				processData: false,//Отправка DOM элемента
				contentType: false,//Отправка DOM элемента
				type: 'POST',
				success:
				function(info){
					console.log(info);
					if (info) 
						{
							$('#edit_modal_block').modal('hide');
							get_data_by_filter();
							print_info('Успешно', 'Данные успешно обновлены', 'success',delay=4000);
						}
						else
						{
							print_info('Ошибка', 'Ошибка при работе с базой данных', 'error',delay=4000);
						}				
					}
				});
		}
		else
		{
			console.log("Валидность не пройдена");
		}
		
		
	}
}

//очищаем форму
function reset_edit_forms() 
{

	$('form').trigger('reset');

	//удаляем представителей (кроме первого)
	$("#parents").find(".close-link:not('.invisible')").click();

	//очищаем комментарии
	$("[name='note']").val("");

	//очищаем фото
	$("#myphoto").find("img").attr("src","images/people-icon.png");

	//по умолчанию ставим свидетельство о рождении
	change_doc($("[name='type_of_doc']").find("option[value='1']")[0]);

}


function export_excel() 
{
	var arr=filter_data();
	export_to_excel(arr,"build/php/make_excel_file_students.php");  
	
}


function modal_add_to_groups(id_students,name) 
{
	$.post("build/php/get_form_to_add_to_group.php",{id_students:id_students},
	function(data){
		//console.log(data);
		$('#modal_add_to_group').find(".modal-title").html(name);
		$('#modal_add_to_group').find(".modal-body").html(data);
		$('#modal_add_to_group').modal('show');
		$('#modal_add_to_group').on('shown.bs.modal', function (e) 
			{
				init_multi_select(); 
				update_select_block(); 
				init_choose_period(); 
				$("input#date,input#multi_select_whith_meta").click(function(){
					$(this).removeClass("parsley-error");
					$(this).next("ul.parsley-errors-list").addClass("display_none"); 
				});
			})	
		$('#modal_add_to_group').modal('handleUpdate') //для обновления позиции модального элемента
			
	});

}


function add_to_group()
{
	var data={};
		data.id_students=$("#modal_add_to_group").find("input[name='id_students']").val();//данные студента
		data.id_groups=[];//данные по группам

	var error_count=0;
	//отмечены ли были группы
	var groups=$("#modal_add_to_group").find("input[name='id_groups'][type='checkbox']:checked");

	if (groups.length==0)
	{
		$("#modal_add_to_group").find("#multi_select_whith_meta").addClass("parsley-error");
		error_count++;
	}
	else
	{
		groups.each(function(){
			data.id_groups.push($(this).val());
		});
	}

	//указан ли период обучения
	var $dates=$("#modal_add_to_group").find("#date").data('datepicker').getFormattedDate('yyyy/mm');
	
	if ($dates=="")
	{
		$("#modal_add_to_group").find("#date").addClass("parsley-error");
		$("#modal_add_to_group").find("#date").next("ul").removeClass("display_none");
		error_count++;
	}
	else
	{
		let mas=$dates.split(" - ");
		let begin=end=mas[0];
		if (mas.length>1)
		{
			end=mas[1];
		}

		data.month_begin=Number(begin.split("/")[1]);
		data.month_end=Number(end.split("/")[1]);
	}

	if (error_count==0)
	{
		console.log("сохраняем данные");
		console.log(data);
		$.post("build/php/save_add_to_group.php",{data:JSON.stringify(data)},function(info){
			console.log(info);
			if (info)  
				{
					print_info('Успешно', 'Данные успешно сохранены', 'success',delay=4000);
					$("#modal_add_to_group").modal('hide');
					get_data_by_filter();
				}
				else
				{
					print_info('Ошибка', 'Ошибка при работе с базой данных', 'error',delay=4000);
				}	
		})
	}
	else
	{
		console.log("найдены ошибки");
	}
	
}


function modal_add_to_achive(name,id_students_groups) 
{
	$.post("build/php/get_form_add_to_achive.php",{id_students_groups:id_students_groups},
	function(data){
		//console.log(data);
		$('#modal_add_to_achive').find(".modal-title").html(name);
		$('#modal_add_to_achive').find(".modal-body").html(data);
		$('#modal_add_to_achive').modal('show');
		$('#modal_add_to_achive').on('shown.bs.modal', function (e) 
			{
				init_multi_select(); 
				update_select_block(); 
				init_choose_period(); 
				$("input#date,input#multi_select_whith_meta").click(function(){
					$(this).removeClass("parsley-error");
					$(this).next("ul.parsley-errors-list").addClass("display_none"); 
				});
			})	
		$('#modal_add_to_achive').modal('handleUpdate') //для обновления позиции модального элемента
			
	});
}


function add_to_achive()
{
	let data={};
	    data.id_students_groups=$("#modal_add_to_achive").find("input[name='id_students_groups']").val();
	    data.months_of_study=$("#modal_add_to_achive").find("input[name='months_of_study']").val();
	    data.note=$("#modal_add_to_achive").find("textarea[name='note']").val();

	
	$.post("build/php/save_add_to_achive.php",{data:JSON.stringify(data)},function(info){
			console.log(info);
			if (info)  
				{
					print_info('Успешно', 'Запись успешно добавлена в архив', 'success',delay=4000);
					$("#modal_add_to_achive").modal('hide');
					get_data_by_filter();
				}
				else
				{
					print_info('Ошибка', 'Ошибка при работе с базой данных', 'error',delay=4000);
				}	
		});

}


function modal_restore_from_achive(name,id_students_groups)
{
	$.post("build/php/get_form_restore_from_achive.php",{id_students_groups:id_students_groups},
	function(data){
		//console.log(data);
		$('#modal_restore_from_achive').find(".modal-title").html(name);
		$('#modal_restore_from_achive').find(".modal-body").html(data);
		$('#modal_restore_from_achive').modal('show');
		$('#modal_restore_from_achive').on('shown.bs.modal', function (e) 
			{
				$('input.flat').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            							});
			})	
		
		$('#modal_restore_from_achive').modal('handleUpdate') //для обновления позиции модального элемента
			
	});
}


function restore_from_achive()
{
	let data={};
	    data.id_students_groups=$("#modal_restore_from_achive").find("input[name='id_students_groups']").val();
	    data.months_of_study=$("#modal_restore_from_achive").find("input[name='months_of_study']").val();
	    data.month_begin=$("#modal_restore_from_achive").find("input[name='month']:checked").val(); 
	    data.note=$("#modal_restore_from_achive").find("textarea[name='note']").val();

	
	$.post("build/php/save_restore_from_achive.php",{data:JSON.stringify(data)},function(info){
			console.log(info);
			
			if (info)  
				{
					print_info('Успешно', 'Запись успешно восстановлена', 'success',delay=4000);
					$("#modal_restore_from_achive").modal('hide');
					get_data_by_filter();
				}
				else
				{
					print_info('Ошибка', 'Ошибка при работе с базой данных', 'error',delay=4000);
				} 
				
		});
}

//отправить письма родителям со ссылками для создания/обновления логина и пароля
function access_to_account()
{
	$("#send_email_with_access").find(".modal-body").html("");
	var users= new Object();
	users.arr_id_students = new Array();//массив с идентификаторами пользователей кому адресованы письма со ссылками

	$("#datatable-fixed-header").find("input:checkbox[name=selected]:checked").each(function()
	{ 
		users.arr_id_students.push($(this).parents('tr').find("span#student").attr("data-id-students"));
	});
	
	 console.log(users);
	if (users.arr_id_students.length>0)
	{
		if (users.arr_id_students.length<=20)
		{
			$.post("build/php/get_data_email_with_access_to_account.php",{data:JSON.stringify(users)},
			function(info){
				//console.log(info); 				
				$("#send_email_with_access").find(".modal-body").html(info);
				$('[data-toggle="tooltip"]').tooltip();//иницализируем вывод подсказок
				$('#send_email_with_access').modal('show'); 
				});
		}
		else
		{
			print_info('Превышен лимит получателей', 'Число получателей не должно превышать 20 человек!', 'warning',2000);
		}
		  
	}
	else
	{
		print_info('Получатели не указаны', 'Выберите хотя бы одного получателя!', 'warning',2000);
	}
}


function send_email_with_key(el)
{
	if (!$(el).hasClass("disabled"))
	{
		//собираем id_parents
		var data = new Object();
			data.arr_id_students=new Array();
			data.arr_id_parents=new Array();

		$('#send_email_with_access').find("label.active").each(function(){
			data.arr_id_students.push($(this).attr("data_id_students"));
			data.arr_id_parents.push($(this).attr("data_id_parents"));
		});

		console.log(data); 

		//закрываем доступ на повторную отпарвку писем
		$(el).addClass("disabled");

		$.post("build/php/send_mail_with_link_to_access_to_account.php",{data:JSON.stringify(data)},
			function(data){
				console.log(data);
				
				try {
				    data = JSON.parse(data); 
				    console.log(data);

				    let send_ok_count=0;//количество успешно отправленных
					let send_error_count=0;//количество неуспешно отправленных

					for (key in data) {
						//console.log(data[key]);
						
						if (data[key].result=='ok')
						{
							$("#send_email_with_access").find("[data-email='"+data[key].email+"']").parent("label.active").addClass("send_ok");
							send_ok_count++;
						} 
						else
						{
							send_error_count++;
							$("#send_email_with_access").find("[data-email='"+data[key].email+"']").parent("label.active").addClass("send_error");
							$("#send_email_with_access").find("[data-email='"+data[key].email+"']").parent("label.active").attr("data-original-title",data[key].msg);
						}
					}

						print_info("Письма отправлены",("Отправлено: "+send_ok_count+"<br> Не отправлено: "+send_error_count),"success");
						
				} catch(e) {
						print_info("Не удалось отправить письма","Неизвестная ошибка, обратитесь в тех. поддержку","warning");
				    
				}
				
				$(el).removeClass("disabled"); 
				
			});
	}	//проверка разблоченности кнопки "отправить сообщение"
}


					