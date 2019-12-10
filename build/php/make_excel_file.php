<?php 

require_once("functions.php");

if (isset($_POST["data"]))
 	{
 		$arr=json_decode($_POST["data"]);
 		$requests=get_all_requests($arr);
 	}
 	else
 	{
 		$requests=get_all_requests();
 	}

header('Content-Type: application/json');

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Статус');$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->setCellValue('B1', 'Фамилия');$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->setCellValue('C1', 'Имя');$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->setCellValue('D1', 'Отчество');$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->setCellValue('E1', 'Дата рождения');$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->setCellValue('F1', 'Класс');$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->setCellValue('G1', 'Посещал');$sheet->getColumnDimension('G')->setAutoSize(true);

$sheet->setCellValue('H1', 'Представитель');$sheet->getColumnDimension('H')->setAutoSize(true);
$sheet->setCellValue('I1', 'Телефон');$sheet->getColumnDimension('I')->setAutoSize(true);
$sheet->setCellValue('J1', 'Email');$sheet->getColumnDimension('J')->setAutoSize(true);
$sheet->setCellValue('K1', 'Курс(ы)');$sheet->getColumnDimension('K')->setAutoSize(true);
$sheet->setCellValue('L1', 'Комм-ий');
$sheet->setCellValue('M1', 'Адм-р');

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



$sheet->getStyle('A1:M1')->applyFromArray($styleArray);
$sheet->setAutoFilter('A1:M1');


for ($i=0;$i<count($requests);$i++)
{
	$sheet->setCellValue(('A'.($i+2)), get_request_status(array("id_request_status" => array($requests[$i]["id_request_status"])))[0]["request_status"]);
	$sheet->setCellValue(('B'.($i+2)), $requests[$i]['surname']);
	$sheet->setCellValue(('C'.($i+2)), $requests[$i]['name']);
	$sheet->setCellValue(('D'.($i+2)), $requests[$i]['patronymic']);
	$sheet->setCellValue(('E'.($i+2)), $requests[$i]['birth']);
	$sheet->setCellValue(('F'.($i+2)), $requests[$i]['class_number']);
	$sheet->setCellValue(('G'.($i+2)), (($requests[$i]['attend'])?'да':'нет'));

	$sheet->setCellValue(('H'.($i+2)), $requests[$i]['parent']);
	$sheet->setCellValue(('I'.($i+2)), $requests[$i]['phone']);
	$sheet->setCellValue(('J'.($i+2)), $requests[$i]['email']);

	$courses=get_all_courses_of_request($requests[$i]['id_requests']);
    $str='';

	  for ($n=0;$n<count($courses);$n++)
	  {
	  	 if ($str!='') $str.=',';
	     $str.=$courses[$n]['name_of_course'];
	  }
	$sheet->setCellValue(('K'.($i+2)), $str);
	$sheet->setCellValue(('L'.($i+2)), $requests[$i]["note_of_user"]);
	$sheet->setCellValue(('M'.($i+2)), $requests[$i]["note"]);

}

//some code...
$writer = new Xlsx($spreadsheet);
ob_start();
$writer->save('php://output');
$xlsData = ob_get_contents();
ob_end_clean();

echo json_encode('data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,'.base64_encode($xlsData));
?>