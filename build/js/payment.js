   
    	 function handleStart(evt) 
	{ 

	  $('input').blur();	
	  evt.preventDefault();
	  var touches = evt.changedTouches[0];

	  mouse.x = touches.pageX-$(canvas).offset().left;
	  mouse.y = touches.pageY-$(canvas).offset().top; 

	  console.log("mouse.x=",mouse.x);
	  console.log("mouse.y=",mouse.y);

	  draw = true;
	  context.beginPath();
	  context.moveTo(mouse.x, mouse.y);
	}


	function handleMove(evt) {

	  console.log("touchmoves"); 
	  evt.preventDefault();
	  var touches = evt.changedTouches[0];

	  if(draw==true){
	  	    paint=true; 
    
    		mouse.x = touches.pageX-$(canvas).offset().left;
	  		mouse.y = touches.pageY-$(canvas).offset().top; 

            context.lineTo(mouse.x, mouse.y);
            context.stroke();
            $("#myCanvas").removeClass("parsley-error"); 
	                }
	}

	function handleEnd(evt) {
	  evt.preventDefault();
	  var touches = evt.changedTouches[0];

	   mouse.x = touches.pageX-$(canvas).offset().left;
	   mouse.y = touches.pageY-$(canvas).offset().top; 

	   context.lineTo(mouse.x, mouse.y);
	   context.stroke();
	   context.closePath();
	   draw = false;
	}

	function handleCancel(evt)
	{
		console.log(' вышли из поля видимости');
	}

    if (document.getElementById("myCanvas"))
    {
    	var canvas = document.getElementById("myCanvas");
	    context = canvas.getContext("2d");

	    var mouse = { x:0, y:0};
	    var draw = false;
	    paint=false;//не расписались

	/*Роспись МЫШЬЮ - НАЧАЛО*/
    canvas.addEventListener("mousedown", function(e){
        mouse.x = e.layerX;
        mouse.y = e.layerY;

        draw = true;
        context.beginPath();
        context.moveTo(mouse.x, mouse.y);
    });

    canvas.addEventListener("mousemove", function(e){

        if(draw==true){
            paint=true; 
            mouse.x = e.layerX;
        	mouse.y = e.layerY;

            context.lineTo(mouse.x, mouse.y);
            context.stroke();
            
            $("#myCanvas").removeClass("parsley-error"); 
        }
    });

    canvas.addEventListener("mouseup", function(e){
         
        mouse.x = e.layerX;
        mouse.y = e.layerY;

        context.lineTo(mouse.x, mouse.y);
        context.stroke();
        context.closePath();

        draw = false;
    }); 
    /*Роспись МЫШЬЮ - КОНЕЦ*/

	/*Роспись TOUSCH - Начало*/
	 canvas.addEventListener("touchstart", handleStart, false);
	 canvas.addEventListener("touchend", handleEnd, false);
	 canvas.addEventListener("touchcancel", handleCancel, false);
	 canvas.addEventListener("touchmove", handleMove, false);
    }

    $(document).ready(function(){
    //размер Canvas по ширине экрана
	resize();

	//меняем размер шрифта, если просмотр идет через планшет
	if ('ontouchstart' in window) {
		$(".page-title").find("h3").addClass("gadget"); 
		$(".right_col").find("input,label,button").addClass("gadget"); 
		$(".form-group").css("margin-bottom","30px");
		}

	//быстрый поиск обучающегося
	quick_search($("#find_student"),find_words,select_student,get_ul_from_words,"build/php/find_student.php",["id_students_groups"]); 

	//быстрый поиск родителя/представителя
	quick_search($("#find_parent"),find_words,select_parent,get_ul_from_words_parent,"build/php/find_parent.php",["id_students_groups"],0)

	$("#find_parent").focus(function(event)
	{
		find_words($("#find_parent"),"","build/php/find_parent.php",select_parent,get_ul_from_words_parent,["id_students_groups"],0); 
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
			      changeAmount();
			}).on("show",function(event){
					if ('ontouchstart' in window) {
					$(".datepicker").addClass("gadget"); 
					$(window).resize();
				}
			})
	
		/*
	function getDates()
	{
	    console.log($("#date").datepicker("getDates"));
	    console.log($("#date").datepicker("getUTCDates"));
	    console.log($("#date").data('datepicker').getFormattedDate('yyyy/mm'));
	} */

	




	/*Роспись TOUSCH - Конец*/

	//отображаем рабочую область после отображения шрифтов
	$(".right_col").css("opacity","1");

	$("input").click(function(){
		$(this).removeClass("parsley-error");
	});

	});
	/*document.ready - end*/

	function select_student() 
	{
		changeAmount();
		$("[name='parent']").val("");
	}

	function select_parent() 
	{
		console.log('Выбрали родителя'); 
	}

	//печатаем список всех подходящих слов
	function get_ul_from_words(word)
	{
		var str='<ul>'; 
		  for (i=0;i<word.length;i++)
			  {
			  	  let name=word[i].surname+' '+word[i].name+' '+word[i].patronymic;
			  	  str+='<li id="'+word[i].id_students_groups+'">';
			  	  	str+='<p style="margin:0px 10px;">'+name+'/ </p>';
			  	  	str+='<p style="text-indent:40px;"><small>'+word[i]["name_of_group"]+'/ '+word[i]["name_of_course"]+'</small></p>';
			  	  str+='</li>';
			   }
		  str+='</ul>'; 
		  return str;
	}

	//печатаем список всех подходящих слов
	function get_ul_from_words_parent(word)
	{
		var str=''; 
		
		if (word.length>0)
		{
		  str+='<ul>'; 
		  for (i=0;i<word.length;i++)
			  {
			  	  let name=word[i].surname+' '+word[i].name+' '+word[i].patronymic;
			  	  str+='<li id="'+word[i].id_parents+'">';
			  	  	str+='<p style="margin:0px 10px;">'+name+'</p>';
			  	  str+='</li>';
			   }
		  str+='</ul>';  
		  return str;
		}
		else
		{
			return '';
		}
		
	}

	//перерисовываем канвас
	function resize()
	{
		if (document.getElementById("myCanvas"))
		{
			var canvas = document.getElementById("myCanvas");
			context = canvas.getContext("2d");
			var w=$(canvas).parent().width();
			console.log("parent_width="+w); 
	    	$(canvas).width(w); 
	    	context.canvas.width=w;
	    	$("#painting").css("opacity",'1');   
		}

	 }

    $(window).on('resize', function() {
        resize();
    });

    //очищаем содержиомое
    function clearCanvas()
    {
    	var canvas = document.getElementById("myCanvas");
			context = canvas.getContext("2d");
    	context.clearRect(0, 0, canvas.width, canvas.height);
    	paint=false; 
    }

    function payment(btn,online=false)
    {
    	if (!$(btn).hasClass("disabled"))
    	{
    		//проверяем заполнены ли все поля
	    	var error_count=0;
	    	var obj=new Object();  
	    	
	    	//обучающийся
	    	if ($("[name='id_students_groups']").val()=="")
	    	{

	    		if ($("#find_student").length>0)
	    		{
	    			$("#find_student").addClass("parsley-error");
	    		}
	    		error_count+=1;
	    	}
	    	else
	    	{   
	    		obj.id_students_groups=$("[name='id_students_groups']").val();
	    	}
	    	

	    	//период
		    var date=$("#date").data('datepicker').getFormattedDate('yyyy/mm');

		    if (date=="")
		    {  
		    	$("#date").addClass("parsley-error");
	    		error_count+=1;
		    }
		    else
		    {
		    	let arr=date.split(" - ");
		    	let begin=end=arr[0];
		    	if (arr.length>1)
		    	{
		    		end=arr[1];
		    	}
		    	
		    	obj.month_begin=Number(begin.split("/")[1]);
		    	obj.month_end=Number(end.split("/")[1]);
		    	
		    }
		    
		    //цена
		    var price=$("#price").val().replace(/\s/g, '');
	    
		    if (Number(price)==0)
		    {  
		    	$("#price").addClass("parsley-error");
	    		error_count+=1;
		    }
		    else
		    {
		    	obj.amount=Number(price);
		    }

		    //родитель/ представитель
		    if ($("[name='id_parents']").val()=='')
		    {
		    	$("#find_parent").addClass("parsley-error");
	    		error_count+=1;
		    }
		    else
		    {
		    	obj.id_parents=$("[name='id_parents']").val();
		    }

		    if (document.getElementById("myCanvas"))
		    {
		    	//Роспись
		    	console.log(paint); 
			    if (paint==false)
			    {
			    	$("#myCanvas").addClass("parsley-error"); 
			    	error_count+=1;
			    }
			    else
			    {
			    	obj.paint=canvas.toDataURL();
			    }
		    }
		    

		    //Комментарий
		    obj.note=$("[name='note']").val();
		    
		    console.log(obj);

		    if (error_count==0)
		    {
		    	if (!online)
		    	{
		    		$(btn).addClass("disabled");
		    		
		    		$.post("build/php/save_payment.php",{data:JSON.stringify(obj)},function(data){
		    		console.log(data); 
		    		
		    		if (data) 
					{
						print_info('Успешно', 'Данные успешно сохранены', 'success',delay=5000);
						reset_forms();
					}
					else
					{
						print_info('Ошибка', 'Ошибка при работе с базой данных', 'error',delay=5000);
					}	
					$(btn).removeClass("disabled");
							
		    						});	
		    	}
		    	else
		    	{

					$(btn).addClass("disabled");
					
					obj.email=$("[name='email']").val(); 
					
					$('html, body').animate({scrollTop: 0},500);
					$("body").append("<div class='modal d-block' style='padding-right:17px;'><img src='images/preloader.gif' style='position: absolute;left: 50%;margin-left: -80px;top: 48%;'></div><div class='modal-backdrop in'></div>"); 
					$("body").addClass("nav-md modal-open");  
					
					$.post("build/php/get_url_for_payment.php",{data:JSON.stringify(obj)},
		    			function(info){
		    				console.log(info);

		    				try
		    				{
		    					let data=JSON.parse(info);
		    					console.log(data);
		    					if (data.result=="ok")
		    					{
		    						console.log(data);   
		    						window.location.href=data.url;//отправляем пользователя на оплату 
		    					}
		    					else
		    					{
		    					   print_info("Ошибка!", data.msg, "warning",5000);	
		    					}
		    					
		    				}
		    				catch 
		    				{
		    					print_info("Неизвестная ошибка!", "Обратитесь к администратору Технопарка СФ БашГУ", "warning",5000);
		    					
		    				}

		    				$("body").find(".modal.d-block,.modal-backdrop").remove();
		    				$(btn).removeClass("disabled");  
		    				$("body").removeClass("modal-open"); 
		    				
		    			});

		    			}


	    	}
    	}

    }

    function reset_forms()
    {
    	$("#payment_block").find("input").val(""); 
    	clearCanvas();
    }

    function changeAmount()
    {
    	//студент
    	let id_students_groups=$("[name='id_students_groups']").val();
    	//период
	    var date=$("#date").data('datepicker').getFormattedDate('yyyy/mm');

	    if (id_students_groups!="")
	    	if (date!="")
	    	{
	    		let obj= new Object();
	    		let arr=date.split(" - ");
		    	let begin=end=arr[0];
		    	if (arr.length>1)
		    	{
		    		end=arr[1];
		    	}

		    	obj.id_students_groups=id_students_groups;
		    	obj.month_begin=Number(begin.split("/")[1]);
		    	obj.month_end=Number(end.split("/")[1]);
			    	
		    	$.post("build/php/get_price.php",{data:JSON.stringify(obj)},
		    		function(data){
		    			$("input#price").val(data).removeClass("parsley-error");
		    		}); 
	    	}
	    	else
	    	{
	    		$("input#price").val("").removeClass("parsley-error");
	    	}
    	
    }
