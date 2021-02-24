<?php
require_once('config.php');
require_once('CsvController.class.php');

$targetCSV=__DIR__."/".DATA_PATH.DATA_CSV_NAME;
if(file_exists($targetCSV)){
	$cc=new CsvController($targetCSV,COLUMN_NAMES);
	$arrys=$cc->read();
	mb_convert_variables("utf-8","SJIS-WIN",$arrys);
	
	$limits=$cc->readLimit(2,4);
	mb_convert_variables("utf-8","SJIS-WIN",$limits);
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Example How to CsvController</title>
	<style>
		table,tr,td{
			border:solid #ccc 1px;
			border-collapse: collapse;
			padding: 10px;
			margin-bottom:10px;
		}
		form{
			border:solid #ccc 1px;
			padding:10px;
			margin-bottom:10px;
		}
		form label{display: block;}
		h5{margin:0;}
	</style>
</head>
<body>
	<form action="action/createCSV.php" method="post">
		<h5>CreateCSV</h5>
		<input type="submit" value="createCSV">
	</form>
	<?php if(isset($arrys)):?>
		<form action="action/create.php" method="post">
			<h5>Create</h5>
			<?php foreach(COLUMN_NAMES as $value): ?>
			<label><?=$value ?>:<input type="text" name="<?=$value ?>"></label>
			<?php endforeach ?>
			<input type="submit" value="create">
		</form>
		<form action="action/read.php" method="post">
			<h5>Read</h5>
			<label>id:<input type="text" name="id"></label>
			<label>columnName:<input type="text" name="columnName"></label>
			<input type="submit" value="read">
			<?php echo isset($_GET['responseRead']) ? "<p>".mb_convert_encoding($_GET['responseRead'],"utf-8","SJIS-WIN")."</p>" :null; ?>
		</form>
		<form action="action/update.php" method="post">
			<h5>Update</h5>
			<label>id:<input type="text" name="id"></label>
			<label>columnName:<input type="text" name="columnName"></label>
			<label>changeValue:<input type="text" name="changeValue"></label>
			<input type="submit" value="update">
		</form>
		<form action="action/delete.php" method="post">
			<h5>Delete</h5>
			<label>id:<input type="text" name="id"></label>
			<input type="submit" value="delete">
		</form>
		<h5>read()</h5>
		<table>
			<?php
			$i=1;
			foreach($arrys as $index=>$arry):
			?>
			<?php $elems=explode(",",$arry); ?>
			<tr>
				<td><?=$i ?></td>
				<?php foreach($elems as $col=>$value): ?>
				<td><?=$value ?></td>
				<?php endforeach ?>
			</tr>
			<?php
			$i++;
			endforeach
			?>
		</table>
		<h5>readLimit(2,4)</h5>
		<table>
			<?php
			$i=1;
			foreach($limits as $index=>$arry):
			?>
			<?php $elems=explode(",",$arry); ?>
			<tr>
				<td><?=$i ?></td>
				<?php foreach($elems as $col=>$value): ?>
				<td><?=$value ?></td>
				<?php endforeach ?>
			</tr>
			<?php
			$i++;
			endforeach
			?>
		</table>
	<?php endif ?>
</body>
</html>