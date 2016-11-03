<?php


$debug = True;

if ($debug) {
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);
}

function failure($err_msg) {
    echo '<div><p>' . $err_msg . '</p></div>';
    exit();
}

?>
