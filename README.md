## CsvController ver1.1.0

### Constructor:
	- set targetCSV Path at first parameter,and set array of column name at second parameter.
	
### Private Method:
	setColumns(Array):void
		- set column at firstLine in targetCSV.

### Public Method:
	count(Bool):int
		- count all lines in targetCSV.if parameter is true,then count all lines include first line.
		
	create(Array):bool
		- Add new line.
		
	read(int,String):string
		- gets any line. If specify second parameter,then you can get value of any column.
		- if not specify parameters or first parameter is 0,then you can get all lines.
	
	readLimit(int,int):array
		- gets the number of rows specified in the second from the rows specified in the first parameter.
	
	update(int,String,Any):bool
		- update value of specified column in any line.
		
	delete(int):bool
		- delete specified line.
    
### example
~~~
<?php
// create

require_once('config.php');
require_once('CsvController.class.php');

$POST=filter_var_array($_POST,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$cc=new CsvController(DATA_PATH.DATA_CSV_NAME,COLUMN_NAMES);
$cc->create($POST);
?>

<?php
// read

require_once('config.php');
require_once('CsvController.class.php');

$POST=filter_var_array($_POST,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$cc=new CsvController(DATA_PATH.DATA_CSV_NAME,COLUMN_NAMES);
$responseRead=$cc->read($POST['id'],$POST['columnName']);
?>

<?php
// update

require_once('config.php');
require_once('CsvController.class.php');

$POST=filter_var_array($_POST,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$cc=new CsvController(DATA_PATH.DATA_CSV_NAME,COLUMN_NAMES);
$cc->update($POST['id'],$POST['columnName'],$POST['changeValue']);
?>

<?php
// delete

require_once('config.php');
require_once('CsvController.class.php');

$POST=filter_var_array($_POST,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$cc=new CsvController(DATA_PATH.DATA_CSV_NAME,COLUMN_NAMES);
$cc->delete($POST['id']);
?>
~~~
