$(document).ready(function(){
	//отображаем таблицу с заявками
	get_data_by_filter();


})



function filter_data()
{
	var arr={};

	$("#filter-block").find("[name='id_requests']:checked,[name='class_number']:checked,[name='attend']:checked,[name='id_request_status']:checked,[name='id_courses']:checked,[name='id_roles']").each(function(){
		let name=$(this).attr("name");
		let val=$(this).val();

		if (!(name in arr))
		{
			arr[name]=[];
		}
		
		arr[name].push(val);
	});

	console.log(arr);

	return arr;
}

//Отображаем отфильтрованные данные
function get_data_by_filter()
{
	var arr=filter_data();


	$.post("build/php/get_table_all_request.php",{data:JSON.stringify(arr)},
		function(data){
			$("#table_block").html(data);
			init_table();
		});
		
}

//инициализация таблицы
function init_table(){
	$('#datatable-fixed-header').DataTable({
	"bStateSave": true,
    "fnStateSave": function (oSettings, oData) {
        localStorage.setItem('offersDataTables', JSON.stringify(oData));
    },
    "fnStateLoad": function (oSettings) {
        return JSON.parse(localStorage.getItem('offersDataTables'));
    },
  	 orderCellsTop: true,
     fixedHeader: true,
    'order': [[ 5, 'desc' ]]//отображаем самые "свежие" заявки
	});
}

//редактируем статус заявки
function edit_request_status(el,id_requests)
{
	$.post("build/php/edit_request_status.php",{id_requests:id_requests},
		function(data){
			$(el).find("i").css("color",data);
		});
}

//получаем данные о записи из базы
function get_data_request(id_requests)  
{
	$.post("build/php/get_data_request.php",{id_requests:id_requests},
		function(data){
			
			let request=JSON.parse(data);
			//console.log(request);
			$("#edit_modal_block").find('[name="id_requests"]').val(id_requests);
			//console.log(request);
			for (var key in request) {
			  switch(key) {
				  case 'attend': 
				  		$("#edit_modal_block").find('[name="'+key+'"][value="'+request[key]+'"]').next("ins").click();
				    break;
				  case 'class_number': 
				  		$("#edit_modal_block").find('[name="'+key+'"]').find('[value="'+request[key]+'"]').attr("selected","selected");
				    break;
				  case 'id_courses': 

				  		//очищаем блок с направлениями select
				  		$("#edit_modal_block").find('input[name="id_courses"]:checked').click();
				  		//открываем все курсы сначала
						$("form#edit_request").find("input[name='id_courses']").parents("li").removeClass("disabled");
						$("form#edit_request").find("input[name='id_courses']").removeAttr("disabled");

				  		//очищаем блок с направлениями	
				  		$("#courses_block").html("");

				  		let id_courses=request['id_courses'];

				  		//отмечаем все выбранные курсы
				  		for (i=0;i<id_courses.length;i++)
				  		{
					  		$("#edit_modal_block").find('input[name="id_courses"][value="'+id_courses[i].id_courses+'"]').click();
					  		update_value_input_filter();

				  		}				  		
				    break;    

				  default:
				   $("#edit_modal_block").find('[name="'+key+'"]').val(request[key]);
				}
			}

		//закрываем курсы для класса 
		update_disabled_of_courses(request['class_number']);

		//открываем модальное окно редаткирования записи
   	 	$('#edit_modal_block').modal('show');
   	 	$('#edit_modal_block').modal('handleUpdate') //для обновления позиции модального элемента в случае

   	 	$('#edit_modal_block').on('shown.bs.modal', function (e) {
		   update_select_block();
		});

		})
}




//сохраняем изменения (редактирование записи)
function update_request() 
{
	update_value_input_filter(); 
	var not_error=!$("#direction_in_edit_form").hasClass("parsley-error");
	var validate = $('#edit_request').parsley().validate(); 
	
	if (validate & not_error)
	{
		var data={};

		$("form#edit_request").find("input[type='hidden'],input[type='text']:not([readonly='readonly']),input[type='date'],input[type='radio']:checked,input[type='email'],select,input[type='checkbox']:checked,textarea").each(function(){
			var name=$(this).attr("name");
			var val=$(this).val(); 
			switch(name) {
			  case 'id_courses':  
			  	if (!("id_courses" in data))
			  	{
			  		data["id_courses"]=[];
			  	}
			  	data["id_courses"].push(val);
			  	break;
			  default:
			    data[name]=val;
			}

		});

		$.post("../build/php/update_request.php",{data:JSON.stringify(data)},
			function(info){
				console.log(info);
				if (info) 
					{
						$('#edit_modal_block').modal('hide');
						get_data_by_filter();

						new PNotify({
                          title: 'Успешно',
                          text: 'Изменения успешно сохранены',
                          type: 'success',
                          hide: true,
                          animation: 'fade',
                          animateSpeed: '250ms',
                          delay: 4000,
                          remove: true,
                          width:700,
                          styling: 'bootstrap3',
                          buttons: {closer: false,sticker: false}
                          });
					}
					else
					{
						new PNotify({
                          title: 'Ошибка',
                          text: 'Ошибка при работе с базой данных',
                          type: 'error',
                          hide: true,
                          animation: 'fade',
                          animateSpeed: '250ms',
                          delay: 4000,
                          remove: true,
                          width:700,
                          styling: 'bootstrap3',
                          buttons: {closer: false,sticker: false}
                          });
					}
				
			})
			
	}
	else
	{
		console.log("Ошибка в форме");
	}
	

}

//при смене класса меняем доступность добавления курсов
function change_courses(el)
{
	update_disabled_of_courses($(el).val());
}

function update_disabled_of_courses(this_class_number)
{
	//открываем все курсы сначала
	$("form#edit_request").find("input[name='id_courses']").parents("li").removeClass("disabled");
	$("form#edit_request").find("input[name='id_courses']").removeAttr("disabled");

	//проходим по всем курсам и закрываем ненужные
	$("form#edit_request").find("input[name='id_courses']").each(function(){
		
		let class_number=$(this).attr("data-class_number");		
		
		if (class_number!="")
		{
			let arr=class_number.split(",");

			if (arr.indexOf(this_class_number)<0)			
			{
				if ($(this).prop("checked")) 
				{
					$(this).click();	
				}

				$(this).parents("li").addClass("disabled");
				$(this).attr("disabled","disabled");
			}
		}
		
	});

}


function export_excel() 
{
	var arr=filter_data();
	export_to_excel(arr,"build/php/make_excel_file_requests.php"); 
	
}