<?php
    header("content-type:text/html;charset=gb2312"); 
    include_once("mail/test.php"); //增加邮件提醒
        //获取来自问卷的内容
        $user_name = $_POST['user_name'];
        $user_url = $_POST['user_url'];
        $user_donate = $_POST['user_donate'];
        $pay_way = $_POST['pay_way'];
        $donate_msg = $_POST['donate_msg'];

        //数据库需要的内容
        //获取ip https://blog.csdn.net/benben0729/article/details/87859314
        $ip = ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
        $user_ip = ($ip) ? $ip : $_SERVER["REMOTE_ADDR"];

        date_default_timezone_set("Asia/Shanghai"); //获取填写时间
        $donate_time=date('Y-m-d H:i:s');

        $donate_confirm='NO'; //确认信息默认为'NO'

        //连接数据库
        $conn = new mysqli(localhost,'donate_dominoh_c','dmmhDWYZW8raNaAe','donate_dominoh_c');
        mysqli_set_charset($conn,"utf8");
        if ($conn->connect_error){ //连接失败javascript:;
            //echo '数据库连接失败，请联系博主！';
          	echo '<script>window.parent.errorRes("提交失败了，请联系一下博主，谢谢！");</script>';
            exit(0);
        }else { //连接成功
            //查询该ip打赏次数、避免恶意刷取数据
            $sql = "select count(*) from donate_info where user_ip = '$user_ip'";
            $result = $conn->query($sql);
          	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
            	//因为使用的是关联数组方式获取每一行数据，所以只能使用关联数组的方法读取数据，不能使用索引的方式读取数据。
            	$ip_num=$row['count(*)'];
          	}
            if ($ip_num>=15) {  //这里设置同ip最高打赏次数
                //echo '<script>alert("上传失败，总打赏次数超限！");history.go(-1);</script>';
              	echo '<script>window.parent.errorRes("提交失败，你提交太多次了吧！");</script>';
            } else {
                $sql_insert = "insert into donate_dominoh_c.`donate_info` (`user_name`, `user_url`, `user_donate`,`pay_way`, `user_ip`, `donate_time`, `donate_confirm`, `donate_msg`) VALUES ('$user_name', '$user_url', '$user_donate', '$pay_way', '$ip', '$donate_time', '$donate_confirm', '$donate_msg')";
             	$res_insert = $conn->query($sql_insert);
                if ($res_insert) {
                 	//echo "<script>alert($user_name);</script>";
                  	echo '<script>window.parent.successRes("提交成功！博主会尽快确认的~");</script>';
                 	send_mail(); //发送提醒邮件
                } else {
                    echo '<script>window.parent.warnRes("请检查一下是不是哪里填错啦！");</script>';
                }
            }
        }
        mysqli_close($conn);
?>