<?php
$id = $_GET["id"];
$page = "http://140.116.238.95:8080/service_course/show.php?id=".$id; 
$save = 'C:\AppServ\www\service_course\upload\test2.pdf';
$sh = "C:\wkhtmltopdf\wkhtmltopdf.exe ".$page." ".$save;
//echo $sh;
$results = shell_exec($sh);  
//echo $results;  
header("location:upload/test2.pdf");
?> 