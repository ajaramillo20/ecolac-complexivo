<?php

class App
{
    public static function UnsetSessionVar($nombre)
    {
        if (isset($_SESSION[$nombre])) {
            $_SESSION[$nombre] = null;
            unset($_SESSION[$nombre]);
        }
    }

    public static function GetHash($cadena)
    {
        return password_hash($cadena, PASSWORD_DEFAULT, ['cost' => 4]);
    }

    public static function VerifyHash($cadena, $hash)
    {
        $result = password_verify($cadena, $hash);
        return $result;
    }

    public static function ThrowAccess($pantalla, $accion)
    {
        $ruta = $pantalla . '/' . $accion;
        foreach (default_pantallas as $def) {
            if ($def == $ruta) {
                return true;
            }
        }

        foreach (logged_pantallas as $def) {
            if ($def == $ruta && App::IsLogged()) {
                return true;
            } else if ($def == $ruta && !App::IsLogged()) {
                $_SESSION['loginError'] = 'Debes iniciar sesión primero';
                require_once 'views/usuario/login.php';
                exit();
            }
        }

        if (isset($_SESSION['userconnect'])) {
            $usr = $_SESSION['userconnect'];
            $pantallasPermitidas = AppController::GetMenuByRol($usr->rol_id);

            foreach ($pantallasPermitidas as $pnt) {
                if ($ruta == $pnt->pnt_vinculo) {
                    return true;
                }
            }
        }
        throw new Exception("No tiene permitido este recurso");
    }


    public static function EstadisticasCarrito()
    {
        $datos = array(
            'count' => 0,
            'total' => 0
        );
        if (isset($_SESSION['carrito'])) {
            $datos['count'] = count($_SESSION['carrito']);

            foreach ($_SESSION['carrito'] as $indice => $producto) {
                $datos['total'] += $producto['pro_valor'] * $producto['unidades'];
            }
        }

        return $datos;
    }

    public static function IsLogged()
    {
        if (isset($_SESSION['userconnect'])) {
            return true;
        }
        return false;
    }

    public static function UploadImage($archivo, $path = '')
    {
        //GUARDAR IMAGEN            
        $nombre = $archivo['name'];
        $type = $archivo['type'];

        $path = App::IsNullOrEmptyString($path) ? 'files/image' : $path;
        $fullPath = $path . '/' . $nombre;

        if ($type == 'image/jpg' || $type == 'image/jpeg' || $type == 'image/png' || $type == 'image/gif') {
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            move_uploaded_file($archivo['tmp_name'], $fullPath);
            return true;
        }
        return false;
    }

    public static function IsNullOrEmptyString($str)
    {
        return (!isset($str) || trim($str) === '');
    }

    public static function Redirect($url = '')
    {
        header("Location:" . base_url . $url);
        // echo '<script type="text/javascript">' .
        //     'window.location.href="' . base_url . $url . '"' .
        //     '</script>';
    }
}