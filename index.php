<?php
require_once '/application/vendor/autoload.php';
use Pocmedia\Shuttle\Util\App as Container;
use \Cs\Router\Util\App as Router;
register_shutdown_function('endScript');

try {
    $context = Container::getApp();
    $routes = $context->get('router');
    $config = $context->get('config');
    $app =  new Router([], $context, $routes, $config, ['debug' => true]);
    $app->run();
}
catch(\Exception $e) {

    $errorCode = $e->getCode();
    $traceMessage = $e->getMessage();
    $result = [
        'error' => $traceMessage,
        'errorId' => $errorCode,
        'status' => false
    ];
    header("Content-Type: application/json");
    http_response_code(500);
    echo json_encode($result);
}

function endScript() {
    $error = error_get_last();
    if (isset($error['type']) === true && $error['type'] === 1) {
        $result = [
            'error' => error_get_last()['message'],
            'errorType' => error_get_last()['type'],
            'lineNo' => error_get_last()['line'],
            'errorId' => 10,
            'status' => false
        ];
        header("Content-Type: application/json");
        http_response_code(500);
        echo json_encode($result);
    }
}

