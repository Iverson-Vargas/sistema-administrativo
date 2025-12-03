<?php

namespace App\Controllers;

use App\Models\Empleado;

class ListarEmpleados extends BaseController
{
    public function returnEmpleados(){
        $Empleado = new Empleado();
        $datos = $Empleado->getEmpleado();
        return $this->response->setJSON(['success' => true, 'data' => $datos]);
    }

    public function getOneEmpleado($id_empleado){
        $Empleado = new Empleado();
        $datos = $Empleado->getOneEmpleado($id_empleado);

        if (!$datos) {
            return $this->response->setJSON(['success' => false, 'message' => 'Empleado no encontrado.']);
        }

        $empleado = !empty($datos) ? $datos[0] : null;
        return $this->response->setJSON(['success' => true, 'data' => $empleado]);
    }

    public function actualizarEmpleado($id_empleado){
        $Empleado = new Empleado();

        // Obtener los datos enviados como JSON y convertirlos a un array asociativo
        $data = $this->request->getJSON(true);

        // Registrar los datos recibidos para depuración (esto ya está bien)
        log_message('info', 'Datos recibidos: ' . json_encode($data));

        // Validar que al menos un campo esté presente
        if (empty($data)) {
            return $this->response->setJSON(['success' => false, 'message' => 'No se enviaron datos para actualizar.']);
        }

        try {
            // Actualizar solo los campos enviados
            $resultado = $Empleado->actualizarEmpleado($id_empleado, $data);

            if ($resultado) {
                return $this->response->setJSON(['success' => true, 'message' => 'Empleado actualizado correctamente.']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Error al actualizar el empleado.']);
            }
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Error interno del servidor.']);
        }
    }

    public function deshabilitarEmpleado($id_empleado)
    {
        $empleadoModel = new Empleado();

        try {
            $resultado = $empleadoModel->deshabilitarEmpleado($id_empleado);

            if ($resultado) {
                return $this->response->setJSON(['success' => true, 'message' => 'Empleado deshabilitado correctamente.']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'El empleado no se pudo deshabilitar o ya estaba inactivo.']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error al deshabilitar empleado: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Error interno del servidor.']);
        }
    }
}