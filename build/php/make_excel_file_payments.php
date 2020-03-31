<?php 
session_name('toltek');
session_start();
    
require_once("functions.php");

  $arr=json_decode($_POST["data"],true);
  
  if (count($arr)!=0)
    {
      //print_r($arr); 
        $payments=get_payments($arr);

    }
    else
    {
    $payments=get_payments();
    }
header('Content-Type: application/json');

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Обучающийся');$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->setCellValue('B1', 'Плательщик');$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->setCellValue('C1', 'Школа');$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->setCellValue('D1', 'Группа');$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->setCellValue('E1', 'Сумма');$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->setCellValue('F1', 'Дата платежа');$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->setCellValue('G1', 'Дата списания');$sheet->getColumnDimension('G')->setAutoSize(true);
$sheet->setCellValue('H1', 'Кассир');$sheet->getColumnDimension('H')->setAutoSize(true);
$sheet->setCellValue('I1', 'orderId');$sheet->getColumnDimension('I')->setAutoSize(true);

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



$sheet->getStyle('A1:I1')->applyFromArray($styleArray);
$sheet->setAutoFilter('A1:I1');

$count=2;
foreach ($payments as $k => $v) 
{
  $student=get_students(array("id_students"=>array($v["id_students"])))[0];
  $group=get_groups(array("id_groups"=>array($v["id_groups"])))[0];//информацию по группе
  $parent=get_parents(array("id_students" => array($v["id_students"]) ))[0]; 
  $name=$student["surname"].' '.$student["name"].' '.$student["patronymic"];
  

  foreach ($v["payments"] as $key => $val)
   { 
     $paymaster=get_paymasters(array("id_users"=>array($val["id_users"])))[0];//кассир  
     $sheet->setCellValue(('A'.$count), $name);
     $parent=get_info_parents($val["id_parents"])[0];//представитель
     $sheet->setCellValue(('B'.$count), ($parent['surname'].' '.$parent['name'].' '.$parent['patronymic']));
     $sheet->setCellValue(('C'.$count), $group["name_of_directions"]);
     $sheet->setCellValue(('D'.$count), $group["name_of_group"]);
     $sheet->setCellValue(('E'.$count), $val["amount"]);
     $sheet->setCellValue(('F'.$count), get_time($val["date_of_entry"],4));
     $sheet->setCellValue(('G'.$count), get_time($val["date_of_receiving"],4));
     $sheet->setCellValue(('H'.$count), get_inic($paymaster["surname"],$paymaster['name'],$paymaster['patronymic']));
     $sheet->setCellValue(('I'.$count), ((get_orderid($val["id_payment"]))?get_orderid($val["id_payment"]):""));
     
     $count++;
  } 

}

$writer = new Xlsx($spreadsheet);
ob_start();
$writer->save('php://output');
$xlsData = ob_get_contents();
ob_end_clean();

echo json_encode('data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,'.base64_encode($xlsData));

?>