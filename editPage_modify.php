
<?
session_start();
if($_SESSION["uid"]=="")
	header("location:loginPage.php");
require("dblink.php");
$uid=$_SESSION["uid"];

$id = $_GET["id"];
$sql = "SELECT * FROM course WHERE id='$id'";
$c = mysql_fetch_array(mysql_query($sql));
$sql = "SELECT * FROM detail WHERE id='$id'";
$d = mysql_fetch_array(mysql_query($sql));

$zz=99;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>服務學習課程申請表</title>
<!-- Load JQuery Libraries from "http://www.google.com/jsapi" -->
<link rel="stylesheet" href="CSS/theme.css" type="text/css"/>
<script type="text/javascript" src="JS/jquery-1.4.2.js"></script>
<script type="text/javascript" src="JS/jquery-ui-1.8.5.custom.min.js"></script>
<script type="text/javascript" src="JS/global_variables.js"></script>
<!--Ajax upload-->
	<link href="AjaxUpload/uploadify.css" rel="stylesheet" type="text/css">
	<link href="AjaxUpload/default.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="AjaxUpload/swfobject.js"></script>
	<script type="text/javascript" src="AjaxUpload/jquery.uploadify.v2.1.0.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	setTimeout("tempsave();", 420000);  //每7分鐘自動存檔
	var test= new Date();
	var year= test.getYear();
	var month=test.getMonth()+1;
	var day= test.getDay();
	var hours= test.getHours();
	var minutes= test.getMinutes();
	var seconds= test.getSeconds();
	var attached_date= String(year)+"-"+String(month)+"-"+String(day)+"-"+String(hours)+"-"+String(minutes)+"-"+String(seconds);
	
	$('#attached_file').uploadify({
		'uploader'	: 'AjaxUpload/uploadify.swf',
		'script'	: 'AjaxUpload/fileupload.jsp',
		'folder'	: 'Download',
		'buttonImg'	: 'AjaxUpload/test.png',
		'buttonText': '瀏覽',
		'width'		: '50',
		'height'	: '30',
		'cancelImg'	: 'AjaxUpload/cancel.png',
		'auto'		: true,
		'method'	: 'GET',
		'scriptData': {'attached_date': attached_date},
        'onSelect': function(e, queueId, fileObj)
        {
			$("#attached_file_name").attr("value",attached_date+"-"+fileObj.name); //<input type="hidden" name="attached_file_name" id="attached_file_name"/>
			
        /*    alert("唯一標識:" + queueId + "\r\n" +
			                  "文件名：" + fileObj.name + "\r\n" +
			                  "文件大小：" + fileObj.size + "\r\n" +
			                  "創建時間：" + fileObj.creationDate + "\r\n" +
			                  "最後修改時間：" + fileObj.modificationDate + "\r\n" +
			                  "文件類型：" + fileObj.type
			            );*/
						
		}
	});
});
</script>

<script type="text/javascript" language="javascript">
window.onload=function(){

    Init_JQueryUI();//初始畫Jquery物件

    $("#tabDiv").tabs();//宣告JQueryUI Tab物件
    $("#ShowMsg").dialog({
            title: '注意!',
            autoOpen: false,
            modal:true,
            show: 'clip',
            hide: 'clip',
            buttons: {
                        確定: function() {
                            $("#ShowMsg").dialog('close');
			}
                    }
        });
   
   $.post("getSession.do","time="+new Date(),function(JSONData){
        //表單修改(如果session的course_id變數沒有指定ID)
        if(JSONData.sessionAttr.course_id!="null"){
		
                $.get("getData.do","action=RecordInfo&time="+new Date(),function(JSON_Data)
				{
                     Insert_filed_data(JSON_Data);//填入資料庫資料
                     AdjustBackgroundHeight();//設定背景高度
                },"json");
        }
        //表單新增(如果session的course_id有指定某ID)
        else{
		
            table_add(table_1_content,empty_array_1);//預設插入一行
            table_add(table_2_content,empty_array_2);
            table_add(table_3_content,empty_array_3);
			table_add(table_4_content,empty_array_4);
            table_add(table_5_content,empty_array_5);
			table_add(table_6_content,empty_array_6);
			table_add(table_7_content,empty_array_7);
        }
    },"json");

    $("input:button,input:submit").button();
    $("input:button").css({ width: '50px', 'padding-top': '0px', 'padding-bottom': '0px' });//設定按鈕大小

}


