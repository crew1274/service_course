 <?php    
    include("class.phpmailer.php"); //匯入PHPMailer類別       
          
    $mail= new PHPMailer(); //建立新物件        
    $mail->IsSMTP(); //設定使用SMTP方式寄信        
    $mail->SMTPAuth = true; //設定SMTP需要驗證        
    $mail->SMTPSecure = "ssl"; // Gmail的SMTP主機需要使用SSL連線   
    $mail->Host = "smtp.gmail.com"; //Gamil的SMTP主機        
    $mail->Port = 465;  //Gamil的SMTP主機的SMTP埠位為465埠。        
    $mail->CharSet = "big5"; //設定郵件編碼        
          
    $mail->Username = ""; //設定驗證帳號        
    $mail->Password = ""; //設定驗證密碼        
          
    $mail->From = ""; //設定寄件者信箱        
    $mail->FromName = ""; //設定寄件者姓名        
          
    $mail->Subject = ""; //設定郵件標題        
    $mail->Body = ""; //設定郵件內容        
    $mail->IsHTML(true); //設定郵件內容為HTML        
    $mail->AddAddress("", ""); //設定收件者郵件及名稱        
          
    if(!$mail->Send()) {        
    echo "Mailer Error: " . $mail->ErrorInfo;        
    } else {        
    echo "已經幫您儲存您新增的課程，並寄信通知課務組負責人";        
    }    
	
	?>
    
