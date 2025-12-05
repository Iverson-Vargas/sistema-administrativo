<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\Persona;
use App\Models\PerNatural;
use App\Models\PerJuridicaModel;

class ClienteController extends BaseController
{
    public function listarClientes()
    {
        $clienteModel = new ClienteModel();
        $data = $clienteModel->getClientes();
        return $this->response->setJSON(['data' => $data]);
    }

    public function crearCliente()
    {
        $db = \Config\Database::connect();
        
        try {
            $json = $this->request->getJSON();

            // Validar datos comunes
            if (empty($json->tipo) || empty($json->ci_rif) || empty($json->telefono) || empty($json->correo) || empty($json->direccion)) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Todos los campos generales son requeridos.']);
            }
            
            $db->transStart();

            $personaModel = new Persona();
            $idPersona = $personaModel->insert([
                'tipo' => $json->tipo,
                'ci_rif' => $json->ci_rif,
                'telefono' => $json->telefono,
                'correo' => $json->correo,
                'direccion' => $json->direccion,
            ]);

            if ($json->tipo === 'N') {
                if (empty($json->nombre) || empty($json->apellido) || empty($json->sexo)) {
                     throw new \Exception('Nombre, apellido y sexo son requeridos para persona natural.');
                }
                $perNaturalModel = new PerNatural();
                $perNaturalModel->insert([
                    'id_persona' => $idPersona,
                    'nombre' => $json->nombre,
                    'apellido' => $json->apellido,
                    'sexo' => $json->sexo,
                ]);
            } elseif ($json->tipo === 'J') {
                if (empty($json->razon_social)) {
                    throw new \Exception('Razón social es requerida para persona jurídica.');
                }
                $perJuridicaModel = new PerJuridicaModel();
                $perJuridicaModel->insert([
                    'id_persona' => $idPersona,
                    'razon_social' => $json->razon_social,
                ]);
            }

            $clienteModel = new ClienteModel();
            $clienteModel->insert(['id_persona' => $idPersona]);

            $db->transComplete();

            if ($db->transStatus() === false) {
                $error = $db->error();
                throw new \Exception('La transacción de la base de datos falló: ' . $error['message']);
            }

            return $this->response->setJSON(['success' => true, 'message' => 'Cliente creado exitosamente.']);

        } catch (\Exception $e) {
            log_message('error', '[ClienteController] ' . $e->getMessage());
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return $this->response->setStatusCode(409)->setJSON(['success' => false, 'message' => 'Error: El CI/RIF ingresado ya existe.']);
            }
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
