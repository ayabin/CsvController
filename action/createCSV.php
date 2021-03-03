<?php
require_once('../config.php');
require_once('../CsvController.class.php');

$cc=new CsvController("../".DATA_PATH.DATA_CSV_NAME,COLUMN_NAMES);
$cc->setColumns();
header("location:../");
?>