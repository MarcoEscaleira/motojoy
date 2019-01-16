<?php
    require 'core/config.php';
    require_once INCLUDES_PATH . 'header.php';

    //PHP.net download example
    $file = 'monkey.gif';

    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }
?>

    <div class="container">

    </div>

    
<?php
    require_once INCLUDES_PATH . 'footer.php';
?>