/******** 將資料庫資料填入"表單"欄位   當資料要修改時 才會用到**********
/*  JSON_DB_data:從資料庫取得的欄位資料(JSON Object)
*/
function Insert_filed_data(JSON_DB_data){
        $("#session_year").attr("value",JSON_DB_data.main[0].session_year);
		$("#apply_date").attr("value",JSON_DB_data.main[0].apply_date);
		
		$("#teacher_id").attr("value",JSON_DB_data.main[0].teacher_id);
        $("#course_name").attr("value",JSON_DB_data.main[0].course_name);
		
        //$("#course_first_or_not").attr("value",JSON_DB_data.main[0].course_first_or_not);
		if((JSON_DB_data.main[0].course_first_or_not)=="1")
			$("input[name='course_first_or_not'][value='1']").attr('checked',true); 
		else if((JSON_DB_data.main[0].course_first_or_not)=="2")
			$("input[name='course_first_or_not'][value='2']").attr('checked',true); 
			
        $("#institute").attr("value",JSON_DB_data.main[0].institute);
        //$("#cousre_attribute").attr(JSON_DB_data.main[0].cousre_attribute);
        if((JSON_DB_data.main[0].cousre_attribute)=="1")
			$("input[name='cousre_attribute'][value='1']").attr('checked',true); 
		else if((JSON_DB_data.main[0].cousre_attribute)=="2")
			$("input[name='cousre_attribute'][value='2']").attr('checked',true);
			
		$("#course_grade").attr("value",JSON_DB_data.main[0].course_grade);
        //$("#required_elective_course").attr("value",JSON_DB_data.main[0].required_elective_course);
        if((JSON_DB_data.main[0].required_elective_course)=="1")
			$("input[name='required_elective_course'][value='1']").attr('checked',true); 
		else if((JSON_DB_data.main[0].required_elective_course)=="2")
			$("input[name='required_elective_course'][value='2']").attr('checked',true); 
		
		$("#course_point").attr("value",JSON_DB_data.main[0].course_point);
		$("#course_point_time").attr("value",JSON_DB_data.main[0].course_point_time);
        //$("#is_assistant").attr("value",JSON_DB_data.main[0].is_assistant);
		if((JSON_DB_data.main[0].is_assistant)=="1")
			$("input[name='is_assistant'][value='1']").attr('checked',true); 
		else if((JSON_DB_data.main[0].is_assistant)=="2")
			$("input[name='is_assistant'][value='2']").attr('checked',true); 
	
        $("#student_quota").attr("value",JSON_DB_data.main[0].student_quota);
        //$("#is_insurance").attr("value",JSON_DB_data.main[0].is_insurance);
		if((JSON_DB_data.main[0].is_insurance)=="1")
			$("input[name='is_insurance'][value='1']").attr('checked',true); 
		else if((JSON_DB_data.main[0].is_insurance)=="2")
			$("input[name='is_insurance'][value='2']").attr('checked',true); 
			
        $("#service_frequency").attr("value",JSON_DB_data.main[0].service_frequency);
        //$("#service_choose").attr("value",JSON_DB_data.main[0].service_choose);
        if((JSON_DB_data.main[0].service_choose)=="1")
			$("input[name='service_choose'][value='1']").attr('checked',true); 
		else if((JSON_DB_data.main[0].service_choose)=="2")
			$("input[name='service_choose'][value='2']").attr('checked',true);
		else if((JSON_DB_data.main[0].service_choose)=="3")
			$("input[name='service_choose'][value='3']").attr('checked',true);
		
		$("#service_times_everytime").attr("value",JSON_DB_data.main[0].service_times_everytime);
        //$("#service_time_intervel").attr("value",JSON_DB_data.main[0].service_time_intervel);
       if((JSON_DB_data.main[0].service_time_intervel)=="1")//兩個都選了
		{
			$("input[name='service_time_intervel'][value='1']").attr('checked',true); 
			$("input[name='service_time_intervel_1'][value='2']").attr('checked',true); 
		}
		else if((JSON_DB_data.main[0].service_time_intervel)=="2")//選了第一個
			$("input[name='service_time_intervel'][value='1']").attr('checked',true); 
		else//選第二個
			$("input[name='service_time_intervel_1'][value='2']").attr('checked',true);
                    
                    
        //service_subject 多選部分            
                    if((JSON_DB_data.main[0].service_subject_1)=="1")
			$("input[name='service_subject_1'][value='1']").attr('checked',true);
                    if((JSON_DB_data.main[0].service_subject_2)=="2")
                        $("input[name='service_subject_2'][value='2']").attr('checked',true);
                    if((JSON_DB_data.main[0].service_subject_3)=="3")
                        $("input[name='service_subject_3'][value='3']").attr('checked',true);
                    if((JSON_DB_data.main[0].service_subject_4)=="4")
                        $("input[name='service_subject_4'][value='4']").attr('checked',true);
                    if((JSON_DB_data.main[0].service_subject_5)=="5")
                        $("input[name='service_subject_5'][value='5']").attr('checked',true);
                    if((JSON_DB_data.main[0].service_subject_6)=="6")
                        $("input[name='service_subject_6'][value='6']").attr('checked',true);
                    
                     
                    
                    
	//service_client 多選部分
                    if((JSON_DB_data.main[0].service_client_1)=="1")
			$("input[name='service_client_1'][value='1']").attr('checked',true);
                    if((JSON_DB_data.main[0].service_client_2)=="2")
                        $("input[name='service_client_2'][value='2']").attr('checked',true);
                    if((JSON_DB_data.main[0].service_client_3)=="3")
                        $("input[name='service_client_3'][value='3']").attr('checked',true);
                    if((JSON_DB_data.main[0].service_client_4)=="4")
                        $("input[name='service_client_4'][value='4']").attr('checked',true);
                    if((JSON_DB_data.main[0].service_client_5)=="5")
                        $("input[name='service_client_5'][value='5']").attr('checked',true);
                    if((JSON_DB_data.main[0].service_client_6)=="6")
                        $("input[name='service_client_6'][value='6']").attr('checked',true);
                    if((JSON_DB_data.main[0].service_client_7)=="7")
                        $("input[name='service_client_7'][value='7']").attr('checked',true);
                    if((JSON_DB_data.main[0].service_client_8)=="8")
                        $("input[name='service_client_8'][value='8']").attr('checked',true);
                    if((JSON_DB_data.main[0].service_client_9)=="9")
                        $("input[name='service_client_9'][value='9']").attr('checked',true);
   
		//$("#need_service_or_not").attr("value",JSON_DB_data.main[0].need_service_or_not);
        if((JSON_DB_data.main[0].need_service_or_not)=="1")
			$("input[name='need_service_or_not'][value='1']").attr('checked',true); 
		else if((JSON_DB_data.main[0].need_service_or_not)=="2")
			$("input[name='need_service_or_not'][value='2']").attr('checked',true);
		
		//$("#is_fix_service_time").attr("value",JSON_DB_data.main[0].is_fix_service_time);
        if((JSON_DB_data.main[0].is_fix_service_time)=="1")
			$("input[name='is_fix_service_time'][value='1']").attr('checked',true); 
		else if((JSON_DB_data.main[0].is_fix_service_time)=="2")
			$("input[name='is_fix_service_time'][value='2']").attr('checked',true);
		
                $("#service_subject_text").attr("value",JSON_DB_data.main[0].service_subject_text);
                $("#service_client_text").attr("value",JSON_DB_data.main[0].service_client_text);
		$("#course_object").attr("value",JSON_DB_data.main[0].course_object);
                $("#course_contents").attr("value",JSON_DB_data.main[0].course_contents);
                $("#teaching_policy").attr("value",JSON_DB_data.main[0].teaching_policy);
		$("#prepare_stages_work").attr("value",JSON_DB_data.main[0].prepare_stages_work);
		$("#service_stages_work").attr("value",JSON_DB_data.main[0].service_stages_work);
		$("#reflection_stages_work").attr("value",JSON_DB_data.main[0].reflection_stages_work);
		$("#celebrate_stages_work").attr("value",JSON_DB_data.main[0].celebrate_stages_work);
		$("#total_week_times").attr("value",JSON_DB_data.main[0].total_week_times);
		$("#method_service_carries").attr("value",JSON_DB_data.main[0].method_service_carries);
		
		$("#anticipated_benefit").attr("value",JSON_DB_data.main[0].anticipated_benefit);
		$("#ContinuousPlan_ConcreteMethod").attr("value",JSON_DB_data.main[0].ContinuousPlan_ConcreteMethod);
		
		$("#attached_file_name").attr("value",JSON_DB_data.main[0].attached_file_name);
		
		$("#total_price_amount").attr("value",JSON_DB_data.main[0].total_price_amount);
		$("#apply_price").attr("value",JSON_DB_data.main[0].apply_price);
  

        var tableArray;
        //sub_table_1   teachers
        for(var i=0;i<JSON_DB_data.teachers.length;i++){
			tableArray=new Array(JSON_DB_data.teachers[i].name,JSON_DB_data.teachers[i].title,JSON_DB_data.teachers[i].workplace,JSON_DB_data.teachers[i].phone,JSON_DB_data.teachers[i].email);
            table_add(table_1_content,tableArray);
        }
        //sub_table_2 assistant
        for(var i=0;i<JSON_DB_data.assistant.length;i++){
			tableArray=new Array(JSON_DB_data.assistant[i].name,JSON_DB_data.assistant[i].title,JSON_DB_data.assistant[i].workplace,JSON_DB_data.assistant[i].phone,JSON_DB_data.assistant[i].email);
            table_add(table_2_content,tableArray);
        }
        //sub_table_3  cooperating_organization
        for(var i=0;i<JSON_DB_data.cooperating_organization.length;i++){
			tableArray=new Array(JSON_DB_data.cooperating_organization[i].organization,JSON_DB_data.cooperating_organization[i].name,JSON_DB_data.cooperating_organization[i].phone,JSON_DB_data.cooperating_organization[i].email,JSON_DB_data.cooperating_organization[i].address);
            table_add(table_3_content,tableArray);
        }
		//sub_table_4  lectures_training
        for(var i=0;i<JSON_DB_data.lectures_training.length;i++){
			tableArray=new Array(JSON_DB_data.lectures_training[i].items ,JSON_DB_data.lectures_training[i].date,JSON_DB_data.lectures_training[i].place,JSON_DB_data.lectures_training[i].contents,JSON_DB_data.lectures_training[i].lecturer,JSON_DB_data.lectures_training[i].time);
            table_add(table_4_content,tableArray);
        }
		//sub_table_5   comment_quantity
        for(var i=0;i<JSON_DB_data.comment_quantity.length;i++){
			tableArray=new Array(JSON_DB_data.comment_quantity[i].items,JSON_DB_data.comment_quantity[i].percentage);
            table_add(table_5_content,tableArray);
        }
		//sub_table_6   funds_budget
        for(var i=0;i<JSON_DB_data.funds_budget.length;i++){
			tableArray=new Array(JSON_DB_data.funds_budget[i].items, JSON_DB_data.funds_budget[i].unit_price, JSON_DB_data.funds_budget[i].amount, JSON_DB_data.funds_budget[i].total_price, JSON_DB_data.funds_budget[i].use_explanation);
			table_add(table_6_content,tableArray);
        }
		//sub_table_7   every_week_flow
        for(var i=0;i<JSON_DB_data.every_week_flow.length;i++){
            tableArray=new Array(JSON_DB_data.every_week_flow[i].items, JSON_DB_data.every_week_flow[i].contents, JSON_DB_data.every_week_flow[i].times);
			table_add(table_7_content,tableArray);
        }
}
/*************************
	1. 用來計算總時數和總金額 
	2.table_id 參考global_variables.js
	3. 用table6和table7來計算新增了幾個表單
*************************/
function amount_time()
{
	var count_time= 0;
	for(var i=0;i<$("input[name='t7_times']").length;i++)
	{	
		//alert("test="+$("input[name='t7_times'].get(i).value)");
		count_time= count_time+parseInt($("input[name='t7_times']").get(i).value);	
	}
	$("#total_week_times").attr("value",count_time);
}
function amount_money()
{
	var count_momey= 0;
	var errorMSG="";
    var error_flag=false;
	
	$("input[id='t6_amount'],input[id='t6_amount']").css({color: 'black'});
		
	$("input[id='t6_unit_price'],input[id='t6_unit_price']").css({color: 'black'});
	for(var i=0;i<$("input[id='t6_tota_price']").length;i++)
	{
		
		if( $('#test1').val == "7" )
	{
		if( $("input[id='t6_unit_price']").get(i).value < 120 )
		{
			errorMSG+= "most > 120";
			error_flag=true;
		}
	}
		if(!isInteger($("input[id='t6_amount']").get(i).value)  || !isInteger($("input[id='t6_unit_price']").get(i).value))
		{
			$("input[id='t6_amount'],input[id='t6_amount']").css({color: 'red'});
            $("input[id='t6_unit_price'],input[id='t6_unit_price']").css({color: 'red'});
			errorMSG+="'單價'、'數量'，必須為數字!<br/>文字說明請放置'用途說明'<br/>";
			error_flag=true;
			
			if(error_flag){
			$("#ShowMsg").get(0).innerHTML=errorMSG;
			$("#ShowMsg").dialog('open');
			}
			else
				$("#register_form").submit();
		}
		else
		{
			var count= ($("input[id='t6_unit_price']").get(i).value)*($("input[id='t6_amount']").get(i).value);
			$("input[id='t6_tota_price']")[i].value=count;
			count_momey= count_momey +  parseInt($("input[id='t6_tota_price']").get(i).value);
		}
	}
	
	$("#total_price_amount").attr("value",count_momey);
}

