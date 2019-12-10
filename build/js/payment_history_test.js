$(document).ready(function()
{
	$("button[name='actual']").addClass("active"); 	
	//старший кассир
	if ($("input[name='role']").val()==3)
	{
		$("button[name='notReceiving']").addClass("active");
	} 
	else
	{
		$("button[name='notPay']").addClass("active");
	}
	
	change_blocks_of_filter();

	//фильтр
	$("#paystatus").find("button").click(function(){
		$("#paystatus").find("button").removeClass("active");
		$(this).addClass("active");
		change_blocks_of_filter(); //Добавляем фильтры дополнительно
		//get_data_by_filter();
	});


	//актуальные, архив и все записи
	$("#achivestatus").find("button").click(function(){
		$("#achivestatus").find("button").removeClass("active");
		$(this).addClass("active");
		get_data_by_filter();
	});


	//выбор периода 
	$('#date').datepicker({
    format: "M yyyy",
    startView: 1,
    minViewMode: 1,
    maxViewMode: 2,
    multidate: true,
    multidateSeparator: " - ",
    autoClose:true
		}).on("changeDate",function(event){
				  var dates = event.dates, elem=$('#date');
			      if(elem.data("selecteddates")==dates.join(",")) return; //To prevernt recursive call, that lead to lead the maximum stack in the browser.
			      if(dates.length>2) dates=dates.splice(dates.length-1);
			      dates.sort(function(a,b){return new Date(a).getTime()-new Date(b).getTime()});
			      elem.data("selecteddates",dates.join(",")).datepicker('setDates',dates);
			});

	//отображаем таблицу со студентами
	get_data_by_filter();
});

