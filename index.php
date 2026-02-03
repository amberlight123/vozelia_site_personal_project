<?php
require_once __DIR__ . '/config/config.php';

// Router mínimo (sin framework): contexto real exige claridad.
$controllerName = isset($_GET['controller']) ? $_GET['controller'] : 'pages';
$actionName = isset($_GET['action']) ? $_GET['action'] : 'home';

// Para observabilidad
$GLOBALS['__route'] = $controllerName . '.' . $actionName;

// Chaos (opcional): simula fallos HTTP... 
$chaos = ctx()['chaos'] ?? [];
if (!empty($chaos['http_fail_rate']) && $chaos['http_fail_rate'] > 0) {
    $r = mt_rand() / mt_getrandmax();
    if ($r < $chaos['http_fail_rate']) {
        Obs::alert('CHAOS_HTTP_FAIL', 'warning', 'Fallo HTTP simulado', ['route' => $GLOBALS['__route']]);
        http_response_code(500);
        echo 'CHAOS: fallo simulado. Ref: ' . htmlspecialchars(Obs::requestId());
        exit;
    }
}

$controllerClass = ucfirst($controllerName) . 'Controller';
$controllerFile = __DIR__ . '/controllers/' . $controllerClass . '.php';

if (!file_exists($controllerFile)) {
    http_response_code(404);
    Obs::event('route_controller_not_found', 'warning', ['controller' => $controllerName], []);
    echo 'Controlador no encontrado. Ref: ' . htmlspecialchars(Obs::requestId());
    exit;
}

require_once $controllerFile;
$controller = new $controllerClass();

if (!method_exists($controller, $actionName)) {
    http_response_code(404);
    Obs::event('route_action_not_found', 'warning', ['controller' => $controllerName, 'action' => $actionName], []);
    echo 'Acción no encontrada. Ref: ' . htmlspecialchars(Obs::requestId());
    exit;
}

// Ejecuta acción
$controller->$actionName();
