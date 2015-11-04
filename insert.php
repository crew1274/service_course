<?

require("dblink.php");
$i=0;
$Ary = & $_POST;
  foreach($Ary as $AryKey[$i]=>$a[$i]){


        //印出陣列索引號$i,POST欄位名稱,POST的值
        //echo $i." ".$AryKey[$i] . "=>" . $a[$i] . "<br>";
		$post[$AryKey[$i]]=$a[$i];
		//echo $post[$AryKey[$i]]."<br>";
        $i++;
  } 
//echo "<hr>"; //印出水平分隔線

/*
若是用表單傳送資料時
$AryKey[] 陣列存的是表單裡的欄位名稱
其值則是對應到$a[] 陣列中
*/

//insert into db.course
$sql = "INSERT INTO course(uid,year,name,first,institute,attribute,grade,subject,point,assistant,weektime,insurance,quota,choose,frequency,everytime,fix) 
VALUES ('".$post['teacher_id']."','".$post['session_year']."','".$post['course_name']."','".$post['course_first_or_not']."','".$post['institute']."','".$post['cousre_attribute']."','".$post['course_grade']."','".$post['required_elective_course']."','".$post['course_point']."','".$post['is_assistant']."','".$post['course_point_time']."','".$post['is_insurance']."','".$post['student_quota']."','".$post['service_choose']."','".$post['service_frequency']."','".$post['service_times_everytime']."','".$post['is_fix_service_time']."')";
mysql_query($sql) or die($sql);

$id = mysql_insert_id();
/*
$sql = "SELECT * FROM course ORDER BY id DESC";
$r=mysql_fetch_array(mysql_query($sql));
$id=$r[0];//課程id
*/
//insert into db.period
if($post['service_time_intervel']){
	$sql = "INSERT INTO period(id,period) VALUES ('$id','".$post['service_time_intervel']."')";
	mysql_query($sql) or die($sql);
}
if($post['service_time_intervel_1']){
	$sql = "INSERT INTO period(id,period) VALUES ('$id','".$post['service_time_intervel_1']."')";
	mysql_query($sql) or die($sql);
}

//insert into db.detail
$sql = "INSERT INTO detail(id,object,content,strategy,service,benefit,future) VALUES ('$id','".$post['course_object']."','".$post['course_contents']."','".$post['teaching_policy']."','".$post['method_service_carries']."','".$post['anticipated_benefit']."','".$post['ContinuousPlan_ConcreteMethod']."')";
mysql_query($sql) or die($sql);




