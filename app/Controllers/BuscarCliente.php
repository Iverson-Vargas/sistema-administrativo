<?php

namespace App\Controllers;
use App\Models\Persona;
use App\Models\Cliente;

class BuscarCliente extends BaseController
{
    public function buscarPorCiRif()
    {
        $json = $this->request->getJSON();
        $ci_rif = $json->ci_rif ?? null;

        if (empty($ci_rif)) {
            return $this->response->setJSON(['success' => false, 'message' => 'El RIF o Cédula no puede estar vacío']);
        }

        $PersonaModel = new Persona();
        $persona = $PersonaModel->buscarPorCiRif($ci_rif);

        if ($persona) {
            // Verificar si la persona es un cliente y obtener su id_cliente
            $clienteModel = new Cliente();
            // Adaptamos según si retorna objeto o array
            $idPersona = is_object($persona) ? $persona->id_persona : $persona['id_persona'];
            
            $cliente = $clienteModel->where('id_persona', $idPersona)->first();
            
            if ($cliente) {
                // Combinamos los datos para devolver id_cliente
                $datos = is_object($persona) ? (array)$persona : $persona;
                $datos['id_cliente'] = $cliente['id_cliente'];
                return $this->response->setJSON(['success' => true, 'data' => $datos]);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'La persona existe pero no está registrada como cliente.']);
            }
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'No se encontró ningún proveedor con el RIF o Cédula proporcionado.']);
        }
    }
}