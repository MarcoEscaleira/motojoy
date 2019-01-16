<?php
    /**
     * Class para a confirmação do registo da conta
     */
    class Confirm {
        public static function generate() {
            $code = Hash::make(uniqid());
            return $code;
        }
    }

?>
