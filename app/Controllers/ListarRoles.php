<?php

namespace App\Controllers;

use App\Models\Roles;

class ListarRoles extends BaseController
{
    public function returnRoles(){
        $Roles = new Roles();
        $datos = $Roles->traerRoles();
        return $this->response->setJSON(['success' => true, 'data' => $datos]);
    }
}