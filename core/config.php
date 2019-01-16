<?php
    session_start();
    ob_start();

    error_reporting(E_ALL | E_WARNING | E_NOTICE);
    ini_set('display_errors', TRUE);

   $current_file = explode('/', $_SERVER['SCRIPT_NAME']);
   $current_file = end($current_file);

    //Configuração dos Diretórios do Website
    define("SYSTEM_PATH", dirname(__DIR__)."/");
    define("HTTP", isset($_SERVER["HTTP_HOST"]) ?
           		$_SERVER["HTTP_HOST"] : (
           	   isset($_SERVER["SERVER_NAME"]) ?
           	    $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));
    define("URL_PATH", 'http://'.HTTP."/motojoy/");
    define("CURRENT_FILE", $current_file);
    define("CORE_PATH", URL_PATH.'core/');
    define("CLASSES_PATH", URL_PATH.'classes/');
    define("IMGS_PATH", URL_PATH.'assets/imgs/');
    define("AIMGS_PATH", URL_PATH.'assets/imgs/accounts/');
    define("NEWS_PATH", URL_PATH.'assets/imgs/news/');
    define("STORE_PATH", URL_PATH.'store/');
    define("TIPS_PATH", URL_PATH.'assets/imgs/tips/');
    define("PRODUCTS_PATH_LOCAL", $_SERVER['DOCUMENT_ROOT'].'/motojoy/assets/imgs/products/');
    define("PRODUCTS_PATH", URL_PATH.'assets/imgs/products/');
    define("INCLUDES_PATH", 'includes/');
    define("CUSTOM_PATH_CSS", URL_PATH.'assets/custom/css/');
    define("CUSTOM_PATH_JS", URL_PATH.'assets/custom/js/');
    define("ASSETS_PATH", URL_PATH.'assets/');
   
    date_default_timezone_set('Europe/Lisbon');

    $GLOBALS['config'] = array(
        'mysql' => array(
            'host' => '127.0.0.1',
            'user' => 'root',
            'pass' => '',
            'db'   => 'motojoy',
        ),
        'remember' => array(
            'cookie_name'   => 'hash',
            'cookie_expiry' => 604800
        ),
        'session' => array(
            'session_name' => 'user',
            'token_name'   => 'token'
        )
    ); //echo Config::get('mysql/host'); //127.0.0.1

    //Inclusão de todas as Classes requeridas
    spl_autoload_register(function($class_name){
        require_once './classes/' . $class_name . '.php';
    });

    //Ficheiro para sanitizar as variáveis
    require_once './functions/sanitize.php';

    $cookieName = Config::get('remember/cookie_name');
    //Caso o utilizador tenha usado o "remember me" no login
    if ((Cookie::exists($cookieName)) && (!Session::exists(Config::get('session/session_name')))) {
        $hash = Cookie::get($cookieName);

        $hashCheck = Db::getInstance()->get('sessions', array('hash', '=', $hash));

        if ($hashCheck->count()) {
            $user = new User($hashCheck->first()->user_id);

            $user->login();
        }
    }
