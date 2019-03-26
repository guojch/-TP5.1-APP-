<?php

namespace app\common\third;

use PHPMailer\PHPMailer\PHPMailer;
use think\facade\Env;

/**
 * 邮件基类
 * Class Email
 * @package app\common\third
 */
class Email
{
    const EMAIL_HOST = 'smtp.qq.com';
    const EMAIL_FROMNAME = '';
    const EMAIL_PASSWORD = '';
    const EMAIL_USERNAME = '';

    /**
     * 邮件发送接口
     * @param $to 目标地址
     * @param $subject 邮件标题
     * @param $content 邮件内容
     * @return bool
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public static function send($to, $subject, $content)
    {
        include_once Env::get('root_path') . 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
        include_once Env::get('root_path') . 'vendor/phpmailer/phpmailer/src/SMTP.php';
        $mail = new PHPMailer();
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = self::EMAIL_HOST;
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->Hostname = '';
        $mail->CharSet = 'UTF-8';
        $mail->Fromname = self::EMAIL_FROMNAME;
        $mail->Username = self::EMAIL_USERNAME;
        $mail->Password = self::EMAIL_PASSWORD;
        $mail->From = self::EMAIL_USERNAME;
        $mail->isHTML(true);
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $content;
        try {
            $status = $mail->send();
            return $status;
        } catch (Exception $e) {
            return false;
        }
    }
}