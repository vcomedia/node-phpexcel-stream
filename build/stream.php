<?php

if (!defined('PHPEXCEL_ROOT')) {
  define('PHPEXCEL_ROOT', __DIR__. '/vendor/phpoffice/phpexcel/Classes/');
  require_once PHPEXCEL_ROOT . 'PHPExcel/Autoloader.php';
}

$file = $argv[1];

// Use SQLite cell cache (significantly reduces memory usage)
$cache = PHPExcel_CachedObjectStorageFactory::cache_to_sqlite3;

if (PHPExcel_Settings::setCacheStorageMethod($cache)!==true) {
  throw new Exception('SQLite3 not available');
}

$excel = PHPExcel_IOFactory::createReaderForFile($file)
  ->setReadDataOnly(false)  //true
  ->load($file);

//normalize all date fields
$sheet = $excel->getActiveSheet();
$MAX_COL = $sheet->getHighestDataColumn();
$MAX_COL_INDEX = PHPExcel_Cell::columnIndexFromString($MAX_COL);
for($ii=0;$ii<=$MAX_COL_INDEX;$ii++){
  $col = PHPExcel_Cell::stringFromColumnIndex($ii);
  $highestRow = $sheet->getHighestRow();
  for($row=1; $row <= $highestRow; $row++) {
    $cellobj=$sheet->getCellByColumnAndRow($col, $row);
    if(PHPExcel_Shared_Date::isDateTime($cellobj)) {
      $cellobj->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD);
    }
  }
}

PHPExcel_IOFactory::createWriter($excel, 'CSV')
  ->save('php://stdout');
