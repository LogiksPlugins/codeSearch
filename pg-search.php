<?php
$term=$_REQUEST["term"];
$src=$_REQUEST["src"];

$data=searchCodeIndex($term,$src);
foreach($data as $n=>$b) {
	//$data[$n]=explode("\t",$b);
	$data[$n]=preg_split("/\t+/",$b);
}
//printArray($data);
$icon=getCodeIcon($src);
_skin("jquery.ui.cupertino");
?>
<style>
html,body {overflow-x:hidden;padding:0px;margin:0px;}
.codeSearchResults a {color:#333;text-decoration:underline;}
.codeSupportTools {position:fixed;left:0px;bottom:0px;width:100%;padding:4px;}
</style>

<table class='codeSearchResults ui-widget-content' width=100% border=0 cellpadding=2 cellspacing=0 style='padding:0px;margin:0px;'>
	<thead class='ui-widget-header'>
		<tr>
			<th width=28px></th>
			<th width=60px>Type</th>
			<th>Name</th>
			<th>Source</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<tr><td colspan=20><hr/></td></tr>
<?php
	foreach($data as $a) {
			if(count($a)<=1) continue;
			for($i=count($a);$i<=4;$i++) $a[$i]="";

			$b=$a[0];
			if($a[3]<=0) $a[3]="1";
?>
		<tr>
			<td width=28px align=left><img src='<?=$icon?>' width=25px height=25px /></td>
			<td width=60px align=left><?=$a[1]?></td>
			<th align=left><?=$a[0]?></th>
			<td width=150px  align=left title='<?=$a[2]?>'><?=basename($a[2]).":".$a[3]?></td>
			<td width=40px align=left><a href='https://github.com/Logiks/Logiks-Core/blob/master/<?=$a[2]."#L".$a[3]?>' target=_blank>SRC</a></td>
		</tr>
<?php
	}
?>
		<tr><td colspan=20></td></tr>
	</tbody>
</table>
<br/>
<div class='codeSupportTools ui-state-default'>
<a href='https://github.com/Logiks/'>Logiks@Github</a>
||
<a href='https://www.facebook.com/openlogiks/'>Logiks@Facebook</a>
</div>
