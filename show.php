<?
/*
session_start();
if($_SESSION["uid"]=="")
	header("location:loginPage.php");
*/
require('dblink.php');
$id = $_GET["id"];
$sql = "SELECT * FROM course WHERE id='$id'";
$c = mysql_fetch_array(mysql_query($sql));
$sql = "SELECT * FROM detail WHERE id='$id'";
$d = mysql_fetch_array(mysql_query($sql));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<style type="text/css">
.a {
	text-align: center;
}
.a {
	text-align: center;
}
</style>
</head>

<body>

<h3 align="center"><strong>國立成功大學服務學習課程計畫書</strong></h3>
<table width="700" height="1209" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" style="word-break:break-all">
  <tr>
    <td colspan="3" bgcolor="#CCCCCC"><strong>一、課程基本資訊  </strong></td>
    <td width="158"><strong>課程序號</strong></td>
    <td colspan="2"><? echo $id; ?></td>
  </tr>
  <tr>
    <td width="108" bgcolor="#CCCCCC">課程名稱</td>
    <td colspan="2"><?php echo $c["name"]; ?></td>
    <td width="158" bgcolor="#CCCCCC">本課程開設次數</td>
    <td colspan="2"><? if($c["first"]==1) echo "首次開課"; else echo "非首次開課"; ?></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC">開課單位</td>
    <td colspan="2"><?php echo $c["institute"]; ?></td>
    <td bgcolor="#CCCCCC">課程屬性</td>
    <td colspan="2">
		<?
			if($c["attribute"]==1)
				echo "一般性服務學習";
			else if($c["attribute"]==2) 
				echo "融入服務學習內涵之專業課程";
			else if($c["attribute"]==3) 
				echo "共同議題(社區)融入服務學習內涵之專業課程";
		?>
    </td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC">任課老師</td>
    <td width="100" bgcolor="#CCCCCC">職稱</td>
    <td width="89" bgcolor="#CCCCCC">系所</td>
    <td bgcolor="#CCCCCC">聯絡電話</td>
    <td colspan="2" bgcolor="#CCCCCC">email</td>
  </tr>
    <?
    	$sql="SELECT * FROM teacher WHERE id='$id' and type='1' ORDER BY tid ASC";
		$r = mysql_query($sql);
		while($t=mysql_fetch_array($r)){
			echo "<tr>";
			echo "<td>".$t["name"]."</td>";
			echo "<td>".$t["title"]."</td>";
			echo "<td>".$t["department"]."</td>";
			echo "<td>".$t["phone"]."</td>";
			echo "<td colspan=2>".$t["email"]."</td>";
			echo "</tr>";
		}
	?>
  <tr>
    <td bgcolor="#CCCCCC">教學助理</td>
    <td bgcolor="#CCCCCC">職稱</td>
    <td bgcolor="#CCCCCC">系所</td>
    <td bgcolor="#CCCCCC">聯絡電話</td>
    <td colspan="2" bgcolor="#CCCCCC">email</td>
  </tr>
  <?
    	$sql="SELECT * FROM teacher WHERE id='$id' and type='2' ORDER BY tid ASC";
		$r = mysql_query($sql);
		while($t=mysql_fetch_array($r)){
			echo "<tr>";
			echo "<td>".$t["name"]."</td>";
			echo "<td>".$t["title"]."</td>";
			echo "<td>".$t["department"]."</td>";
			echo "<td>".$t["phone"]."</td>";
			echo "<td colspan=2>".$t["email"]."</td>";
			echo "</tr>";
		}
	?>
  <tr>
    <td bgcolor="#CCCCCC">開課年級</td>
    <td colspan="2"><?php echo $c["grade"]; ?></td>
    <td bgcolor="#CCCCCC">必/選修</td>
    <td colspan="2"><?php if($c["subject"]==1) echo "必修"; else echo "選修"; ?></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC">學分數</td>
    <td colspan="2"><?php echo $c["point"]; ?></td>
    <td bgcolor="#CCCCCC">是否配置教學助理</td>
    <td colspan="2"><?php if($c["assistant"]==1) echo "是"; else echo "否"; ?></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC">每週上課時數</td>
    <td colspan="2"><?php echo $c["weektime"]; ?></td>
    <td bgcolor="#CCCCCC">是否辦理保險</td>
    <td colspan="2"><?php if($c["insurance"]==1) echo "是"; else echo "否"; ?></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC">預定修課人數</td>
    <td colspan="2"><?php echo $c["quota"]; ?></td>
    <td bgcolor="#CCCCCC">服務單位如何擇定</td>
    <td colspan="2">
    	<?
        	if($c["choose"]==1)
				echo "學生";
			else if($c["choose"]==2)
				echo "教師";
			else if($c["choose"]==3)
				echo "學校";
		?>
    </td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC">每學期服務次數</td>
    <td colspan="2"><?php echo $c["frequency"]; ?></td>
    <td bgcolor="#CCCCCC">服務時段</td>
    <td colspan="2">
    	<?
        	$sql = "SELECT * FROM period WHERE id='$id'";
			$r = mysql_query($sql);
			while($p=mysql_fetch_array($r)){
				if($p[1]==1)
					echo "課堂 ";
				else
					echo "課餘時間 ";
			}
		?>
    </td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC">每次服務時數</td>
    <td colspan="2"><?php echo $c["everytime"]; ?></td>
    <td bgcolor="#CCCCCC">是否有固定服務時間</td>
    <td colspan="2"><? if($c["fix"]==1) echo "是"; else echo "否"; ?></td>
  </tr>
  <tr>
    <td width="108" bgcolor="#CCCCCC">服務議題</td>
    <td colspan="5">
    	<?
        	$sql = "SELECT * FROM issue WHERE id='$id'";
			$r = mysql_query($sql);
			while($i=mysql_fetch_array($r)){
				if($i[1]==1)
					echo "課輔 ";
				else if($i[1]==2)
					echo "志工培育 ";
				else if($i[1]==3)
					echo "弱勢關懷與陪伴 "; 
				else if($i[1]==4)
					echo "節能減碳/環保/保育 ";
				else if($i[1]==5)
					echo "醫療服務 "; 
				else if($i[1]==6)
					echo $i[2]." ";
			}
		?>
    </td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC">服務對象</td>
    <td colspan="5">
    	<?
        	$sql = "SELECT * FROM object WHERE id='$id'";
			$r = mysql_query($sql);
			while($i=mysql_fetch_array($r)){
				if($i[1]==1)
					echo "新移民 ";
				else if($i[1]==2)
					echo "老人 ";
				else if($i[1]==3)
					echo "身心障礙 "; 
				else if($i[1]==4)
					echo "兒童青少年 ";
				else if($i[1]==5)
					echo "國際服務 "; 
				else if($i[1]==6)
					echo "成大校園 "; 
				else if($i[1]==7)
					echo "社區經營 "; 
				else if($i[1]==8)
					echo "機構 "; 
				else if($i[1]==9)
					echo $i[2]." ";
			}
		?>
    </td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td colspan="6"><strong>二、課程目標</strong></td>
  </tr>
  <tr>
    <td colspan="6"><?php echo $d["object"]; ?></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td colspan="6"><strong>三、課程內容及特色</strong></td>
  </tr>
  <tr>
    <td colspan="6"><?php echo $d["content"]; ?></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td colspan="6"><strong>四、教學策略 </strong>(例如：如何透過課堂專業學習達成社區服務之目的、安排課程及服務比重…等)</td>
  </tr>
  <tr>
    <td colspan="6"><?php echo $d["strategy"]; ?></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td colspan="6"><strong>五、各階段工作及各週流程</strong> (以每學期18週計算)</td>
  </tr>
  
   <? 
				$sql_sw = "SELECT * FROM schedul_work WHERE id='$id' ORDER BY stype ASC";
				$r_sw = mysql_query($sql_sw) or die($sql_sw);
				$n=1;
				while($sw = mysql_fetch_array($r_sw)){
					$swshow[$n] = $sw["work"];
					$n++; 
				}
				
