<?php

namespace App\Controllers;
use App\Models\Usuario;

class Login extends BaseController
{
    public function validarDatos(): string
    {
        $json = $this->request->getJSON();
        $usuario = $json->usuario ?? null;
        $contrasena = $json->contrasena ?? null;

        if (empty($usuario) || empty($contrasena)) {
            return json_encode(array('success' => false, 'mensaje' => 'el usuario o contraseña no pueden estar vacio'));
        }

        $Usuario = new Usuario();
        $datosUsuario = $Usuario->getOneUsuarioValidar($usuario);

        if (count($datosUsuario) > 0) {
            if ($contrasena == $datosUsuario[0]->contrasena) {
                $data = [
                    "id_usuario" => $datosUsuario[0]->id_usuario,
                    "rol" => $datosUsuario[0]->rol,
                    "persona" => $datosUsuario[0]->persona,
                    "nick" => $datosUsuario[0]->nick,
                    "contrasena" => $datosUsuario[0]->contrasena,
                ];
                
                $session = session();
                $session->set($data);
                return json_encode(array('success' => true, 'mensaje' => 'datos correcto'));
            } else {
                return json_encode(array('success' => false, 'mensaje' => 'contraseña incorrecta'));
            }
        } else {
            return json_encode(array('success' => false, 'mensaje' => 'usuario no encontrado'));
        }
    }
}
