<?php
session_start();
require_once 'App/StringFormat.php';
require_once 'App/App.php';
require_once 'App/Enums/PedidosEstatus.php';
require_once 'autoload.php';
require_once 'config/database.php';
require_once 'config/params.php';

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    try {
        if (isset($_GET['controller'])) {
            $nombre_controlador = $_GET['controller'] . 'Controller';
        } elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
            $nombre_controlador = default_controller;
        } else {
            error();
            exit();
        }

        if (class_exists($nombre_controlador)) {
            $controlador = new $nombre_controlador();

            if (isset($_GET['action']) && method_exists($controlador, $_GET['action'])) {
                $action = $_GET['action'];
                $controlador->$action();
            } elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
                $defaultAction = default_action;
                echo $controlador->$defaultAction();
            } else {
                error("null");
            }
        } else {
            error("null");
        }
    } catch (Exception $ex) {
        error($ex->getMessage());
    }
    exit;
}

require_once 'views/layout/header.php';
try {

    if (isset($_GET['controller'])) {
        $nombre_controlador = $_GET['controller'] . 'Controller';
    } elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
        $nombre_controlador = default_controller;
    } else {
        error();
        require_once 'views/layout/footer.php';
        exit();
    }

    if (class_exists($nombre_controlador)) {
        $controlador = new $nombre_controlador();

        if (isset($_GET['action']) && method_exists($controlador, $_GET['action'])) {
            App::ThrowAccess($_GET['controller'], $_GET['action']);
            $action = $_GET['action'];
            $controlador->$action();
        } elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
            $defaultAction = default_action;
            $controlador->$defaultAction();
        } else {
            error("La pagina que buscas no existe");
        }
    } else {
        error("La pagina que buscas no existe");
    }
} catch (Exception $ex) {
    error($ex->getMessage());
}

function error($msg = '')
{
    $error = new ErrorController();
    $error->index($msg);
    exit();
}

require_once 'views/layout/footer.php';
