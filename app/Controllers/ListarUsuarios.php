<?php

namespace App\Controllers;

use App\Models\Usuario;

class ListarUsuarios extends BaseController
{
     public function returnUsuarios(){
        $Usuarios = new Usuario();
        $datos = $Usuarios->getUsuario();
        return $this->response->setJSON(['success' => true, 'data' => $datos]);
    }

    public function getOneUsuario($id_usuario){
        $Usuarios = new Usuario();
        $dato = $Usuarios->getOneUsuario($id_usuario);

        if (!$dato) {
            return $this->response->setJSON(['success' => false, 'message' => 'Usuario no encontrado.']);
        }

        return $this->response->setJSON(['success' => true, 'data' => $dato]);
    }

    public function actualizarUsuario($id_usuario){
        $data = $this->request->getJSON(true);

        // Filtrar solo los campos permitidos y no nulos
        $updateData = [];
        if (!empty($data['id_roles'])) $updateData['id_roles'] = $data['id_roles'];
        if (!empty($data['nick'])) $updateData['nick'] = $data['nick'];
        if (!empty($data['contrasena'])) $updateData['contrasena'] = $data['contrasena'];

        // Hashear la contraseña solo si se proporciona una nueva
        

        if (empty($updateData)) {
            return $this->response->setJSON(['success' => false, 'message' => 'No se enviaron datos para actualizar.']);
        }

        $Usuarios = new Usuario();
        $resultado = $Usuarios->actualizarUsuario($id_usuario, $updateData);
        if($resultado){
            return $this->response->setJSON(['success' => true, 'message' => 'Usuario actualizado correctamente.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al actualizar el usuario.']);
        }
    }
}