<?php
    /**
     * Class de Token
     */
    class Token
    {
        public static function generate() {
            return Session::put(Config::get('session/token_name'), md5(uniqid()));
        }

        public static function check($token) {

         $tokenName = Config::get('session/token_name');
          # check if input token and session token are the same
            if(Session::exists($tokenName) && $token === Session::get($tokenName)) {
               // Session::delete($tokenName);
                # If the session is deleted this condition will always return false, because every time the script is run
                # it wont find a session to compare the form token.
                return true;
              }
             return false;   # bad token.
        }
    }

?>
