<?php 

require_once("functions.php");
    
if (isset($_POST["data"]))
{
    $arr=json_decode($_POST["data"],true);
    //print_r($arr);
    $groups=get_groups($arr); 
}
else
{ 
    $groups=get_groups();
}

header('Content-Type: application/json');

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Уровень');$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->setCellValue('B1', 'Группа');$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->setCellValue('C1', 'Направление');$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->setCellValue('D1', 'Курс');$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->setCellValue('E1', 'Учеников');$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->setCellValue('F1', 'Детали');$sheet->getColumnDimension('F')->setAutoSize(true);

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



$sheet->getStyle('A1:F1')->applyFromArray($styleArray);
$sheet->setAutoFilter('A1:F1');


for ($i=0;$i<count($groups);$i++)
{
	$sheet->setCellValue(('A'.($i+2)), $groups[$i]["level"]);
	$sheet->setCellValue(('B'.($i+2)), $groups[$i]["name_of_group"]);
	$sheet->setCellValue(('C'.($i+2)), $groups[$i]['name_of_directions']);
	$sheet->setCellValue(('D'.($i+2)), $groups[$i]['name_of_course']);
	$sheet->setCellValue(('E'.($i+2)), 0);
	$sheet->setCellValue(('F'.($i+2)), $groups[$i]['note']);
}

//some code...
$writer = new Xlsx($spreadsheet);
ob_start();
$writer->save('php://output');
$xlsData = ob_get_contents();
ob_end_clean();

echo json_encode('data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,'.base64_encode($xlsData));
?>