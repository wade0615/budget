<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../cores/Loader.php';
require_once __DIR__ . '/../cores/Helper.php';

$f3 = \Base::instance();

$f3->set('CACHE', __DIR__ . '/../cache');

//env detect
if (isDev()) {
    $f3->set('DEBUG', 3);
    $f3->set('ONERROR', function ($f3) {
        $err = $f3->get('ERROR');
        if (isAjax()) {
            \FATZ\Api::_return($err['code'], [
                'status' => $err['status'],
                'level' => $err['level'],
                'text' => $err['text'],
                'trace' => $err['trace'],
            ]);
        } else {
            \FATZ\Page::_echo();
        }

    })
} else {
    $f3->set('DEBUG', 0);
    $f3->set('ONERROR', function ($f3) {
        $err = $f3->get('ERROR');
        Api::_return($err['code'], [
            'status' => $err['status'],
            'level' => $err['level'],
            'text' => $err['text'],
            'trace' => $err['trace'],
        ]);
    })
}

//config
$f3->config(__DIR__ . '/../configs/' . $f3->get('enviromnment') . '.cfg');

//route
$f3->config(__DIR__ . '/../configs/routes.cfg');

$f3->run();