?>
  
  <tr>
    <td colspan="3"><strong>準備</strong><br>
    <? echo $swshow[1]; ?>
    
    </td>
    <td colspan="5"><table width="100%" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <td width="50"><strong>次數</strong></td>
        <td><strong>內容</strong></td>
        <td width="70"><strong>總時數</strong></td>
      </tr>
      <?
	  	$sql = "SELECT * FROM schedul WHERE id='$id' and type='1' ORDER BY sid ASC";
		$r = mysql_query($sql) or die($sql);
		while($s=mysql_fetch_array($r)){
			echo "<tr>";
			echo "<td>".$s["number"]."</td>";
			echo "<td>".$s["content"]."</td>";
			echo "<td>".$s["time"]."</td>";
			echo "</tr>";
		}
	  ?>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><strong>服務</strong><br>
    <? echo $swshow[2]; ?>
    
    </td>
    <td colspan="5"><table width="100%" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <td width="50"><strong>次數</strong></td>
        <td><strong>內容</strong></td>
        <td width="70"><strong>總時數</strong></td>
      </tr>
      <?
	  	$sql = "SELECT * FROM schedul WHERE id='$id' and type='2' ORDER BY sid ASC";
		$r = mysql_query($sql) or die($sql);
		while($s=mysql_fetch_array($r)){
			echo "<tr>";
			echo "<td>".$s["number"]."</td>";
			echo "<td>".$s["content"]."</td>";
			echo "<td>".$s["time"]."</td>";
			echo "</tr>";
		}
	  ?>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><strong>反思</strong><br>
    <? echo $swshow[3]; ?></td>
    <td colspan="5"><table width="100%" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <td width="50"><strong>次數</strong></td>
        <td><strong>內容</strong></td>
        <td width="70"><strong>總時數</strong></td>
      </tr>
      <?
	  	$sql = "SELECT * FROM schedul WHERE id='$id' and type='3' ORDER BY sid ASC";
		$r = mysql_query($sql) or die($sql);
		while($s=mysql_fetch_array($r)){
			echo "<tr>";
			echo "<td>".$s["number"]."</td>";
			echo "<td>".$s["content"]."</td>";
			echo "<td>".$s["time"]."</td>";
			echo "</tr>";
		}
	  ?>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><strong>慶賀</strong><br>
    <? echo $swshow[4]; ?></td>
    <td colspan="5"><table width="100%" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <td width="50"><strong>次數</strong></td>
        <td><strong>內容</strong></td>
        <td width="70"><strong>總時數</strong></td>
      </tr>
      <?
	  	$sql = "SELECT * FROM schedul WHERE id='$id' and type='4' ORDER BY sid ASC";
		$r = mysql_query($sql) or die($sql);
		while($s=mysql_fetch_array($r)){
			echo "<tr>";
			echo "<td>".$s["number"]."</td>";
			echo "<td>".$s["content"]."</td>";
			echo "<td>".$s["time"]."</td>";
			echo "</tr>";
		}
	  ?>
    </table></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td colspan="6"><strong>六、合作機構</strong></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td>合作機構</td>
    <td>機構聯絡人</td>
    <td>機構電話</td>
    <td>e-mail</td>
    <td colspan="2">機構地址</td>
  </tr>
  <?
    	$sql="SELECT * FROM cooperation WHERE id='$id' ORDER BY cid ASC";
		$r = mysql_query($sql);
		while($t=mysql_fetch_array($r)){
			echo "<tr>";
			echo "<td>".$t["name"]."</td>";
			echo "<td>".$t["people"]."</td>";
			echo "<td>".$t["phone"]."</td>";
			echo "<td>".$t["email"]."</td>";
			echo "<td colspan=2>".$t["address"]."</td>";
			echo "</tr>";
		}
	?>
  <tr bgcolor="#CCCCCC">
    <td colspan="6"><strong>七、講習訓練與服務進行方式 </strong>(請具體說明服務時間、地點、執行方式、執行次數及活動內容)</td>
  </tr>
  <tr>
    <td height="30" colspan="6">(一) 講習訓練</td>
  </tr>
  <tr>
    <td><strong>項目</strong></td>
    <td><strong>日期</strong></td>
    <td><strong>地點</strong></td>
    <td><strong>內容</strong></td>
    <td width="153" colspan=""><strong>講師</strong></td>
    <td width="78"><strong>時間</strong></td>
  </tr>
  <?
    	$sql="SELECT * FROM lecture WHERE id='$id' ORDER BY lid ASC";
		$r = mysql_query($sql);
		while($t=mysql_fetch_array($r)){
			echo "<tr>";
			echo "<td>".$t["item"]."</td>";
			echo "<td>".$t["date"]."</td>";
			echo "<td>".$t["address"]."</td>";
			echo "<td>".$t["content"]."</td>";
			echo "<td>".$t["teacher"]."</td>";
			echo "<td>".$t["time"]."</td>";
			echo "</tr>";
		}
	?>
  <tr>
    <td colspan="6">(二)  服務進行方式</td>
  </tr>
  <tr>
    <td colspan="6"><?php echo $d["service"]; ?></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td colspan="6"><strong>八、評量方式</strong></td>
  </tr>
  <tr>
    <td colspan="3">項目</td>
    <td colspan="3">分數百分比(%)</td>
  </tr>
  <?
    	$sql="SELECT * FROM point WHERE id='$id' ORDER BY pid ASC";
		$r = mysql_query($sql);
		while($t=mysql_fetch_array($r)){
			echo "<tr>";
			echo "<td colspan=3>".$t["item"]."</td>";
			echo "<td colspan=3>".$t["percent"]."</td>";
			echo "</tr>";
		}
	?>
  <tr bgcolor="#CCCCCC">
    <td colspan="6"><strong>九、預期效益</strong> (預計修課人數、提供服務人次、接受服務人次、影響效益等)</td>
  </tr>
  <tr>
    <td colspan="6"><?php echo $d["benefit"]; ?></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td height="20" colspan="6"><strong>十、延續性規劃及具體作法 </strong> (自申請當學年起含二學年度內提升課程品質之遠景規劃)</td>
  </tr>
  <tr>
    <td colspan="6"><?php echo $d["future"]; ?></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td colspan="6"><strong>十一、協力單位合作協議書</strong></td>
  </tr>
  <tr>
    <td colspan="6">
    <?
    	$sql = "SELECT * FROM portocal WHERE id='$id'";
		$f = mysql_fetch_array(mysql_query($sql));
		echo "<a href=http://140.116.238.95:8080/service_course/upload/".$f["filename"]." target=\"_blank\">".$f["name"]."</a>";    
	?>
    </td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td colspan="6"><strong>十二、經費預算</strong></td>
  </tr>
  <tr>
    <td><strong>經費項目</strong></td>
    <td><strong>單價（元）</strong></td>
    <td><strong>數量</strong></td>
    <td><strong>總價（元）</strong></td>
    <td colspan="2"><strong>用途說明</strong>(含計算方式)</td>
  </tr>
  <?
    	$sql="SELECT * FROM finance WHERE id='$id' ORDER BY fid ASC";
		$r = mysql_query($sql);
		while($t=mysql_fetch_array($r)){
			echo "<tr>";
			if($t["item"]==1)
				echo "<td>鐘點費(外聘專家)</td>";
			else if($t["item"]==2)
				echo "<td>鐘點費(內聘專家)</td>";
			else if($t["item"]==3)
				echo "<td>印刷費</td>";	
			else if($t["item"]==4)
				echo "<td>誤餐費</td>";
			else if($t["item"]==5)
				echo "<td>交通費</td>";	
			else if($t["item"]==6)
				echo "<td>雜支</td>";
			else if($t["item"]==7)
				echo "<td>工讀金</td>";
			else if($t["item"]==8)
				echo "<td>保險費</td>";	
			echo "<td>".$t["price"]."</td>";
			echo "<td>".$t["number"]."</td>";
			echo "<td>".$t["total"]."</td>";
			echo "<td colspan=2>".$t["explain"]."</td>";
			echo "</tr>";
		}
	?>
  <?
  	$sql = "SELECT * FROM apply WHERE id='$id'";
	$a=mysql_fetch_array(mysql_query($sql));
  ?>
  <tr>
    <td bgcolor="#CCCCCC">合計</td>
    <td colspan="5" bgcolor="#CCCCCC"><?php echo $a["amount"]; ?></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC">申請補助金額</td>
    <td colspan="5" bgcolor="#CCCCCC"><?php echo $a["apply"]; ?></td>
  </tr>
  
   <?
  	$sql = "SELECT * FROM preprocess WHERE id='$id'";
	$p=mysql_fetch_array(mysql_query($sql));
  ?>
  <tr>
  	<td colspan="6" bgcolor="#CCCCCC"><strong>十三、前次課程執行成果 (首次開課免填)</strong></td>
  </tr>
  <tr>
  	<td colspan="3">修課人數</td>
    <td colspan="3"><? echo $p["number"]; ?></td>
  </tr>
  <tr>
  	<td colspan="3">提供服務人次<br>(每學期每人平均服務次數*修課人數)</td>
    <td colspan="3"><? echo $p["count"]; ?></td>
  </tr>
  <tr>
  	<td colspan="3">提供服務時數<br>(每人服務總時數*修課人數)</td>
    <td colspan="3"><? echo $p["servertime"]; ?></td>
  </tr>
  <tr>
  	<td colspan="3">經費報支執行率</td>
    <td colspan="3"><? echo $p["frequency"]; ?></td>
  </tr>
  <tr>
  	<td colspan="3">獲獎紀錄</td>
    <td colspan="3"><? echo $p["record"]; ?></td>
  </tr> 
  
  
  <tr>
    <td colspan="6"><p>註： <br />
      1.經費之編列與核銷，悉依「教育部補助及委辦經費核撥結報作業要點」、「國內外出差旅費報支要點」暨相關辦法執行之。 <br />
      2.學生參與課外活動之保險，依據「國立成功大學學生團體保險辦法」執行之。<br/>
3.每門課程補助項目，包含鐘點費（外聘、內聘專家）、印刷費、誤餐費、交通費、保險費、工讀金(補助對象為服務學習教學助理)及雜支等必要之支出。雜支金額不得超過補助款20%。 </td>
  </tr>
</table>
<p class="a"><strong>系所主管：</strong><strong class="a"> 　　　　　　　　　　　　　　　　　       院長：</strong>  　　　　　　　　　　　</p>
</body>
</html>
