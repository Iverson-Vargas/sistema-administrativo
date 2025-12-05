<?php

namespace App\Models;

use CodeIgniter\Model;

class ProveedorModel extends Model
{
    protected $table = 'proveedor';
    protected $primaryKey = 'id_proveedor';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['id_persona'];

    public function getProveedorByRif(string $rif)
    {
        return $this->db->table('proveedor pr')
            ->select('pr.id_proveedor, p.ci_rif, COALESCE(pj.razon_social, CONCAT(pn.nombre, " ", pn.apellido)) as nombre_proveedor')
            ->join('persona p', 'p.id_persona = pr.id_persona')
            ->join('per_natural pn', 'pn.id_persona = p.id_persona', 'left')
            ->join('per_juridica pj', 'pj.id_persona = p.id_persona', 'left')
            ->where('p.ci_rif', $rif)
            ->get()
            ->getRowArray();
    }

    public function crearNuevoProveedor(string $rif, string $razonSocial)
    {
        $this->db->transStart();

        $personaModel = new Persona();
        $idPersona = $personaModel->insertarMiPersona([
            'tipo' => 'J', // Asumimos que los proveedores son Jurídicos
            'ci_rif' => $rif,
            'telefono' => 'N/A', 'correo' => 'N/A', 'direccion' => 'N/A'
        ]);

        $this->db->table('per_juridica')->insert(['id_persona' => $idPersona, 'razon_social' => $razonSocial, 'ramo' => 'N/A']);
        $this->insert(['id_persona' => $idPersona]);
        $idProveedor = $this->insertID();

        $this->db->transComplete();
        return $this->db->transStatus() ? $idProveedor : false;
    }
}

