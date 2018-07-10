<?php
defined('IN_YZMPHP') or exit('Access Denied');
yzm_base::load_sys_class('page', '', 0);


/**
 * Class HelperSendMail
 * 发送邮件类
 */
class HelperSendMail {
    public function __construct() {
        include YZMPHP_PATH . 'common/class/class.phpmailer.php';
        include YZMPHP_PATH . 'common/class/class.smtp.php';
    }

    //发送验证邮箱
    public function sendVerify($email, $title, $content) {
        try {
            $mail = new PHPMailer(true);
            $content = str_replace("[\]", '', $content);
            $mail->IsSMTP();
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->SMTPKeepAlive = true;
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465;  //tls:587  ssl :465
            $mail->SMTPDebug = 1;
            $mail->Timeout = 300;

            //填写你的gmail账号和密码
            $mail->Username = "wondergame06@gmail.com";
            $mail->Password = "WonderGame9130";
            //设置发送方，最好不要伪造地址
            $mail->From = "wondergame06@gmail.com";
            $mail->FromName = "wondergame";
            $mail->Subject = $title;
            $mail->AltBody = $content;
            $mail->Body = 526984;
            $mail->WordWrap = 50; // set word wrap

            //设置回复地址
//                $mail->AddReplyTo("yourname@gmail.com","马斯塔");

            //设置邮件接收方的邮箱和姓名
            $mail->AddAddress($email);
//                $mail->AddAddress($email,"chen ChangSheng");

            if (!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message has been sent';
            }
        } catch (Exception $e) {
            return false;
        }
        $mail->Smtpclose();
    }

