 <?php    
    include("class.phpmailer.php"); //�פJPHPMailer���O       
          
    $mail= new PHPMailer(); //�إ߷s����        
    $mail->IsSMTP(); //�]�w�ϥ�SMTP�覡�H�H        
    $mail->SMTPAuth = true; //�]�wSMTP�ݭn����        
    $mail->SMTPSecure = "ssl"; // Gmail��SMTP�D���ݭn�ϥ�SSL�s�u   
    $mail->Host = "smtp.gmail.com"; //Gamil��SMTP�D��        
    $mail->Port = 465;  //Gamil��SMTP�D����SMTP��쬰465��C        
    $mail->CharSet = "big5"; //�]�w�l��s�X        
          
    $mail->Username = "50156gm@gmail.com"; //�]�w���ұb��        
    $mail->Password = "em50156em"; //�]�w���ұK�X        
          
    $mail->From = "50156gm@gmail.com"; //�]�w�H��̫H�c        
    $mail->FromName = "�ҰȲ�"; //�]�w�H��̩m�W        
          
    $mail->Subject = "�A�Ⱦǲߺ����q��"; //�]�w�l����D        
    $mail->Body = "���Ѯv�s�W�A�Ⱦǲ߽ҵ{�F�@ !     
    "; //�]�w�l�󤺮e        
    $mail->IsHTML(true); //�]�w�l�󤺮e��HTML        
    $mail->AddAddress("50156gm@gmail.com", "�ҰȲ�"); //�]�w����̶l��ΦW��        
          
    if(!$mail->Send()) {        
    echo "Mailer Error: " . $mail->ErrorInfo;        
    } else {        
    echo "�w�g���z�x�s�z�s�W���ҵ{�A�ñH�H�q���ҰȲխt�d�H";        
    }    
	
	?>
    