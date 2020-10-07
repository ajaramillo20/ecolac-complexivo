<?php
class Usuario
{

    public $usr_id;
    public $usr_nombre;
    public $usr_cedula;
    public $usr_correo;
    public $usr_telefono;
    public $usr_usuario;
    public $usr_contrasena;
    public $rol_id;
    public $suc_id;
    //Relaciones
    public $Direccion = array();

    protected $db;

    public function __construct()
    {
        $this->db = BaseConection::Connect();
    }

    //CRUD

    public function GetAllUsuarios()
    {
        $sql = "SELECT usr.usr_id, usr.usr_nombre, usr.usr_correo, usr.usr_cedula, usr.usr_telefono, rol.rol_nombre FROM usuario usr
        INNER JOIN rol rol on usr.rol_id = rol.rol_id
        WHERE  (" . (StringFormat::IsNullOrEmptyString($this->rol_id) ? 'null' : "{$this->rol_id}") . " IS NULL
                OR rol.rol_id =" . (StringFormat::IsNullOrEmptyString($this->rol_id) ? 'null' : "{$this->rol_id}") . ") " .
            "AND (" . (StringFormat::IsNullOrEmptyString($this->usr_nombre) ? "'null'" : "'{$this->usr_nombre}'") . " = 'null'
                OR usr.usr_nombre LIKE " . (StringFormat::IsNullOrEmptyString($this->usr_nombre) ? 'null' : "'%{$this->usr_nombre}%'")  . ") " .
            "AND (" . (StringFormat::IsNullOrEmptyString($this->usr_correo) ? "'null'" : "'{$this->usr_correo}'") . " = 'null'
                OR usr.usr_correo LIKE " . (StringFormat::IsNullOrEmptyString($this->usr_correo) ? 'null' : "'%{$this->usr_correo}%'") . ") 
                ORDER BY rol.rol_nombre, usr.usr_nombre";
        $usuarios = $this->db->query($sql);

        return $usuarios;
    }

    public function GetUserById()
    {
        $sql = "SELECT * FROM usuario usr 
                INNER JOIN rol rol ON usr.rol_id = rol.rol_id                                        
                WHERE usr.usr_id = {$this->usr_id}";

        $result = $this->db->query($sql);

        $sqlDir = "SELECT * FROM direccion dir
                    INNER JOIN usuariodireccion usd on dir.dir_id = usd.dir_id
                    WHERE usd.usr_id = {$this->usr_id}";
        $resultDir = $this->db->query($sqlDir);

        if ($result && $resultDir) {
            $entity = $result->fetch_object('Usuario');
            while ($r = $resultDir->fetch_object('Direccion')) {
                array_push($entity->Direccion, $r);
            }

            return $entity;
        } else {
            return null;
        }
    }

    public function EliminarUsuario()
    {
        try {
            return true;
            $usr = $this->GetUserById();
            $this->db->begin_transaction();

            $sqlusd = "DELETE from usuariodireccion where usr_id = {$this->usr_id}";
            $sqlusr = "DELETE from usuario where usr";

            $sqlUsr = "DELETE FROM usuario WHERE usr_id = {$usr->usr_id}";
            $sqlDir = "DELETE FROM direccion where dir_id = {$usr->dir_id}";

            $resultUsr = $this->db->query($sqlUsr);
            $resultDir = $this->db->query($sqlDir);

            if ($resultUsr && $resultDir) {
                $this->db->commit();
                return true;
            }
            throw new Exception('Error al eliminar');
        } catch (\Throwable $ex) {
            $_SESSION["usuarioGestionError"] = $ex->getMessage();
            $this->db->rollback();
            return false;
        }
    }

    public function GuardarUsuario()
    {
        if ($this->UserExist()) {
            throw new Exception('Ya existe un usuario con esos datos');
        }

        $this->db->begin_transaction();

        $sqlDir = "INSERT INTO direccion (dir_direccion, dir_latitud, dir_longitud, ciu_id,dir_predeterminado)"
            . "VALUES ('{$this->Direccion[0]->dir_direccion}', '{$this->Direccion[0]->dir_latitud}', '{$this->Direccion[0]->dir_longitud}',"
            . " '{$this->Direccion[0]->ciu_id}',true) ";

        $resultDir = $this->db->query($sqlDir);
        $this->Direccion[0]->dir_id = $this->db->insert_id;

        $sqlRolInicio = "SELECT rol_id FROM rol WHERE rol_nombre = (SELECT conf_valor FROM configuracion WHERE conf_descripcion = 'rol_inicio')";
        $rol = $this->db->query($sqlRolInicio);
        $rolId = $rol->fetch_object()->rol_id;

        $this->usr_contrasena = App::GetHash($this->usr_contrasena);
        $sqlUsr = "INSERT INTO usuario(usr_nombre, usr_cedula, usr_correo, usr_telefono, usr_usuario, usr_contrasena, rol_id)"
            . "VALUES ('{$this->usr_nombre}','{$this->usr_cedula}','{$this->usr_correo}', '{$this->usr_telefono}', '{$this->usr_usuario}',"
            . "'{$this->usr_contrasena}', {$rolId})";

        $resultUsr = $this->db->query($sqlUsr);
        $this->usr_id = $this->db->insert_id;

        $sqlUsrDireccion = "INSERT INTO usuariodireccion (usr_id,dir_id) VALUES ({$this->usr_id}, {$this->Direccion[0]->dir_id})";
        $resultUsrDir = $this->db->query($sqlUsrDireccion);

        if ($resultUsr && $resultDir && $resultUsrDir) {
            $this->db->commit();
            return $this;
        } else {
            throw new Exception('error al guardar');
        }
        return null;
    }

    public function ActualizarUsuario()
    {
        try {
            if ($this->UserUpdateExist()) {
                throw new Exception('Ya existe un usuario con esos datos');
            }

            $sqlUsuario = "UPDATE usuario set 
                    usr_nombre = '{$this->usr_nombre}',
                    usr_cedula = '{$this->usr_cedula}',
                    usr_correo = '{$this->usr_correo}',
                    usr_telefono = '{$this->usr_telefono}',
                    usr_usuario = '{$this->usr_usuario}',                    
                    rol_id = {$this->rol_id},
                    suc_id = COALESCE({$this->suc_id}, null)
                    WHERE usr_id = {$this->usr_id}";
            $resultUsr = $this->db->query($sqlUsuario);
            if ($resultUsr) {
                return $this;
            } else {
                throw new Exception('error al actualizar');
            }
        } catch (Throwable $ex) {
            $_SESSION['registroError'] = $ex->getMessage();
            return null;
        }
    }


    public function ActualizarPerfilUsuario()
    {
        if ($this->UserUpdateExist()) {
            throw new Exception('Ya existe un usuario con esos datos');
        }

        $sqlUsuario = "UPDATE usuario set 
                    usr_nombre = '{$this->usr_nombre}',                    
                    usr_correo = '{$this->usr_correo}',
                    usr_telefono = '{$this->usr_telefono}',
                    usr_usuario = '{$this->usr_usuario}',                                        
                    usr_contrasena = COALESCE(" . (!StringFormat::IsNullOrEmptyString($this->usr_contrasena) ? "'" . App::GetHash($this->usr_contrasena) . "'" : 'null') .  " , usr_contrasena)
                    WHERE usr_id = {$this->usr_id}";

        $resultUsr = $this->db->query($sqlUsuario);
        if ($resultUsr) {
            return $this;
        } else {
            throw new Exception('error al actualizar');
        }
        return null;
    }

    public function IniciarSesion($correo, $contrasena)
    {
        $sql = "SELECT * FROM usuario usr 
                INNER JOIN rol rol ON usr.rol_id = rol.rol_id
                WHERE usr_correo = '{$correo}'";

        $result = $this->db->query($sql);

        if ($result && $result->num_rows == 1) {
            $entity = $result->fetch_object();
            $verify = App::VerifyHash($contrasena, $entity->usr_contrasena);
            if ($verify) {
                return $entity;
            }
        }
        return null;
    }

    public function GuardarUsuarioSistema()
    {
        if ($this->UserExist()) {
            throw new Exception('Ya existe un usuario con esos datos');
        }

        $this->usr_contrasena = App::GetHash($this->usr_contrasena);
        $sql = "INSERT INTO usuario (usr_nombre, usr_cedula, usr_correo, usr_telefono, usr_usuario, usr_contrasena, suc_id, rol_id)
                VALUES ('{$this->usr_nombre}', '{$this->usr_cedula}', '{$this->usr_correo}', '{$this->usr_telefono}', '{$this->usr_usuario}', '{$this->usr_contrasena}' 
                , {$this->suc_id}, {$this->rol_id})";

        $result = $this->db->query($sql);

        if ($result) {
            return true;
        }
        throw new Exception('Error al registrar usuario');
    }

    public function UserExist()
    {
        $sql = "SELECT * FROM usuario WHERE usr_correo = '{$this->usr_correo}' "
            . "OR usr_cedula = '{$this->usr_cedula}'";

        $result = $this->db->query($sql);

        if ($result && $result->num_rows == 1) {
            return true;
        }
        return false;
    }

    public function UserUpdateExist()
    {
        $sql = "SELECT * FROM usuario WHERE usr_id <> {$this->usr_id} AND (usr_correo = '{$this->usr_correo}' "
            . "OR usr_cedula = '{$this->usr_cedula}') ";

        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            return true;
        }
        return false;
    }
}
