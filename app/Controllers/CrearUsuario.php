<?php

namespace App\Controllers;

use App\Models\Persona;
use App\Models\PerNatural;
use App\Models\Usuario;

class CrearUsuario extends BaseController
{

    public function CrearUnUsuario()
    {
        $json = $this->request->getJSON();
        $tipo = $json->tipo ?? null;
        $ci_rif = $json->ci_rif ?? null;
        $nombre = $json->nombre ?? null;
        $apellido = $json->apellido ?? null;
        $sexo = $json->sexo ?? null;
        $telefono = $json->telefono ?? null;
        $correo = $json->correo ?? null;
        $direccion = $json->direccion ?? null;
        $roles = $json->roles ?? null;
        $nick = $json->nick ?? null;
        $contrasena = $json->contrasena ?? null;

        if (empty($tipo) || empty($ci_rif) || empty($nombre) || empty($apellido) || empty($sexo) || empty($telefono) || empty($correo) || empty($direccion) || empty($roles) || empty($nick) || empty($contrasena)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Los datos no pueden estar vacíos']);
        }

        $datosPersona = [
            'tipo' => $tipo,
            'ci_rif' => $ci_rif,
            'telefono' => $telefono,
            'correo' => $correo,
            'direccion' => $direccion
        ];
        $CrearMiPersona = new Persona();
        $resultadoPersona = $CrearMiPersona->insertarMiPersona($datosPersona);

        // Ahora $resultadoPersona contiene el ID si tuvo éxito, o false si falló.
        if ($resultadoPersona) {
            $id_persona = $resultadoPersona; // Usamos el ID que nos devolvió el modelo

            $datosPerNatural = [
                'id_persona' => $id_persona,
                'nombre' => $nombre,
                'apellido' => $apellido,
                'sexo' => $sexo
            ];
            $CrearMiPerNatural = new PerNatural();
            $resultadoPerNatural = $CrearMiPerNatural->insertarMiPerNatural($datosPerNatural);
 
            if ($resultadoPerNatural) {
                $datosUsuario = [
                    'id_roles' => $roles,
                    'id_persona' => $id_persona,
                    'nick' => $nick,
                    'contrasena' => $contrasena,
                ];
                $CrearMiUsuario = new Usuario();
                $resultadoUsuario = $CrearMiUsuario->insertarMiUsuario($datosUsuario);
 
                if ($resultadoUsuario) {
                    return $this->response->setJSON(['success' => true, 'message' => 'El usuario fue creado correctamente']);
                } else {
                    // Falló la inserción en la tabla 'usuario'.
                    return $this->response->setJSON(['success' => false, 'message' => 'Error al guardar los datos del usuario. El nick puede que ya esté en uso.']);
                }
            } else {
                // Falló la inserción en la tabla 'per_natural'.
                return $this->response->setJSON(['success' => false, 'message' => 'Error al guardar los datos naturales de la persona.']);
            }
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al guardar los datos de la persona. La cédula o RIF puede que ya esté en uso.']);
        }
    }
}