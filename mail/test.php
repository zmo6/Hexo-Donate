<?php
   
   require_once('send_mail.php');
   $to = "domino@dominoh.com"; //收件人
   $title = "收到了新的投喂！";//邮件主题
   $content = "收到了新的投喂！";//邮件内容
   $send = new send_mail();   
   $status = $send->send_email($to,$title,$content);
?>