<?php
  /**
   * Created by IntelliJ IDEA.
   * User: dongluyang
   * Date: 2017/12/27
   * Time: 11:51
   */
  require_once('Smtp.class.php');
  class Send_mail{
      public $smtp_host = "ssl://SERVER_ADDRESS";//SMTP服务器地址
      public $smtp_user = "USER_NAME";//SMTP用户名
      public $smtp_pass = "USER_PASSWD";//密码
      function send_email($to, $title, $content){
          $mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件                     
          //************************ 配置信息****************************
          $smtp = new Smtp($this->smtp_host,465,true,$this->smtp_user,$this->smtp_pass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
          $smtp->debug = true;//是否显示发送的调试信息
          $state = $smtp->sendmail($to, $this->smtp_user,$title,$content, $mailtype)    ;
          return $state;
      }
 }
?>