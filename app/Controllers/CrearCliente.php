<?php

namespace App\Controllers;

use App\Models\Persona;
use App\Models\PerNatural;
use App\Models\PerJuridica;
use App\Models\Cliente;

class CrearCliente extends BaseController
{

    public function CrearUnCliente()
    {
        try {
            $json = $this->request->getJSON();
            $tipo = $json->tipo_persona ?? null;
            $ci_rif = $json->ci_rif ?? null;
            $nombre = $json->nombre ?? null;
            $apellido = $json->apellido ?? null;
            $sexo = $json->sexo ?? null;
            $telefono = $json->telefono ?? null;
            $correo = $json->correo ?? null;
            $direccion = $json->direccion ?? null;
            $razon_social = $json->razon_social ?? null;

            // Validación de campos obligatorios comunes
            if (empty($tipo) || empty($ci_rif) || empty($telefono) || empty($correo) || empty($direccion)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Los datos obligatorios no pueden estar vacíos']);
            }

            // Validación según el tipo de proveedor (Natural o Jurídica)
            if ($tipo === 'N') {
                if (empty($nombre) || empty($apellido) || empty($sexo)) {
                    return $this->response->setJSON(['success' => false, 'message' => 'Faltan datos para persona natural']);
                }
            } elseif ($tipo === 'J') {
                if (empty($razon_social)) {
                    return $this->response->setJSON(['success' => false, 'message' => 'Falta la razón social para persona jurídica']);
                }
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Tipo de persona no válido']);
            }

            // Validación de Duplicados (RIF/CI)
            $PersonaModel = new Persona();
            if ($PersonaModel->where('ci_rif', $ci_rif)->first()) {
                return $this->response->setJSON(['success' => false, 'message' => 'El RIF o Cédula ya se encuentra registrado en el sistema.']);
            }

            // Iniciar Transacción
            $db = \Config\Database::connect();
            $db->transBegin();

            // 1. Insertar en tabla Persona
            $datosPersona = [
                'tipo' => $tipo,
                'ci_rif' => $ci_rif,
                'telefono' => $telefono,
                'correo' => $correo,
                'direccion' => $direccion
            ];
            
            $resultadoPersona = $PersonaModel->insertarMiPersona($datosPersona);

            if ($resultadoPersona) {
                $id_persona = $resultadoPersona;
                $resultadoDetalle = false;

                // 2. Insertar en tabla específica (PerNatural o PerJuridica)
                if ($tipo === 'N') {
                    $datosPerNatural = [
                        'id_persona' => $id_persona,
                        'nombre' => $nombre,
                        'apellido' => $apellido,
                        'sexo' => $sexo
                    ];
                    $CrearMiPerNatural = new PerNatural();
                    $resultadoDetalle = $CrearMiPerNatural->insertarMiPerNatural($datosPerNatural);
                } else {
                    $datosPerJuridica = [
                        'id_persona' => $id_persona,
                        'razon_social' => $razon_social
                    ];
                    $CrearMiPerJuridica = new PerJuridica();
                    $resultadoDetalle = $CrearMiPerJuridica->insertarMiPerJuridica($datosPerJuridica);
                }

                if ($resultadoDetalle) {
                    // 3. Insertar en tabla Provedor
                    $datosProvedor = [
                        'id_persona' => $id_persona,
                    ];
                    $CrearMiCliente = new Cliente();
                    $resultadoProvedor = $CrearMiCliente->insertarCliente($datosProvedor);

                    if ($resultadoProvedor) {
                        $db->transCommit(); // Confirmar Transacción
                        return $this->response->setJSON(['success' => true, 'message' => 'El cliente fue creado correctamente', 'id_cliente' => $resultadoProvedor]);
                    } else {
                        $db->transRollback(); // Revertir cambios
                        return $this->response->setJSON(['success' => false, 'message' => 'Error al guardar los datos del cliente.']);
                    }
                } else {
                    $db->transRollback(); // Revertir cambios
                    return $this->response->setJSON(['success' => false, 'message' => 'Error al guardar los datos específicos de la persona.']);
                }
            } else {
                $db->transRollback(); // Revertir cambios
                return $this->response->setJSON(['success' => false, 'message' => 'Error al guardar los datos de la persona.']);
            }
        } catch (\Exception $e) {
            if (isset($db)) {
                $db->transRollback();
            }
            return $this->response->setJSON(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
        }
    }
}