    /**
     * 邮箱验证码html模板
     *
     * @param $add_name     收件人姓名
     * @param $auth_code    验证码
     * @param $add_email    收件人邮箱
     * @param $language     语言种类
     */
    public function VerificationTemplate($add_name, $auth_code, $add_email, $language='zj') {
        switch ($language) {
            case zf:
                $str1 = '你好';
                $str2 = '此次帳號信息變更需要的驗證碼如下，請在 30 分鐘內輸入驗證碼進行下一步操作。';
                $str3 = '如果非你本人操作，你的帳號可能存在安全風險，請立即';
                $str4 = '修改密碼';
                $str6 = '這封郵件的收件地址是';
                $str7 = '你可以通過';
                $str8 = '點擊這裏';
                $str9 = '來訪問wonderent遊戲平臺';
                $str10 = '© 2018	www.wonderent.net ';
                break;
            case tw:
                $str1 = 'คุณเป็นยังไงบ้าง';
                $str2 = 'ข้อมูลบัญชีผู้ใช้นี้การเปลี่ยนแปลงที่ต้องการตรวจสอบโค้ดด้านล่าง กรุณาป้อนรหัสยืนยันใน 30 นาทีสำหรับขั้นตอนถัดไป。';
                $str3 = 'ถ้าคุณไม่ทำงาน บัญชีของคุณอาจเสี่ยงต่อความปลอดภัย กรุณาทันที';
                $str4 = 'ปรับเปลี่ยนรหัสผ่าน';
                $str6 = 'เป็นอยู่ของอีเมล์นี้';
                $str7 = 'คุณสามารถส่งผ่าน';
                $str8 = 'คลิกที่นี่';
                $str9 = 'การเข้าถึงแพลตฟอร์มเกม Wonderent';
                $str10 = '© 2018	www.wonderent.net ';
                break;
            case yn:
                $str1 = 'Xin chào';
                $str2 = 'Thông tin tài khoản này được thay đổi để thay đổi mã số là như sau, xin vui lòng nhập mã xác minh trong 30 phút để thực hiện các hoạt động tiếp theo。';
                $str3 = 'Nếu không có bạn, tài khoản của bạn có thể có nguy cơ an ninh, xin vui lòng ngay lập tức';
                $str4 = 'Sửa đổi mật khẩu';
                $str6 = 'Địa chỉ của thư này là';
                $str7 = 'Bạn có thể thông qua';
                $str8 = 'Click vào đây';
                $str9 = 'Để truy cập wonderent nền tảng trò chơi ';
                $str10 = '© 2018	www.wonderent.net ';
                break;
            case en:
                $str1 = ' hi';
                $str2 = 'The verification code required for this account information change is as follows. Please enter the verification code within 30 minutes for the next operation。';
                $str3 = 'If you are not operating, your account may be at risk of security, please immediately';
                $str4 = 'change password';
                $str6 = 'The delivery address of this mail is';
                $str7 = 'You can go through';
                $str8 = 'click here';
                $str9 = 'Visit the wonderent gaming platform ';
                $str10 = '© 2018	www.wonderent.net ';
                break;
            default:
                $str1 = '你好';
                $str2 = '此次帐号信息变更需要的验证码如下，请在 30 分钟内输入验证码进行下一步操作。';
                $str3 = '如果非你本人操作，你的帐号可能存在安全风险，请立即';
                $str4 = '修改密码';
                $str6 = '这封邮件的收件地址是';
                $str7 = '你可以通过';
                $str8 = '点击这里';
                $str9 = '来访问wonderent游戏平台 ';
                $str10 = '© 2018	www.wonderent.net ';
                break;
        }
        $comment = '<style type="text/css">@media screen and (max-width: 525px) {.qmbox table[class="responsive-table"]{width:100%!important;}.qmbox td[class="padding"]{padding:30px 8% 35px 8% !important;}.qmbox td[class="padding2"]{padding:30px 4% 10px 4% !important;text-align: left;}}@media all and (-webkit-min-device-pixel-ratio: 1.5) {.qmbox body[yahoo] .zhwd-high-res-img-wrap {background-size: contain;background-position: center;background-repeat: no-repeat;}.qmbox body[yahoo] .zhwd-high-res-img-wrap img {display: none !important;}.qmbox body[yahoo] .zhwd-high-res-img-wrap.zhwd-zhihu-logo {width:71px;height:54px ;}}.zhwd-zhihu-logo a {color: #fff;text-decoration: none;}</style><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td bgcolor="#f7f9fa" align="center" style="padding:22px 0 20px 0" class="responsive-table"><table border="0" cellpadding="0" cellspacing="0" style="background-color:f7f9fa; border-radius:3px;border:1px solid #dedede;margin:0 auto; background-color:#ffffff" width="552" class="responsive-table"><tbody><tr><td bgcolor="#0373d6" height="54" align="center" style="border-top-left-radius:3px;border-top-right-radius:3px;"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center" class="zhwd-high-res-img-wrap zhwd-zhihu-logo"><a href="http://www.wonderent.net" target="_blank">www.wonderent.net</a></td></tr></tbody></table></td></tr><tr><td bgcolor="#ffffff" align="center" style="padding: 0 15px 0px 15px;"><table border="0" cellpadding="0" cellspacing="0" width="480" class="responsive-table"><tbody><tr><td><table width="100%" border="0" cellpadding="0" cellspacing="0"><tbody><tr><td><table cellpadding="0" cellspacing="0" border="0" align="left" class="responsive-table"><tbody><tr><td width="550" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tbody><tr><td bgcolor="#ffffff" align="left" style="background-color:#ffffff; font-size: 17px; color:#7b7b7b; padding:28px 0 0 0;line-height:25px;"><b>'.$add_name.','.$str1.'</b></td></tr><tr><td align="left" valign="top" style="font-size:15px; color:#7b7b7b; font-size:14px; line-height: 25px; font-family:Hiragino Sans GB; padding: 20px 0px 20px 0px">'.$str2.'</td></tr><tr><td style="border-bottom:1px #f1f4f6 solid; padding: 0 0 25px 0;" align="center" class="padding"><table border="0" cellspacing="0" cellpadding="0" class="responsive-table"><tbody><tr><td><span style="font-family:Hiragino Sans GB;"><div style="padding:10px 18px 10px 18px;border-radius:3px;text-align:center;text-decoration:none;background-color:#ecf4fb;color:#4581E9;font-size:20px; font-weight:700; letter-spacing:2px; margin:0;white-space:nowrap">'.$auth_code.'</div></span></td></tr></tbody></table></td></tr><tr><td align="left" valign="top" style="font-size:15px; color:#7b7b7b; font-size:14px; line-height: 25px; font-family:Hiragino Sans GB; padding: 20px 0px 35px 0px">'.$str3.'<a style="font-size:14px;line-height:20px;text-decoration:none;color:#259;border:none;outline:none;" href="http://www.wonderent.net" target="_blank">'.$str4.'</a></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table cellpadding="0" cellspacing="0" border="0" width="100%"><tbody><tr><td bgcolor="#f7f9fa" align="center"><table width="552" border="0" cellpadding="0" cellspacing="0" align="center" class="responsive-table"><tbody><tr><td align="center" valign="top" bgcolor="#f7f9fa" style="font-family:Hiragino Sans GB; font-size:12px; color:#b6c2cc; line-height:17px; padding:0 0 25px 0;">'.$str6.'<a href="mailto:'.$add_email.'" target="_blank">'.$add_email.'</a> <br>'.$str7.'<a href="http://www.wonderent.net" style="border:none;color:#8a939b;text-decoration:none;" target="_blank">&nbsp;'.$str8.'&nbsp;</a><span>'.$str9.'</span> <br>'.$str10.'</td></tr></tbody></table></td></tr></tbody></table>';

        return $comment;

    }


}