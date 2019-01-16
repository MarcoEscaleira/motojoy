<?php
/**
 * Redirect class
 */
class Redirect
{
    public static function to($location = null) {
        if ($location) {
            if (is_numeric($location)) {
                switch ($location) {
                    case 404:
                        header('HTTP/1.0 404 Not found');
                        include 'includes/errors/404.php';
                        exit();
                    break;
                }
            }
            header('Location: ' . $location);
            exit();
        }
    }

    public static function adminTo($location = null) {
        if ($location) {
            if (is_numeric($location)) {
                switch ($location) {
                    case 404:
                        header('HTTP/1.0 404 Not found');
                        include '../includes/errors/404';
                        exit();
                    break;
                }
            }
            header('Location: '. URL_PATH . 'admin/' .$location);
            exit();
        }
    }
}

?>