/******** 動態新增表單中表格的欄位 **********
 *  JSONtable:欄位定義檔(JSON Object)
 *  DataArray:表格內容(String Array)
*/
var k=0;
function table_add(JSONtable,DataArray){
	
	k++;
	var element_tr,element_td,element_input; 
	element_tr=document.createElement("tr");
	for(var i=0;i<JSONtable.columns.length;i++)
	{
            element_td=document.createElement("td");
            if(JSONtable.columns[i].type=="textarea"){
                element_input=document.createElement("textarea");
                $(element_input).attr("rows","2");
                $(element_input).attr("style","width:"+$("#sub_table_"+JSONtable.table_id+" tr th").get(i).getAttribute("width")+"px");//設定寬度
                element_input.name=JSONtable.columns[i].name;
                $(element_input).append(DataArray[i]);
                $(element_td).append(element_input);
                
            }
            else if(JSONtable.columns[i].type=="select"){
                element_input=document.createElement("select");
                element_input.name=JSONtable.columns[i].name+"_"+k;
				
                var element_option;
                for(var j=0;j<JSONtable.columns[i].value.length;j++)//這邊會跑18次
                {
                    element_option=document.createElement("option");
				
					if(j==parseInt(DataArray[i]))
						$(element_option).attr("selected", "true");
						
                    element_option.value=JSONtable.columns[i].value[j];
                    $(element_option).append(JSONtable.columns[i].text[j]);
                    $(element_input).append(element_option);
                    $(element_td).append(element_input);
                }
            }
            else{
                element_input=document.createElement("input");
                $(element_input).attr("style","width:"+$("#sub_table_"+JSONtable.table_id+" tr th").get(i).getAttribute("width")+"px");//設定寬度
                element_input.type=JSONtable.columns[i].type;
                element_input.name=JSONtable.columns[i].name+"_"+k;
                element_input.value=DataArray[i];
				element_input.id=JSONtable.columns[i].id;
                $(element_td).append(element_input);
            }
             $(element_tr).append(element_td);
	}
	
	element_td=document.createElement("td");
	element_input=document.createElement("input");
	$(element_input).attr("type","button");
	$(element_input).attr("value","移除");
        $(element_input).click(function(event)
        {
            var element = event.target;
            var td = element.parentNode;
            var target = td.parentNode;
            var table = target.parentNode;
            $("#ShowMsg2").dialog({
                title: '注意!',
                autoOpen: true,
                modal:true,
                show: 'clip',
                hide: 'clip',
                buttons: {
                        刪除: function() {                          
                            $(target).remove();
                            amount_time();
                            amount_money();
                            $("#ShowMsg2").dialog('close');
			},
                        取消: function() {
                            $("#ShowMsg2").dialog('close');
			}
                    }
                });
        });

	$(element_td).append(element_input);
	$(element_tr).append(element_td);
	
	$("#sub_table_"+JSONtable.table_id).append(element_tr);
	$("input:button").button();
	$("input:button").css({ width: '50px', 'padding-top': '0px', 'padding-bottom': '0px' });//設定按鈕大小
	
		
}

//上傳
function upload(){
$sql = "SELECT * FROM portocal WHERE id='$id'";
								$f = mysql_fetch_array(mysql_query($sql));
								
}


/******** 欄位檢查 **********
*/
function submit_check(){

    var errorMSG="";
    var error_flag=false;
	
	$("#t_total_week_times,#total_week_times").css({color: 'black'});
        $("#t_course_point,#course_point").css({color: 'black'});
        $("#t_student_quota,#student_quota").css({color: 'black'});
	
	$("#t_course_grade,#course_grade").css({color: 'black'});
	$("#t_course_point_time,#course_point_time").css({color: 'black'});
	$("#t_service_frequency,#service_frequency").css({color: 'black'});
        $("#service_times_everytime,#service_times_everytime").css({color: 'black'});

	if($("#total_week_times").val()<18){
        $("#t_total_week_times,#total_week_times").css({color: 'red'});
        errorMSG+="'各階段流程總時數'，合計須超過18小時!<br/>";
        error_flag=true;
    }
	/*if(!isInteger($("#course_grade").val())){
        $("#course_grade,#course_grade").css({color: 'red'});
        errorMSG+="'開課年級'，必須為整數!<br/>";
        error_flag=true;
		
    }*/
        if(!isInteger($("#course_point").val())){
        $("#t_course_point,#course_point").css({color: 'red'});
        errorMSG+="'學分數'，必須為整數!<br/>";
        error_flag=true;
    }
	if(!isInteger($("#course_point_time").val())){
        $("#course_point_time,#course_point_time").css({color: 'red'});
        errorMSG+="'每周授課時數'，必須為整數!<br/>";
        error_flag=true;
    }
    if(!isInteger($("#student_quota").val())){
        $("#t_student_quota,#student_quota").css({color: 'red'});
        errorMSG+="'修課人數'，必須為整數!<br/>";
        error_flag=true;
    }
	if(typeof($("input[name='course_first_or_not']:checked").val())== "undefined"){
		$("#course_first_or_not,#course_first_or_not").css({color: 'red'});
        errorMSG+="'本課程開設次數*'，必須填寫!<br/>";
        error_flag=true;
	}
	if(typeof($("input[name='cousre_attribute']:checked").val())== "undefined"){
		$("#cousre_attribute,#cousre_attribute").css({color: 'red'});
        errorMSG+="'課程屬性'，必須填寫!<br/>";
        error_flag=true;
	}
	if(typeof($("input[name='required_elective_course']:checked").val())== "undefined"){
		$("#required_elective_course,#required_elective_course").css({color: 'red'});
        errorMSG+="'必/選修'，必須填寫!<br/>";
        error_flag=true;
	}
	if(typeof($("input[name='is_assistant']:checked").val())== "undefined"){
		$("#is_assistant,#is_assistant").css({color: 'red'});
        errorMSG+="'是否配置教學助理'，必須填寫!<br/>";
        error_flag=true;
	}
	if(typeof($("input[name='is_insurance']:checked").val())== "undefined"){
        errorMSG+="'是否辦理保險'，必須填寫!<br/>";
        error_flag=true;
	}
	if(typeof($("input[name='service_choose']:checked").val())== "undefined"){
        errorMSG+="'服務單位如何擇定'，必須填寫!<br/>";
        error_flag=true;
	}
	if(!($("input[name='service_time_intervel']").is(":checked")) && !($("input[name='service_time_intervel_1']").is(":checked")) ){
        errorMSG+="'服務時段'，必須填寫!<br/>";
        error_flag=true;
	}
	if(typeof($("input[name='is_fix_service_time']:checked").val())== "undefined"){
        errorMSG+="'是否有固定服務時間'，必須填寫!<br/>";
        error_flag=true;
	}
        if(!($("input[name='service_subject_1']").is(":checked")) && !($("input[name='service_subject_2']").is(":checked"))&& !($("input[name='service_subject_3']").is(":checked"))&& !($("input[name='service_subject_4']").is(":checked"))&& !($("input[name='service_subject_5']").is(":checked"))&& !($("input[name='service_subject_6']").is(":checked")) ){
        errorMSG+="'服務議題'，必須填寫!<br/>";
        error_flag=true;
	}
        if(!($("input[name='service_client_1']").is(":checked")) && !($("input[name='service_client_2']").is(":checked"))&& !($("input[name='service_client_3']").is(":checked"))&& !($("input[name='service_client_4']").is(":checked"))&& !($("input[name='service_client_5']").is(":checked"))&& !($("input[name='service_client_6']").is(":checked"))&& !($("input[name='service_client_7']").is(":checked"))&& !($("input[name='service_client_8']").is(":checked"))&& !($("input[name='service_client_9']").is(":checked")) ){
        errorMSG+="'服務對象'，必須填寫!<br/>";
        error_flag=true;
	}
    if(error_flag){
        $("#ShowMsg").get(0).innerHTML=errorMSG;
        $("#ShowMsg").dialog('open');
    }
    else
       $("#register_form").submit();
	   
}

 





