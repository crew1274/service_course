<?
$linkname = 'localhost';  //輸入伺服器位置
$linkid = 'root';  //輸入資料庫帳號
$linkpassword = "50150";  //輸入資料庫密碼
$database = 'service_course';  //輸入資料庫名稱


$conn = mysql_pconnect ($linkname,$linkid,$linkpassword) 
        or die("Could not connect"); //連結mysql
mysql_select_db($database) 
                or die("Could not select database"); //選擇資料庫
  
mysql_query("SET NAMES utf8"); //將編碼設定為utf-8
?>