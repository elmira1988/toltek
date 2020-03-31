$(document).ready(function(){
		
		quick_search($("#find_request"),find_words,upload_date_of_request,get_ul_from_words,"build/php/find_request.php");//быстрый поиск заявки            

		//выбор периода 
		init_choose_period();

		$("input#date,input#multi_select_whith_meta").click(function(){
			$(this).removeClass("parsley-error");
		});
});



//загружаем данные заявки
function upload_date_of_request(id_requests)
{
	$.post("build/php/get_data_request.php",{id_requests:id_requests},
		function(data){
			//console.log(data);
			var request=JSON.parse(data);
			//console.log(request);
			for (variable in request) {
				switch(variable) {
				  case 'class_number':  
				  		$('select[name="class_number"]').find('option[value="'+request[variable]+'"]').attr("selected","selected");
				    break;

				  case 'parent': 
				  	var parent=request[variable].split(' ');
				  		$("input[name='parent_surname']").val(parent[0]);
				  		$("input[name='parent_name']").val(parent[1]);
				  		$("input[name='parent_patronymic']").val(parent[2]);
				    break;
				  
				  case 'email': 
				  		$("input[name='parent_email']").val(request[variable]);
				    break;

				  case 'phone': 
				  		$("input[name='parent_phone']").val(request[variable]);
				    break;  

				  default:
				    $('input[name="'+variable+'"]').val(request[variable]);
				    break;
				}

			}

			let courses='';
			
			for (var i=0;i<request['id_courses'].length;i++)
			{
				courses+='<br>';
				courses+=request['id_courses'][i]['name_of_course'];
				courses+=' (<i>'+request['id_courses'][i]['name_of_directions']+'</i>)';
			}

			$("#selected_courses").find("span:eq(1)").html(courses);
			$("#selected_courses").css("display","block");


		});
}

function get_ul_from_words(word)
{
	var str='';
	  str+='<ul>';
	  for (i=0;i<word.length;i++)
		  {
		  	  let star='<i class="fa fa-star';
		  	  	  if (word[i].attend==0) {
		  	  	  	star+='-o';
		  	  	  }	
		  	  	  star+='" style="font-weight:bold;color:'+word[i].color+'"></i>'; 	
		  	  let name=word[i].surname+' '+word[i].name+' '+word[i].patronymic;
			  str+='<li id="'+word[i].id_requests+'">'+star+' '+name+'</li>';
			}
	  str+='</ul>';
	  return str;
}

//при смене класса меняем доступность добавления курсов
function change_group(el)
{
	update_disabled_of_group($(el).val());
}

function update_disabled_of_group(this_class_number)
{
	var groups=$("form#add_student").find("input[name='id_groups']");
	//открываем все курсы сначала
	groups.parents("li").removeClass("disabled");
	groups.removeAttr("disabled");

	//проходим по всем группам и закрываем ненужные
	groups.each(function(){
		
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

 
function add_students()
{
	//проверяем форму добавления данных студента
	var validate_student = $('#add_student').parsley().validate(); 
	
	//отмечены ли были группы
	var groups_count=$("form#add_student").find("input[name='id_groups'][type='checkbox']:checked").length;

	if (groups_count==0)
	{
		$("form#add_student").find("#multi_select_whith_meta").addClass("parsley-error");
	}

	$dates=$("form#add_student").find("#date").data('datepicker').getFormattedDate('yyyy/mm');
	
	if ($dates=="")
	{
		$("form#add_student").find("#date").addClass("parsley-error");
	}


	console.log(validate_student);
	if (validate_student && groups_count>0 && $dates!="")
	{	
		var data={};
			data.student={};//данные студента
			data.id_groups=[];//данные по группам
			data.parents=[];//данные представителей
		
			//console.log(data);
		//собираем данные студента и группы - начало
		$("form#add_student").find("input[type='text']:not('.display_none'):not([readonly='readonly']),input[type='date'],input[type='radio']:checked,input[type='email'],select,input[type='checkbox']:checked").each(function(){
			
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

		let mas=$dates.split(" - ");
		let begin=end=mas[0];
		if (mas.length>1)
		{
			end=mas[1];
		}

		data.student["month_begin"]=[];
		data.student["month_begin"].push(Number(begin.split("/")[1]));
		data.student["month_end"]=[];
		data.student["month_end"].push(Number(end.split("/")[1]));


	
		//собираем все данные форм с представителями
		$('form.add_parent').each(function(){
			let validate= $(this).parsley().validate(); 
			
			let value={};

			if (validate)
			{
				$(this).find("input[type='text'],input[type='date'],input[type='radio']:checked,input[type='email'],select").each(function(){
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

		console.log(data);
		 
		//если все формы с представителями валидны
		if (data.parents.length==$("form.add_parent").length)
		{
			//console.log(data);
			var fd=new FormData();
			fd.append('img',$('[name="img_of_user"]')[0].files[0]);
			//console.log(fd.getAll('img'));
			fd.append('str',JSON.stringify(data)); 
			$.ajax({
				url:"../build/php/save_students.php",
				data:fd,
				processData: false,//Отправка DOM элемента
				contentType: false,//Отправка DOM элемента
				type: 'POST',
				success:
				function(info){
					//console.log(info); 
				
					data=JSON.parse(info);
					console.log(data);
					
					if (data.result=='ok')   
						{ 
							//отправляем письма родителям (или родителю, если он один)
							let students = new Object();
								students.arr_id_students=new Array();
							students.arr_id_students.push(data.id_students);
							
							console.log(students);
							
						  $.post("build/php/send_mail_with_link_to_access_to_account.php",{data:JSON.stringify(students)},
							function(data){
								console.log(data);
							});
						  
						  print_info('Успешно', 'Данные успешно сохранены', 'success',delay=5000); 
						  reset_forms();
						}
						else
						{
						  print_info('Ошибка', 'Ошибка при работе с базой данных', 'error',delay=5000);
						}		 	
					}//function
				});
		}
		else
		{
			console.log("Валидность не пройдена");
		}
		
	}
}

//очищаем форму
function reset_forms() 
{

	$('form').trigger('reset');

	//удаляем выбранные группы
	$("#meta_block").html("");
	$(".select-block.direction-top").find(".selected").click();

	//удаляем представителей (кроме первого)
	$("#parents").find(".close-link:not('.invisible')").click();

	$("[name='note']").val("");

	$("#myphoto").find("img").attr("src","images/people-icon.png");

	change_doc($("[name='type_of_doc']").find("option[value='1']")[0]);

	$("#selected_courses").css("display","none"); 
}


