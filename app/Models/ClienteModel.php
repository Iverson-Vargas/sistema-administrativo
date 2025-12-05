<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'id_cliente';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['id_persona'];

    // Busca un cliente por su CI/RIF
    public function getClienteByCiRif(string $ci_rif)
    {
        return $this->db->table('cliente c')
            ->select('c.id_cliente, p.ci_rif, pn.nombre, pn.apellido')
            ->join('persona p', 'p.id_persona = c.id_persona')
            ->join('per_natural pn', 'pn.id_persona = p.id_persona', 'left') // Asumimos clientes naturales
            ->where('p.ci_rif', $ci_rif)
            ->get()
            ->getRowArray();
    }

    // Crea un nuevo cliente (persona natural y cliente)
    public function crearNuevoCliente(array $personaData, array $perNaturalData)
    {
        $this->db->transStart();

        $personaModel = new Persona();
        $idPersona = $personaModel->insertarMiPersona($personaData);

        $perNaturalData['id_persona'] = $idPersona;
        $perNaturalModel = new PerNatural();
        $perNaturalModel->insertarMiPerNatural($perNaturalData);

        $this->insert(['id_persona' => $idPersona]);
        $this->db->transComplete();

        return $this->db->transStatus() ? $this->insertID() : false;
    }
}
