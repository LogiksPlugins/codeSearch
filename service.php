<?php
if(!defined('ROOT')) exit('No direct script access allowed');
//checkServiceSession();
//isAdminSite();

loadModule("codeSearch");

if($_REQUEST['action']=="search") {
	if(!isset($_REQUEST["term"])) $_REQUEST["term"]="";
	if(!isset($_REQUEST["src"])) $_REQUEST["src"]="php";
	if(!isset($_REQUEST["format"])) $_REQUEST["format"]="html";

	$format=$_REQUEST["format"];

	//printArray($data);
	if($format=="json") {
		$term=$_REQUEST["term"];
		$src=$_REQUEST["src"];
		$data=searchCodeIndex($term,$src);
		foreach($data as $n=>$b) {
			$data[$n]=explode("\t",$b);
			if(!isset($data[$n][3])) $data[$n][3]="1";
			$data[$n][]="https://github.com/Logiks/Logiks-Core/blob/master/".$data[$n][2]."#L".$data[$n][3];
		}
		echo json_encode($data);
	} else {
		loadModuleLib("codeSearch","pg-search");
	}
} elseif($_REQUEST['action']=="createcodeindex") {
	if(!isset($_REQUEST["src"])) $_REQUEST["src"]="php";

	$codeIndex=ROOT.TMP_FOLDER."codeIndex/";
	$codeFile="{$codeIndex}{$src}/default.dat";

	//Create Code Index
} elseif($_REQUEST['action']=="downloadindex") {
	//Download Code Index
} elseif($_REQUEST['action']=="autocomplete" && isset($_REQUEST["term"]) && strlen($_REQUEST["term"])>=1) {
	if(!isset($_REQUEST["term"])) $_REQUEST["term"]="";
	if(!isset($_REQUEST["src"])) $_REQUEST["src"]="php";
	if(!isset($_REQUEST["format"])) $_REQUEST["format"]="json";

	$term=$_REQUEST["term"];
	$src=$_REQUEST["src"];
	$format=$_REQUEST["format"];

	$data=searchCodeIndex($term,$src);
	dispatchAutoCompleteData($data,$format);
}

function dispatchAutoCompleteData($data,$format="json") {
	if($format=="json") {
		$arr=array();
		foreach($data as $a=>$b) {
			if(strlen($b)>0) {
				$x=array();
				$bx=explode("\t",$b);

				if(isset($bx[1])) {
					$x["label"]=$bx[1]." ".$bx[0];
					$x["value"]=$bx[0];
				} else {
					$x["label"]=$bx[0];
					$x["value"]=$bx[0];
				}
				$x["data"]="";
				array_push($arr,$x);
			}
		}
		echo json_encode($arr);
	} elseif($format=="selector") {
		foreach($data as $a=>$b) {
			if(strlen($b)>0) {
				$x=array();
				$bx=explode("\t",$b);
				if(isset($bx[1])) {
					echo "<option value='{$b[0]}'>{$b[1]} {$b[0]}</option>";
				} else {
					echo "<option value='{$b[0]}'>{$b[0]}</option>";
				}
			}
		}
	}
}
?>
