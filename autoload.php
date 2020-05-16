<?php

spl_autoload_register(function($className) {
    $ns = 'SteadyUa\\NsAnalyzer\\';
    if (strpos($className, $ns) === 0) {
        $classPath = str_replace('\\', '/', substr($className, strlen($ns)));
        require __DIR__ . '/src/' . $classPath . '.php';
        return true;
    }
    return false;
});
