<?php

ini_set('display_errors', 0);
session_start();
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

chdir('..');
include("utils.php");

$param = ['tabel', $_POST['oper']];
$pag = $_POST['oper'];
include('settings.ini');
include('lang/english.lng.php');
$_DEFLNG = $_LNG;
if (file_exists('lang/' . $APP_LANGUAGE . '.lng.php')) {
    include('lang/' . $APP_LANGUAGE . '.lng.php');
}
include('connector/' . $APP_DB_TYPE . '.con.php');
db_connect();
$dontshowpages = 1;

include('script/tabel.scr.php');

$expArr = [];

$arr = [];
foreach ($_POST['fields'] as $v)
    $arr[] = is_array($fields[$v]) ? $fields[$v]['name'] : $fields[$v];
$expArr[] = $arr;

foreach ($rows as $r) {
    $arr = [];
    foreach ($_POST['fields'] as $k) {
        $v = $r[$k];
        ob_start();
        if (file_exists("settings/$pag/{$k}_show.php")) {
            include("settings/$pag/{$k}_show.php");
        } else {
            fieldFormat($k, $v, $r[$k], '', '', $r[$id], $param[1]);
        }
        $arr[] = trim(str_replace(["\n", "\r", "\t"], '', ob_get_contents()));
        ob_end_clean();
    }
    $expArr[] = $arr;
}


chdir('script');



$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0);
$workSheet = $spreadsheet->getActiveSheet();
$workSheet->fromArray($expArr);
$spreadsheet->setActiveSheetIndex(0);

switch ($_POST['type']) {
    case 'xls':
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$pag.'.xls"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        break;
    case 'xlsx':
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$pag.'.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        break;
    case 'pdf':
        IOFactory::registerWriter('Pdf', \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class);
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment;filename="'.$pag.'.pdf"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Pdf');
        break;
    case 'ods':
        header('Content-Type: application/vnd.oasis.opendocument.spreadsheet');
        header('Content-Disposition: attachment;filename="'.$pag.'.ods"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $writer = IOFactory::createWriter($spreadsheet, 'Ods');
        break;
    case 'csv':
        header('Content-Disposition: attachment;filename="'.$pag.'.csv"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $writer = IOFactory::createWriter($spreadsheet, 'Csv');
        break;
}
$writer->save('php://output');
?>