//insert 使用者自己新增表單的資料
$z=0;
$m=0;
$total = array();
for($j=0;$j<count($a);$j++){
	$data=explode("_",$AryKey[$j]);
	$multi = $data[0]."_".$data[1];
	switch($data[0]){
		case "t1": //teacher
			if($data[2]!=$z){
				$sql = "INSERT INTO teacher(id,name,title,department,phone,email,type) VALUES ('$id','".$a[$j]."','".$a[$j+1]."','".$a[$j+2]."','".$a[$j+3]."','".$a[$j+4]."','1')";
				mysql_query($sql) or die($sql);
				$z=$data[2];
			}
		break;
		case "t2": //teacher
			if($data[2]!=$z){
				$sql = "INSERT INTO teacher(id,name,title,department,phone,email,type) VALUES ('$id','".$a[$j]."','".$a[$j+1]."','".$a[$j+2]."','".$a[$j+3]."','".$a[$j+4]."','2')";
				mysql_query($sql) or die($sql);
				$z=$data[2];
			}
		break;
		case "t3": //cooperation
			if($data[2]!=$z){
				$sql = "INSERT INTO cooperation(id,name,people,phone,email,address) VALUES ('$id','".$a[$j]."','".$a[$j+1]."','".$a[$j+2]."','".$a[$j+3]."','".$a[$j+4]."')";
				mysql_query($sql) or die($sql);
				$z=$data[2];
			}
		break;
		case "t4": //lecture
			if($data[2]!=$z){
				$sql = "INSERT INTO lecture(id,item,date,address,content,teacher,time) VALUES ('$id','".$a[$j]."','".$a[$j+1]."','".$a[$j+2]."','".$a[$j+3]."','".$a[$j+4]."','".$a[$j+5]."')";
				mysql_query($sql) or die($sql);
				$z=$data[2];
			}
		break;
		case "t5": //point
			if($data[2]!=$z){
				$sql = "INSERT INTO point(id,item,percent) VALUES ('$id','".$a[$j]."','".$a[$j+1]."')";
				mysql_query($sql) or die($sql);
				$z=$data[2];
			}
		break;
		case "t6": //finance
			if($data[2]!=$z){
				$total[$m] = $a[$j+1]*$a[$j+2];
				$sql = "INSERT INTO finance(id,item,price,number,total,`explain`) VALUES ('$id','".$a[$j]."','".$a[$j+1]."','".$a[$j+2]."','".$total[$m]."','".$a[$j+4]."')";
				mysql_query($sql) or die($sql);
				$z=$data[2];
				$m++;
			}
		break;
		case "t7": //schedul
			if($data[2]!=$z){
				$sql = "INSERT INTO schedul(id,type,number,content,time) VALUES ('$id','1','".$a[$j]."','".$a[$j+1]."','".$a[$j+2]."')";
				mysql_query($sql) or die($sql);
				$z=$data[2];
			}
		break;
		case "t8": //schedul
			if($data[2]!=$z){
				$sql = "INSERT INTO schedul(id,type,number,content,time) VALUES ('$id','2','".$a[$j]."','".$a[$j+1]."','".$a[$j+2]."')";
				mysql_query($sql) or die($sql);
				$z=$data[2];
			}
		break;
		case "t9": //schedul
			if($data[2]!=$z){
				$sql = "INSERT INTO schedul(id,type,number,content,time) VALUES ('$id','3','".$a[$j]."','".$a[$j+1]."','".$a[$j+2]."')";
				mysql_query($sql) or die($sql);
				$z=$data[2];
			}
		break;
		case "t10": //schedul
			if($data[2]!=$z){
				$sql = "INSERT INTO schedul(id,type,number,content,time) VALUES ('$id','4','".$a[$j]."','".$a[$j+1]."','".$a[$j+2]."')";
				mysql_query($sql) or die($sql);
				$z=$data[2];
			}
		break;
	}
	
	switch($multi){ //多選題
		case "service_subject":
			if($data[2]==6){ //other
				$sql = "INSERT INTO issue(id,issue,other) VALUES('$id','".$a[$j]."','".$post['service_subject_text']."')";
				mysql_query($sql) or die($sql);
			}else if($data[2]!="text"){
				$sql = "INSERT INTO issue(id,issue) VALUES('$id','".$a[$j]."')";
				mysql_query($sql) or die($sql);
			}
		break;
		case "service_client":
			if($data[2]==9){ //other
				$sql = "INSERT INTO object(id,object,other) VALUES('$id','".$a[$j]."','".$post['service_client_text']."')";
				mysql_query($sql) or die($sql);
			}else if($data[2]!="text"){
				$sql = "INSERT INTO object(id,object) VALUES('$id','".$a[$j]."')";
				mysql_query($sql) or die($sql);
			}
		break;
	}
}


//insert into db.apply
$amount=0;
for($i=0;$i<count($total);$i++){
	$amount = $amount + $total[$i];
}
$sql = "INSERT INTO apply(id,amount,apply) VALUES ('$id','".$amount."','".$post['apply_price']."')";
mysql_query($sql) or die($sql);

//insert 13
$number = $_POST["number_13"];
$count = $_POST["count_13"];
$servertime = $_POST["servertime_13"];
$frequency = $_POST["frequency_13"];
$record = $_POST["record_13"];
$sql = "INSERT INTO preprocess (id,number,count,servertime,frequency,record) VALUE ('$id','$number','$count','$servertime','$frequency','$record')";
mysql_query($sql) or die($sql);


//insert db.schedul_work
$sql = "INSERT INTO schedul_work(id, stype, work) VALUES ('$id', '1', '".$post["schedul_1"]."')";
mysql_query($sql) or die($sql);
$sql = "INSERT INTO schedul_work(id, stype, work) VALUES ('$id', '2', '".$post["schedul_2"]."')";
mysql_query($sql) or die($sql);
$sql = "INSERT INTO schedul_work(id, stype, work) VALUES ('$id', '3', '".$post["schedul_3"]."')";
mysql_query($sql) or die($sql);
$sql = "INSERT INTO schedul_work(id, stype, work) VALUES ('$id', '4', '".$post["schedul_4"]."')";
mysql_query($sql) or die($sql);

//insert file
$uploaddir = 'upload/';
$filename = basename($_FILES['file']['name']);
$file=explode(".",$filename);
$newfilename = time().rand(0,999).".".$file[1];
$uploadfile = $uploaddir.$newfilename;
//echo "<pre>";
if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
   // echo "Upload OK \n";
	$sql = "INSERT INTO portocal(id,name,filename) VALUES ('$id','$filename','$newfilename')";
	mysql_query($sql) or die($sql);
} else {
    //echo "Upload failed \n";
}
/*
print_r($_FILES);
echo "</pre>";
echo $uploadfile."<br>";
echo $filename;
*/

$temp = $_GET["temp"];
	if($temp==1){
		header("location:editPage_modify.php?id=$id");
	}else{
		header("location:index.php");
	}

?>