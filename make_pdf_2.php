<?php
header('Content-Type: application/json');
require_once __DIR__ . '/build/php/vendor/autoload.php';
//require 'vendor/autoload.php'; 
$surname='Иванов';
$name='Иван';
$patronymic='Иванович';

$series='8004';
$number='654523';
$data_get='12.03.2006';

use \Mpdf\Mpdf;

$mpdf = new \Mpdf\Mpdf();
//['left' => 5]

$html.='<p style="text-align: right;font-size:10pt;">Приложение 3</p>
<p style="text-align: center;margin:0px;">ДОГОВОР № О19/&nbsp; &nbsp;&ndash;&nbsp;</p>
<p style="text-align: center;font-size:10pt;margin:0px;"><strong>об образовании на обучение</strong><br /><strong> по дополнительным образовательным программам</strong></p>
<p style="text-align: justify;font-size:10pt;">г. Стерлитамак&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &laquo;_____ &raquo;_____________ 20___ г.</p>
<p style="text-align: justify;font-size:10pt;">Федеральное государственное бюджетное образовательное учреждение высшего образования &laquo;Башкирский государственный университет&raquo;, осуществляющее образовательную деятельность на основании лицензии от 26 февраля 2016 г. № 1964, выданной Федеральной службой по надзору в сфере образования и науки, в лице помощника директора по инновациям и стратегии Алешина Павла Николаевича, действующего на основании Положения о филиале и доверенности, именуемый в дальнейшем &laquo;Исполнитель&raquo;, и <b>'.$surname.'</b> именуемый(ая) в дальнейшем &laquo;Заказчик&raquo;, и <b>'.$surname.'</b> именуемый (ая) &nbsp;&nbsp;в &nbsp;дальнейшем &nbsp;&laquo;Обучающийся&raquo;, &nbsp;&nbsp;совместно &nbsp;&nbsp;именуемые &nbsp;Стороны, &nbsp;заключили настоящий Договор (далее - Договор) о нижеследующем:
<p style="text-align:center;font-weight:bold;font-size:10pt;">1.Предмет Договора</з> 
<p style="text-align: left;font-size:10pt;text-indent:40px;">1.1. Исполнитель обязуется предоставить образовательные услуги, а Заказчик обязуется оплатить обучение по дополнительной образовательной программе</p>
<p style="margin-bottom:0px;">______________________________________________________________________________________________________</p>
<p style="text-align:center;font-size:8pt;margin:0px;">(наименование дополнительной образовательной программы)</p>
<p style="text-align:center;font-size:8pt;margin-bottom:0px;"><u>дополнительная общеразвивающая программа</u></p>
<p style="text-align:center;font-size:8pt;margin:0px;">(подвид дополнительной образовательной программы)</p>
<p style="text-align:center;font-size:8pt;margin-bottom:0px;"><u>очная</u></p>
<p style="text-align:center;font-size:8pt;margin:0px;">(форма обучения)</p>
<p style="text-align: justify;font-size:10pt;margin:0px;">в пределах образовательной программы Исполнителя в&nbsp; Научно-инновационном управлении (НИУ) СФ БашГУ.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">Срок освоения образовательной программы (продолжительность обучения) на момент подписания Договора составляет ____ ак. часов ( 9 месяцев).</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">Граждане, успешно завершившие обучение, получают удостоверение об обучении .</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">1.2. В случае перехода Обучающегося на обучение по индивидуальному учебному плану в порядке, установленном локальным нормативным актом Исполнителя, срок и стоимость освоения образовательной программы определяется приказом директора СФ БашГУ с последующим заключением дополнительного соглашения между Сторонами.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">1.3. В случае, если Заказчик и Обучающийся одно и тоже лицо, то Заказчик имеет права и несет обязанности Обучающегося, установленные законодательством, локальными нормативными актами Университета (СФ БашГУ) и настоящим Договором.</p>
</ul>
<p style="text-align:center;font-size:10pt;font-weight:bold;">2. Взаимодействие сторон</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.1. Исполнитель вправе:</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.1.1. Самостоятельно осуществлять образовательный процесс, устанавливать системы оценок, формы, порядок и периодичность промежуточной аттестации Обучающегося;</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.1.2. Разрабатывать и принимать в соответствии с законодательством локальные нормативные акты, обязательные для Обучающегося.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.1.3. В одностороннем порядке отказаться от исполнения договора в случаях, предусмотренных настоящим Договором, действующим законодательством Российской Федерации.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.2. Заказчик вправе получать информацию от Исполнителя по вопросам организации и обеспечения надлежащего предоставления услуг, предусмотренных разделом 1 настоящего Договора.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.3. Обучающемуся предоставляются академические права в соответствии с частью 1 статьи 34 Федерального закона от 29 декабря 2012 г. N 273-ФЗ &laquo;Об образовании в Российской Федерации&raquo;. Обучающийся вправе:</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.3.1. Получать информацию от Исполнителя по вопросам организации и обеспечения надлежащего предоставления услуг, предусмотренных разделом 2 настоящего Договора.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.3.2. Пользоваться в порядке, установленном локальными нормативными актами, имуществом Исполнителя, необходимым для освоения образовательной программы.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.3.3. Получать полную и достоверную информацию об оценке своих знаний, умений, навыков и компетенций, а также о критериях этой оценки.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.4. Исполнитель обязан:</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.4.1. Зачислить Обучающегося на обучение, выполнившего установленные законодательством Российской Федерации, учредительными документами, локальными нормативными актами Исполнителя условия приема.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.4.2. Довести до Заказчика информацию, содержащую сведения о предоставлении платных образовательных услуг в порядке и объеме, которые предусмотрены Законом Российской Федерации от 7 февраля 1992 г. N 2300-1 &laquo;О защите прав потребителей&raquo; и Федеральным законом от 29 декабря 2012 г. N 273-ФЗ &laquo;Об образовании в Российской Федерации&raquo;.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.4.3. Организовать и обеспечить надлежащее предоставление образовательных услуг, предусмотренных разделом 2 настоящего Договора, в полном объеме в соответствии с образовательной программой, расписанием занятий Исполнителя, в том числе индивидуальным учебным планом.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.4.4. Обеспечить Обучающемуся предусмотренные выбранной образовательной программой условия ее освоения.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.4.5. Принимать от Заказчика плату за образовательные услуги.</p>
<p style="text-align: left;font-size:10pt;text-indent:40px;margin:0px;">2.5. Заказчик обязан:</p>
<p style="text-align: left;font-size:10pt;text-indent:40px;margin:0px;">2.5.1. Своевременно вносить плату за предоставляемые Обучающемуся образовательные услуги, указанные в разделе 1 настоящего Договора, в размере и порядке, определенными настоящим Договором, а также предоставлять платежные документы, подтверждающие такую оплату.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.6. Обучающийся обязан:</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.6.1. Добросовестно осваивать образовательную программу, выполнять индивидуальный учебный план, в том числе посещать предусмотренные учебным планом или индивидуальным учебным планом учебные занятия, осуществлять самостоятельную подготовку к занятиям, выполнять задания, данные педагогическими работниками в рамках образовательной программы.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.6.2. Выполнять требования Устава Университета, Положения о филиале, правил внутреннего распорядка и иных локальных нормативных актов по вопросам организации и осуществления образовательной деятельности.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.6.3. Уважать честь и достоинство других обучающихся и работников Университета (СФ БашГУ), не создавать препятствий для получения образования другими обучающимися.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.6.4. Бережно относиться к имуществу Исполнителя.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.6.5. При поступлении в Университет и в процессе обучения своевременно представлять все необходимые документы, предусмотренные законодательством Российской Федерации и локальными нормативными актами Университета.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.6.6. Своевременно извещать Исполнителя об уважительных причинах отсутствия на занятиях. В течение семи дней после возникновения соответствующих обстоятельств, представить документы в НИУ СФ БашГУ, подтверждающие пропуски занятий по уважительным причинам.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">2.6.7. Возмещать ущерб, причиненный имуществу Исполнителя, в соответствии с законодательством Российской Федерации.</p>
<p style="text-align:center;font-weight:bold;font-size:10pt;">3. Стоимость образовательных услуг, сроки и порядок их оплаты</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">3.1. Полная стоимость образовательных услуг за весь период обучения Обучающегося составляет:</p> 
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">_________________ (__________________________________________________________________ )&nbsp;&nbsp; рублей.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">3.2.Стоимость образовательных услуг в месяц составляет:</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">______________________________________________________________________ рублей.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">3.3. Заказчик производит оплату стоимости обучения Обучающегося:</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">&ndash; &nbsp;ежемесячно до 5 го числа текущего месяца;</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">3.4. Образовательные услуги, оказываемые по Договору, налогом на добавленную стоимость не облагаются на основании п.п. 14 п. 2 ст. 149 Налогового кодекса Российской Федерации.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">3.5. Оплата производится в безналичном порядке на счет Исполнителя, указанный в разделе 8 Договора. В платежном документе указывается фамилия, имя, отчество Заказчика и Обучающегося, наименование образовательной программы.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">3.6. Оплата услуг за обучение удостоверяется путем предоставления Заказчиком или Обучающимся платежного документа в СФ БашГУ.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">3.7. В случае прекращения образовательных отношений по инициативе Обучающегося в течение периода обучения часть суммы, внесенной за образовательные услуги, признается излишне уплаченной и подлежит возврату в установленном порядке, за вычетом фактически понесенных расходов.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">3.8. Возврат денежных средств, производится бухгалтерией СФ БашГУ путем перечисления на счет Заказчика в течение 30 дней с даты отчисления.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">3.9. При прекращении образовательных отношений при инициативе Университета сумма, внесенная за образовательные услуги, подлежит возврату за вычетом фактически понесенных расходов (часть 2 статьи 781 Гражданского кодекса Российской федерации) в случае:</p>
<p style="text-align: justify;font-size:10pt;text-indent:60px;margin:0px;">а) применения к Обучающемуся отчисления как меры дисциплинарного взыскания;</p>
<p style="text-align: justify;font-size:10pt;text-indent:60px;margin:0px;">б) невыполнения обучающимся по дополнительной образовательной программе (части образовательной программы) обязанностей по добросовестному освоению такой образовательной программы (части образовательной программы) и выполнению учебного плана;</p>
<p style="text-align: justify;font-size:10pt;text-indent:60px;margin:0px;">в) установления нарушения порядка приема в Университет, повлекшего по вине Обучающегося его незаконное зачисление в Университет;</p>
<p style="text-align: justify;font-size:10pt;text-indent:60px;margin:0px;">г) просрочки оплаты стоимости платных образовательных услуг;</p>
<p style="text-align: justify;font-size:10pt;text-indent:60px;margin:0px;">д) невозможности надлежащего исполнения обязательств по оказанию платных образовательных услуг вследствие действий (бездействия) Обучающегося.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">3.10. В случае, когда невозможность исполнения настоящего договора возникла по обстоятельствам, за которые ни одна из сторон не отвечает, Заказчик возмещает Исполнителю фактически понесенные им расходы.</li>
</ul>
<p style="text-align:center;font-size:10pt;font-weight:bold;">4. Порядок изменения и расторжения Договора</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">4.1. Изменения и дополнения к Договору оформляются дополнительным соглашением Сторон, которое является неотъемлемой частью Договора и подписываться уполномоченными представителями Сторон.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">4.2. Настоящий Договор может быть расторгнут по соглашению Сторон.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">4.3. Исполнитель вправе отказаться от исполнения обязательств по Договору при условии полного возмещения Заказчику убытков.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">4.4. Заказчик вправе отказаться от исполнения настоящего Договора при условии оплаты Исполнителю фактически понесенных им расходов.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">4.5. Во всех случаях моментом расторжения Договора считается дата отчисления Обучающегося, указанная в приказе об отчислении.</p>
<p style="text-align:center;font-size:10pt;font-weight:bold;">5. Ответственность Исполнителя, Заказчика и Обучающегося</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">5.1. За неисполнение или ненадлежащее исполнение своих обязательств по Договору Стороны несут ответственность, предусмотренную законодательством Российской Федерации и настоящим Договором.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">5.2. Стороны берут на себя взаимные обязательства по соблюдению режима конфиденциальности в отношении информации, полученной при исполнении настоящего договора. Стороны несут ответственность за последствия, вызванные нарушением обязательств по конфиденциальности, независимо от того, было ли это нарушение совершено преднамеренно или случайно.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">5.3. Передача информации третьим лицам или иное разглашение информации, признанной по настоящему договору конфиденциальной, может осуществляться только с письменного согласия другой стороны. Исключения из настоящего положения составляют случаи обязательного предоставления информации, предусмотренные действующими нормативно-правовыми актами.</p>
<p style="text-align:center;font-size:10pt;font-weight:bold;">6. Срок действия Договора
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">6.1. Настоящий Договор вступает в силу со дня его заключения Сторонами и действует до полного исполнения Сторонами обязательств.</p>
<p style="text-align:center;font-size:10pt;font-weight:bold;">7. Заключительные положения</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">7.1. Настоящий Договор составлен в ___ экземплярах <sup>1</sup>, по одному для каждой из сторон. Все экземпляры имеют одинаковую юридическую силу.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">7.2. &nbsp;&nbsp;Споры и разногласия, которые могут возникнуть при исполнении настоящего договора, будут по возможности разрешаться путем переговоров между Сторонами.</p>
<p style="text-align: justify;font-size:10pt;text-indent:40px;margin:0px;">7.3.&nbsp;&nbsp; В случае невозможности разрешения разногласий путем переговоров они подлежат рассмотрению в суде в соответствии с действующим законодательством Российской Федерации.</p>
<p style="text-align:center;font-size:10pt;font-weight:bold;">8. Адреса и реквизиты сторон</strong></p>
</ol>
<table>
<tbody>
<tr>
<td style="width:33%;"> 
<p style="font-size:10pt; text-align:center;"><b>Федеральное государственное бюджетное образовательное учреждение высшего образования &laquo;Башкирский государственный университет&raquo;</b></p>

