<?
require("dblink.php");
$id = $_GET["id"];

$sql = "DELETE FROM apply WHERE id='$id'";
mysql_query($sql) or die($sql);

$sql = "DELETE FROM cooperation WHERE id='$id'";
mysql_query($sql) or die($sql);

$sql = "DELETE FROM course WHERE id='$id'";
mysql_query($sql) or die($sql);

$sql = "DELETE FROM detail WHERE id='$id'";
mysql_query($sql) or die($sql);

$sql = "DELETE FROM finance WHERE id='$id'";
mysql_query($sql) or die($sql);

$sql = "DELETE FROM issue WHERE id='$id'";
mysql_query($sql) or die($sql);

$sql = "DELETE FROM lecture WHERE id='$id'";
mysql_query($sql) or die($sql);

$sql = "DELETE FROM object WHERE id='$id'";
mysql_query($sql) or die($sql);

$sql = "DELETE FROM period WHERE id='$id'";
mysql_query($sql) or die($sql);

$sql = "DELETE FROM point WHERE id='$id'";
mysql_query($sql) or die($sql);

$sql = "DELETE FROM portocal WHERE id='$id'";
mysql_query($sql) or die($sql);

$sql = "DELETE FROM schedul WHERE id='$id'";
mysql_query($sql) or die($sql);

$sql = "DELETE FROM teacher WHERE id='$id'";
mysql_query($sql) or die($sql);

$sql = "DELETE FROM preprocess WHERE id='$id'";
mysql_query($sql) or die($sql);

$sql = "DELETE FROM schedul_work WHERE id='$id'";
mysql_query($sql) or die($sql);

header("location:index.php");
?>