<?php

namespace App\Controllers;
use App\Models\Persona;

class BuscarProvedor extends BaseController
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
            return $this->response->setJSON(['success' => true, 'data' => $persona]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'No se encontró ningún proveedor con el RIF o Cédula proporcionado.']);
        }
    }
}