/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var table_1_content = $.parseJSON('{"table_id":"1","columns": [ {"name": "t1_name", "type": "text", "value":""},{"name": "t1_title", "type": "text", "value":""}, {"name": "t1_workplace", "type": "text", "value":""},{"name": "t1_phone", "type": "text", "value":""},{"name": "t1_email", "type": "text", "value":""}]}');
var table_2_content = $.parseJSON('{"table_id":"2","columns": [ {"name": "t2_name", "type": "text", "value":""},{"name": "t2_title", "type": "text", "value":""}, {"name": "t2_workplace", "type": "text", "value":""},{"name": "t2_phone", "type": "text", "value":""},{"name": "t2_email", "type": "text", "value":""}]}');
var table_3_content = $.parseJSON('{"table_id":"3","columns": [ {"name": "t3_organization", "type": "text", "value":""},{"name": "t3_name", "type": "text", "value":""}, {"name": "t3_phone", "type": "text", "value":""},{"name": "t3_email", "type": "text", "value":""},{"name": "t3_address", "type": "text", "value":""}]}');
var table_4_content = $.parseJSON('{"table_id":"4","columns": [ {"name": "t4_items", "type": "text", "value":""},{"name": "t4_date", "type": "text", "value":""}, {"name": "t4_place", "type": "text", "value":""},{"name": "t4_contents", "type": "text", "value":""},{"name": "t4_lecturer", "type": "text", "value":""},{"name": "t4_time", "type": "text", "value":""}]}');
var table_5_content = $.parseJSON('{"table_id":"5","columns": [ {"name": "t5_items", "type": "text", "value":""},{"name": "t5_percentage", "type": "text", "value":""}]}');
var table_6_content = $.parseJSON('{"table_id":"6","columns": [ {"name": "t6_items", "type": "select", "value":[0,1,2,3,4,5,6,7,8], "text":[" ","鐘點費(外聘專家)","鐘點費(內聘專家)","印刷費","誤餐費","交通費","雜支","工讀金","保險費"]  },{"name": "t6_unitprice", "id": "t6_unit_price", "type": "text", "value":""},{"name": "t6_amount", "id": "t6_amount", "type": "text", "value":""},{"name": "t6_totaprice", "id": "t6_tota_price", "type": "text", "value":""},{"name": "t6_useexplanation", "id": "t6_useexplanation", "type": "text", "value":""}]}');
var table_7_content = $.parseJSON('{"table_id":"7","columns": [ {"name": "t7_items", "type": "text", "value":""},{"name": "t7_content", "type": "text", "value":""},{"name": "t7_times", "type": "text", "value":""}]}');
var table_8_content = $.parseJSON('{"table_id":"8","columns": [ {"name": "t8_items", "type": "text", "value":""},{"name": "t8_content", "type": "text", "value":""},{"name": "t8_times", "type": "text", "value":""}]}');
var table_9_content = $.parseJSON('{"table_id":"9","columns": [ {"name": "t9_items", "type": "text", "value":""},{"name": "t9_content", "type": "text", "value":""},{"name": "t9_times", "type": "text", "value":""}]}');
var table_10_content = $.parseJSON('{"table_id":"10","columns": [ {"name": "t10_items", "type": "text", "value":""},{"name": "t10_content", "type": "text", "value":""},{"name": "t10_times", "type": "text", "value":""}]}');

var empty_array_1=new Array("","","","","");
var empty_array_2=new Array("","","","","");
var empty_array_3=new Array("","","","","");
var empty_array_4=new Array("","","","","","");
var empty_array_5=new Array("","");
var empty_array_6=new Array("","","","","");
var empty_array_7=new Array("","","");
var empty_array_8=new Array("","","");
var empty_array_9=new Array("","","");
var empty_array_10=new Array("","","");

function loadProfile(){
    var returnJSON;
    //從profile.json設定檔初始化表單內容
    $.ajax({
        async:false,
        dataType:"json",
        type:"POST",
        url:"profile.json",
        success: function(JSONData){
            returnJSON=JSONData;
        }
    });
    return returnJSON;
}

function Init_JQueryUI(){
            //初始畫Jquery物件
        $(".menu_item").button();
        $(".menu_item").css({"font-size": '14px', width: '135px', height: '30px',"font-family": '"微軟正黑體","新細明體","標楷體","細明體"'});//設定按鈕大小
}

function AdjustBackgroundHeight(){
    var height;
    if(window.Node)//firefox
        height=window.innerHeight;
    else//IE
        height=document.body.offsetHeight;
    if($(".page_container").innerHeight()<height)
        $(".page_container").css("height","100%");
}