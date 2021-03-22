<?php
spl_autoload_register(function ($class_name) {
    $class_name=str_replace('Webhook\\', '', $class_name);
    $class_name=str_replace('WEBhook\\', '', $class_name);
    $class_name=str_replace('WebHook\\', '', $class_name);
    $class_name=str_replace('\\', '/', $class_name);
    $path=$_SERVER['DOCUMENT_ROOT'].'/local/php_interface/class/'.$class_name.'.php';
    include_once $path;
});