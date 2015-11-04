<?
session_start();
require("dblink.php");
$id = $_POST["id"];
$pw = $_POST["password"];
$sql = "SELECT * FROM user WHERE uid='$id'";
$r = mysql_query($sql) or die($sql);
$row = mysql_num_rows($r);

if($row==0){
	header("location:loginPage.php?msg=1");}else{
	$p=mysql_fetch_array($r);
	if($p[1]!=$pw){
		header("location:loginPage.php?msg=1");
	}else{
		$_SESSION["uid"] = $id;
		header("location:index.php");
	}
}
?>