function tempsave(){

	$("#register_form").attr("action", "modify.php?temp=1").submit();
}


function isInteger(val)
{
    if(val==null)
    {
        return false;
    }
    if (val.length==0)
    {
        return false;
    }
    for (var i = 0; i < val.length; i++)
    {
        var ch = val.charAt(i)
        if (i == 0 && ch == "-")
        {
            continue
        }
        if (ch < "0" || ch > "9")
        {
            return false
        }
    }
    return true
}

function clean(id){
$("#"+id).attr("value","");
}

//移除按鈕
function  del_element(elem) {
	
	 $("#ShowMsg2").dialog({
                title: '注意!',
                autoOpen: true,
                modal:true,
                show: 'clip',
                hide: 'clip',
                buttons: {
                        刪除: function() {                          
  							var row = $(elem).parent().parent();
							row.fadeOut('normal', function() {
    						row.remove();
  							});
                            $("#ShowMsg2").dialog('close');
			},
                        取消: function() {
                            $("#ShowMsg2").dialog('close');
			}
                    }
                });

}
</script>
<style>
.error_text{
        color: red;
}
.correct_text{
        color: black;
}
#tabDiv{
    width: 95%;
    font-size: 14px;
}

</style>
</head>

<body>
<div class="page_container ui-state-error">
	<div class="page_header"></div>
	<div id="menuDiv" class="menuDiv ui-widget-header">
		<table width="100%">
			<tr>
				<td>
					<a href="index.php" class="menu_item">返回</a>
					<button class="menu_item" onclick="submit_check()">存檔送出</button>            
				</td>
			</tr>
		</table>
	</div>
	<div class="data_content">
		<!--JQueryUI Tabs -->
		<div id="tabDiv" class="data_content">
		   <form id="register_form" name="register_form" method="post" action="modify.php" enctype="multipart/form-data">
				<!---------Tab 1----------------------------------------------------------------------------------------------------------------->
				<div id="tab_1">
					<input type="hidden" name="id" id="id" value="<? echo $id; ?>" />
					<input name="teacher_id" type="hidden" id="teacher_id" value="<? echo $uid; ?>"/>
					
					<table  width="92%" border="1" cellspacing="0">
		       		  <tr>
			                <th colspan="6" scope="col" class="field_title ui-state-highlight">國立成功大學服務學習課程計畫書</th>
			            </tr>
                        <tr>
			                <th colspan="6" scope="col" class="ui-state-highlight">一、課程基本資訊</th>
			            </tr>
			            <tr>
			                <th width="17%" class="field_title ui-state-highlight">課程序號</th>
			                <td width="33%"><? echo $id; ?></td>
                            <th width="17%" class="field_title ui-state-highlight">申請學年度(例:991)</th>
			                <td width="33%"><input type="text" name="session_year" id="session_year" value="<?php echo $c["year"]; ?>"/></td>
			            </tr>
			            <tr>
			                <th width="17%" class="field_title ui-state-highlight">課程名稱</th>
			                <td width="33%"><input type="text" name="course_name" id="course_name" value="<?php echo $c["name"]; ?>"/></td>
			                <th width="17%" class="field_title ui-state-highlight">本課程開設次數</th>
			                <td width="33%">
								<input type=radio  value="1" name="course_first_or_not" <? if($c["first"]==1) echo "checked=\"checked\"";?> >首次開設</input><br />
								<input type=radio  value="2" name="course_first_or_not" <? if($c["first"]==2) echo "checked=\"checked\"";?> >非首次開設</input>
					</td>
			            </tr>
						<tr>
			                <th width="17%" class="field_title ui-state-highlight">開課單位</th>
			                <td width="33%"><input type="text" name="institute" id="institute" value="<?php echo $c["institute"]; ?>" /></td>
			                <th width="17%" class="field_title ui-state-highlight">課程屬性</th>
			                <td width="33%">
								<input type=radio  value="1" name="cousre_attribute" <? if($c["attribute"]==1) echo "checked=\"checked\""; ?>>一般性服務學習</input><br />
                                                                <input type=radio  value="2" name="cousre_attribute" <? if($c["attribute"]==2) echo "checked=\"checked\""; ?> >融入服務學習內涵之通識課程或專業課程</input><br />
								<input type=radio  value="3" name="cousre_attribute" <? if($c["attribute"]==3) echo "checked=\"checked\""; ?> >共同議題(社區)融入服務學習內涵之通識或專業課程</input>
							</td>
			            </tr>
					</table>
				</div><!--      tab_1 end    -->
				<!---------Tab 2---------------------------------------------------------------------------->
				<div id="tab_2">
					<table width="92%" border="1" cellspacing="0">
						<tr>
                            <td colspan="5" width="100%">
                                <table id="sub_table_1" width="100%" border="1" cellspacing="0" class="sub_table" >
                                    <tr id="sub_titile_1" class="field_title ui-state-highlight">
                                        <th width="83">任課老師</th>
                                        <th width="82">職稱</th>
                                        <th width="150">系所</th>
                                        <th width="80">分機</th>
                                        <th width="370">e-mail</th>
                                        <th width="40"></th>
                                    </tr>
                                    
                                     <?
										$sql="SELECT * FROM teacher WHERE id='$id' and type='1' ORDER BY Tid ASC";
										$r = mysql_query($sql);
										while($t=mysql_fetch_array($r)){
											echo "<tr>";
											echo "<td><input style=\"width:83px\" type=\"text\" name=\"t1_name_".$zz."\" value=\"".$t["name"]."\" ></td>";
											echo "<td><input style=\"width:82px\" type=\"text\" name=\"t1_title_".$zz."\" value=\"".$t["title"]."\" ></td>";
											echo "<td><input style=\"width:150px\" type=\"text\" name=\"t1_workplace_".$zz."\" value=\"".$t["department"]."\" ></td>";
											echo "<td><input style=\"width:80px\" type=\"text\" name=\"t1_phone_".$zz."\" value=\"".$t["phone"]."\" ></td>";
											echo "<td><input style=\"width:370px\" type=\"text\" name=\"t1_email_".$zz."\" value=\"".$t["email"]."\" ></td>";
											echo "<td><input style=\"width:40px\" type=\"button\" value=\"移除\" onclick=\"del_element(this)\" ></td>";
											echo "</tr>";
											$zz--;
										}
									?>
                                    
                                
                                </table>
                                <input type="button" onclick="table_add(table_1_content,empty_array_1)" value="新增"/>
                            </td>
                       </tr>
                        <tr>
                            <td colspan="5" width="100%">
                                <table id="sub_table_2" width="100%" border="1" cellspacing="0" class="sub_table" >
                                    <tr id="sub_table_2" class="field_title ui-state-highlight">
                                         <th width="83">教學助理</th>
                                        <th width="82">職稱</th>
                                        <th width="150">系所</th>
                                        <th width="80">分機</th>
                                        <th width="370">e-mail</th>
                                        <th width="40"></th>
                                    </tr>
                                    
                                     <?
										$sql="SELECT * FROM teacher WHERE id='$id' and type='2' ORDER BY Tid ASC";
										$r = mysql_query($sql);
										while($t=mysql_fetch_array($r)){
											echo "<tr>";
											echo "<td><input style=\"width:83px\" type=\"text\" name=\"t2_name_".$zz."\" value=\"".$t["name"]."\" ></td>";
											echo "<td><input style=\"width:82px\" type=\"text\" name=\"t2_title_".$zz."\" value=\"".$t["title"]."\" ></td>";
											echo "<td><input style=\"width:150px\" type=\"text\" name=\"t2_workplace_".$zz."\" value=\"".$t["department"]."\" ></td>";
											echo "<td><input style=\"width:80px\" type=\"text\" name=\"t2_phone_".$zz."\" value=\"".$t["phone"]."\" ></td>";
											echo "<td><input style=\"width:370px\" type=\"text\" name=\"t2_email_".$zz."\" value=\"".$t["email"]."\" ></td>";
											echo "<td><input style=\"width:40px\" type=\"button\" value=\"移除\" onclick=\"del_element(this)\" ></td>";
											echo "</tr>";
											$zz--;
										}
									?>
                                    
                                </table>
                                <input type="button" onclick="table_add(table_2_content,empty_array_2)" value="新增"/>
                            </td>
                        </tr>
					</table>
				</div><!--      tab_2 end    -->
				<div id="tab_3">
					<table width="92%" border="1" cellspacing="0">
						<tr>
							<th width="20%" class="field_title ui-state-highlight">開課年級</th>
							<td width="31%"><input type="text" name="course_grade" id="course_grade" value="<?php echo $c["grade"]; ?>"/></td>
							<th width="25%" class="field_title ui-state-highlight">必/選修</th>
							<td width="29%">
							<input type=radio  value="1" name="required_elective_course" <?php if($c["subject"]==1) echo "checked=\"checked\"";  ?> >必修</input>
							<input type=radio  value="2" name="required_elective_course" <?php if($c["subject"]==2) echo "checked=\"checked\"";  ?>>選修</input>
							</td>
						</tr>
						<tr>
                                                        <th class="field_title ui-state-highlight">學分數</th>
                                                        <td>
                                                            <input width="50" type="text" name="course_point" id="course_point" size="5" value="<?php echo $c["point"]; ?>"/>
                                                        </td>
                                                        <th class="field_title ui-state-highlight">是否配置教學助理</th>
                                                        <td>
                                                            <input type=radio  value="1" name="is_assistant" <?php if($c["assistant"]==1) echo "checked=\"checked\""; ?> >是</input>
                                                            <input type=radio  value="2" name="is_assistant" <?php if($c["assistant"]==2) echo "checked=\"checked\""; ?> >否</input>
                                                        </td>
                                                </tr>
						<tr>
                                                        <th class="field_title ui-state-highlight">每週授課時數</th>
                                                        <td>
                                                            <input name="course_point_time" type="text" id="course_point_time"  width="50" size="5" value="<?php echo $c["weektime"]; ?>"/>
                                                        </td>
							<th class="field_title ui-state-highlight">是否辦理保險</th>
							<td>
							<input type=radio  value="1" name="is_insurance" <?php if($c["insurance"]==1) echo "checked=\"checked\""; ?> >是</input>
							<input type=radio  value="2" name="is_insurance"  <?php if($c["insurance"]==2) echo "checked=\"checked\""; ?> >否</input>
							</td>
						</tr>
						<tr>
							<th class="field_title ui-state-highlight">預定修課人數</th>
							<td><input type="text" name="student_quota" id="student_quota" value="<?php echo $c["quota"]; ?>"/></td>
							<th width="25%" class="field_title ui-state-highlight">服務單位如何擇定</th>
							<td width="29%">
							<input type=radio  value="1" name="service_choose" <? 	if($c["choose"]==1) echo "checked=\"checked\""; ?>>學生</input>
							<input type=radio  value="2" name="service_choose" <? 	if($c["choose"]==2) echo "checked=\"checked\""; ?>>教師</input>
							<input type=radio  value="3" name="service_choose" <? 	if($c["choose"]==3) echo "checked=\"checked\""; ?>>學校安排</input>
							</td>
						</tr>
						<tr>
							<th width="15%" class="field_title ui-state-highlight">每學期服務次數</th>
							<td width="31%"><input type="text" name="service_frequency" id="service_frequency" value="<?php echo $c["frequency"]; ?>" /></td>
							<th width="25%" class="field_title ui-state-highlight">服務時段</th>
							<td width="29%">
                            
                            <?
								$sql = "SELECT * FROM period WHERE id='$id'";
								$r = mysql_query($sql);
								while($p=mysql_fetch_array($r)){
									if($p[1]==1)
										$mst[1]=1;
									if($p[1]==2)
										$mst[2]=1;;
								}
							?>
                            
							<input type=checkbox  value="1" name="service_time_intervel" <? 	if($mst[1]==1) echo "checked=\"checked\""; ?> >課堂</input>
							<input type=checkbox  value="2" name="service_time_intervel_1" <? 	if($mst[2]==1) echo "checked=\"checked\""; ?> >課餘時間</input>
							</td>
						</tr>
						<tr>
							<th width="15%" class="field_title ui-state-highlight">每次服務時數</th>
							<td width="31%"><input type="text" name="service_times_everytime" id="service_times_everytime"  value="<?php echo $c["everytime"]; ?>" /></td>
							<th width="25%" class="field_title ui-state-highlight">是否有固定服務時間</th>
							<td width="29%">
							<input type=radio  value="1" name="is_fix_service_time" <? if($c["fix"]==1) echo "checked=\"checked\""; ?> >是</input>
							<input type=radio  value="2" name="is_fix_service_time" <? if($c["fix"]==2) echo "checked=\"checked\""; ?> >否</input>
							</td>
						</tr>
					</table>
				</div><!--      tab_3 end    -->
                                
                                <div id="tab_14">
                                    <table width="92%" border="1" cellspacing="0">
                                                 <tr>
                                                        <th width="20%" rowspan="2" class="field_title ui-state-highlight">服務議題</th>

							<?
								$sql = "SELECT * FROM issue WHERE id='$id'";
								$r = mysql_query($sql);
								while($i=mysql_fetch_array($r)){
									if($i[1]==1)
										$ft[1]=1;
									else if($i[1]==2)
										$ft[2]=1;
									else if($i[1]==3)
										$ft[3]=1; 
									else if($i[1]==4)
										$ft[4]=1;
									else if($i[1]==5)
										$ft[5]=1; 
									else if($i[1]==6){
										$ft[6]=1;
										$ft[7]=$i[2];
									}
								}
							?>
                            <td width="80%">
							<input type=checkbox  value="1" name="service_subject_1" <? 	if($ft[1]==1) echo "checked=\"checked\""; ?>>課輔</input>
							<input type=checkbox  value="2" name="service_subject_2" <? 	if($ft[2]==1) echo "checked=\"checked\""; ?> >志工培育</input>
                                                        <input type=checkbox  value="3" name="service_subject_3" <? 	if($ft[3]==1) echo "checked=\"checked\""; ?> >弱勢關懷與陪伴</input>
							<input type=checkbox  value="4" name="service_subject_4" <? 	if($ft[4]==1) echo "checked=\"checked\""; ?> >節能減碳/環保/保育</input>
                                                        <input type=checkbox  value="5" name="service_subject_5" <? 	if($ft[5]==1) echo "checked=\"checked\""; ?> >醫療服務</input>
                                                         
                                                        </td>
						</tr>
                                                <tr>
                                                    <td>
                                                        <input type=checkbox  value="6" name="service_subject_6" <? 	if($ft[6]==1) echo "checked=\"checked\""; ?> >其它</input>
                                                        <textarea id="service_subject_text" name="service_subject_text" cols="70" rows="1" ><? echo $ft[7]; ?></textarea>
                                                    </td>
                                                </tr>
                                    </table>
                                </div><!-- tab13 end -->
                                
                                <div id="tab_13">
                                    <table width="92%" border="1" cellspacing="0">
                                                 <tr>
                                                        <th width="20%" rowspan="2" class="field_title ui-state-highlight">服務對象</th>

							<?
								$sql = "SELECT * FROM object WHERE id='$id'";
								$r = mysql_query($sql);
								while($i=mysql_fetch_array($r)){
									if($i[1]==1)
										$sc[1]=1;
									else if($i[1]==2)
										$sc[2]=1;
									else if($i[1]==3)
										$sc[3]=1; 
									else if($i[1]==4)
										$sc[4]=1;
									else if($i[1]==5)
										$sc[5]=1; 
									else if($i[1]==6)
										$sc[6]=1; 
									else if($i[1]==7)
										$sc[7]=1;
									else if($i[1]==8)
										$sc[8]=1;
									else if($i[1]==9){
										$sc[9]=1;
										$sc[10]=$i[2];
									}
								}
							?>
                            
                            <td width="80%">
							<input type=checkbox  value="1" name="service_client_1" <? 	if($sc[1]==1) echo "checked=\"checked\""; ?>>新移民</input>
							<input type=checkbox  value="2" name="service_client_2" <? 	if($sc[2]==1) echo "checked=\"checked\""; ?> >老人</input>
                                                        <input type=checkbox  value="3" name="service_client_3" <? 	if($sc[3]==1) echo "checked=\"checked\""; ?> >身心障礙</input>
							<input type=checkbox  value="4" name="service_client_4" <? 	if($sc[4]==1) echo "checked=\"checked\""; ?> >兒童青少年</input>
                                                        <input type=checkbox  value="5" name="service_client_5" <? 	if($sc[5]==1) echo "checked=\"checked\""; ?> >國際服務</input>
                                                        <input type=checkbox  value="6" name="service_client_6" <? 	if($sc[6]==1) echo "checked=\"checked\""; ?> >成大校園</input>
                                                        <input type=checkbox  value="7" name="service_client_7" <? 	if($sc[7]==1) echo "checked=\"checked\""; ?> >社區經營</input>
                                                        <input type=checkbox  value="8" name="service_client_8" <? 	if($sc[8]==1) echo "checked=\"checked\""; ?> >機構</input>
                                                        </td>
						</tr>
                                                <tr>
                                                        <td>
                                                            <input type=checkbox  value="9" name="service_client_9" <? 	if($sc[9]==1) echo "checked=\"checked\""; ?> >其他</input>
                                                            <textarea id="service_client_text" name="service_client_text" cols="70" rows="1" ><? echo $sc[10]; ?></textarea>
                                                        </td>
                                                </tr>
                                    </table>
                                </div><!-- tab13 end -->
                                
				<div id="tab_4">
					<table width="92%" border="1" cellspacing="0" class="ui-state-highlight">
                                                <tr>
							<td><strong>二、課程目標</strong></td></tr>
                            <tr>
                            <td><textarea id="course_object" name="course_object" cols="90" rows="5" ><?php echo $d["object"]; ?></textarea></td>
						</tr>
						<tr>
							<td><strong>三、課程內容及特色</strong></td></tr>
                            <tr>
                            <td><textarea id="course_contents" name="course_contents" cols="90" rows="5"><?php echo $d["content"]; ?></textarea></td>
						</tr>
						<tr>
							<td><strong>四、教學策略</strong> (例如：如何透過課堂專業學習達成社區服務之目的、安排課程及服務比重、如何培養學生服務倫理，及服務所具備之專業能力說明…等)</td></tr>
                            <tr>
                            <td><textarea id="teaching_policy" name="teaching_policy" cols="90" rows="5" ><?php echo $d["strategy"]; ?></textarea></td>
						</tr>
                	</table>
                </div>
               
                <div id="tab_5">
                
                
                	<table width="92%" border="1" cellspacing="0">
                        <tr>
                       		<td colspan="4" class="ui-state-highlight"><strong>五、各階段工作及流程</strong> (以每學期18週計算)</td>
                        </tr>
                        <tr>
                            <td width="5%" class="ui-state-highlight">準備</td>
                            <td width="25%">準備階段工作規劃<textarea id="schedul_1" name="schedul_1" cols="25"   rows="5"  ><? echo $swshow[1] ?></textarea></td>
                          <td width="70%">
                            	<table id="sub_table_7" width="100%" border="1" cellspacing="0" class="sub_table">
                                    <tr id="sub_table_7" class="field_title ui-state-highlight">
                                        <th width="50">次數</th>
                                        <th width="300">內容</th>
                                        <th width="50">總時數</th>
                                        <th width="40"></th>
                                    </tr>
                                    
                                    <?
										$sql = "SELECT * FROM schedul WHERE id='$id' and type='1' ORDER BY Sid ASC";
										$r = mysql_query($sql) or die($sql);
										while($s=mysql_fetch_array($r)){
											echo "<tr>";
											echo "<td><input type=\"text\" name=\"t7_items_".$zz."\" value=\"".$s["number"]."\" size=\"5\"></td>";
											echo "<td><input type=\"text\" name=\"t7_content_".$zz."\" value=\"".$s["content"]."\" size=\"30\"></td>";
											echo "<td><input type=\"text\" name=\"t7_times_".$zz."\" value=\"".$s["time"]."\" size=\"5\"></td>";
											echo "<td><input type=\"button\" value=\"移除\" onclick=\"del_element(this)\" ></td>";
											echo "</tr>";
											$zz--;
										}
									  ?>
                                    
                                </table>   
                                 <input type="button" onclick="table_add(table_7_content,empty_array_7)" value="新增" /> 
                            </td>
                           
                        </tr>
                        <tr>
                            <td class="ui-state-highlight">服務</td>
                            <td>服務階段工作規劃<textarea id="schedul_2" name="schedul_2" cols="25"   rows="5"  ><? echo $swshow[2] ?></textarea></td>
                          <td>
                            	<table id="sub_table_8" width="100%" border="1" cellspacing="0" class="sub_table">
                                    <tr id="sub_table_8" class="field_title ui-state-highlight">
                                        <th width="50">次數</th>
                                        <th width="370">內容</th>
                                        <th width="50">總時數</th>
                                        <th width="40"></th>
                                    </tr>
                                    
                                    <?
										$sql = "SELECT * FROM schedul WHERE id='$id' and type='2' ORDER BY Sid ASC";
										$r = mysql_query($sql) or die($sql);
										while($s=mysql_fetch_array($r)){
											echo "<tr>";
											echo "<td><input type=\"text\" name=\"t8_items_".$zz."\" value=\"".$s["number"]."\" size=\"5\"></td>";
											echo "<td><input type=\"text\" name=\"t8_content_".$zz."\" value=\"".$s["content"]."\" size=\"30\"></td>";
											echo "<td><input type=\"text\" name=\"t8_times_".$zz."\" value=\"".$s["time"]."\" size=\"5\"></td>";
											echo "<td><input type=\"button\" value=\"移除\" onclick=\"del_element(this)\" ></td>";
											echo "</tr>";
											$zz--;
										}
									  ?>
                                    
                                </table>   
                                 <input type="button" onclick="table_add(table_8_content,empty_array_8)" value="新增" /> 
                            </td>
                            </td>
                        </tr>
                        <tr>
                            <td class="ui-state-highlight">反省</td>
                            <td>反省階段工作規劃<textarea id="schedul_3" name="schedul_3" cols="25"   rows="5"  ><? echo $swshow[3] ?></textarea></td>
                          <td>
                            	<table id="sub_table_9" width="100%" border="1" cellspacing="0" class="sub_table">
                                    <tr id="sub_table_9" class="field_title ui-state-highlight">
                                        <th width="50">次數</th>
                                        <th width="370">內容</th>
                                        <th width="50">總時數</th>
                                        <th width="40"></th>
                                    </tr>
                                    
                                    <?
										$sql = "SELECT * FROM schedul WHERE id='$id' and type='3' ORDER BY Sid ASC";
										$r = mysql_query($sql) or die($sql);
										while($s=mysql_fetch_array($r)){
											echo "<tr>";
											echo "<td><input type=\"text\" name=\"t9_items_".$zz."\" value=\"".$s["number"]."\" size=\"5\"></td>";
											echo "<td><input type=\"text\" name=\"t9_content_".$zz."\" value=\"".$s["content"]."\" size=\"30\"></td>";
											echo "<td><input type=\"text\" name=\"t9_times_".$zz."\" value=\"".$s["time"]."\" size=\"5\"></td>";
											echo "<td><input type=\"button\" value=\"移除\" onclick=\"del_element(this)\" ></td>";
											echo "</tr>";
											$zz--;
										}
									  ?>
                                    
                                </table>   
                                 <input type="button" onclick="table_add(table_9_content,empty_array_9)" value="新增" /> 
                            </td>
                        </tr>
                        <tr>
                            <td class="ui-state-highlight">慶賀</td>
                            <td>慶賀階段工作規劃<textarea id="schedul_4" name="schedul_4" cols="25"   rows="5"  ><? echo $swshow[4] ?></textarea></td>
                          <td>
                            	<table id="sub_table_10" width="100%" border="1" cellspacing="0" class="sub_table">
                                    <tr id="sub_table_10" class="field_title ui-state-highlight">
                                        <th width="50">次數</th>
                                        <th width="370">內容</th>
                                        <th width="50">總時數</th>
                                        <th width="40"></th>
                                    </tr>
                                    
                                    <?
										$sql = "SELECT * FROM schedul WHERE id='$id' and type='4' ORDER BY Sid ASC";
										$r = mysql_query($sql) or die($sql);
										while($s=mysql_fetch_array($r)){
											echo "<tr>";
											echo "<td><input type=\"text\" name=\"t10_items_".$zz."\" value=\"".$s["number"]."\" size=\"5\"></td>";
											echo "<td><input type=\"text\" name=\"t10_content_".$zz."\" value=\"".$s["content"]."\" size=\"30\"></td>";
											echo "<td><input type=\"text\" name=\"t10_times_".$zz."\" value=\"".$s["time"]."\" size=\"5\"></td>";
											echo "<td><input type=\"button\" value=\"移除\" onclick=\"del_element(this)\" ></td>";
											echo "</tr>";
											$zz--;
										}
									  ?>
                                    
                                </table>   
                                 <input type="button" onclick="table_add(table_10_content,empty_array_10)" value="新增" /> 
                            </td>
                        </tr>
			        </table>
				</div><!--      tab_5 end    -->
				<div id="tab_6">
					 <table width="92%" border="1" cellspacing="0" >
						<tr>
							<th colspan="6" class="field_title ui-state-highlight"><strong>六、合作機構</strong></th>
						</tr>
						<tr>
							<td colspan="5">
								<table id="sub_table_3" width="100%" border="1" cellspacing="0" class="sub_table" >
									<tr class="field_title ui-state-highlight">
                                   		<th  width="130" height="22">合作機構</th>
									 	<th  width="80">機構聯絡人</th>
										<th  width="120">機構電話</th>
										<th  width="215">e-mail</th>
										<th  width="220">機構地址</th>
                                        <th  width="40"></th>
									</tr>
                                    
                                    <?
										$sql="SELECT * FROM cooperation WHERE id='$id'";
										$r = mysql_query($sql);
										while($t=mysql_fetch_array($r)){
											echo "<tr>";
											echo "<td><input style=\"width:130px\" type=\"text\" name=\"t3_organization_".$zz."\" value=\"".$t["name"]."\" ></td>";
											echo "<td><input style=\"width:80px\" type=\"text\" name=\"t3_name_".$zz."\" value=\"".$t["people"]."\" ></td>";
											echo "<td><input style=\"width:120px\" type=\"text\" name=\"t3_phone_".$zz."\" value=\"".$t["phone"]."\" ></td>";
											echo "<td><input style=\"width:215px\" type=\"text\" name=\"t3_email_".$zz."\" value=\"".$t["email"]."\" ></td>";
											echo "<td><input style=\"width:220px\" type=\"text\" name=\"t3_address_".$zz."\" value=\"".$t["address"]."\" ></td>";
											echo "<td><input style=\"width:40px\" type=\"button\" value=\"移除\" onclick=\"del_element(this)\" ></td>";
											echo "</tr>";
											$zz--;
										}
									?>
                                    
								</table>
								<input type="button" onclick="table_add(table_3_content,empty_array_3)" value="新增"/>
							</td>
						</tr>
					</table>
				</div><!--      tab_6 end    -->
				<div id="tab_7">
					<table width="92%" border="1" cellspacing="0" >
						<tr>
							<th colspan="6" class="field_title ui-state-highlight"><strong>七、講習訓練與服務進行方式</strong> (請具體說明服務時間、地點、執行方式、執行次數及活動內容)</th>
						</tr>
                                                <tr>
							<th colspan="6" class="field_title ui-state-highlight" align="left">(一) 講習訓練 </th>
						</tr>
						<tr>
							<td colspan="6">
								<table id="sub_table_4" width="100%" border="1" cellspacing="0" class="sub_table" >
									<tr class="field_title ui-state-highlight">
										<th  width="100">項目</th>
										<th  width="100">日期</th>
										<th  width="100">地點</th>
										<th  width="255">內容</th>
										<th  width="100">講師</th>
										<th  width="100">時間</th>
                                        <th width="40"></th>
									</tr>
                                    
                                    <?
										$sql="SELECT * FROM lecture WHERE id='$id' ORDER BY lid ASC";
										$r = mysql_query($sql);
										while($t=mysql_fetch_array($r)){
											echo "<tr>";
											echo "<td><input style=\"width:100px\" type=\"text\" name=\"t4_items_".$zz."\" value=\"".$t["item"]."\"></td>";
											echo "<td><input style=\"width:100px\" type=\"text\" name=\"t4_date_".$zz."\" value=\"".$t["date"]."\"></td>";
											echo "<td><input style=\"width:100px\" type=\"text\" name=\"t4_place_".$zz."\" value=\"".$t["address"]."\"></td>";
											echo "<td><input style=\"width:255px\" type=\"text\" name=\"t4_contents_".$zz."\" value=\"".$t["content"]."\"></td>";
											echo "<td><input style=\"width:100px\" type=\"text\" name=\"t4_lecturer_".$zz."\" value=\"".$t["teacher"]."\"></td>";
											echo "<td><input style=\"width:100px\" type=\"text\" name=\"t4_time_".$zz."\" value=\"".$t["time"]."\"></td>";
											echo "<td><input style=\"width:40px\" type=\"button\" value=\"移除\" onclick=\"del_element(this)\" ></td>";
											echo "</tr>";
											$zz--;
										}
									?>
                                    
								</table>
								<input type="button" onclick="table_add(table_4_content,empty_array_4)" value="新增"/>
							</td>
						</tr>
                                                <tr>
							<th colspan="6" class="field_title ui-state-highlight" align="left">(二) 服務進行方式 </th>
						</tr>
						<tr>
							<td colspan="6"><textarea id="method_service_carries" name="method_service_carries" cols="90" rows="5" ><?php echo $d["service"]; ?></textarea></td>
						</tr>
					</table>
				</div><!--      tab_7 end    -->
				<div id="tab_8">
               		<table width="92%" border="1" cellspacing="0" >
						<tr>
							<th colspan="6" class="field_title ui-state-highlight">八、評量方式</th>
						</tr>
						<tr>
							<td colspan="2">
								<table id="sub_table_5" width="100%" border="1" cellspacing="0" class="sub_table" >
									<tr class="field_title ui-state-highlight">
										<th  width="690">項目</th>
										<th  width="101">百分比(%)<br />(請輸入數字)</th>
                                        <th  width="40"></th>
									</tr>
                                    
                                     <?
										$sql="SELECT * FROM point WHERE id='$id' ORDER BY pid ASC";
										$r = mysql_query($sql);
										while($t=mysql_fetch_array($r)){
											echo "<tr>";
											echo "<td><input style=\"width:690px\" type=\"text\" name=\"t5_items_".$zz."\" value=\"".$t["item"]."\"></td>";
											echo "<td><input style=\"width:101px\" type=\"text\" name=\"t5_percentage_".$zz."\" value=\"".$t["percent"]."\"></td>";
											echo "<td><input style=\"width:40px\" type=\"button\" value=\"移除\" onclick=\"del_element(this)\" ></td>";
											echo "</tr>";
											$zz--;
										}
									?>
                                    
								</table>
								<input type="button" onclick="table_add(table_5_content,empty_array_5)" value="新增"/>
							</td>
						</tr>
					</table>
                </div><!--      tab_8 end    -->
                <div id="tab_9">
					<table width="92%" border="1" cellspacing="0" >
						<tr>
							<td class="field_title ui-state-highlight">九、預期效益 (預計修課人數、提供服務人次、接受服務人次、影響效益等)</td>
						</tr>
						<tr>
							<td><textarea id="anticipated_benefit" name="anticipated_benefit" cols="90" rows="5" ><?php echo $d["benefit"]; ?></textarea></td>
						</tr>
						<tr>
							<td class="field_title ui-state-highlight">十、延續性規劃及具體作法 (自申請當學年起含二學年度內提升課程品質之遠景規劃)</td>
						</tr>
						<tr>
							<td><textarea id="ContinuousPlan_ConcreteMethod" name="ContinuousPlan_ConcreteMethod" cols="90" rows="5" ><?php echo $d["future"]; ?></textarea></td>
						</tr>
					</table>
				</div><!--      tab_9 end    -->
				<div id="tab_11">
					<table width="92%"  border="0" cellspacing="0" >
						<tr>
							<td class="field_title ui-state-highlight">十一、協力單位合作協議書(檔名請用「學年度+課程名稱」命名(例:1021服務學習)後再上傳)</td>
						</tr>
						<tr>
							<td>
                            
                             <?
								$sql = "SELECT * FROM portocal WHERE id='$id'";
								$f = mysql_fetch_array(mysql_query($sql));
								echo "<a style=\"color:blue\" href=upload/".$f["filename"]." target=\"_blank\">".$f["name"]."</a>";    
							
							 ?>
                            
						    
						    <input type="checkbox" name="filemodify" id="filemodify" value="1" />
						    修改或刪除原檔
                             <input type="file" name="file" id="file"  />
                             
                             <button onclick="upload()">上傳</button>
                             
						</tr>
						
					</table>
                    
			 </div><!--      tab_11 end    -->
				<div id="tab_12">
               		<table width="92%" border="1" cellspacing="0" >
						<tr>
							<th colspan="6" class="field_title ui-state-highlight">十二、經費預算</th>
						</tr>
						<tr>
							<td colspan="2">
								<table id="sub_table_6" width="100%" border="1" cellspacing="0" class="sub_table" >
									<tr class="field_title ui-state-highlight">
										<th width="135">經費項目</th>
                                        <th width="100">單價(元)</th>
                                        <th width="100">數量</th>
                                        <th width="100">總價(元)</th>
                                        <th width="330">用途說明(含計算方式)</th>
										<td></td>
									</tr>
                                    
                                     <?
										$sql="SELECT * FROM finance WHERE id='$id' ORDER BY fid ASC";
										$r = mysql_query($sql);
										while($t=mysql_fetch_array($r)){
											echo "<tr><td>";
											echo "<select id='test1' name=\"t6_items_".$zz."\"><option value=\"0\"> </option>";
											
											if($t["item"]==1)
												echo "<option value=\"1\" selected=\"selected\">鐘點費(外聘專家)</option>";
											
											else
												echo "<option value=\"1\">鐘點費(外聘專家)</option>";
											
											if($t["item"]==2)
												echo "<option value=\"2\" selected=\"selected\">鐘點費(內聘專家)</option>";
											else
												echo "<option value=\"2\">鐘點費(內聘專家)</option>";
												
											if($t["item"]==3)
												echo "<option value=\"3\" selected=\"selected\">印刷費</option>";
											else
												echo "<option value=\"3\">印刷費</option>";
											
											if($t["item"]==4)
												echo "<option value=\"4\" selected=\"selected\">誤餐費</option>";
											else
												echo "<option value=\"4\">誤餐費</option>";
												
											if($t["item"]==5)
												echo "<option value=\"5\" selected=\"selected\">交通費</option>";
											else
												echo "<option value=\"5\">交通費</option>";
												
											if($t["item"]==6)
												echo "<option value=\"6\" selected=\"selected\">雜支</option>";
											else
												echo "<option value=\"6\">雜支</option>";
											
											if($t["item"]==7)
												echo "<option value=\"7\" selected=\"selected\">工讀金</option>";
											  
											else
												echo "<option value=\"7\">工讀金</option>";
											
											if($t["item"]==8)
												echo "<option value=\"8\" selected=\"selected\">保險費</option>";
											else
												echo "<option value=\"8\">保險費</option>";
											
											echo "</select></td>";
											
											echo "<td><input style=\"width:100px\" type=\"text\" name=\"t6_unitprice_".$zz."\" id=\"t6_unit_price\" value=\"".$t["price"]."\"></td>";
											echo "<td><input style=\"width:100px\" type=\"text\" name=\"t6_amount_".$zz."\" id=\"t6_amount\" value=\"".$t["number"]."\" ></td>";
											echo "<td><input style=\"width:100px\" type=\"text\" name=\"t6_totaprice_".$zz."\" id=\"t6_tota_price\" value=\"".$t["total"]."\" ></td>";
											echo "<td><input style=\"width:330px\" type=\"text\" name=\"t6_useexplanation_".$zz."\" value=\"".$t["explain"]."\" ></td>";
											echo "<td><input style=\"width:40px\" type=\"button\" value=\"移除\" onclick=\"del_element(this)\" ></td>";
											echo "</tr>";
											$zz--;
										}
									?>
                                    
								</table>
								<input type="button" onclick=alert('各經費項目單價上限【鐘點費(外聘專家):1600元】【鐘點費(內聘專家):800元】【誤餐費(每人每餐):80元】【工讀金(時薪):120元】');table_add(table_6_content,empty_array_6) value="新增" />
							</td>
						</tr>
                        <?
  	$sql = "SELECT * FROM apply WHERE id='$id'";
	$a=mysql_fetch_array(mysql_query($sql));
  ?>
						<tr>
							<td colspan="6"><input type="button" onclick="amount_money()" value="合計" />
							<input type="text" name="total_price_amount" id="total_price_amount" readonly="true" value="<?php echo $a["amount"]; ?>"/>
										申請補助金額：<input type="text" name="apply_price" id="apply_price" value="<?php echo $a["apply"]; ?>"/>
							</td>
						</tr>
					</table>					   
				</div><!--      tab_12 end    -->
				
				
				 <?
					$sql = "SELECT * FROM preprocess WHERE id='$id'";
					$p=mysql_fetch_array(mysql_query($sql));
				  ?>
                <table width="92%"  border="1" cellspacing="0" >
						<tr>
							<td colspan="2" class="field_title ui-state-highlight">十三、前次課程執行成果 (首次開課免填)</td>
                           
						</tr>
						<tr> 
							<td width="40%">修課人數</td>
                            <td><label for="number_13"></label>
                            <input type="text" name="number_13" id="number_13" value="<? echo $p["number"]; ?>" /></td>
						</tr>
                        <tr>
                        	<td>提供服務人次<br>(每學期每人平均服務次數*修課人數)</td>
                            <td><input type="text" name="count_13" value="<? echo $p["count"]; ?>"  /></td>
                        </tr>
						<tr>
							<td>提供服務時數<br>(每人服務總時數*修課人數)</td>
                            <td><input type="text" name="servertime_13" value="<? echo $p["servertime"]; ?>"  /></td>
						</tr>
                        <tr>
							<td>經費報支執行率</td>
                            <td><input type="text" name="frequency_13" value="<? echo $p["frequency"]; ?>"  /></td>
						</tr>
                        <tr>
							<td>獲獎紀錄</td>
                            <td><input type="text" name="record_13" value="<? echo $p["record"]; ?>"  /></td>
						</tr>
					</table>
				
				
                <div>
                	<table width="92%" border="0" cellspacing="0" >
						<td>
                        註：<br />
1.經費之編列與核銷，悉依「教育部補助及委辦經費核撥結報作業要點」、「國內外出差旅費報支要點」暨相關辦法執行之。<br />
2.學生參與課外活動之保險，依據「國立成功大學學生團體保險辦法」執行之。<br />
3.每門課程補助項目，包含鐘點費（外聘、內聘專家）、印刷費、誤餐費、交通費、保險費、工讀金(補助對象為服務學習教學助理)及雜支等必要之支出。雜支金額不得超過補助款20%。 <br />

                        </td>
					</table>
                </div>
			</form>
		</div>
	</div>
</div>
<div id="ShowMsg" ></div>
<div id="ShowMsg2" >確定刪除此列?</div>
</body>
</html>
