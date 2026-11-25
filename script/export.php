<?php
ini_set('display_errors', 0);
session_start();
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
chdir('..');
include("utils.php");
$pag = $_POST['oper'] ?? '';
// module names may only contain lowercase letters, digits and "_"
if (!preg_match('/^[a-z0-9_]+$/', $pag)) exit;
$param = [$pag];
include('settings.ini');
include('lang/english.lng.php');
$_DEFLNG = $_LNG;
if (file_exists('lang/' . $APP_LANGUAGE . '.lng.php')) {
    include('lang/' . $APP_LANGUAGE . '.lng.php');
}
include('connector/' . $APP_DB_TYPE . '.con.php');
db_connect();
// logged in, valid CSRF token and view right on the module
if (empty($_SESSION['userid']) || !csrf_ok() || !has_right(load_rights($pag), 'view_right')) {
    http_response_code(403);
    exit;
}
$settingFile = "settings/$pag/config.php";
if (!file_exists($settingFile)) $settingFile = "settings_default/$pag/config.php";
if (!file_exists($settingFile)) exit;
include($settingFile);
if (empty($tabel) || empty($fields) || !is_array($fields)) exit;
$dontshowpages = 1;
include('script/tabel.scr.php');
// only fields of the module can be exported
$expFields = array_values(array_intersect((array)($_POST['fields'] ?? []), array_keys($fields)));
$expArr = [];
$arr = [];
foreach ($expFields as $v)
    $arr[] = is_array($fields[$v]) ? $fields[$v]['name'] : $fields[$v];
$expArr[] = $arr;
foreach (($rows ?? []) as $r) {
    $arr = [];
    foreach ($expFields as $k) {
        $v = $fields[$k];
        ob_start();
        if (file_exists("settings/$pag/{$k}_show.php")) {
            include("settings/$pag/{$k}_show.php");
        } else {
            fieldFormat($k, $v, $r[$k], '', '', $r[$id], $pag);
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
    default:
        exit;
}
$writer->save('php://output');
?>