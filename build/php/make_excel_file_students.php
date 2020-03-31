<?php 

require_once("functions.php");

  $arr=json_decode($_POST["data"],true);
  
  if (count($arr)!=0)
    {
      //print_r($arr); 
        $students=get_students($arr);
    }
    else
    {
    $students=get_students();
    }

header('Content-Type: application/json');

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Фамилия');$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->setCellValue('B1', 'Имя');$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->setCellValue('C1', 'Отчество');$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->setCellValue('D1', 'Пол');$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->setCellValue('E1', 'Дата рождения');$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->setCellValue('F1', 'Класс');$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->setCellValue('G1', 'Документ');$sheet->getColumnDimension('G')->setAutoSize(true);

$sheet->setCellValue('H1', 'Адрес');$sheet->getColumnDimension('H')->setAutoSize(true);
$sheet->setCellValue('I1', 'Телефон');$sheet->getColumnDimension('I')->setAutoSize(true);
$sheet->setCellValue('J1', 'Группы');$sheet->getColumnDimension('J')->setAutoSize(true);
$sheet->setCellValue('K1', 'Комм-ий');$sheet->getColumnDimension('K')->setAutoSize(true);

$styleArray = [
    'font' => [
        'bold' => true,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
    ],
    'borders' => [
        'top' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
        'bottom' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ]
        ,
        'right' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'color' => [
            'argb' => 'FFA0A0A0',
        ],
    ],
];



$sheet->getStyle('A1:K1')->applyFromArray($styleArray);
$sheet->setAutoFilter('A1:K1');


for ($i=0;$i<count($students);$i++)
{
	$sheet->setCellValue(('A'.($i+2)), $students[$i]['surname']);
	$sheet->setCellValue(('B'.($i+2)), $students[$i]['name']);
	$sheet->setCellValue(('C'.($i+2)), $students[$i]['patronymic']);
	$sheet->setCellValue(('D'.($i+2)), (($students[$i]['gender']==1)?'м':'ж'));
	$sheet->setCellValue(('E'.($i+2)), $students[$i]['birth']);
	$sheet->setCellValue(('F'.($i+2)), $students[$i]['class_number']);

    $doc=$students[$i]['doc'].": ".$students[$i]['series'].' '.$students[$i]['number'];
    if (!($students[$i]['passport_who']===''))
    { 
      $doc.=",".get_time($students[$i]['passport_date'],1).', '.$students[$i]['passport_who'];
    }

	$sheet->setCellValue(('G'.($i+2)), $doc);
	$sheet->setCellValue(('H'.($i+2)), $students[$i]['adress']);
	$sheet->setCellValue(('I'.($i+2)), $students[$i]['phone']);
   


	$groups=get_students_group($students[$i]['id_students']);
    $str='';

	  for ($n=0;$n<count($groups);$n++)
	  {
	  	 if ($str!='') $str.=',';
	     $str.=$groups[$n]['name_of_group'];
	  }
	$sheet->setCellValue(('J'.($i+2)), $str);  
    $sheet->setCellValue(('K'.($i+2)), $students[$i]['note']);
}

//some code...
$writer = new Xlsx($spreadsheet);
ob_start();
$writer->save('php://output');
$xlsData = ob_get_contents();
ob_end_clean();

echo json_encode('data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,'.base64_encode($xlsData));

?>