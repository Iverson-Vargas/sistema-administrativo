<?php

namespace App\Controllers;

use App\Models\Empleado;

class EliminarEmpleado extends BaseController
{
    // public function deshabilitarEmpleado($id_empleado){
    //     $Empleado = new Empleado();

    //     // Cambiar el estatus del empleado a 'deshabilitado' (por ejemplo, 0)
    //     $data = ['estatus' => 0];

    //     try {
    //         $resultado = $Empleado->actualizarEmpleado($id_empleado, $data);

    //         if ($resultado) {
    //             return $this->response->setJSON(['success' => true, 'message' => 'Empleado deshabilitado correctamente.']);
    //         } else {
    //             return $this->response->setJSON(['success' => false, 'message' => 'Error al deshabilitar el empleado.']);
    //         }
    //     } catch (\Exception $e) {
    //         log_message('error', $e->getMessage());
    //         return $this->response->setJSON(['success' => false, 'message' => 'Error interno del servidor.']);
    //     }
    // }

}