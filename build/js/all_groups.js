$(document).ready(function(){
	
	//отображаем таблицу с группами
	if ($("#table_block").length!=0) get_data_by_filter();

})


//Отображаем отфильтрованные данные
function get_data_by_filter()
{
	var arr=filter_data(); 
	console.log(arr);

	$.post("build/php/get_table_all_groups.php",{data:JSON.stringify(arr)},
		function(data){
			$("#table_block").html(data);
			init_table();
		});
		
}

function filter_data()
{
	var arr={};

	$("#filter-block").find("[name='id_groups']:checked,[name='id_courses']:checked,[name='id_roles']").each(function(){
		let name=$(this).attr("name");
		let val=$(this).val();

		if (!(name in arr))
		{
			arr[name]=[];
		}
		
		arr[name].push(val);
	});

	return arr;
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
    'order': [[ 0, 'asc' ]]//отображаем самые "свежие" заявки
	});
}


function save_group()
{
	 if ($('#form-add-group').parsley().validate())
	 {
	 	var form=$('#form-add-group');
	 	var arr={};
	 	//собираем данные формы
	 	form.find("input,select,textarea").each(function(){
	 		name=$(this).attr("name");
	 		val=$(this).val();
	 		arr[name]=val;

	 	});

	 	//сохраняем группу в базе
		 $.post("build/php/save.php",{
			data:JSON.stringify(arr),
			type:"group"
		},function(id_group){ 

			if (id_group)
			{
				let text=form.find("input[name='name_of_group']").val();
					text+=' ('+form.find("select[name='id_courses']").find("option:selected").text()+')';
				print_info('Запись сохранена', ('Группа <b>'+text+'</b> успешно добавлена в базу'), 'success',4000);
				form[0].reset();
			}
			else
			{
				print_info('Ошибка', 'Возникла ошибка при работе с базой данных', 'error',3000);
			}
		})
	 }
	 else
	 {
	 	console.log("Ошибка в форме");	 	
	 }
}

function export_excel() 
{
	
	var arr=filter_data();
	console.log(arr);
	export_to_excel(arr,"build/php/make_excel_file_groups.php"); 
	
}


//получаем данные о записи из базы
function get_data_groups(id_groups)  
{
	$.post("build/php/get_data_groups.php",{id_groups:id_groups},
		function(data){ 
			 
			let group=JSON.parse(data);
			console.log(group);
			$("#edit_modal_block").find('[name="id_groups"]').val(id_groups);
			//console.log(request);
			
			for (var key in group) {
			  switch(key) {
				  case 'name_of_group': 
				  		$("#edit_modal_block").find('[name="'+key+'"]').val(group[key]);
				    break;
				  case 'id_courses': 
				  		$("#edit_modal_block").find('[name="'+key+'"]').attr("disabled","");
				  		$("#edit_modal_block").find('[name="'+key+'"]').find('option[value="'+group[key]+'"]').attr("selected","selected");
				  		$("#edit_modal_block").find('[name="'+key+'"]').attr("disabled","disabled");
				    break;
				  case 'note':
				   		$("#edit_modal_block").find('[name="'+key+'"]').val(group[key]);		  		
				    break;    
				}
			}

		
		//открываем модальное окно редактирования записи
   	 	$('#edit_modal_block').modal('show'); 
   	 	$('#edit_modal_block').modal('handleUpdate') //для обновления позиции модального элемента в случае

   	 	$('#edit_modal_block').on('shown.bs.modal', function (e) {
		   update_select_block();
		});

		})
}

//сохраняем изменения (редактирование записи)
function update_group() 
{
	var validate = $('#edit_group').parsley().validate(); 
	
	if (validate)
	{
		
		var data={};

		$("form#edit_group").find("input[type='hidden'],input[type='text'],textarea").each(function(){ 
			var name=$(this).attr("name");
			var val=$(this).val(); 
			data[name]=val;
		});

		$.post("../build/php/update_group.php",{data:JSON.stringify(data)},
			function(info){
				console.log(info); 
				if (info) 
					{
						$('#edit_modal_block').modal('hide');
						get_data_by_filter();
						print_info('Успешно', 'Изменения успешно сохранены', 'success',4000);
					}
					else
					{
						print_info('Ошибка', 'Ошибка при работе с базой данных', 'error',4000);
					}
			})
	}
	else
	{
		console.log("Ошибка в форме");
	}
	

}

function modal_group_structure(id_groups,name)
{
	$.post("build/php/get_groups_structure.php",{id_groups:id_groups},
		function(data){
			//console.log(data);
			$('#modal_group_structure').find(".modal-title").html("Состав группы "+name);
			$('#modal_group_structure').find(".modal-body").html(data);
			$('#modal_group_structure').modal('show');	
			$('#modal_group_structure').modal('handleUpdate') //для обновления позиции модального элемента				
		});
}