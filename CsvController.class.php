<?php
/* ----------------------------------------------------------------
CsvController ver1.2.0

Constructor:
	- set targetCSV Path at first parameter,and set array of column name at second parameter.
	
Public Method:
	setColumns(Array):void
		- set column at firstLine in targetCSV.
		
	count(Bool):int
		- count all lines in targetCSV.if parameter is true,then count all lines include first line.
		
	create(Array):bool
		- Add new line.
		
	read(int(option),String(option)):array
		- gets any line. If specify second parameter,then you can get value of any column.
		- if not specify parameters or first parameter is 0,then you can get all lines.
			
	readLimit(int,int):array
		-	gets the number of rows specified in the second from the rows specified in the first parameter.
		
	update(int,String,Any):bool
		- update value of specified column in any line.
		
	delete(int):bool
		- delete specified line.
-----------------------------------------------------------------*/

class CsvController{
	private $targetCSV;
	private $arrys;
	private $columns=array();
	
	function __construct($targetCSV,$columns){
		$this->targetCSV=$targetCSV;
		if(file_exists($this->targetCSV)){
			$this->arrys=file($this->targetCSV);
		}
		$this->columns=$columns;
	}
	
	/* -----------------------------------------
	(VOID)SET COLUMNS
		parameter:array
	----------------------------------------- */
	public function setColumns(){
		mb_convert_variables("SJIS-WIN","utf-8",$this->columns);
		if(!file_exists($this->targetCSV)){
			$results=implode(",",$this->columns)."\n";
			$fh=fopen($this->targetCSV,"w");
			flock($fh,LOCK_EX);
			fputs($fh,$results);
			flock($fh,LOCK_UN);
			fclose($fh);
		}
	}
	
	/* -----------------------------------------
	(INT)COUNT LINES
		parameter:bool(option)
	----------------------------------------- */
	public function count($includeFirstLine=false){
		if($includeFirstLine){
			return count($this->arrys);
		}
		return count($this->arrys)-1;
	}
	
	/* -----------------------------------------
	(BOOL)CREATE
		parameter:array
	----------------------------------------- */
	public function create($data){
		mb_convert_variables("SJIS-WIN","utf-8",$data);
		try{
			$fh=fopen($this->targetCSV,"a+");
			flock($fh,LOCK_EX);
			fputcsv($fh,$data);
			flock($fh,LOCK_UN);
			fclose($fh);
			return true;
		}catch(Exception $error){
			echo $error->getMessage();
		}
	}
	
	/* -----------------------------------------
	(ARRAY)READ
		1st parameter:int(option)
		2nd parameter:string(option)
	----------------------------------------- */
	public function read($id=0,$columnName=""){
		if($id==0){
			$i=0;
			$results=array();
			foreach($this->arrys as $value){
				if($i){array_push($results,$value);}
				$i++;
			}
			return $results;
		}else{
			if($id<=$this->count()){
				if($columnName!=""){
					if(array_search($columnName,$this->columns)!==false){
						$i=array_search($columnName,$this->columns);
						foreach($this->arrys as $index=>$value){
							if($index==$id){
								$elements=explode(",",$value);
								return array($elements[$i]);
							}
						}
					}
					return array();	
				}else{
					foreach($this->arrys as $index=>$value){
						if($index==$id){
							return array($value);
						}
					}
					return array();
				}		
			}
			return array();
		}
	}
	
	/* -----------------------------------------
	(ARRAY)READ LIMIT
		1st parameter:int
		2nd parameter:int
	----------------------------------------- */
	public function readLimit($startRow=1,$getRowCount){
		$lastRowCount=$this->count()<$startRow+$getRowCount ? $this->count()+1 : $startRow+$getRowCount;
		$results=array();
		for($i=$startRow;$i<$lastRowCount;$i++){
			array_push($results,$this->arrys[$i]);
		}
		return $results;
	}
	
	/* -----------------------------------------
	(BOOL)UPDATE
		1st parameter:int
		2nd parameter:string
		3rd parameter:any
	----------------------------------------- */
	public function update($id,$columnName,$changeValue){
		mb_convert_variables("SJIS-WIN","utf-8",$changeValue);
		$results="";
		$tempResults="";
		if(array_search($columnName,$this->columns)!==false){
			$i=array_search($columnName,$this->columns);
			foreach($this->arrys as $index=>$value){
				if($index==$id){
					$elements=explode(",",$value);
					foreach($elements as $key=>$element){
						if($key==$i){
							$tempResults.=$changeValue.",";
						}else{
							$tempResults.=$element.",";
						}
					}
					$tempResults=str_replace("\n","",$tempResults);
					$results.=substr($tempResults,0,-1)."\n";
				}else{
					$results.=$value;
				}
			}
		}
		$fh=fopen($this->targetCSV,"w");
		flock($fh,LOCK_EX);
		fputs($fh,$results);
		flock($fh,LOCK_UN);
		fclose($fh);
		return true;
	}
	
	/* -----------------------------------------
	(BOOL)DELETE
		parameter:int
	----------------------------------------- */
	public function delete($id){
		if($id<=$this->count()){
			$results="";
			foreach($this->arrys as $index=>$value){
				if($index!=$id){
					$results.=$value;
				}
			}
			try{
				$fh=fopen($this->targetCSV,"w");
				flock($fh,LOCK_EX);
				fputs($fh,$results);
				flock($fh,LOCK_UN);
				fclose($fh);
				return true;
			}catch(Exception $error){
				echo $error->getMessage();
			}
		}else{
			return false;
		}
	}
}

?>