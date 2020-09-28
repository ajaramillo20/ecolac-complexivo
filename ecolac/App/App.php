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

        $path = StringFormat::IsNullOrEmptyString($path) ? 'files/image' : $path;
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

    public static function Redirect($url = '')
    {
        header("Location:" . base_url . $url);
        // echo '<script type="text/javascript">' .
        //     'window.location.href="' . base_url . $url . '"' .
        //     '</script>';
    }

    public static function GoBack()
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public static function ShowMessage($mensaje, $titulo = 'Mensaje')
    {
        echo "<script type='text/javascript'>" .
            "MostrarMensaje('{$mensaje}', '{$titulo}');" .
            "</script>";
    }


    public static function SetSession($userconnect)
    {
        $_SESSION['userconnect'] = $userconnect;
        App::GetDefaultDirSession();
        //App::GetNearSuc();
        //var_dump($_SESSION);
    }

    public static function SetDireccionSession($dir)
    {
        if (!is_null($dir)) {
            $_SESSION['dirconnect'] = $dir;
            App::GetNearSuc();
        }
    }

    public static function SetSucursalSession($suc)
    {
        $_SESSION['succonnect'] = $suc;
    }

    public static function GetNearSuc()
    {
        if (isset($_SESSION['dirconnect'])) {
            $sucursales = AppController::GetSucursales();
            $suc = null;
            $sucursal = null;
            $longo = $_SESSION['dirconnect']->dir_longitud;
            $lato = $_SESSION['dirconnect']->dir_latitud;
            while ($s = $sucursales->fetch_object()) {
                $distancia = App::getDistance($longo, $lato, $s->dir_longitud, $s->dir_latitud);

                if ($suc == null) {
                    $suc = $distancia;
                    $sucursal = $s;
                } else {
                    if ($distancia < $suc) {
                        $suc = $distancia;
                        $sucursal = $s;
                    }
                }
            }
            $_SESSION['succonnect'] = $sucursal;
        }
    }

    public static function GetDefaultDirSession()
    {
        $dir = AppController::GetDefaultUserDir($_SESSION['userconnect']->usr_id);
        App::SetDireccionSession($dir);
    }

    public static function getDistance($long1, $lat1, $long2, $lat2)
    {
        // return distance in meters
        $lon1 = App::toRadian($long1);
        $lat1 = App::toRadian($lat1);
        $lon2 = App::toRadian($long2);
        $lat2 = App::toRadian($lat2);

        $deltaLat = $lat2 - $lat1;
        $deltaLon = $lon2 - $lon1;

        $a = pow(sin($deltaLat / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($deltaLon / 2), 2);
        $c = 2 * asin(sqrt($a));
        $EARTH_RADIUS = 6371;
        return ($c * $EARTH_RADIUS * 1000);
    }
    public static function toRadian($degree)
    {
        return ($degree * pi() / 180);
    }

    public static function ValidarDireccionPedido($dirid)
    {
        $dirdata = AppController::GetDireccionById($dirid);
        $sucsession = $_SESSION['succonnect'];
        if ($dirdata->ciu_id == $sucsession->ciu_id) {
            return true;
        } else {
            throw new Exception("Esta dirección pertenece a otra ciudad, seleccione otra dirección u otra sucursal");
        }
    }
}
