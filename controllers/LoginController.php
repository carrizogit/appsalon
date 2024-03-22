<?php

namespace Controllers;

use MVC\Router;
use Classes\Email;
use Model\Usuario;

class LoginController {
    public static function login(Router $router) {

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();

            if(empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);
                if($usuario) {

                    if($usuario->comporbarPasswordAndVerificado($auth->password)) {
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        if($usuario->admin === '1') {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('location: /admin');
                        }else  {
                            header('location: /cita');
                        }
                    }
                    
                    
                }else {
                    Usuario::setAlerta('error', 'Usuario no encnotrado');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }

    public static function logout(Router $router) {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }

    public static function olvide(Router $router) {
         $alertas = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);
                if($usuario && $usuario->confirmado === '1') {
                    $usuario->crearToken();
                    $usuario->guardar();

                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarInstrucciones();

                    Usuario::setAlerta('exito', 'Revisa tu email');
                    
                }else {
                    Usuario::setAlerta('error', 'Elsusrio no existe o no esta confirmado');
                    
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide-password', [
             'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router) {

        $alertas = [];
        $error = false;
        $token = s($_GET['token']);

        //buscar ususrio po rsu token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token no valido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = new Usuario($_POST);

            $alertas = $password->validarPassword();

            if(empty($alertas)) {
                //restablece el pass anterior
                $usuario->password = null;

                $usuario->password = $password->password;
                $usuario->hashPAssword();
                $usuario->token = null;
                $resultado = $usuario->guardar();
                if($resultado) {
                    header('Location: /');
                }


            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function crear(Router $router) {
        
        $usuario = new Usuario($_POST);
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            //revisar que alerta este vacio
            if(empty($alertas)) {
                //verificar que el usuario no este registrado
                $resultado = $usuario->existeUsuario();

                //si num_rows es 1 es xq si encontro coincidiencia
                if($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                }else {
                    //no esta registrado
                    $usuario->hashPassword();

                    //generar token unico
                    $usuario->crearToken();

                    //enviar email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);

                    $email->enviarConfirmacion();

                    //guardando usuario
                    $resultado = $usuario->guardar();

                    if($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router) {
        $router->render('auth/mensaje', [
        ]);
    }

    public static function confirmar(Router $router) {
        $alertas = [];
        //leer el token de la url
        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            Usuario::setAlerta('error','Token no valido');
        }else {
            $usuario->confirmado = '1';
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Verificada Correctamente');
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
    
}