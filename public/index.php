<?php

/**
 * Routeur principal de l'application
 *
 * Point d'entrée unique. Analyse l'URL et dispatch vers
 * le bon contrôleur et la bonne méthode.
 *
 * @package TouchePasAuKlaxon
 */

session_start();

// Chargement automatique des classes
spl_autoload_register(function (string $class): void {
    $directories = ['Models', 'Controllers'];
    foreach ($directories as $dir) {
        $file = __DIR__ . '/../app/' . $dir . '/' . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Récupération et nettoyage de l'URL
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$url = filter_var($url, FILTER_SANITIZE_URL);
$parts = $url ? explode('/', $url) : [];

// Extraction du contrôleur, de la méthode et des paramètres
$controllerName = !empty($parts[0]) ? ucfirst(strtolower($parts[0])) . 'Controller' : 'TrajetController';
$method = $parts[1] ?? 'index';
$params = array_slice($parts, 2);

// Vérification de l'existence du contrôleur et de la méthode
$controllerFile = __DIR__ . '/../app/Controllers/' . $controllerName . '.php';

if (!file_exists($controllerFile)) {
    http_response_code(404);
    echo '<h1>Page introuvable</h1>';
    exit;
}

$controller = new $controllerName();

if (!method_exists($controller, $method)) {
    http_response_code(404);
    echo '<h1>Page introuvable</h1>';
    exit;
}

// Appel de la méthode avec les paramètres
call_user_func_array([$controller, $method], $params);