//Отображаем отфильтрованные данные
function get_data_by_filter()  
{
	//$("#table_block").html('<img src="images/preloader.gif" style="margin-left:45%;">');
	var arr=filter_data();

	//Таблица уже инициализирована
	if ( $.fn.dataTable.isDataTable('#datatable-fixed-header') ) {
		console.log("уже есть");
    	$('#datatable-fixed-header').DataTable().destroy();
    	$('#datatable-fixed-header').find('tbody').html('<tr><td colspan="4"><img src="images/preloader.gif" style="margin-left:45%;"></td></tr>');
    	if (!$.fn.dataTable.isDataTable('#datatable-fixed-header') ) {console.log("теперь нет");}

	}
	//Инициализируем таблицу
		$.post("build/php/get_ajax_payment.php",{data:JSON.stringify(arr)}, 
		function(info){			
			$obj=JSON.parse(info);
			//console.log($obj);
			var table=$('#datatable-fixed-header').DataTable( {
		        orderCellsTop: true,
     			fixedHeader: true,
     			"bStateSave": true, 
					 "order": [[1, "asc" ]], 
				    "fnStateSave": function (oSettings, oData) {
				        localStorage.setItem('offersDataTables', JSON.stringify(oData));
				    },
				    "fnStateLoad": function (oSettings) {
				        return JSON.parse(localStorage.getItem('offersDataTables'));
				    },
		        data : $obj.data,
		        "initComplete": function(settings, json) {
		        	$("span#count_pay").html($obj.count);
		        	$("span#summa").html(""); 
		        	if (!$("#paystatus").find("[name='notPay']").hasClass("active"))
					{
						$("span#summa").html(' &nbsp;&nbsp;&nbsp;&nbsp;<small>сумма </small>'+String($obj.summa).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ')); 	
					}
				  }
		    } );
		    console.log(' - первоначальная инициализация'); 
		    init_table(table);
		});	 
   
}

//собираем данные фильтра
function filter_data()
{
	var arr={};
	
	$("#filter-block").find("[name='id_students']:checked,[name='id_groups']:checked,[name='id_users']:checked").each(function(){
		let name=$(this).attr("name");
		let val=$(this).val();

		if (!(name in arr))
		{
			arr[name]=[];
		}
		
		arr[name].push(val);
	});

	arr["payment"]=[$("#paystatus").find("button.active").attr("name")];
	arr["achive"]=[$("#achivestatus").find("button.active").attr("name")]; 
	
	$dates=$("#filter-block").find("#date").data('datepicker').getFormattedDate('yyyy/mm');
	
	if ($dates!="")
	{
		let mas=$dates.split(" - ");
		let begin=end=mas[0];
		if (mas.length>1)
		{
			end=mas[1];
		}

		arr["month_begin"]=[];
		arr["month_begin"].push(Number(begin.split("/")[1]));
		arr["month_end"]=[];
		arr["month_end"].push(Number(end.split("/")[1]));
	}


	console.log(arr); 
	return arr;
}


//инициализация таблицы
function init_table(table)
{	

	init_all_in_table(table);//инициализируем checkbox при смене страницы и при поиске	

	if ($("button[name='notReceiving']").hasClass("active"))
	{
		if ($("input[name='role']").val()==3) 
		{
			$(".dataTables_length").parent("div").append('<button id="receiving_button" type="button" class="btn btn-default btn-sm pull-right" onclick="open_receiving_block()"><i class="fa fa-check-square-o"></i> списать</button>');	
		}
		
	}
	

	$('#datatable-fixed-header tbody').on( 'click', 'tr', function (e) {
		
		//if ($("input[name='role']").val()==3) 
		if (!e.target.hasAttribute("paint")) 
        //if ($("button[name='notReceiving']").hasClass("active"))
        {
        	$(this).toggleClass('selected');
        }
        $(this).find("input[type='checkbox'][name='selected']").iCheck("toggle");
    }); 

	
	$("input[type='checkbox'][name='selected']").on('ifClicked',function(event){
	//$(event.target).parents("tr").click();
	if ($("input[name='role']").val()==3)
		if ($("button[name='notReceiving']").hasClass("active"))
        {
        	$(event.target).parents("tr").toggleClass('selected');
        }
			});
	$('[data-toggle="tooltip"]').tooltip();
}

function change_blocks_of_filter()
{
	let nameButton=$("#paystatus").find("button.active").attr("name");
	
	$("#achivestatus").find("button").css("display","inline-block");

	

	if ((nameButton=="notPay") || (nameButton=="notReceiving"))
	{
		$("#achivestatus").find("button[name='achive']").css("display","none");
		$("#achivestatus").find("button[name='all']").css("display","none");
	}

	if (nameButton=="Receiving")
	{
		$("#achivestatus").find("button[name='actual']").css("display","none");
		$("#achivestatus").find("button[name='achive']").css("display","none");
		$("#achivestatus").find("button[name='all']").click();
	}
	else
	{
		$("#achivestatus").find("button[name='actual']").click();
	}



	if (nameButton=="allPay")
	{
		$("#time").css("visibility","hidden");
	}
	else
	{
		$("#time").css("visibility","visible");
	}

	if ((nameButton=="notPay") || (nameButton=="allPay"))
	{
		$("#paymasters").css("visibility","hidden");
	}
	else
	{
		$("#paymasters").css("visibility","visible");
	}

	$("#export_payments").css("display","none");

	if (nameButton=="Receiving")
	{
		$("#export_payments").css("display","inline-block");
	}
}


function print_payment_info(elem)
{
	$('#payment_paint_block').find("#surname").text($(elem).attr("surname"));
	$('#payment_paint_block').find(".paint_block").attr("src",$(elem).attr("paint"));

	//открываем модальное окно редаткирования записи
 	$('#payment_paint_block').modal('show');
 	$('#payment_paint_block').modal('handleUpdate') //для обновления позиции модального элемента в случае
 	
} 

function open_receiving_block()
{
	
	let AllAmount=0; 

	$("table#datatable-fixed-header tr.selected [amount='notreceiving']").each(function(){
		AllAmount+=Number($(this).text());
	});

	
 
	$("#receiving_block .price").html(new Intl.NumberFormat('ru-RU').format(AllAmount)); 
	//открываем модальное окно редаткирования записи
	if (AllAmount==0)
	{
		$("#receiving_block .btn.btn-primary").css("visibility","hidden");
	}
	else
	{
		$("#receiving_block .btn.btn-primary").css("visibility","visible");
	}

 	$('#receiving_block').modal('show');
 	$('#receiving_block').modal('handleUpdate') //для обновления позиции модального элемента в случае
}

//списать денежные средства
function receiving()
{
  let IdPayments=[];

	$("table#datatable-fixed-header tr.selected [amount='notreceiving']").each(function(){
		IdPayments.push($(this).attr("payment"));
	});
  console.log(IdPayments);

  $.post("build/php/receiving_money.php",{data:JSON.stringify(IdPayments)},
  	function(data){
  		if (data) 
			{
			$('#receiving_block').modal('hide');
			get_data_by_filter();
			new PNotify({
              title: 'Успешно',
              text: 'Сумма успешно списана',
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
			  get_data_by_filter();
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
});
}

function export_excel() 
{
	var arr=filter_data();
	export_to_excel(arr,"build/php/make_excel_file_payments.php"); 
	
}