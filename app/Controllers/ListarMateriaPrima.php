<?php

namespace App\Controllers;

use App\Models\MateriaPrima;

class ListarMateriaPrima extends BaseController
{
    public function listarMateriaPrima()
    {
        $materiaPrimaModel = new MateriaPrima();
        $materiasPrimas = $materiaPrimaModel->getMateriasPrima();
        return $this->response->setJSON(['data' => $materiasPrimas]);
    }

}