<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php 
include("word.php"); 
$word=new word; 

//$id=$_GET["id"];

$word->start(); 
include("show.php");
$doc = time().rand(0,99).".doc";
$word->save("upload/".$doc);//保存word并且结束. 
?> 
<style type="text/css">
.aa {
	font-size: larger;
	text-align: center;
}
.aa a strong {
	font-size: xx-large;
}
</style>
<p>&nbsp;</p>
<div class="aa">
<a href="<? echo "upload/".$doc; ?>" target="_blank"><strong>下載</strong></a>
</div>
 
