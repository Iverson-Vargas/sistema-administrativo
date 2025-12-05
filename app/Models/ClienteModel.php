<?php

namespace App\Models;

use App\Models\Persona;
use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'id_cliente';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['id_persona'];

    
    // Obtiene todos los clientes para la tabla de gestión
    public function getClientes()
    {
        $builder = $this->db->table('cliente c');
        $builder->select('
            c.id_cliente,
            p.ci_rif,
            p.tipo,
            p.telefono,
            p.correo,
            p.direccion,
            COALESCE(CONCAT(pn.nombre, " ", pn.apellido), pj.razon_social) as nombre_completo
        ');
        $builder->join('persona p', 'p.id_persona = c.id_persona');
        $builder->leftJoin('per_natural pn', 'p.id_persona = pn.id_persona AND p.tipo = "N"');
        $builder->leftJoin('per_juridica pj', 'p.id_persona = pj.id_persona AND p.tipo = "J"');
        $builder->orderBy('c.id_cliente', 'DESC');
        
        return $builder->get()->getResultArray();
    }

    // Busca un cliente por su CI/RIF
    public function getClienteByCiRif(string $ci_rif)
    {
        $builder = $this->db->table('cliente c');
        $builder->select('
            c.id_cliente,
            p.ci_rif,
            COALESCE(CONCAT(pn.nombre, " ", pn.apellido), pj.razon_social) as nombre_completo
        ')
            ->join('persona p', 'p.id_persona = c.id_persona')
            ->leftJoin('per_natural pn', 'p.id_persona = pn.id_persona AND p.tipo = "N"')
            ->leftJoin('per_juridica pj', 'p.id_persona = pj.id_persona AND p.tipo = "J"')
            ->where('p.ci_rif', $ci_rif);
        
        return $builder->get()->getRowArray();
    }

    /**
     * Crea un nuevo cliente (persona y cliente), manejando tanto naturales como jurídicos.
     * @param array $personaData Datos para la tabla 'persona'.
     * @param array $specificData Datos para 'per_natural' o 'per_juridica'.
     * @return int|false El ID del nuevo cliente o false si falla.
     */
    public function crearNuevoCliente(array $personaData, array $specificData)
    {
        $this->db->transStart();

        $personaModel = new Persona();
        $idPersona = $personaModel->insert($personaData);

        $specificData['id_persona'] = $idPersona;
        $this->db->table($personaData['tipo'] === 'N' ? 'per_natural' : 'per_juridica')->insert($specificData);

        $this->insert(['id_persona' => $idPersona]);
        $idCliente = $this->insertID();

        $this->db->transComplete();

        return $this->db->transStatus() ? $idCliente : false;
    }
}
