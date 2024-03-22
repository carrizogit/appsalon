<?php

namespace Model;

class Usuario extends ActiveRecord {
    //base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['id'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    //mensja ede validacion como se manda a llamar de otro lado queda como public
    public function validarNuevaCuenta() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }

        if(!$this->apellido) {
            self::$alertas['error'][] = 'El apellido es obligatorio';
        } 

        if(!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }

        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatorio';
        } 

        if(strlen($this->password) < 4) {
            self::$alertas['error'][] = 'La contraseña debe ser mayor 4 caracteres';
        }

        return self::$alertas;
    }

    public function existeUsuario() {
        //COMILLA SIMPLE XQ EMAIL ES UN STRING
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" .$this->email  . "' LIMIT 1";
        $resultado = self::$db->query($query);
        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El usuario ya esta registrado';
        }
        return $resultado; 
    }

    public function hashPAssword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() {
        $this->token = uniqid();
    }

    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es oblogatorio';
        }

        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatorio';
        }
        return self::$alertas;
    }
    
    public function comporbarPasswordAndVerificado($password) {
        $resultado = password_verify($password, $this->password);

        if(!$resultado || !$this->confirmado) {

            self::$alertas['error'][] = 'Contraseña incorrecta o cuenta no confirmada';
        }else {
            return true;
        }
    }



    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es oblogatorio';
        }
        return self::$alertas;
    }

    public function validarPassword() {
        if(!$this->password) {
            self::$alertas['error'][] = 'La Contraseña es oblogatorio';
        }

        if(strlen($this->password) < 3 ) {
            self::$alertas['error'][] = 'La Contraseña debe ser mayor a 3 caracteres';
        }

        return self::$alertas;
    }

}