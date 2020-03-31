
$(document).ready(function(){
	$('[data-toggle="popover"]').popover(); 

	//отображаем таблицу с преподавателями
	get_data_by_filter();

    //фильтр
	$("#achive").find("button").click(function(){
		$("#achive").find("button").removeClass("active");
		$(this).addClass("active");
		get_data_by_filter();
	});
});

//Отображаем отфильтрованные данные
function get_data_by_filter() 
{
	$("#table_block").html('<img src="images/preloader.gif" style="margin-left:45%;">');
	var arr=filter_data();

	//console.log(arr);
	$.post("build/php/get_table_all_teachers.php",{data:JSON.stringify(arr)}, 
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

//Редактирование данных обучающегося
function get_data_teacher(id_teachers)
{
	reset_edit_forms();

	$.post("build/php/get_data_teacher.php",{id_teachers:id_teachers},
		function(data){
			let teacher=JSON.parse(data);
			
			$("#edit_modal_block").find('[name="id_teachers"]').val(id_teachers);
			
			for (var key in teacher) {
			  switch(key) {
			  	  case 'photo': 
					  	  if (teacher[key]!="")
					  	  {
					  	  	$("#myphoto").find("img").attr("src",("photo/"+teacher[key]));
					  	  }
			  	  		break;
			  	  case 'gender': 
				  		$("#edit_modal_block").find('[name="'+key+'"][value="'+teacher[key]+'"]').next("ins").click();
				   		 break;
				  default:
				   $("#edit_modal_block").find('[name="'+key+'"]').val(teacher[key]);
				}
			}

		//открываем модальное окно редаткирования записи
   	 	$('#edit_modal_block').modal('show');
   	 	$('#edit_modal_block').modal('handleUpdate') //для обновления позиции модального элемента в случае
   	 	
		})

	
}


//сохраняем изменения (редактирование записи)
function update_teacher()  
{
	//проверяем форму добавления данных студента
	var validate_teacher = $('#add_teacher').parsley().validate(); 

	console.log(validate_teacher);
	if (validate_teacher)
	{	
		var data={};
			data.teacher={};//данные преподавателя
		
		//собираем данные преподавателя
		$("form#add_teacher").find("input[type='hidden'],input[type='text'],input[type='date'],input[type='radio']:checked,input[type='email']").each(function(){
			var name=$(this).attr("name");
			var val=$(this).val();
				data.teacher[name]=val;
		});//собираем данные преподавателя

		data.teacher["note"]=$("textarea[name='note']").val();
	
		console.log(data);
 
		var fd=new FormData();
		fd.append('img',$('[name="img_of_user"]')[0].files[0]);
		//console.log(fd.getAll('img'));
		fd.append('str',JSON.stringify(data));
		$.ajax({
			url:"../build/php/update_teacher.php",
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
						print_info('Успешно', 'Данные успешно обновлены', 'success', 4000);
					}
					else
					{
						print_info('Ошибка', 'Ошибка при работе с базой данных', 'error', 4000);
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
function reset_edit_forms() 
{

	$('form').trigger('reset');

	//очищаем комментарии
	$("[name='note']").val("");

	//очищаем фото
	$("#myphoto").find("img").attr("src","images/people-icon.png");

}


function export_excel() 
{
	var arr=filter_data();
	export_to_excel(arr,"build/php/make_excel_file_teachers.php");   
	
}


//добавляем в архив преподавателя
function modal_add_to_achive(name,id_teachers) 
{
	$.post("build/php/get_form_add_to_achive_teacher.php",{id_teachers:id_teachers},
	function(data){
		//console.log(data);
		$('#modal_add_to_achive').find(".modal-title").html(name);
		$('#modal_add_to_achive').find(".modal-body").html(data);
		$('#modal_add_to_achive').modal('show');
		/*
		$('#modal_add_to_achive').on('shown.bs.modal', function (e) 
			{
				init_multi_select(); 
				update_select_block(); 
				init_choose_period(); 
				$("input#date,input#multi_select_whith_meta").click(function(){
					$(this).removeClass("parsley-error");
					$(this).next("ul.parsley-errors-list").addClass("display_none"); 
				});
			})*/	
		$('#modal_add_to_achive').modal('handleUpdate') //для обновления позиции модального элемента
			
	});
}


function add_to_achive()
{
	let data={};
	    data.id_teachers=$("#modal_add_to_achive").find("input[name='id_teachers']").val();
	    data.note=$("#modal_add_to_achive").find("textarea[name='note']").val();

	console.log(data);
	$.post("build/php/save_add_to_achive_teacher.php",{data:JSON.stringify(data)},function(info){
			console.log(info); 
			if (info)  
				{
					print_info('Успешно', 'Запись успешно добавлена в архив', 'success',4000);
					$("#modal_add_to_achive").modal('hide');
					get_data_by_filter();
				}
				else
				{
					print_info('Ошибка', 'Ошибка при работе с базой данных', 'error',4000);
				}	
		});

}


function modal_restore_from_achive(name,id_teachers)
{
	$.post("build/php/get_form_restore_from_achive_teacher.php",{id_teachers:id_teachers},
	function(data){
		//console.log(data);
		$('#modal_restore_from_achive').find(".modal-title").html(name);
		$('#modal_restore_from_achive').find(".modal-body").html(data);
		$('#modal_restore_from_achive').modal('show');/*
		$('#modal_restore_from_achive').on('shown.bs.modal', function (e) 
			{
				$('input.flat').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            							});
			})	
		*/ 
		$('#modal_restore_from_achive').modal('handleUpdate') //для обновления позиции модального элемента
			
	});
}


function restore_from_achive()
{
	let data={};
	    data.id_teachers=$("#modal_restore_from_achive").find("input[name='id_teachers']").val();
	    data.note=$("#modal_restore_from_achive").find("textarea[name='note']").val();

	
	$.post("build/php/save_restore_from_achive_teacher.php",{data:JSON.stringify(data)},function(info){
			console.log(info);
			
			if (info)  
				{ 
					print_info('Успешно', 'Запись успешно восстановлена', 'success', 4000);
				    $("#modal_restore_from_achive").modal('hide');
				    get_data_by_filter();
				}
				else
				{
					print_info('Ошибка', 'Ошибка при работе с базой данных', 'error', 4000);
				}
				
		}); 
}


					