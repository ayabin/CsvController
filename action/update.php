<?php
require_once('../config.php');
require_once('../CsvController.class.php');

$POST=filter_var_array($_POST,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$cc=new CsvController("../".DATA_PATH.DATA_CSV_NAME,COLUMN_NAMES);
echo $responseRead=$cc->update($POST['id'],$POST['columnName'],$POST['changeValue']);
header("location:../");
?>