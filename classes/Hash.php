<?php
    /**
     * class de Hash
     */
    class Hash {
        public static function make($string, $salt = '') {
            return hash('sha256', $string . $salt);
        }

        public static function salt($lenght) {
            return utf8_encode(random_bytes($lenght));
        }

        public static function unique() {
            return self::make(uniqid());
        }
    }

?>
