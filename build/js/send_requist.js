$(document).ready(function(){

  $("[name='class_number']:eq(0)").click();//по умолчани ставим 1 класс
  $("[name='attend']:eq(1)").click();//по уиолчанию ставим пометку о том, что курсы Технопарка ранее не посещал

  $(".actionBar").find(".buttonFinish").unbind("click");
  $(".actionBar").find(".buttonFinish").click(function(){clean_form()});

	var user={};
  var name_of_selected_courses='';
	var $sections = $('.form-section'); 

  	$sections.each(function(index, section) {
    	$(section).find(':input').attr('data-parsley-group', 'block-' + index);
  	});

  	function navigateTo(index) {

    //Помечаем текущую секцию классом 'current'
    $sections.removeClass('current').eq(index).addClass('current');
    // Показываем только те кнопки навигации, которые имеют смысл для текущего раздела

    var atTheEnd = index >= $sections.length - 1;
    $(".actionBar").find(".buttonValidate").toggle(!atTheEnd);

    if (index==1)
    {
      $(".actionBar").find(".buttonPrevious").toggle(1);  
      $('.buttonValidate').html('Отправить заявку');
    }    
    else
    {
      $(".actionBar").find(".buttonPrevious").toggle(0);
      $('.buttonValidate').html('Далее');
    }

    $(".actionBar").find(".buttonFinish").toggle(atTheEnd);

    $(".actionBar").find(".buttonFinish").html("Завершить");

  }

   function curIndex() {
    // Return the current index by looking at which section has the class 'current'
    return $sections.index($sections.filter('.current'));
  }

	// Next button goes forward iff current block validates
  	$(".actionBar").find(".buttonValidate").click(function() {

    $('#send-requist-form').parsley().whenValidate({
      group: 'block-' + curIndex()      
    }).done(function() {

      //идем на второй шаг
      if (curIndex()==0)
      {

      	$('input[data-parsley-group="block-0"][type="hidden"],input[data-parsley-group="block-0"][type="text"],input[data-parsley-group="block-0"][type="date"],input[data-parsley-group="block-0"][type="email"]').each(function(elem){
      		//console.log($(this).attr("name")+" = "+$(this).val());	
      		user[$(this).attr("name")]=$(this).val();
      	})

      	$('input[data-parsley-group="block-0"][type="radio"][name="class_number"]').each(function(){
      		if ($(this).prop("checked"))
      		{
      			user["class_number"]=$(this).val();
      		}
      	})

        $('input[data-parsley-group="block-0"][type="radio"][name="attend"]').each(function(){
          if ($(this).prop("checked"))
          {
            user["attend"]=$(this).val();
          }
        })


        //console.log(user);
        /*Возврат контента второй страницы*/
      	$.post(
          "build/php/get_step_2.php", 
      	{
      		val:JSON.stringify(user)
      	},function(data){
			                     $("#step-2").html(data);

                           $('input.flat').iCheck({
                                    checkboxClass: 'icheckbox_flat-green',
                                    radioClass: 'iradio_flat-green'
                                });

                             $sections.each(function(index, section) {
                            $(section).find(':input').attr('data-parsley-group', 'block-' + index);
                          });
	       	             }
      	       )
        /*Возврат контента второй страницы - конец*/
      	navigateTo(curIndex() + 1);//Проверка на ошибки
        $(".actionBar").find(".buttonNext").click();//Отображение вторго шага
      	
      } else

      //идем на отправку (третий шаг)
      if (curIndex()==1)
      {
        user.id_courses=new Array();
        var k=0;
       
        $('input[data-parsley-group="block-1"][type="checkbox"][name="id_courses"').each(function(){
          if ($(this).prop("checked"))
          {
            user.id_courses[k]=$(this).val();
          /*
            user.id_courses[k]={};
            user.id_courses[k].id_courses=$(this).val();
            
            user.id_courses[k].id_groups='';

          $('input[name="id_courses_'+$(this).val()+'"]').each(function(){
            if ($(this).prop("checked"))
            {
              if ( user.id_courses[k].id_groups!='') user.id_courses[k].id_groups+=',';
              user.id_courses[k].id_groups+=$(this).val();
            }
          });
            */
            k=k+1;
          }
          })

          if (k==0)
          {
            new PNotify({
                          title: 'Укажите курс',
                          text: 'Вы не выбрали ни один курс',
                          type: 'error',
                          styling: 'bootstrap3'
                      });
          }
          else
          {
            user["note_of_user"]=$('[data-parsley-group="block-1"][name="note_of_user"').val();
            delete user.tutor;
            //console.log(user);  
            //Отправляем данные на сервер
            $.post("build/php/save_requist.php",
            {
              val:JSON.stringify(user)
            },
            function(data){
                          //console.log(data);
                          //console.log(user);
                          if (data)
                          {
                            navigateTo(curIndex() + 1);//Проверка на ошибки
                            $(".actionBar").find(".buttonNext").click();//Отображение сообщения
                            
                            $.post("/build/php/send_mail.php", 
                              {val:JSON.stringify(user),
                               id_requests:data, 
                                for_email:'user'}); 

                            
                            $.post("/build/php/send_mail.php", 
                              {val:JSON.stringify(user),
                                for_email:'admin'}); 

                          }
                          else
                          {
                            new PNotify({
                              title: 'Ошибка',
                              text: 'Произошла ошибка при работе с базой данных',
                              type: 'error',
                              styling: 'bootstrap3'
                                });
                          }
                          }
            ) 
          }

              
      }


    });
  });

  	// Previous button is easy, just go back
  $(".actionBar").find(".buttonPrevious").click(function() {
    navigateTo(curIndex() - 1);
  });

  	navigateTo(0);

});

function clean_form()
{
  location.reload();
}

