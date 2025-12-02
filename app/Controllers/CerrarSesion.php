<?php

namespace App\Controllers;


class CerrarSesion extends BaseController
{
    public function cerrarSession()
    {
        $session = session();
        $session->destroy();
        return $this->response->setJSON(['success' => true, 'message' => 'se cerro la session correctamente']);
    }
}