<p style="font-size:10pt;">Юр.адрес: 450076, ул. Заки Валиди, д.32, г.Уфа, Республика Башкортостан, Стерлитамакский филиал федерального государственного бюджетного образовательного учреждения высшего образования</p>
<p style="font-size:10pt;" >Почтовый адрес: 453103, пр. Ленина, 49, г. Стерлитамак, Республика Башкортостан УФК по Республике Башкортостан (Стерлитамакский филиал Баш ГУ, СФ Баш ГУ,</p>
<p style="font-size:10pt;">л/с 20016Х52360),&nbsp;&nbsp; р/с 40501810500002000002</p>
<p style="font-size:10pt;">Отделение-НБ Республика Башкортостан &nbsp;г.Уфа</p>
<p style="font-size:10pt;">БИК 048073001</p>
<p style="font-size:10pt;" >ИНН 0274011237,&nbsp; КПП 026802001</p>
<p style="font-size:10pt;">КБК: 00000000000000000130</p>
<p style="font-size:10pt;">ОКТМО 80745000001</p>
<p>________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; П.Н. Алешин</p>
<p style="font-size:8pt; margin-top:0px;" >М.П.(подпись)</p></td>
<td style="width:33%;vertical-align:top;">
<p style="text-align:center;"><b>Заказчик</b></p>
<p>Ф.И.О.________________________________</p>
<p>_______________________________________</p>
<p>_______________________________________</p>
<p>_______________________________________</p>
<p>Дата рождения ______________________</p> 
<p>Паспорт:</p>
<p>серия__________ №____________________</p>
<p>выдан _______________________________</p>
<p>_______________________________________</p>
<p>_______________________________________</p>
<p>Адрес места жительства:</p>
<p>_______________________________________</p>
<p>_______________________________________</p>
<p>_______________________________________</p>
<p>&nbsp;</p>
<p>Адрес регистрации (заполняется при отличии с местом жительства):</p>
<p>_______________________________________</p>
<p>_______________________________________</p>
<p>_______________________________________</p>
<p>Тел.(код .п.)__________________________</p>
<p>Моб.тел _____________________________</p>


