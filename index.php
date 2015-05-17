<?php
if(!defined('ROOT')) exit('No direct script access allowed');

$codeIndex=ROOT.TMP_FOLDER."codeIndex/";
if(!is_dir($codeIndex)) {
	if(mkdir($codeIndex,0777,true)) {
		chmod($codeIndex,0777);
	}
}
function searchCodeOnline($term,$src) {

}
function searchCodeIndex($term,$src) {
	$codeIndex=ROOT.TMP_FOLDER."codeIndex/";
	$codeFile="{$codeIndex}{$src}/".strtolower(substr($term,0,1)).".dat";
	if(!file_exists($codeFile)) {
		$codeFile="{$codeIndex}{$src}/default.dat";
	}
	$data=array();
	if(file_exists($codeFile)) {
		$data=file_get_contents($codeFile);
		$data=explode("\n",$data);
		foreach($data as $a=>$b) {
			if(strlen($term)>0) {
				if(strpos("#".strtolower($b),strtolower($term))==1) {
				} elseif(strpos($b,"=")>1 && strpos(strtolower($b),strtolower("=".$term))==strpos($b,"=")) {
				} else {
					unset($data[$a]);
				}
			}
		}
	}
	return $data;
}
function getCodeIcon($src) {
	$wp=getWebPath(__FILE__);
	return $wp."images/{$src}.png";
}
?>
