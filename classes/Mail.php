<?php
    /**
     * Class para o envio de emails
     */
    class Mail
    {
        public static function send($to, $subject, $message, $headers = null) {
            $headers = "From: MotoJoy" . "\r\n" . "Reply-To: marcoescaleira2000@gmail.com" . "\r\n" . "Content-type:text/html;charset=UTF-8" . "\r\n";

            if (mail($to,$subject,$message,$headers)) {
                return true;
            }

            return false;
        }
    }
?>
