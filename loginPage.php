<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>服務學習課程系統登入頁面</title>
    
<!-- Load JQuery Libraries from "http://www.google.com/jsapi" -->
<link rel="stylesheet" href="CSS/theme.css" type="text/css"/>
<script type="text/javascript" src="JS/jquery-1.4.2.js"></script>
<script type="text/javascript" src="JS/jquery-ui-1.8.5.custom.min.js"></script>
<script type="text/javascript" src="JS/global_variables.js"></script>
<script type="text/javascript" language="javascript">
	window.onload=function(){
            AdjustBackgroundHeight();
                /*---------------------------------------------------------------------
			The Options, Events and Methods of JQuery Elements can reference
			to JQuery API Documents on "http://jqueryui.com".
		/*---------------------------------------------------------------------*/
		/*------------------ JQuery Dialog Declaration --------------------*/
                $("#ShowMsg").dialog({
			 title: '注意!!!',
			 autoOpen: false,
			 modal:true,
                        show: 'clip',
                        hide: 'clip',
			 buttons: {
				OK: function() {
					$("#ShowMsg").dialog('close');
				}
			}
		});
		/*--------------------------------------------------------------------*/
		$.get("getSession.do","time="+new Date(),function(JSON_Data){
                //alert(JSON_Data.sessionAttr.ErrorMSG);
                    if(JSON_Data.sessionAttr.ErrorMSG!="null")                                       
                          $("#ShowMsg").dialog('open');
                },"json");

               $("input:submit").button();
               $("input:submit").css({ "font-size": '12px', width: '80px', height: '30px'});//設定按鈕大小
			   
		<? if($_GET["msg"]){ ?>	   
			   
		$("#ShowMsg").dialog('open');
		<? } ?>
	}

	</script>
    
   
        <style>
            #contentDiv{
                top: 130px;
}
        
        </style>
	</head>

	<body>
    	<div class="page_container ui-state-error">
            <div class="page_header"></div>
            <div id="contentDiv" class="contentDiv">

                <form name="loginForm" id="loginForm" action="login_check.php" method="POST">
                    <input type="hidden" name="action" value="login"/>
                    <table width="350" border="0" cellpadding="0" cellspacing="0" align="center"  class="ui-widget-content">
                      	<tr>
                            <td colspan="2" align="center" class="ui-state-default"><h3>服務學習課程系統登入</h3></td>
                        </tr>
                        <tr>
                            <td width="40%" height="50" align="center"><label for="id">使用者帳號:</label></td><td width="60%"><input type="text" name="id" value=""></td>
                        </tr>
                        <tr>
                            <td height="50" align="center"><label for="password">密     碼:</label></td><td><input type="password" name="password" value=""></td>
                        </tr>
                        <tr>
                            <td  height="50" align="center"><a href='#'>忘記密碼</a></td><td align="center"><input type="submit" id="Login_button" value="登入"></td>
                        </tr>
                    </table>
                    <font color="red">管理者身分帳密:root/root<br/>                        其他使用者帳密ex: teacher01/teacher01
                                </font>

              </form>
            </div>
            <div name="ShowMsg" id="ShowMsg" >
            查無此帳號或密碼輸入錯誤！請重新輸入...
            </div>
            </div>

	</body>
</html>
