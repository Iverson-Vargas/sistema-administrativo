<?php

namespace App\Controllers;

use App\Models\Persona;
use App\Models\PerNatural;
use App\Models\Empleado;
use App\Models\FuncionEmpleado;

class CrearCosturero extends BaseController
{
    public function CrearUnCosturero()
    {
        try {
            $json = $this->request->getJSON();
            $tipo = $json->tipo ?? null;
            $ci_rif = $json->ci_rif ?? null;
            $nombre = $json->nombre ?? null;
            $apellido = $json->apellido ?? null;
            $sexo = $json->sexo ?? null;
            $telefono = $json->telefono ?? null;
            $correo = $json->correo ?? null;
            $direccion = $json->direccion ?? null;
            $fecha_ingreso = $json->fecha_ingreso ?? null;
            $descripcion_cargo = $json->descripcion_cargo ?? null;

            if (empty($tipo) || empty($ci_rif) || empty($nombre) || empty($apellido) || empty($sexo) || empty($telefono) || empty($correo) || empty($direccion) || empty($fecha_ingreso) || empty($descripcion_cargo)) {
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

            if ($resultadoPersona) {
                $id_persona = $resultadoPersona;

                $datosPerNatural = [
                    'id_persona' => $id_persona,
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'sexo' => $sexo
                ];
                $CrearMiPerNatural = new PerNatural();
                $resultadoPerNatural = $CrearMiPerNatural->insertarMiPerNatural($datosPerNatural);

                if ($resultadoPerNatural) {
                    $datosEmpleado = [
                        'id_persona' => $id_persona,
                        'fecha_ingreso' => $fecha_ingreso,
                        'estatus' => 'A'
                    ];
                    $crearEmpleado = new Empleado();
                    $resultadoEmpleado = $crearEmpleado->insertarEmpleado($datosEmpleado);

                    if ($resultadoEmpleado) {
                        $datosFuncion = [
                            'id_empleado' => $resultadoEmpleado, // El modelo Empleado devuelve el ID del empleado insertado
                            'descripcion_cargo' => $descripcion_cargo
                        ];
                        $crearFuncion = new FuncionEmpleado();
                        $crearFuncion->insertarFuncionEmpleao($datosFuncion);

                        return $this->response->setJSON(['success' => true, 'message' => 'El costurero fue creado correctamente']);
                    } else {
                        return $this->response->setJSON(['success' => false, 'message' => 'Error al guardar los datos del empleado.']);
                    }
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Error al guardar los datos naturales de la persona.']);
                }
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
        }
    }

}