<td style="width:33%;vertical-align:top;" >
<p><b><strong>Обучающийся <sup>2</sup></strong></b></p>
<p>Ф.И.О.________________________________</p>
<p>_______________________________________</p>
<p>_______________________________________</p>
<p>_______________________________________</p>
<p>Дата рождения ______________________</p> 
<p>Паспорт:</p>
<p>серия__________ №____________________</p>
<p>выдан _______________________________</p>
<p>_______________________________________</p>
<p>_______________________________________</p>
<p>Адрес места жительства:</p>
<p>_______________________________________</p>
<p>_______________________________________</p>
<p>_______________________________________</p>
<p>&nbsp;</p>
<p>Адрес регистрации (заполняется при отличии с местом жительства):</p>
<p>_______________________________________</p>
<p>_______________________________________</p>
<p>_______________________________________</p>
<p>Тел.(код .п.)__________________________</p>
<p>Моб.тел _____________________________</p>
</tr>

</tbody>
</table>
<p>&nbsp;</p>
<p style="font-size:10pt;margin:0px;">Ответственный за обучение</p>
<p style="font-size:10pt;margin:0px;">по дополнительной общеразвивающей программе_________________/Даминов А.Х.</p>
<p style="font-size: 8pt;text-indent:350px;margin:0px;">(подпись) &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ф.И.О.</p>
<p>&nbsp;</p>
<p style="font-size:10pt;text-indent:40px;">С Уставом, лицензией на право осуществления образовательной деятельности, Положением об оказании платных образовательных услуг БашГУ, Правилами внутреннего распорядка БашГУ ОЗНАКОМЛЕН:</p>
<p style="font-size:10pt;text-indent:40px;">Заказчик ___________/__________________ Обучающийся ___________/__________________</p>
<p>&nbsp;</p>
<p style="font-size:10pt;text-indent:40px;">Экземпляр Договора на руки ПОЛУЧИЛ:</p>
<p style="font-size:10pt;text-indent:40px;">Заказчик ___________/__________________ Обучающийся ___________/__________________</p>
<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
<p style="font-size:8pt;margin:0px;"><sup>1 </sup>&nbsp;Договор будет составлен в двух экземплярах в случае, если Заказчик и Обучающийся являются одним лицом.</p>
<p style="font-size:8pt;margin:0px;"><sup>2&nbsp; </sup>&nbsp;Заполняется в случае, если Обучающийся не является Заказчиком.</p>';
$mpdf->WriteHTML($html);
//$mpdf->Output();

$return = $mpdf->Output('name.pdf', 'S');
$return = base64_encode($return);
$return = 'data:application/pdf;base64,'.$return;
echo json_encode($return);