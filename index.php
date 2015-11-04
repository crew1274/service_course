<?
session_start();
if($_SESSION["uid"]=="")
	header("location:loginPage.php");
$uid = $_SESSION["uid"];
require("dblink.php");
?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>國立成功大學服務學習課程系統</title>

<!-- Load JQuery Libraries from "http://www.google.com/jsapi" -->
<link rel="stylesheet" href="CSS/theme.css" type="text/css"/>
<script type="text/javascript" src="JS/jquery-1.4.2.js"></script>
<script type="text/javascript" src="JS/jquery-ui-1.8.5.custom.min.js"></script>
<script type="text/javascript" src="JS/global_variables.js"></script>
<style>
#tb a {
    
    height: 35px;
    line-height: 35px;
	color:#009;
}
#tb tr:hover {
    background: #A2FBA4;
}

</style>
<script>
function del(id)
{

var r=confirm("確定要刪除?");
if (r==true)
  {
  location.replace("del.php?id="+id);
  }

}
</script>
</head>

  <body>
  	<div class="page_container ui-state-error">
        <div class="page_header"></div>
            <div id="menuDiv" class="menuDiv ui-widget-header">
            <table width="100%">
              <tr>
                  <td id="menu_field">
                        <a href="logout.php" class="menu_item">登出</a>
                        <a href="editPage.php" class="menu_item">新增課程</a>
                </td>
                  <td style="color: white" align="right" id="user_name_field">使用者：<? echo $uid; ?></td>
                   <td></td><td></td><td></td>
                </tr>
              
            </table>
        
        </div>

	<div class="contentDiv">
            
        	<table width="94%" height="30" class=" ui-state-highlight" id="tb">
          		<tr class="ui-state-hover"><td width="20%">更新日期</td><td width="10%">建立者</td><td width="50%">學程名稱</td><td width="10%">操作</td><td width="10%">Word</td></tr>
                <?
				if($uid=="root")
					$sql = "SELECT * FROM course ORDER BY creattime";
				else
					$sql = "SELECT * FROM course WHERE uid='$uid'";
				$r = mysql_query($sql) or die($sql);
				while($c=mysql_fetch_array($r)){
					
					echo "<tr>";
				
					echo "<td>".$c["creattime"]."</td>";
					
					$sql2 = "SELECT * FROM user WHERE uid='".$c["uid"]."'";
					$tname = mysql_fetch_array(mysql_query($sql2));
					echo "<td>".$tname["name"]."</td>";
					echo "<td><a href=\"editPage_modify.php?id=$c[0]\">".$c["name"]."</a></td>";
					echo "<td>
							<a href=\"javascript:del($c[0]);\" > 刪除 </a>";
					echo "<td>
							<a >     </a>";
					//if($uid=="root")
							//echo "<a href=\"print.php?id=$c[0]\" target=_blank> 列印</a>";
					
					//if($uid=="root")
						echo " <a href=\"print_word.php?id=$c[0]\" target=_blank> word</a>";
					
					echo "</td>";
					echo "</td>";
			
					echo "</tr>";
					
				}
				?>
        	</table>
    	</div>

	
    </div>
    
  </body>
</html>
